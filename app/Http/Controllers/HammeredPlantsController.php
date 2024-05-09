<?php

namespace App\Http\Controllers;

use App\Http\Requests\HammeredPlant\StoreHammeredPlantRequest;
use App\Http\Requests\HammeredPlant\UpdateHammeredPlantRequest;
use App\Models\Forest;
use App\Models\Plant;
use Illuminate\Http\Request;

class HammeredPlantsController extends Controller
{
    /**
     * Display a listing of plants using pagination if the flags cutting and cutted are false.
     *
     * @param  Illuminate\Http\Request the request sent
     * @return Illuminate\Http\Response a json with an error message if no plants are found
     * @return Illuminate\Http\Response a json with a list of plants
     */
    public function index(Request $request)
    {
        $plants = Plant::where('hammered', $request->query('hammered'))
                        ->where('cutting', 0)
                        ->where('cutted', 0)
                        ->paginate(13);

        if (!$plants) {
            return response()->json([
                'message' => 'Alberi non trovati',
            ], 404);
        }

        return response()->json([
            'message' => 'Alberi trovati',
            'data' => $plants
        ], 200);
    }

    /**
     * Store a newly created hammered plant in storage.
     *
     * @param  App\Http\Requests\HammeredPlant\StoreHammeredPlantRequest the new plant
     * @return Illuminate\Http\Response a json with the new plant created
     */
    public function store(StoreHammeredPlantRequest $request)
    {
        $validated = $request->validated();

        $forest = Forest::find($request['forest_id']);

        $plant = Plant::create($validated);

        $plant->forest()->associate($forest);
        $plant->save();

        return response()->json([
            'message' => 'Pianta creata con successo',
            'data' => $plant
        ], 200);
    }

    /**
     * Display the specified hammered plant.
     *
     * @param  int  $id the id of the plant
     * @return Illuminate\Http\Response a json with an error message if the plant is not found
     * @return Illuminate\Http\Response a json with the found plant
     */
    public function show($id)
    {
        $plant = Plant::find($id);

        if (!$plant) {
            return response()->json([
                'message' => 'Albero non trovato'
            ], 404);
        }

        return response()->json([
            'message' => 'Albero trovato',
            'data' => $plant
        ], 200);
    }

    /**
     * Update the specified hammered plant in storage.
     *
     * @param  App\Http\Requests\HammeredPlant\UpdateHammeredPlantRequest the changes to be made
     * @param  int  $id the id of the plant to update
     * @return Illuminate\Http\Response a json with an error message if the plant is not found
     * @return Illuminate\Http\Response a json with the updated plant
     */
    public function update(UpdateHammeredPlantRequest $request, $id)
    {
        $plant = Plant::find($id);

        if (!$plant) {
            return response()->json([
                'message' => 'Albero non trovato',
            ], 404);
        }

        $validated = $request->validated();

        $plant->update($validated);

        return response()->json([
            'message' => 'Albero aggiornato con successo',
            'data' => $plant,
        ], 200);
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
