<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Update the specified user in storage.
     *
     * @param App\Http\Requests\User\UpdateUserRequest the changes to be made
     * @param App\Models\User the user id
     * @return Illuminate\Http\Response a json with the updated user
     */
    public function update(UpdateUserRequest $request, User $user) {
        $validated = $request->validated();

        $user->update($validated);

        return response()->json([
            'message' => 'Utente aggiornato con successo',
            'data' => $user,
        ], 200);
    }
}
