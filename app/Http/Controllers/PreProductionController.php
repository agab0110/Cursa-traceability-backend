<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\PreProduction\CreateLogSectionRequest;
use App\Http\Requests\PreProduction\NewPreProductionRequest;
use App\Http\Requests\PreProduction\UpdatePreProductionRequest;
use App\Http\Responses\ApiResponse;
use App\Models\LogSection;
use App\Models\PreProduction;
use OpenApi\Annotations as OA;

class PreProductionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pre-productions",
     *     tags={"Pre-Productions"},
     *     summary="Mostra una lista di pre-produzioni",
     *     description="Recupera tutte le pre-produzioni con paginazione.",
     *     operationId="getPreProductions",
     *     @OA\Response(
     *         response=200,
     *         description="Pre-produzioni trovate",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Segherie trovate"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/PreProduction"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nessuna pre-produzione trovata",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Nessuna segheria trovata")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $preProductions = PreProduction::paginate(15);

        if (!$preProductions) {
            throw new ApiException('Nessuna segheria trovata', 404);
        }

        return new ApiResponse('Segherie trovate', $preProductions, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/pre-productions",
     *     tags={"Pre-Productions"},
     *     summary="Crea una nuova pre-produzione",
     *     description="Crea una nuova pre-produzione e la memorizza nel database.",
     *     operationId="storePreProduction",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Segheria Alfa"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pre-produzione creata con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Segheria creata con successo"),
     *             @OA\Property(property="data", ref="#/components/schemas/PreProduction")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dati non validi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Errore nella creazione della segheria")
     *         )
     *     )
     * )
     */
    public function store(NewPreProductionRequest $request)
    {
        $validated = $request->validated();

        $preProduction = PreProduction::create($validated);

        return new ApiResponse('Segheria creata con successo', $preProduction, 201);
    }

    /**
     * Display the specified pre-production.
     *
     * @param string $name the name of the pre-production
     * @return App\Http\Responses\ApiResponse with the pre-production found
     * @throws App\Exceptions\ApiException with an error message if no pre-production is found
     */
    public function show(string $name)
    {
        $preProduction = PreProduction::where('company_name', $name)->get();

        if (!$preProduction) {
            throw new ApiException('Nessuna segheria trovata con quel nome', 404);
        }

        return new ApiResponse('Segheria trovata', $preProduction, 200);
    }

    /**
     * Update the specified pre-production in storage.
     *
     * @param App\Http\Requests\PreProduction\UpdatePreProductionRequest $request containing the changes to be made
     * @param int $id the id of the pre-production to update
     * @return App\Http\Responses\ApiResponse with the updated pre-production
     * @throws App\Exceptions\ApiException with an error message if the pre-production is not found
     */
    public function update(UpdatePreProductionRequest $request, $id)
    {
        $preProduction = PreProduction::find($id);

        if (!$preProduction) {
            throw new ApiException('Segheria non trovata', 404);
        }

        $validated = $request->validated();

        $preProduction->update($validated);

        return new ApiResponse('Segheria aggiornata con successo', $preProduction, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function createLogSection(CreateLogSectionRequest $request) {
        $validated = $request->validated();

        $logSection = new LogSection();

        $logSection->lot_id = $validated['lot_id'];
        $logSection->log_number = $validated['log_number'];
        $logSection->section = $validated['section'];

        $logSection->save();

        return new ApiResponse('Sezione di toppo creata con successo', $logSection, 201);
    }
}
