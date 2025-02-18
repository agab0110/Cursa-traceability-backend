<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\Role;
use OpenApi\Annotations as OA;

class RoleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/roles/{id}",
     *     tags={"Roles"},
     *     summary="Mostra un ruolo specifico",
     *     description="Recupera il ruolo utilizzando il suo ID.",
     *     operationId="getRoleById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ruolo trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ruolo trovato"),
     *             @OA\Property(property="data", type="string", example="Admin")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ruolo non trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ruolo non trovato")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $role = Role::find($id);

        return new ApiResponse('Ruolo trovato', $role->name, 200);
    }
}
