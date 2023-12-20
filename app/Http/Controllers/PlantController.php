<?php

namespace App\Http\Controllers;

use App\Http\Requests\Plant\StorePlantRequest;
use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlantRequest $request)
    {
        $validated = $request->validated();

        $plant = Plant::create($validated);

        return response()->json([
            'message' => 'Pianta creata con successo',
            'data' => $plant
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
