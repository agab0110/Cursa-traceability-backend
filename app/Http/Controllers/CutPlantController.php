<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cut\UpdateCutPlantRequest;
use App\Models\Lot;
use App\Models\Plant;
use Illuminate\Http\Request;

class CutPlantController extends Controller
{
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
     * @param Illuminate\Http\Request containing the plant
     * @param id the id of the plant
     * @return a json with the updated plant
     */
    public function update(UpdateCutPlantRequest $request, $id)
    {
        $plant = Plant::find($id);

        if (!$plant) {
            return response()->json([
                'message' => 'Albero non trovato',
            ], 404);
        }

        $validated = $request->validated();

        $plant->update($validated);

        if ($request['cutting'] == true && $request['cutted'] == false) {
            $lot = Lot::create([
                'plant_id' => $plant->id,
            ]);

            $lot->save();
        }

        return response()->json([
            'message' => 'Albero aggiornato con successo',
            'data' => $plant,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
