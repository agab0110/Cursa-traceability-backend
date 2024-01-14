<?php

namespace App\Http\Controllers;

use App\Http\Requests\Log\StoreLogRequest;
use App\Http\Requests\Log\UpdateLogRequest;
use App\Models\Log;
use App\Models\Plant;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $logs = Log::where('plant_id', $request->query('plant_id'))
                        ->paginate(13);

        if (!$logs) {
            return response()->json([
                'message' => 'Toppi non trovati',
            ], 404);
        }

        return response()->json([
            'message' => 'Toppi trovati',
            'data' => $logs
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLogRequest $request)
    {
        $validated = $request->validated();

        $plant = Plant::find($request['plant_id']);

        $log = Log::create($validated);

        $log->plant()->associate($plant);
        $log->save();

        return response()->json([
            'message' => 'Toppo creato con successo',
            'data' => $log
        ], 200);
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
    public function update(UpdateLogRequest $request, Log $log)
    {
        $validated = $request->validated();

        $log->update($validated);

        return response()->json([
            'message' => 'Toppo aggiornato con successo',
            'data' => $log
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
