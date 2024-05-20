<?php

namespace App\Http\Controllers;

use App\Exceptions\PasswordException;
use App\Http\Requests\ResetPassword\ResetPasswordRequest;
use App\Http\Responses\PasswordResponse;
use App\Models\PasswordSetupMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    /**
     * This function returns a view with a form to reset passoword
     *
     * @return view
     */
    public function showPasswordSetupForm(Request $request) {
        $token = $request->query('token');
        return view('password.password_reset', ['token' => $token]);
    }

    /**
     * This function finds a user from its email, generate new token for password reset and send an email with password reset form
     *
     * @param Illuminate\Http\Request $request the request with the user's email
     * @return App\Http\Responses\PasswordResponse with a success message if the user is found
     * @throws App\Exceptions\PasswordException with an error message if the user is not found
     */
    public function resetPassword(Request $request) {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw new PasswordException('Utente non trovato', 404);
        }

        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addHour()
        ]);

        Mail::to($user->email)->send(new PasswordSetupMail($token));

        return new PasswordResponse('È stata inviata una mail con un link per il reset delle passowrd', 200);
    }

    /**
     * This function update the user's password
     *
     * @param App\Http\Requests\ResetPassword\ResetPasswordRequest $request the request containing the token and the new password
     * @return view
     * @throws App\Exceptions\PasswordException with an error message if the token is not valid
     * @throws App\Exceptions\PasswordException with an error message if the user is not found
     */
    public function update(ResetPasswordRequest $request) {
        $validated = $request->validated();

        $passwordReset = DB::table('password_resets')->where('token', $validated['token'])->first();

        if (!$passwordReset) {
            throw new PasswordException('Token non valido', 401);
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
            throw new PasswordException('Utente non trovato', 404);
        }

        // Update user's password
        $user->password = bcrypt($validated['password']);
        $user->save();

        // Delete the token from password resets table
        DB::table('password_resets')->where('email', $user->email)->delete();

        return view('password.password_success');
    }
}
