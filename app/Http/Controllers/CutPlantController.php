<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Cut\UpdateCutPlantRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Lot;
use App\Models\Plant;
use App\Services\Blockchain\BlockchainBridge;
use Illuminate\Http\Request;

class CutPlantController extends Controller
{
    protected $blockchainService;

    public function __construct(BlockchainBridge $blockchainService) {
        $this->blockchainService = $blockchainService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
     *     path="/api/plants/{id}",
     *     tags={"Plants"},
     *     summary="Aggiorna una pianta",
     *     description="Aggiorna i dettagli di una pianta esistente. Se la pianta viene segata, viene creato un nuovo lotto.",
     *     operationId="updateCuttedPlant",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID della pianta da aggiornare",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="cutting", type="boolean", example=true),
     *             @OA\Property(property="cutted", type="boolean", example=false),
     *             @OA\Property(property="cutting_date", type="date", example="2025-05-03")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pianta aggiornata con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Pianta aggiornata con successo"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Plant")),
     *             @OA\Property(property="blockchainResponse", type="object",
     *                 @OA\Property(property="status", type="string", example="success"),
     *                 @OA\Property(property="transactionId", type="string", example="abcd1234xyz")
     *             )
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
    public function update(UpdateCutPlantRequest $request, $id)
    {
        $plant = Plant::find($id);

        if (!$plant) {
            throw new ApiException('Pianta non trovata', 404);
        }

        $validated = $request->validated();

        $plant->update($validated);

        if ($validated['cutting'] == true && $validated['cutted'] == false) {
            $lot = Lot::create([
                'plant_id' => $plant->id,
            ]);

            $lot->save();
        }

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
     */
    public function destroy(string $id)
    {
        //
    }
}
