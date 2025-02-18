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
     * @OA\Get(
     *     path="/api/estimation-models",
     *     tags={"Estimation Models"},
     *     summary="Recupera una lista di modelli di stima",
     *     description="Recupera tutti i modelli di stima, con supporto per la paginazione.",
     *     operationId="getEstimationModels",
     *     @OA\Response(
     *         response=200,
     *         description="Modelli di stima trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Modelli di stima trovati"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/EstimationModel")),
     *             @OA\Property(property="pagination", type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="per_page", type="integer", example=15),
     *                 @OA\Property(property="total", type="integer", example=50)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Modelli di stima non trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Nessun modello di stima trovato")
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/estimation-models",
     *     tags={"Estimation Models"},
     *     summary="Crea un nuovo modello di stima",
     *     description="Crea un nuovo modello di stima con i dati forniti.",
     *     operationId="storeEstimationModel",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="height", type="number", format="float", example=12.50),
     *             @OA\Property(property="volume", type="number", format="float", example=5.20),
     *             @OA\Property(property="double_diameter",  type="number", format="float", example=5.20),
     *             @OA\Property(property="mesure", type="string", example="Esempio"),
     *             @OA\Property(property="formula", type="string", example="ax^2+bx+c"),
     *             @OA\Property(property="retrurning_parameter", type="string", example="Parametro di ritorno")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Modello di stima creato con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Modello di stima creato con successo"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/EstimationModel")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dati non validi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Errore nella creazione del modello di stima")
     *         )
     *     )
     * )
     */
    public function store(NewEstimationModelRequest $request)
    {
        $validated = $request->validated();

        $estimationModel = EstimationModel::create($validated);

        return new ApiResponse('Modello di stima creato con successo', $estimationModel, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/estimation-models/{id}",
     *     tags={"Estimation Models"},
     *     summary="Mostra un modello di stima",
     *     description="Recupera i dettagli di un modello di stima specificato tramite il suo ID.",
     *     operationId="showEstimationModel",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del modello di stima",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modello di stima trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Modello di stima trovato"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/EstimationModel")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Modello di stima non trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Modello di stima non trovato")
     *         )
     *     )
     * )
     */
    public function show(EstimationModel $estimationModel)
    {
        if (!$estimationModel) {
            throw new ApiException('Modello di stima non trovato', 404);
        }

        return new ApiResponse('Modello di stima trovato', $estimationModel, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/estimation-models/{id}",
     *     tags={"Estimation Models"},
     *     summary="Aggiorna un modello di stima",
     *     description="Aggiorna i dettagli di un modello di stima specificato tramite il suo ID.",
     *     operationId="updateEstimationModel",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del modello di stima da aggiornare",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="height", type="number", format="float", example=12.50),
     *             @OA\Property(property="volume", type="number", format="float", example=5.20),
     *             @OA\Property(property="double_diameter",  type="number", format="float", example=5.20),
     *             @OA\Property(property="mesure", type="string", example="Esempio"),
     *             @OA\Property(property="formula", type="string", example="ax^2+bx+c"),
     *             @OA\Property(property="retrurning_parameter", type="string", example="Parametro di ritorno")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Modello di stima aggiornato con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Modello di stima aggiornato con successo"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/EstimationModel")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Modello di stima non trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Modello di stima non trovato")
     *         )
     *     )
     * )
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
