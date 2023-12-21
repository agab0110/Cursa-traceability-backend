<?php

namespace App\Http\Controllers;

use App\Http\Requests\Plant\StorePlantRequest;
use App\Models\Forest;
use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $plants = Plant::where('hammered', $request->query('hammered'))->get();

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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Plant\StorePlantRequest  $request
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\Models\Plant $plant
     * @return \Illuminate\Http\Response
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
}
