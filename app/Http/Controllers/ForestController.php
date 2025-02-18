<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Forest\StoreForestRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Forest;
use Illuminate\Http\Request;

class ForestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/forests",
     *     tags={"Forests"},
     *     summary="Recupera una lista di boschi",
     *     description="Recupera tutti i boschi disponibili, con paginazione.",
     *     operationId="getForests",
     *     @OA\Response(
     *         response=200,
     *         description="Boschi trovati con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Boschi trovati"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Forest")),
     *             @OA\Property(property="pagination", type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="per_page", type="integer", example=15),
     *                 @OA\Property(property="total", type="integer", example=100)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Boschi non trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Boschi non trovati")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $forests = Forest::paginate(15);

        if (!$forests) {

            throw new ApiException('Boschi non trovati', 404);
        }

        return new ApiResponse('Boschi trovati', $forests, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/forests",
     *     tags={"Forests"},
     *     summary="Crea un nuovo bosco",
     *     description="Crea un nuovo bosco con i dati forniti.",
     *     operationId="storeForest",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Foresta di esempio"),
     *             @OA\Property(property="city", type="string", example="Italia"),
     *             @OA\Property(property="region", type="string", example="Roma"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Bosco creato con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Bosco creato con successo"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Forest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dati non validi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Errore nella creazione del bosco")
     *         )
     *     )
     * )
     */
    public function store(StoreForestRequest $request)
    {
        $validated = $request->validated();

        $forest = Forest::create($validated);

        return new ApiResponse('Bosco creato con successo', $forest, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/forests/{id}",
     *     tags={"Forests"},
     *     summary="Recupera un bosco specifico",
     *     description="Recupera i dettagli di un bosco specifico tramite il suo ID.",
     *     operationId="showForest",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del bosco da recuperare",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bosco trovato con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Bosco trovato"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Forest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bosco non trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Bosco non trovato")
     *         )
     *     )
     * )
     */
    public function show(Request $request, Forest $forest)
    {
        if (!$forest) {
            throw new ApiException('Bosco non trovato', 404);
        }

        return new ApiResponse('Bosco trovato', $forest, 200);
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
