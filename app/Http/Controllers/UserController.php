<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdatetUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(UpdatetUserRequest $request, User $user) {
        $validated = $request->validated();

        $user->update($validated);

        return response()->json([
            'message' => 'Utente aggiornato con successo',
            'data' => $user,
        ], 200);
    }
}
