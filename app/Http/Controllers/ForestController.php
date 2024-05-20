<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Forest\StoreForestRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Forest;
use Illuminate\Http\Request;

class ForestController extends Controller
{
    /**
     * Show all the forests in the database using pagination
     *
     * @return App\Http\Responses\ApiResponse with the forest found.
     * @throws App\Exceptions\ApiException with error response if no forest is found
     */
    public function index()
    {
        $forests = Forest::paginate(15);

        if (!$forests) {

            throw new ApiException('Boschi non trovati', 404);
        }

        return new ApiResponse('Boschi trovati', $forests, 200);
    }

    /**
     * Store a newly created forest in storage.
     *
     * @param App\Http\Requests\Forest\StoreForestRequest the new forest
     * @return App\Http\Responses\ApiResponse with the new forest created
     */
    public function store(StoreForestRequest $request)
    {
        $validated = $request->validated();

        $forest = Forest::create($validated);

        return new ApiResponse('Bosco creato con successo', $forest, 201);
    }

    /**
     * Display the specified forest requested.
     *
     * @param Illuminate\Http\Request the request sent
     * @param App\Models\Forest the forest id to be found
     * @return App\Http\Responses\ApiResponse with the forest found
     * @throws App\Exceptions\ApiException with error message if no forest is found
     */
    public function show(Request $request, Forest $forest)
    {
        if (!$forest) {
            throw new ApiException('Bosco non trovato', 404);
        }

        return new ApiResponse('Bosco trovato', $forest, 200);
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
