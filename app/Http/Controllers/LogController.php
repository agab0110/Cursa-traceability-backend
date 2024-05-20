<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Log\StoreLogRequest;
use App\Http\Requests\Log\UpdateLogRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the logs using pagination.
     *
     * @param Illuminate\Http\Request the request sent
     * @return Illuminate\Http\Response a json with an error message if no logs are found
     * @return Illuminate\Http\Response a json with a list of the found logs
     */
    public function index(Request $request)
    {
        $logs = Log::where('lot_id', $request->query('lot_id'))
                        ->paginate(13);

        if (!$logs) {
            throw new ApiException('Toppi non trovati', 404);
        }

        return new ApiResponse('Toppi trovati', $logs, 200);
    }

    /**
     * Store a newly created log in storage.
     * @param App\Http\Requests\Log\StoreLogRequest the log to save
     * @return Illuminate\Http\Response a json with the created log
     */
    public function store(StoreLogRequest $request)
    {
        $validated = $request->validated();

        $log = Log::create($validated);

        return new ApiResponse('Toppo creato con successo', $log, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified log in storage.
     * @param App\Http\Requests\Log\UpdateLogRequest the changes to be made
     * @param App\Models\Log the log to update
     * @return Illuminate\Http\Response a json with the updated log
     */
    public function update(UpdateLogRequest $request, Log $log)
    {
        if (!$log) {
            throw new ApiException('Toppo non trovato', 404);
        }
        
        $validated = $request->validated();

        $log->update($validated);

        return new ApiResponse('Toppo aggiornato con successo', $log, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
