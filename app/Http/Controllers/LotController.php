<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use Illuminate\Http\Request;

class LotController extends Controller
{
    /**
     * Display a listing of the lots using pagination.
     * @param Illuminate\Http\Request the request sent
     * @return Illuminate\Http\Response a json with an error message if no lots are not found
     * @return Illuminate\Http\Response a json with a list of found lots
     */
    public function index(Request $request)
    {
        $lots = Lot::paginate(13);

        if (!$lots) {
            return response()->json([
                'message' => 'Lotti non trovati',
            ], 404);
        }

        return response()->json([
            'message' => 'Lotti trovati',
            'data' => $lots
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified lot.
     * @param int $id the id of the lot
     * @return Illuminate\Http\Response a json with an error message if the lot is not found
     * @return Illuminate\Http\Response a json with a list of found lot
     */
    public function show($id)
    {
        $lot = Lot::find($id);

        if (!$lot) {
            return response()->json([
                'message' => 'Lotto non trovato'
            ], 404);
        }

        return response()->json([
            'message' => 'Lotto trovato',
            'data' => $lot
        ], 200);
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
     * Display a listing of filtred lots.
     * The filter is used to find only lots with the cutting flag true
     *
     * @param Illuminate\Http\Request the request sent
     * @return Illuminate\Http\Response a json with an error message if no lots are found
     * @return Illuminate\Http\Response a json with a list of found lots
     */
    public function getCuttingFilteredList(Request $request) {
        $lots = Lot::join('plants', 'lots.plant_id', '=', 'plants.id')
                ->where('plants.cutting', '=', 1)
                ->where('plants.cutted', '=', 0)
                ->select('lots.*')
                ->get();

        if (!$lots) {
            return response()->json([
                'message' => 'Lotti non trovati',
            ], 404);
        }

        return response()->json([
            'message' => 'Lotti trovati',
            'data' => $lots
        ], 200);
    }

    /**
     * Display a listing of filtred lots.
     * The filter is used to find only lots with the cutted flag true
     *
     * @param Illuminate\Http\Request the request sent
     * @return Illuminate\Http\Response a json with an error message if no lots are found
     * @return Illuminate\Http\Response a json with a list of found lots
     */
    public function getCuttedFilteredList() {
        $lots = Lot::join('plants', 'lots.plant_id', '=', 'plants.id')
                ->where('plants.cutted', '=', 1)
                ->select('lots.*')
                ->get();

        if (!$lots) {
            return response()->json([
                'message' => 'Lotti non trovati',
            ], 404);
        }

        return response()->json([
            'message' => 'Lotti trovati',
            'data' => $lots
        ], 200);
    }
}
