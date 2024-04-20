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

        if(!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => 'Incorrect credentials',
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
     * Logs out the user and deletes the tokens
     *
     * @param Request $request
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
