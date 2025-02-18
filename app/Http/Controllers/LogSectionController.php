<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\LogSection\NewLogSectionRequest;
use App\Http\Responses\ApiResponse;
use App\Models\LogSection;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class LogSectionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/log-sections",
     *     tags={"Log Sections"},
     *     summary="Recupera le sezioni di log per un lotto specifico",
     *     description="Recupera un elenco di sezioni di log in base a `lot_id` e `log_number`.",
     *     operationId="getLogSections",
     *     @OA\Parameter(
     *         name="lot_id",
     *         in="query",
     *         required=true,
     *         description="ID del lotto",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="log_number",
     *         in="query",
     *         required=true,
     *         description="Numero del log",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sezioni trovate",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sezioni trovate"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/LogSection"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nessuna sezione trovata",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Nessuna sezione presente")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $sections = LogSection::where('lot_id', $request->lot_id)->where('log_number', $request->log_number)->get();

        if (!$sections) {
            throw new ApiException('Nessuna sezione presente', 404);
        }

        return new ApiResponse('Sezioni trovate', $sections, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/log-sections",
     *     tags={"Log Sections"},
     *     summary="Crea una nuova sezione di log",
     *     description="Crea una nuova sezione di log e la memorizza nel database.",
     *     operationId="storeLogSection",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="lot_id", type="integer", example=1),
     *             @OA\Property(property="log_number", type="integer", example=123),
     *             @OA\Property(property="section", type="string", example="Sezione 1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Sezione di log creata con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sezione di toppo creata"),
     *             @OA\Property(property="data", ref="#/components/schemas/LogSection")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dati non validi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Errore nella creazione della sezione di log")
     *         )
     *     )
     * )
     */
    public function store(NewLogSectionRequest $request)
    {
        $validated = $request->validated();

        $section = LogSection::create($validated);

        return new ApiResponse('Sezione di toppo creata', $section, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
