<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Lcobucci\JWT\Encoding\CannotDecodeContent;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Token\UnsupportedHeaderFound;
use Lcobucci\JWT\UnencryptedToken;
use Nette\Utils\Random;

class AuthController extends Controller
{
    /**
     * Registers the user and returns a token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $request->name . " created",
                'token' => $user->createToken('myapptoken')->plainTextToken,
            ],
            'message' => 'Registration successful',
        ]);
    }

    /**
     * Authenticates the user and returns a token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        $emailUnverified = is_null($user->email_verified_at);

        if(!$user || !Hash::check($validated['password'], $user->password) || $emailUnverified) {
            $message = "Incorrect credentials";

            if ($emailUnverified) {
                $message = "You need to confirm your email before continuing.";
            }

            return response()->json([
                'success' => false,
                'data' => '',
                'message' => $message,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'token' => $user->createToken('myapptoken')->plainTextToken
            ],
            'message' => 'Log in successful',
        ]);
    }

    /**
     * This function handles a user logging in with socials (Google, Facebook, Microsoft)
     *
     * @param Request $request
     * @param string $social
     * @return JsonResponse
     */
    public function loginWithSocials(Request $request, string $social): JsonResponse
    {
        $validated = $request->validate([
            'tokenId' => ['required', 'string'],
        ]);

        $tokenId = $validated['tokenId'];

        $parser = new Parser(new JoseEncoder());

        try {
            $token = $parser->parse($tokenId);
        } catch (CannotDecodeContent | InvalidTokenStructure | UnsupportedHeaderFound $e) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => $e->getMessage(),
            ], 400);
        }

        assert($token instanceof UnencryptedToken);

        $email = $token->claims()->get('email');
        $name = $token->claims()->get('name');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make(Str::random(10)),
            ]);

            event(new Registered($user));

            return response()->json([
                'success' => false,
                'data' => '',
                'message' => "You need to confirm your email before continuing.",
            ], 418);
        }

        $emailUnverified = is_null($user->email_verified_at);

        if ($emailUnverified) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => "You need to confirm your email before continuing.",
            ], 418);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'token' => $user->createToken('myapptoken')->plainTextToken
            ],
            'message' => 'Log in successful',
        ]);
    }

    /**
     * Handles user authentication for socials
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function authenticateSocials(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make(Random::generate(20)),
            ]);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => 'Success',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ]);
    }

    /**
     * Logs out the user and deletes the tokens
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            auth()->user()->tokens()->delete();
            return response()->json([
                'success' => true,
                'data' => '',
                'message' => 'Log out successful',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'Log out unsuccessful',
            ]);
        }
    }

    /**
     * Sends verify email notification to user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendEmailVerificationNotification(Request $request): JsonResponse {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'Email verification not sent',
            ], 418);
        }

        if (is_null($user->email_verified_at)) {
            $user->sendEmailVerificationNotification();

            return response()->json([
                'success' => true,
                'data' => '',
                'message' => 'Email verification notification sent',
            ]);
        }

        return response()->json([
            'success' => false,
            'data' => '',
            'message' => 'Email already verified',
        ], 400);
    }

    /**
     * Verifies email of user
     *
     * @param Request $request
     * @param string $id
     * @param string $hash
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function verifyEmail(Request $request, string $id, string $hash): JsonResponse {
        # https://stackoverflow.com/questions/53885431/how-to-verify-email-without-asking-the-user-to-login-to-laravel
        $user = User::find($id);

        if (!hash_equals($hash, sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($user->markEmailAsVerified())
            event(new Verified($user));

        return response()->json([
            'success' => true,
            'data' => '',
            'message' => 'Email verified',
        ]);
    }
}
