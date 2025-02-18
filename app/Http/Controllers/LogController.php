<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Log\StoreLogRequest;
use App\Http\Requests\Log\UpdateLogRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/logs",
     *     tags={"Logs"},
     *     summary="Recupera un elenco di log",
     *     description="Recupera l'elenco di tutti i log con filtro per 'lot_id' e paginazione.",
     *     operationId="getLogs",
     *     @OA\Parameter(
     *         name="lot_id",
     *         in="query",
     *         required=true,
     *         description="ID del lotto per filtrare i log",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Log trovati con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Toppi trovati"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Log")),
     *             @OA\Property(property="pagination", type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="per_page", type="integer", example=13),
     *                 @OA\Property(property="total", type="integer", example=100)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Toppi non trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Toppi non trovati")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $logs = Log::where('lot_id', $request->query('lot_id'))
                        ->paginate(13);

        if (!$logs) {
            throw new ApiException('Toppi non trovati', 404);
        }

        return new ApiResponse('Toppi trovati', $logs, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/logs",
     *     tags={"Logs"},
     *     summary="Crea un nuovo log",
     *     description="Crea un nuovo log e lo memorizza nel database.",
     *     operationId="storeLog",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="number", type="integer", example=1),
     *             @OA\Property(property="lot_id", type="integer", example=1),
     *             @OA\Property(property="length", type="number", format="float", example=12.30),
     *             @OA\Property(property="median", type="number", format="float", example=12.30),
     *             @OA\Property(property="cut_date", type="string", format="date", example="2025-05-03")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Toppo creato con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Toppo creato con successo"),
     *             @OA\Property(property="data", ref="#/components/schemas/Log")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dati non validi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Errore nella creazione del toppo")
     *         )
     *     )
     * )
     */
    public function store(StoreLogRequest $request)
    {
        $validated = $request->validated();

        $log = Log::create($validated);

        return new ApiResponse('Toppo creato con successo', $log, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/api/logs/{id}",
     *     tags={"Logs"},
     *     summary="Aggiorna un log esistente",
     *     description="Aggiorna un log esistente nel database.",
     *     operationId="updateLog",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="number", type="integer", example=1),
     *             @OA\Property(property="lenght", type="number", format="float", example=12.30),
     *             @OA\Property(property="median", type="number", format="float", example=12.30),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Toppo aggiornato con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Toppo aggiornato con successo"),
     *             @OA\Property(property="data", ref="#/components/schemas/Log")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Toppo non trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Toppo non trovato")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dati non validi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Errore nell'aggiornamento del log")
     *         )
     *     )
     * )
     */
    public function update(UpdateLogRequest $request, Log $log)
    {
        if (!$log) {
            throw new ApiException('Toppo non trovato', 404);
        }

        $validated = $request->validated();

        $log->update($validated);

        return new ApiResponse('Toppo aggiornato con successo', $log, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
