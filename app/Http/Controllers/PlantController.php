<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Plant\StorePlantRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Forest;
use App\Models\Plant;
use App\Services\Blockchain\BlockchainService;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    protected $blockchainService;

    public function __construct(BlockchainService $blockchainService = null) {
        $this->blockchainService = $blockchainService;
    }

    /**
     * Display a listing of plants using pagination.
     * The plants are not hammered or cutted
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
            throw new ApiException('Piante non trovate', 404);
        }

        return new ApiResponse('Piante trovate', $plants, 200);
    }

    /**
     * Store a newly created plant in storage and associate it with a forest.
     *
     * This method validates the input data, creates a new plant, associates it
     * with the specified forest, and sends the plant's data to the blockchain.
     *
     * @param  \App\Http\Requests\Plant\StorePlantRequest the request containing the plant data to store.
     * @return App\Http\Responses\ApiResponse with the created plant and blockchain transaction details.
     */
    public function store(StorePlantRequest $request)
    {
        $validated = $request->validated();

        $forest = Forest::find($validated['forest_id']);

        $plant = Plant::create($validated);

        $plant->forest()->associate($forest);
        $plant->save();

        // invio dati alla blockchain
        $blockchaninData = [
            'lat' => $plant->lat,
            'lng' => $plant->lng,
            'plant_id' => $plant->id,
        ];

        $blockchainResponse = $this->blockchainService->processTransaction($blockchaninData);

        return new ApiResponse('Pianta creata con successo', [$plant, $blockchainResponse], 201);
    }

    /**
     * Display the specified plant.
     *
     * @param  Illuminate\Http\Request $request the request found
     * @param  App\Models\Plant $plant the id of the plant to show
     * @return App\Http\Responses\ApiResponse with the plant found
     * @throws App\Exceptions\ApiException with an error message if the plant is not found
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
     * Get a list of elements from storage given a forest id
     *
     * @param Request $request the forest id and hammered flag
     * @return App\Http\Responses\ApiResponse with a list of plants
     * @throws App\Exceptions\ApiException with an error message if no plants are found
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
