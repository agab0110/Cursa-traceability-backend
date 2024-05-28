<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\LogSection\NewLogSectionRequest;
use App\Http\Responses\ApiResponse;
use App\Models\LogSection;
use Illuminate\Http\Request;

class LogSectionController extends Controller
{
    /**
     * Display a listing of the log sections.
     *
     * @param Illuminate\Http\Request $request containing the lot id and the log number
     * @return App\Http\Responses\ApiResponse with the sections found
     * @throws App\Exceptions\ApiException with an error message if no section is found
     */
    public function index(Request $request)
    {
        $sections = LogSection::where('lot_id', $request->lot_id)->where('log_number', $request->log_number)->get();

        if (!$sections) {
            throw new ApiException('Nessuna sezione presente', 404);
        }

        return new ApiResponse('Sezioni trovate', $sections, 200);
    }

    /**
     * Store a newly created log section in storage.
     *
     * @param App\Http\Requests\LogSection\NewLogSectionRequest $request containing the required fields
     * @return App\Http\Responses\ApiResponse with the created log section
     */
    public function store(NewLogSectionRequest $request)
    {
        $validated = $request->validated();

        $section = LogSection::create($validated);

        return new ApiResponse('Sezione di toppo creata', $section, 201);
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
}
