<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    /**
     * This function returns a view with a form to reset passoword
     *
     * @return view
     */
    public function showPasswordSetupForm(Request $request) {
        $token = $request->query('token');
        return view('password_reset', ['token' => $token]);
    }

    /**
     * This function update the user's password
     *
     * @param Illuminate\Http\Request the request containing the token and the new password
     * @return Illuminate\Http\Response a json with an error message if the user is not found
     * @return Illuminate\Http\Response a json with a success message if the user is found and the password is succesfully updated
     */
    public function update(Request $request) {
        $request->validate([
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $passwordReset = DB::table('password_resets')->where('token', $request->token)->first();

        if (!$passwordReset) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Update user's password
        $user->password = bcrypt($request->password);
        $user->save();

        // Delete the token from password resets table
        DB::table('password_resets')->where('email', $user->email)->delete();

        return response()->json(['message' => 'Password updated successfully'], 200);
    }
}
