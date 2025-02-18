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
     * Display a listing of plants using pagination if the cutting and cutted flags are false.
     *
     * @param  Illuminate\Http\Request $request the request sent
     * @return App\Http\Responses\ApiResponse with a list of plants
     * @throws App\Exceptions\ApiException with an error message if no plants are found
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
     * Store a newly created hammered plant in storage.
     *
     * @param  App\Http\Requests\HammeredPlant\StoreHammeredPlantRequest $request the new plant
     * @return App\Http\Responses\ApiResponse with the new plant created
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
     * Display the specified hammered plant.
     *
     * @param  int  $id the id of the plant
     * @return App\Http\Responses\ApiResponse with the found plant
     * @throws Illuminate\Http\ResponseApp\Exceptions\ApiException with an error message if the plant is not found
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
     * Update the specified hammered plant in storage.
     *
     * @param  App\Http\Requests\HammeredPlant\UpdateHammeredPlantRequest $request the changes to be made
     * @param  int  $id the id of the plant to update
     * @return App\Http\Responses\ApiResponse with the updated plant
     * @throws App\Exceptions\ApiException with an error message if the plant is not found
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
