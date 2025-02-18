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
     * Update the specified resource in storage.
     * If the cutting flag is true then it create a new lot
     *
     * @param App\Http\Requests\Cut\UpdateCutPlantRequest $request the changes to be made
     * @param int $id the id of the plant
     * @return App\Http\Responses\ApiResponse with the updated plant
     * @throws App\Exceptions\ApiException with an error message if the plant is not found
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
