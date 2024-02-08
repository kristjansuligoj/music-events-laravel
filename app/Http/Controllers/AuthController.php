<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => $token,
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

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => $token,
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
}
