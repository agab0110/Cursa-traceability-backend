<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\EstimationModel\NewEstimationModelRequest;
use App\Http\Requests\EstimationModel\UpdateEstimationModelRequest;
use App\Http\Responses\ApiResponse;
use App\Models\EstimationModel;
use Illuminate\Http\Request;

class EstimationModelController extends Controller
{
    /**
     * Display a listing of the estimation models using pagination.
     *
     * @throws App\Exceptions\ApiException with an error message if no estimation model is found
     * @return App\Http\Responses\ApiResponse with the list of estimation models
     */
    public function index()
    {
        $estimationModels = EstimationModel::paginate(15);

        if (!$estimationModels) {
            throw new ApiException('Nessun modello di stima trovato', 404);
        }

        return new ApiResponse('Modelli di stima trovati', $estimationModels, 200);
    }

    /**
     * Store a newly created estimation model in storage.
     *
     * @param App\Http\Requests\EstimationModel\NewEstimationModelRequest $request with the request fields
     * @return App\Http\Responses\ApiResponse with the created estimation model
     */
    public function store(NewEstimationModelRequest $request)
    {
        $validated = $request->validated();

        $estimationModel = EstimationModel::create($validated);

        return new ApiResponse('Modello di stima creato con successo', $estimationModel, 201);
    }

    /**
     * Display the specified estimation model using the name convenion.
     *
     * @param App\Models\EstimationModel $estimationModel containing the id of the model to be found
     * @throws App\Exceptions\ApiException with an error message if the model is not found
     * @return App\Http\Responses\ApiResponse with the found estimation model
     */
    public function show(EstimationModel $estimationModel)
    {
        if (!$estimationModel) {
            throw new ApiException('Modello di stima non trovato', 404);
        }

        return new ApiResponse('Modello di stima trovato', $estimationModel, 200);
    }

    /**
     * Update the specified estimation model in storage.
     *
     * @param App\Http\Requests\EstimationModel\UpdateEstimationModelRequest $request the changes to be made
     * @throws App\Exceptions\ApiException with an error message if the estimation model is not found
     * @return App\Http\Responses\ApiResponse with the updated estimation model
     */
    public function update(UpdateEstimationModelRequest $request, EstimationModel $estimationModel)
    {
        if (!$estimationModel) {
            throw new ApiException('Modello di stima non trovato', 404);
        }

        $validated = $request->validated();

        $estimationModel->update($validated);

        return new ApiResponse('Modello di stima aggiornato con successo', $estimationModel, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
