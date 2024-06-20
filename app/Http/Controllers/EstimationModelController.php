<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstimationModel\NewEstimationModelRequest;
use App\Http\Responses\ApiResponse;
use App\Models\EstimationModel;
use Illuminate\Http\Request;

class EstimationModelController extends Controller
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
    public function store(NewEstimationModelRequest $request)
    {
        $validated = $request->validated();

        $estimationModel = EstimationModel::create($validated);

        return new ApiResponse('Modello di stima creato con successo', $estimationModel, 200);
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
