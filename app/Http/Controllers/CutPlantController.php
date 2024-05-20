<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Cut\UpdateCutPlantRequest;
use App\Http\Responses\ApiResponse;
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

        if ($request['cutting'] == true && $request['cutted'] == false) {
            $lot = Lot::create([
                'plant_id' => $plant->id,
            ]);

            $lot->save();
        }

        return new ApiResponse('Albero aggiornato con successo', $plant, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
