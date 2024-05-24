<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\PreProduction\CreateLogSectionRequest;
use App\Http\Requests\PreProduction\NewPreProductionRequest;
use App\Http\Requests\PreProduction\UpdatePreProductionRequest;
use App\Http\Responses\ApiResponse;
use App\Models\LogSection;
use App\Models\PreProduction;

class PreProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created pre-production in storage.
     *
     * @param App\Http\Requests\PreProduction\NewPreProductionRequest $request containing the requested field
     * @return App\Http\Responses\ApiResponse with the created pre-production
     */
    public function store(NewPreProductionRequest $request)
    {
        $validated = $request->validated();

        $preProduction = new PreProduction();

        $preProduction->company_name = $validated['name'];

        $preProduction->save();

        return new ApiResponse('Segheria creata con successo', $preProduction, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified pre-production in storage.
     *
     * @param App\Http\Requests\PreProduction\UpdatePreProductionRequest $request containing the changes to be made
     * @param int $id the id of the pre-production to update
     * @return App\Http\Responses\ApiResponse with the updated pre-production
     * @throws App\Exceptions\ApiException with an error message if the pre-production is not found
     */
    public function update(UpdatePreProductionRequest $request, $id)
    {
        $preProduction = PreProduction::find($id);

        if (!$preProduction) {
            throw new ApiException('Segheria non trovata', 404);
        }

        $validated = $request->validated();

        $preProduction->update($validated);

        return new ApiResponse('Segheria aggiornata con successo', $preProduction, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function createLogSection(CreateLogSectionRequest $request) {
        $validated = $request->validated();

        $logSection = new LogSection();

        $logSection->lot_id = $validated['lot_id'];
        $logSection->log_number = $validated['log_number'];
        $logSection->section = $validated['section'];

        $logSection->save();

        return new ApiResponse('Sezione di toppo creata con successo', $logSection, 201);
    }
}
