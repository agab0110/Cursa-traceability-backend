<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Production\NewProductionRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Production;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index(Request $request)
    {
        //
    }

   /**
     * @OA\Post(
     *     path="/api/productions",
     *     tags={"Productions"},
     *     summary="Crea una nuova produzione",
     *     description="Crea una nuova produzione e la memorizza nel database.",
     *     operationId="storeProduction",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Produzione XYZ"),
     *             @OA\Property(property="description", type="string", example="Dettagli sulla produzione XYZ")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produzione creata con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Produzione creata con successo"),
     *             @OA\Property(property="data", ref="#/components/schemas/Production")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Richiesta non valida",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Errore nella creazione della produzione")
     *         )
     *     )
     * )
     */
    public function store(NewProductionRequest $request)
    {
        $validated = $request->validated();

        $production = Production::create($validated);

        return new ApiResponse('Produzione creata con successo', $production, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/productions/{id}",
     *     tags={"Productions"},
     *     summary="Mostra una produzione specifica",
     *     description="Recupera una produzione specifica utilizzando l'ID.",
     *     operationId="getProductionById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", example="1")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produzione trovata",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Produzione trovata"),
     *             @OA\Property(property="data", ref="#/components/schemas/Production")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produzione non trovata",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Nessuna produzione trovata")
     *         )
     *     )
     * )
     */
    public function show(Production $production)
    {
        if (!$production) {
            throw new ApiException('Nessuna produzione trovata', 404);
        }

        return new ApiResponse('Produzione trovata', $production, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
