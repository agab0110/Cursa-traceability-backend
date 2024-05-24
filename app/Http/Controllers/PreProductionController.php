<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreProduction\CreateLogSectionRequest;
use App\Http\Responses\ApiResponse;
use App\Models\LogSection;
use Illuminate\Http\Request;

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
