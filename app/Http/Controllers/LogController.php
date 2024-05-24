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
     * @param Illuminate\Http\Request $request the request sent
     * @return App\Http\Responses\ApiResponse with a list of the found logs
     * @throws App\Exceptions\ApiException with an error message if no logs are found
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
     *
     * @param App\Http\Requests\Log\StoreLogRequest $request the log to save
     * @return App\Http\Responses\ApiResponse with the created log
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
     *
     * @param App\Http\Requests\Log\UpdateLogRequest $request the changes to be made
     * @param App\Models\Log $log the log to update
     * @return App\Http\Responses\ApiResponse with the updated log
     * @throws App\Exceptions\ApiException with an error message if no log is found
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
