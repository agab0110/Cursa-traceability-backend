<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use Illuminate\Http\Request;

class LotController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Display the specified resource.
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
