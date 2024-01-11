<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request, User $user) {
        $validated = $request->validated();

        $user->update($validated);

        return response()->json([
            'message' => 'Utente aggiornato con successo',
            'data' => $user,
        ], 200);
    }
}
