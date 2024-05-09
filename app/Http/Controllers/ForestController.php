<?php

namespace App\Http\Controllers;

use App\Http\Requests\Forest\StoreForestRequest;
use App\Models\Forest;
use Illuminate\Http\Request;

class ForestController extends Controller
{
    /**
     * Show all the forests in the database using pagination
     *
     * @return Illuminate\Http\Response json with error response if no forest is found
     * @return Illuminate\Http\Response json with the forest found.
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
     * Store a newly created forest in storage.
     *
     * @param App\Http\Requests\Forest\StoreForestRequest the new forest
     * @return a json with the new forest created
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
     * Display the specified forest requested.
     *
     * @param Illuminate\Http\Request the request sent
     * @param App\Models\Forest the forest id to be found
     * @return a json with error message if no forest is found
     * @return a json with the forest found
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
