<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    /**
     * @OA\Put(
     *     path="/api/users/{user}",
     *     tags={"Users"},
     *     summary="Aggiorna un utente specifico",
     *     description="Aggiorna i dettagli di un utente esistente.",
     *     operationId="updateUser",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="new_password_123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utente aggiornato con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Utente aggiornato con successo"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Richiesta errata, dati non validi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Dati non validi")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utente non trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Utente non trovato")
     *         )
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */
    public function update(UpdateUserRequest $request, User $user) {
        $validated = $request->validated();

        $user->update($validated);

        return new ApiResponse('Utente aggiornato con successo', $user, 201);
    }
}
