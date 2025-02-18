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
     * @OA\Get(
     *     path="/api/pre-productions/{name}",
     *     tags={"Pre-Productions"},
     *     summary="Mostra i dettagli di una pre-produzione specifica",
     *     description="Recupera una pre-produzione in base al nome dell'azienda (company_name).",
     *     operationId="getPreProductionByName",
     *     @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="Nome dell'azienda per la quale cercare la pre-produzione.",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Nome Azienda"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Segheria trovata",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Segheria trovata"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/PreProduction"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nessuna pre-produzione trovata con quel nome",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Nessuna segheria trovata con quel nome")
     *         )
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/pre-productions/{id}",
     *     tags={"Pre-Productions"},
     *     summary="Aggiorna una pre-produzione esistente",
     *     description="Aggiorna i dettagli di una pre-produzione specifica identificata tramite l'ID.",
     *     operationId="updatePreProduction",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID della pre-produzione da aggiornare.",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="I dati da aggiornare per la pre-produzione.",
     *         @OA\JsonContent(
     *             @OA\Property(property="company_name", type="string", example="Nome Azienda"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Segheria aggiornata con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Segheria aggiornata con successo"),
     *             @OA\Property(property="data", ref="#/components/schemas/PreProduction")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Segheria non trovata",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Segheria non trovata")
     *         )
     *     )
     * )
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

    /**
     * @OA\Post(
     *     path="/api/log-section/create-log-section",
     *     tags={"Log Sections"},
     *     summary="Crea una nuova sezione di toppo",
     *     description="Crea una nuova sezione di toppo (log section) con i dati forniti.",
     *     operationId="createLogSection",
     *     @OA\RequestBody(
     *         required=true,
     *         description="I dati necessari per creare una nuova sezione di toppo.",
     *         @OA\JsonContent(
     *             required={"lot_id", "log_number", "section"},
     *             @OA\Property(property="lot_id", type="integer", example=123),
     *             @OA\Property(property="log_number", type="string", example="456"),
     *             @OA\Property(property="section", type="string", example="Sezione 1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Sezione di toppo creata con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sezione di toppo creata con successo"),
     *             @OA\Property(property="data", ref="#/components/schemas/LogSection")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dati di input non validi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Dati non validi")
     *         )
     *     )
     * )
     */
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
