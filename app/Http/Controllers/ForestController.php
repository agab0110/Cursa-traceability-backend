<?php

namespace App\Http\Controllers;

use App\Http\Requests\Forest\StoreForestRequest;
use App\Models\Forest;
use Illuminate\Http\Request;

class ForestController extends Controller
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
    public function store(StoreForestRequest $request)
    {
        $validated = $request->validated();

        $forest = Forest::create($validated);

        return response()->json([
            'message' => 'Pianta creata con successo',
            'data' => $forest
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
