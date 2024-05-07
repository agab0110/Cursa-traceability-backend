<?php

namespace App\Http\Controllers;

use App\Http\Requests\Plant\StorePlantRequest;
use App\Models\Forest;
use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    /**
     * Display a listing of plants using pagination.
     * The plants are not hammered or cutted
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
                'message' => 'Piante non trovate',
            ], 404);
        }

        return response()->json([
            'message' => 'Piante trovate',
            'data' => $plants
        ], 200);
    }

    /**
     * Store a newly created plant in storage.
     * It assoiate a plant with a forest
     *
     * @param  \App\Http\Requests\Plant\StorePlantRequest the plant to store
     * @return \Illuminate\Http\Response a json with the created plant
     */
    public function store(StorePlantRequest $request)
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
     * Display the specified plant.
     *
     * @param  Illuminate\Http\Request the request found
     * @param  App\Models\Plant $plant the id of the plant to show
     * @return Illuminate\Http\Response a json with an error message if the plant is not found
     * @return Illuminate\Http\Response a json with the plant found
     */
    public function show(Request $request, Plant $plant)
    {
        if (!$plant) {
            return response()->json([
                'message' => 'Pianta non trovata'
            ], 404);
        }

        return response()->json([
            'message' => 'Pianta trovata',
            'data' => $plant
        ], 200);
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
     * @return Illuminate\Http\Response a json with an error message if no plants are found
     * @return Illuminate\Http\Response a json with a list of plants
     */
    public function getPlantByForestId(Request $request) {      // manca la paginazione
        $plants = Plant::where('forest_id', $request->query('forest_id'))
                        ->where('hammered', $request->query('hammered'))
                        ->where('cutting', 0)
                        ->where('cutted', 0)
                        ->get();

        if (!$plants) {
            return response()->json([
                'message' => 'Piante non trovate',
            ], 404);
        }

        return response()->json([
            'message' => 'Piante trovate',
            'data' => $plants
        ], 200);
    }
}
