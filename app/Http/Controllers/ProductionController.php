<?php

namespace App\Http\Controllers;

use App\Http\Requests\Production\NewProductionRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Production;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created production in storage.
     *
     * @param App\Http\Requests\Production\NewProductionRequest $request with the field required
     * @return App\Http\Responses\ApiResponse with the created production
     */
    public function store(NewProductionRequest $request)
    {
        $validated = $request->validated();

        $production = new Production();

        $production->name = $validated['name'];
        $production->pre_production_id = $validated['pre_production_id'];
        $production->lot_id = $validated['lot_id'];
        $production->log_number = $validated['log_number'];

        $production->save();

        return new ApiResponse('Produzione creata con successo', $production, 201);
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
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
