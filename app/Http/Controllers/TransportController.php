<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Transport\NewTransportRequest;
use App\Http\Requests\Transport\UpdateTransportRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Transport;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class TransportController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/transports",
     *     tags={"Transports"},
     *     summary="Mostra tutti i trasporti per una specifica compagnia",
     *     description="Recupera tutti i trasporti associati a una compagnia specificata.",
     *     operationId="getTransportsByCompany",
     *     @OA\Parameter(
     *         name="company_name",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", example="ACME Corp")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trasporti trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporti trovati"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Transport"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trasporti non trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporti non trovati")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $transports = Transport::where('company_name', $request->query('company_name'))->get();

        if (!$transports) {
            throw new ApiException('Trasporti non trovati', 404);
        }

        return new ApiResponse('Trasporti trovati', $transports, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/transports",
     *     tags={"Transports"},
     *     summary="Crea un nuovo trasporto",
     *     description="Crea un nuovo trasporto con i dati forniti.",
     *     operationId="createTransport",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"company_name", "vehicle_type", "status"},
     *             @OA\Property(property="company_name", type="string", example="ACME Corp"),
     *             @OA\Property(property="vehicle_type", type="string", example="Truck"),
     *             @OA\Property(property="status", type="string", example="In Transit")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trasporto creato con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporto creato con successo"),
     *             @OA\Property(property="data", ref="#/components/schemas/Transport")
     *         )
     *     )
     * )
     */
    public function store(NewTransportRequest $request)
    {
        $validated = $request->validated();

        $transport = Transport::create($validated);

        return new ApiResponse('Trasporto creato con successo', $transport, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/transports/{transport}",
     *     tags={"Transports"},
     *     summary="Mostra un trasporto specifico",
     *     description="Recupera un trasporto utilizzando il suo ID.",
     *     operationId="getTransportById",
     *     @OA\Parameter(
     *         name="transport",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trasporto trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporto trovato"),
     *             @OA\Property(property="data", ref="#/components/schemas/Transport")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trasporto non trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporto non trovato")
     *         )
     *     )
     * )
     */
    public function show(Transport $transport)
    {
        if (!$transport) {
            throw new ApiException('Trasporto non trovato', 404);
        }

        return new ApiResponse('Trasporto trovato', $transport, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/transports/{id}",
     *     tags={"Transports"},
     *     summary="Aggiorna un trasporto specifico",
     *     description="Aggiorna i dettagli di un trasporto esistente.",
     *     operationId="updateTransport",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"company_name", "vehicle_type", "status"},
     *             @OA\Property(property="company_name", type="string", example="ACME Corp"),
     *             @OA\Property(property="vehicle_type", type="string", example="Truck"),
     *             @OA\Property(property="status", type="string", example="Delivered")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trasporto aggiornato con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporto aggiornato con successo"),
     *             @OA\Property(property="data", ref="#/components/schemas/Transport")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trasporto non trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporto non trovato")
     *         )
     *     )
     * )
     */
    public function update(UpdateTransportRequest $request, $id)
    {
        $transport = Transport::find($id);

        if (!$transport) {
            throw new ApiException('Trasporto non trovato', 404);
        }

        $validated = $request->validated();

        $transport->update($validated);

        return new ApiResponse('Trasporto aggiornato con successo', $transport, 201);
    }

    /**
     * @OA\Delete(
     *     path="/api/transports/{id}",
     *     tags={"Transports"},
     *     summary="Rimuovi un trasporto",
     *     description="Elimina un trasporto esistente.",
     *     operationId="deleteTransport",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Trasporto eliminato con successo"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trasporto non trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporto non trovato")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        // Implementa la logica per eliminare il trasporto
    }

    /**
     * @OA\Get(
     *     path="/api/transports/pre-production",
     *     tags={"Transports"},
     *     summary="Mostra trasporti per una pre-produzione",
     *     description="Recupera tutti i trasporti associati a un pre-produzione specificato.",
     *     operationId="getPreProductionTransports",
     *     @OA\Parameter(
     *         name="pre_production_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", example=101)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trasporti trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporti trovati"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Transport"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trasporti non trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporti non trovati")
     *         )
     *     )
     * )
     */
    public function getPreProductionTransports(Request $request)
    {
        $transports = Transport::Where('pre_production_id', $request['pre_production_id'])->get();

        if (!$transports) {
            throw new ApiException('Trasporti non trovati', 404);
        }

        return new ApiResponse('Trasporti trovati', $transports, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/transports/production",
     *     tags={"Transports"},
     *     summary="Mostra trasporti per una produzione",
     *     description="Recupera tutti i trasporti associati a una produzione specificata.",
     *     operationId="getProductionTransports",
     *     @OA\Parameter(
     *         name="production_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", example=202)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trasporti trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporti trovati"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Transport"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trasporti non trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Trasporti non trovati")
     *         )
     *     )
     * )
     */
    public function getProductionTransports(Request $request)
    {
        $transports = Transport::Where('production_id', $request['production_id'])->get();

        if (!$transports) {
            throw new ApiException('Trasporti non trovati', 404);
        }

        return new ApiResponse('Trasporti trovati', $transports, 200);
    }
}
