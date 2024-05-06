<?php

namespace App\Http\Controllers;

use App\Http\Requests\Forest\StoreForestRequest;
use App\Models\Forest;
use Illuminate\Http\Request;

class ForestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * if no forest is found it returns a json with error response;
     * else it returns a json with the forest found.
     */
    public function index()
    {
        $forests = Forest::paginate(15);

        if (!$forests) {
            return response()->json([
                'message' => 'Boschi non trovati',
            ], 404);
        }

        return response()->json([
            'message' => 'Boschi trovati',
            'data' => $forests
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * Return a json with the new forest found
     */
    public function store(StoreForestRequest $request)
    {
        $validated = $request->validated();

        $forest = Forest::create($validated);

        return response()->json([
            'message' => 'Bosco creato con successo',
            'data' => $forest
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Forest $forest)
    {
        if (!$forest) {
            return response()->json([
                'message' => 'Bosco non trovato'
            ], 404);
        }

        return response()->json([
            'message' => 'Bosco trovato',
            'data' => $forest
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
}
