<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\AuthResponse;
use App\Models\PasswordSetupMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Find a user in the database and attempt to login.
     *
     * @param App\Http\Requests\Auth\LoginRequest containing the user
     * @return App\Http\Responses\AuthResponse with the logged user and the access token if the user is found
     * @throws App\Exceptions\ApiException with a message error if no user is found
     */
    public function login(LoginRequest $request) {
        $validated = $request->validated();

        if (!Auth::attempt($validated)) {
            throw new ApiException('Parametri non validi', 400);
        }

        $user = User::where('email', $validated['email'])->first();

        $token = $user->createToken('api_token')->plainTextToken;

        return new AuthResponse('Login effettuato', $user, $token, 200);
    }

    /**
     * Create a new user in the database
     *
     * @param App\Http\Requests\Auth\RegisterRequest containing the user
     * @return App\Http\Responses\AuthResponse with a success message if the user is found
     */
    public function register(RegisterRequest $request) {
        $validated = $request->validated();

        $temporaryPassword = 'password';

        $user = new User();
        $user->name = $validated['name'];
        $user->surname = $validated['surname'];
        $user->birth_date = $validated['birth_date'];
        $user->cf = $validated['cf'];
        $user->email = $validated['email'];
        $user->role_id = $validated['role_id'];
        $user->password = $temporaryPassword;

        $user->save();

        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addHour()
        ]);

        Mail::to($user->email)->send(new PasswordSetupMail($token));

        return new AuthResponse('Utente creato con successo', null, null, 200);
    }

    /**
     * Logout the current user
     *
     * @param Illuminate\Http\Request containing the user
     * @return App\Http\Responses\AuthResponse with a success message
     */
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        return new AuthResponse('Logout effettuato', null, null, 200);
    }
}
