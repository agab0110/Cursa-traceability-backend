<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Find a user in the database and attempt to login.
     *
     * @param Illuminate\Http\Request containing the user
     * @return Illuminate\Http\Response json with the logged user and the access token if the user is found
     * @return Illuminate\Http\Response json with a message error if no user is found
     */
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

    /**
     * Create a new user in the database
     *
     * @param Illuminate\Http\Request containing the user
     * @return Illuminate\Http\Response json with the created user, the temporary password and the access token if the user is found
     */
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
        $user->password = $temporaryPassword;

        $user->save();

        return response()->json([
            'data' => $user,

            'psw' => $temporaryPassword,
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer'
        ], 200);
    }

    /**
     * Logout the current user
     *
     * @param Illuminate\Http\Request containing the user
     * @return Illuminate\Http\Response json with a success message
     */
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        return response()->json([
            'message' => 'Logout effettuato con successo'
        ], 200);
    }
}
