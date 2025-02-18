<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\ReturningTransport\NewReturningTransportRequest;
use App\Http\Requests\ReturningTransport\UpdateReturningTransportRequest;
use App\Http\Responses\ApiResponse;
use App\Models\ReturningTransport;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ReturningTransportController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/returning-transports",
     *     tags={"Returning Transports"},
     *     summary="Mostra una lista di trasporti di ritorno per una pre-produzione",
     *     description="Recupera tutti i trasporti di ritorno associati a una pre-produzione.",
     *     operationId="getReturningTransportsByPreProductionId",
     *     @OA\Parameter(
     *         name="pre_production_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trasporti trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporti trovati"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ReturningTransport"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trasporto di ritorno non trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Nessun trasporto di ritorno trovato")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $transports = ReturningTransport::where('pre_production_id', $request->pre_production_id)->get();

        if (!$transports) {
            throw new ApiException('Nessun trasporto di ritorno trovato', 404);
        }

        return new ApiResponse('Trasporti trovati', $transports, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/returning-transports",
     *     tags={"Returning Transports"},
     *     summary="Crea un nuovo trasporto di ritorno",
     *     description="Crea un nuovo trasporto di ritorno e lo memorizza nel database.",
     *     operationId="storeReturningTransport",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="pre_production_id", type="integer", example=1),
     *             @OA\Property(property="production_id", type="integer", example=2),
     *             @OA\Property(property="other_field", type="string", example="example value")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Trasporto di ritorno creato con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporto di ritorno creato con successo"),
     *             @OA\Property(property="data", ref="#/components/schemas/ReturningTransport")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Richiesta non valida",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Errore nella creazione del trasporto di ritorno")
     *         )
     *     )
     * )
     */
    public function store(NewReturningTransportRequest $request)
    {
        $validated = $request->validated();

        $returningTransport = ReturningTransport::create($validated);

        return new ApiResponse('Trasporto di ritorno creato con successo', $returningTransport, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/returning-transports/{production_id}",
     *     tags={"Returning Transports"},
     *     summary="Mostra una lista di trasporti di ritorno per una produzione",
     *     description="Recupera tutti i trasporti di ritorno associati a una produzione.",
     *     operationId="getReturningTransportsByProductionId",
     *     @OA\Parameter(
     *         name="production_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trasporti trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporti trovati"),
     *             @OA\Property(property="data", ref="#/components/schemas/ReturningTransport")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trasporto di ritorno non trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Nessun trasporto di ritorno trovato")
     *         )
     *     )
     * )
     */
    public function show(Request $request)
    {
        $transports = ReturningTransport::where('production_id', $request->production_id)->get();

        if (!$transports) {
            throw new ApiException('Nessun trasporto di ritorno trovato', 404);
        }

        return new ApiResponse('Trasporti trovati', $transports, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/returning-transports/{id}",
     *     tags={"Returning Transports"},
     *     summary="Aggiorna un trasporto di ritorno",
     *     description="Aggiorna un trasporto di ritorno esistente.",
     *     operationId="updateReturningTransport",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="pre_production_id", type="integer", example=1),
     *             @OA\Property(property="production_id", type="integer", example=2),
     *             @OA\Property(property="other_field", type="string", example="updated value")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trasporto di ritorno aggiornato con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporto di ritorno aggiornato con successo"),
     *             @OA\Property(property="data", ref="#/components/schemas/ReturningTransport")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trasporto di ritorno non trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporto di ritorno non trovato")
     *         )
     *     )
     * )
     */
    public function update(UpdateReturningTransportRequest $request, $id)
    {
        $returningTransport = ReturningTransport::find($id);

        if (!$returningTransport) {
            throw new ApiException('Trasporto di ritorno non trovato', 404);
        }

        $validated = $request->validated();

        $returningTransport->update($validated);

        return new ApiResponse('Trasporto di ritono aggiornato con successo', $returningTransport, 201);
    }

    public function destroy(string $id)
    {
        //
    }

}
