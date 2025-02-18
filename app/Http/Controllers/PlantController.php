<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Plant\StorePlantRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Forest;
use App\Models\Plant;
use App\Services\Blockchain\BlockchainBridge;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class PlantController extends Controller
{
    protected $blockchainService;

    public function __construct(BlockchainBridge $blockchainService) {
        $this->blockchainService = $blockchainService;
    }

    /**
     * @OA\Get(
     *     path="/api/plants",
     *     tags={"Plants"},
     *     summary="Mostra una lista di piante",
     *     description="Recupera tutte le piante che non sono state segate o tagliate, filtrando per stato.",
     *     operationId="getPlants",
     *     @OA\Parameter(
     *         name="hammered",
     *         in="query",
     *         required=true,
     *         description="Filtra per stato delle piante (e.g. se sono state martellate o no).",
     *         @OA\Schema(type="boolean", example=true)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Piante trovate",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Piante trovate"),
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
     *         description="Piante non trovate",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Piante non trovate")
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
            throw new ApiException('Piante non trovate', 404);
        }

        return new ApiResponse('Piante trovate', $plants, 200);
    }


    /**
     * @OA\Post(
     *     path="/api/plants",
     *     tags={"Plants"},
     *     summary="Crea una nuova pianta",
     *     description="Crea una nuova pianta e la associa a una foresta. I dati della pianta vengono inviati anche alla blockchain.",
     *     operationId="storePlant",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="lat", type="number", format="float", example=45.123),
     *             @OA\Property(property="lng", type="number", format="float", example=9.123),
     *             @OA\Property(property="particle", type="integer", example=1),
     *             @OA\Property(property="woody_species", type="string", example="Quercia"),
     *             @OA\Property(property="diameter", type="number", format="float", example=25.52),
     *             @OA\Property(property="height", type="number", format="float", example=25.52),
     *             @OA\Property(property="cultivar", type="string", example="Sconosciuta"),
     *             @OA\Property(property="propagation", type="string", example="Sconosciuta"),
     *             @OA\Property(property="georeferenzial_date", type="date", example="2025-05-03"),
     *             @OA\Property(property="notes", type="string", example="Note per la pianta"),
     *             @OA\Property(property="hammered", type="boolean", example=false),
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
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dati non validi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Errore nella creazione della pianta")
     *         )
     *     )
     * )
     */
    public function store(StorePlantRequest $request)
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
     *     path="/api/plants/{id}",
     *     tags={"Plants"},
     *     summary="Mostra una pianta specifica",
     *     description="Recupera una pianta utilizzando il suo ID.",
     *     operationId="getPlantById",
     *     @OA\Parameter(
     *         name="plant",
     *         in="path",
     *         required=true,
     *         description="ID della pianta",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pianta trovata",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Pianta trovata"),
     *             @OA\Property(property="data", ref="#/components/schemas/Plant")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pianta non trovata",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Pianta non trovata")
     *         )
     *     )
     * )
     */
    public function show(Request $request, Plant $plant)
    {
        if (!$plant) {
            throw new ApiException('Pianta non trovata', 404);
        }

        return new ApiResponse('Pianta trovata', $plant, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    /**
     * @OA\Get(
     *     path="/api/plant/getPlantByForestId",
     *     tags={"Plants"},
     *     summary="Mostra piante in base alla foresta",
     *     description="Recupera tutte le piante appartenenti a una foresta specifica.",
     *     operationId="getPlantsByForestId",
     *     @OA\Parameter(
     *         name="forest_id",
     *         in="query",
     *         required=true,
     *         description="ID della foresta",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="hammered",
     *         in="query",
     *         required=false,
     *         description="Filtra per stato delle piante",
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Piante trovate",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Piante trovate"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Plant"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Piante non trovate",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Piante non trovate")
     *         )
     *     )
     * )
     */
    public function getPlantByForestId(Request $request) {      // manca la paginazione
        $plants = Plant::where('forest_id', $request->query('forest_id'))
                        ->where('hammered', $request->query('hammered'))
                        ->where('cutting', 0)
                        ->where('cutted', 0)
                        ->get();

        if (!$plants) {
            throw new ApiException('Piante non trovate', 404);
        }

        return new ApiResponse('Piante trovate', $plants, 200);
    }
}
