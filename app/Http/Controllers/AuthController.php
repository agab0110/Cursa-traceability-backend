<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        $validated = $request->validated();

        if (!Auth::attempt($validated)) {
            return response()->json([
                'message' => 'Parametri non validi',
            ], 401);
        }

        $user = User::where('email', $validated['email'])->first();

        return response()->json([
            'data' => $user,
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer'
        ]);
    }

    public function register(RegisterRequest $request) {
        $validated = $request->validated();

        $temporaryPassword = 'password';

        $user = new User();
        $user->name = $request->input("name");
        $user->surname = $request->input("surname");
        $user->birth_date = $request->input("birth_date");
        $user->cf = $request->input("cf");
        $user->email = $request->input("email");
        $user->role = $request->input("role");
        $user->password = bcrypt($temporaryPassword);

        $user->save();

        return response()->json([
            'data' => $user,
            'psw' => $temporaryPassword,
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer'
        ], 200);
    }
}
