<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Exception;

class AuthController extends Controller
{
    public function register(Request $request) {

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

        return response($user);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {

        $validated = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if(!$user || !Hash::check($validated['password'], $user->password)) {
            return response([
                'message' => 'Your credentials dont match'
            ], 401);
        }

        return response($user);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        try {
            auth()->user()->tokens()->delete();
        } catch (\Exception $e) {
            return $e;
        }
        return response('Successfully logged out');
    }
}
