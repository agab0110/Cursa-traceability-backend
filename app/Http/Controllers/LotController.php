<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Responses\ApiResponse;
use App\Models\Lot;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class LotController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/lots",
     *     tags={"Lots"},
     *     summary="Recupera un elenco di lotti",
     *     description="Recupera l'elenco di tutti i lotti con paginazione.",
     *     operationId="getLots",
     *     @OA\Response(
     *         response=200,
     *         description="Lotti trovati con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lotti trovati"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Lot")),
     *             @OA\Property(property="pagination", type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="per_page", type="integer", example=13),
     *                 @OA\Property(property="total", type="integer", example=100)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nessun lotto trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lotti non trovati")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $lots = Lot::paginate(13);

        if (!$lots) {
            throw new ApiException('Lotti non trovati', 404);
        }

        return new ApiResponse('Lotti trovati', $lots, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/lots/{id}",
     *     tags={"Lots"},
     *     summary="Recupera un lotto specifico",
     *     description="Recupera i dettagli di un lotto specifico tramite l'ID.",
     *     operationId="getLotById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del lotto da recuperare",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lotto trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lotto trovato"),
     *             @OA\Property(property="data", ref="#/components/schemas/Lot")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Lotto non trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lotto non trovato")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $lot = Lot::find($id);

        if (!$lot) {
            throw new ApiException('Lotto non trovato', 404);
        }

        return new ApiResponse('Lotto trovati', $lot, 200);
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

    /**
     * @OA\Get(
     *     path="/api/lot/cutting-lots",
     *     tags={"Lots"},
     *     summary="Recupera i lotti con piante in stato di cutting",
     *     description="Recupera una lista di lotti dove le piante sono in stato di cutting e non sono ancora state tagliate.",
     *     operationId="getCuttingFilteredList",
     *     @OA\Response(
     *         response=200,
     *         description="Lotti trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lotti trovati"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Lot"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Lotti non trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lotti non trovati")
     *         )
     *     )
     * )
     */
    public function getCuttingFilteredList(Request $request) {
        $lots = Lot::join('plants', 'lots.plant_id', '=', 'plants.id')
                ->where('plants.cutting', '=', 1)
                ->where('plants.cutted', '=', 0)
                ->select('lots.*')
                ->get();

        if (!$lots) {
            throw new ApiException('Lotti non trovati', 404);
        }

        return new ApiResponse('Lotti trovati', $lots, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/lot/cutted-lots",
     *     tags={"Lots"},
     *     summary="Recupera i lotti con piante in stato di cutted",
     *     description="Recupera una lista di lotti dove le piante sono in stato di cutted e non sono più in cutting.",
     *     operationId="getCuttedFilteredList",
     *     @OA\Response(
     *         response=200,
     *         description="Lotti trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lotti trovati"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Lot"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Lotti non trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Lotti non trovati")
     *         )
     *     )
     * )
     */
    public function getCuttedFilteredList() {
        $lots = Lot::join('plants', 'lots.plant_id', '=', 'plants.id')
                ->where('plants.cutted', '=', 1)
                ->select('lots.*')
                ->get();

        if (!$lots) {
            throw new ApiException('Lotti non trovati', 404);
        }

        return new ApiResponse('Lotti trovati', $lots, 200);
    }
}
