<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\HammeredPlant\StoreHammeredPlantRequest;
use App\Http\Requests\HammeredPlant\UpdateHammeredPlantRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Forest;
use App\Models\Plant;
use App\Services\Blockchain\BlockchainBridge;
use Illuminate\Http\Request;

class HammeredPlantsController extends Controller
{
    protected $blockchainService;

    public function __construct(BlockchainBridge $blockchainService) {
        $this->blockchainService = $blockchainService;
    }

    /**
     * @OA\Get(
     *     path="/api/plants",
     *     tags={"Plants"},
     *     summary="Recupera un elenco di alberi filtrati",
     *     description="Recupera l'elenco di alberi filtrati per 'hammered' con stati 'cutting' e 'cutted' pari a 0 e paginazione.",
     *     operationId="getFilteredPlants",
     *     @OA\Parameter(
     *         name="hammered",
     *         in="query",
     *         required=true,
     *         description="Filtro per lo stato degli alberi 'hammered'",
     *         @OA\Schema(type="boolean", example=true)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Alberi trovati con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Alberi trovati"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Plant")),
     *             @OA\Property(property="pagination", type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="per_page", type="integer", example=13),
     *                 @OA\Property(property="total", type="integer", example=100)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Alberi non trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Alberi non trovati")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $plants = Plant::where('hammered', $request->query('hammered'))
                        ->where('cutting', 0)
                        ->where('cutted', 0)
                        ->paginate(13);

        if (!$plants) {
            throw new ApiException('Alberi non trovati', 404);
        }

        return new ApiResponse('Alberi trovati', $plants, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/hammered-plants",
     *     tags={"Plants"},
     *     summary="Crea una nuova pianta",
     *     description="Crea una nuova pianta associata a una foresta e invia i dati alla blockchain.",
     *     operationId="storePlant",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dati della pianta da creare.",
     *         @OA\JsonContent(
     *             @OA\Property(property="lat", type="number", format="float", example=45.123),
     *             @OA\Property(property="lng", type="number", format="float", example=9.123),
     *             @OA\Property(property="particle", type="integer", example=1),
     *             @OA\Property(property="woody_species", type="string", example="Quercia"),
     *             @OA\Property(property="diameter", type="number", format="float", example=25.52),
     *             @OA\Property(property="height", type="number", format="float", example=25.52),
     *             @OA\Property(property="cultivar", type="string", example="Sconosciuta"),
     *             @OA\Property(property="propagation", type="string", example="Sconosciuta"),
     *             @OA\Property(property="hammered_date", type="date", example="2025-05-03"),
     *             @OA\Property(property="notes", type="string", example="Note per la pianta"),
     *             @OA\Property(property="hammered", type="boolean", example="false"),
     *             @OA\Property(property="forest_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pianta creata con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Pianta creata con successo"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Plant")),
     *             @OA\Property(property="blockchainResponse", type="object",
     *                 @OA\Property(property="status", type="string", example="success"),
     *                 @OA\Property(property="transactionId", type="string", example="abcd1234xyz")
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dati di input non validi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Dati di input non validi")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Errore interno del server",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Errore interno del server")
     *         )
     *     )
     * )
     */
    public function store(StoreHammeredPlantRequest $request)
    {
        $validated = $request->validated();

        $forest = Forest::find($validated['forest_id']);

        $plant = Plant::create($validated);

        $plant->forest()->associate($forest);
        $plant->save();

        // invio dati alla blockchain
        $blockchainData = [
            'lat' => $plant->lat,
            'lng' => $plant->lng,
            'plant_id' => $plant->id,
        ];

        $blockchainResponse = $this->blockchainService->sendData($blockchainData);

        return new ApiResponse('Pianta creata con successo', [$plant, $blockchainResponse], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/hammered-plants/{id}",
     *     tags={"Plants"},
     *     summary="Recupera i dettagli di una pianta",
     *     description="Recupera i dettagli di una pianta specificata tramite il suo ID.",
     *     operationId="showPlant",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID della pianta da recuperare",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pianta trovata con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Albero trovato"),
     *             @OA\Property(property="data", ref="#/components/schemas/Plant"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pianta non trovata",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Albero non trovato")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Errore interno del server",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Errore interno del server")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $plant = Plant::find($id);

        if (!$plant) {
            throw new ApiException('Albero non trovato', 404);
        }

        return new ApiResponse('Albero trovato', $plant, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/hammered-plants/{id}",
     *     tags={"Plants"},
     *     summary="Aggiorna i dettagli di una pianta",
     *     description="Aggiorna i dettagli di una pianta esistente specificata tramite il suo ID e invia i dati alla blockchain.",
     *     operationId="updatePlant",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID della pianta da aggiornare",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dati della pianta da aggiornare.",
     *         @OA\JsonContent(
     *             @OA\Property(property="hammered_date", type="date", example="2025-05-03"),
     *             @OA\Property(property="hammered", type="boolean", description="Stato 'hammered' della pianta", example=true),
     *             @OA\Property(property="diameter", type="number", format="float", example=12.50),
     *             @OA\Property(property="height", format="float", example=12.50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pianta aggiornata con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Albero aggiornato con successo"),
     *             @OA\Property(property="data", ref="#/components/schemas/Plant"),
     *             @OA\Property(property="blockchainResponse", type="object",
     *                 @OA\Property(property="status", type="string", example="success"),
     *                 @OA\Property(property="transactionId", type="string", example="abcd1234xyz")
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pianta non trovata",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Albero non trovato")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dati di input non validi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Dati di input non validi")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Errore interno del server",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Errore interno del server")
     *         )
     *     )
     * )
     */
    public function update(UpdateHammeredPlantRequest $request, $id)
    {
        $plant = Plant::find($id);

        if (!$plant) {
            throw new ApiException('Albero non trovato', 404);
        }

        $validated = $request->validated();

        $plant->update($validated);

        // invio dati alla blockchain
        $blockchainData = [
            'lat' => $plant->lat,
            'lng' => $plant->lng,
            'plant_id' => $plant->id,
        ];

        $blockchainResponse = $this->blockchainService->sendData($blockchainData);

        return new ApiResponse('Albero aggiornato con successo', [$plant, $blockchainResponse], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
