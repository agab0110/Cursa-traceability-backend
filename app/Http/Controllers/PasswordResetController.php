<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPassword\ResetPasswordRequest;
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
     * @param Illuminate\Http\Request the request with the user's email
     * @return Illuminate\Http\Response a json with an error message if the user is not found
     * @return Illuminate\Http\Response a json with a success message if the user is found
     */
    public function resetPassword(Request $request) {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Utente non trovato'
            ], 404);
        }

        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addHour()
        ]);

        Mail::to($user->email)->send(new PasswordSetupMail($token));

        return response()->json([
            'message' => 'È stata inviata una mail con un link per il reset della password'
        ], 200);
    }

    /**
     * This function update the user's password
     *
     * @param Illuminate\Http\Request the request containing the token and the new password
     * @return Illuminate\Http\Response a json with an error message if the user is not found
     * @return Illuminate\Http\Response a json with a success message if the user is found and the password is succesfully updated
     */
    public function update(ResetPasswordRequest $request) {
        $validated = $request->validated();

        $passwordReset = DB::table('password_resets')->where('token', $request->token)->first();

        if (!$passwordReset) {
            return response()->json(['error' => 'Token non valido'], 400);
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Utente non trovato'], 404);
        }

        // Update user's password
        $user->password = bcrypt($request->password);
        $user->save();

        // Delete the token from password resets table
        DB::table('password_resets')->where('email', $user->email)->delete();

        return view('password.password_success');
    }
}
