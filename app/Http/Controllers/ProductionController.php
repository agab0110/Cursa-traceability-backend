<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Production\NewProductionRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Production;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Store a newly created production in storage.
     *
     * @param App\Http\Requests\Production\NewProductionRequest $request with the field required
     * @return App\Http\Responses\ApiResponse with the created production
     */
    public function store(NewProductionRequest $request)
    {
        $validated = $request->validated();

        $production = Production::create($validated);

        return new ApiResponse('Produzione creata con successo', $production, 201);
    }

    /**
     * Display the specified production.
     *
     * @param App\Models\Production $production with the id of the production to be found
     * @return App\Http\Responses\ApiResponse with the found production
     * @throws App\Exceptions\ApiException with an error message if no production is found
     */
    public function show(Production $production)
    {
        if (!$production) {
            throw new ApiException('Nessuna produzione trovata', 404);
        }

        return new ApiResponse('Produzione trovata', $production, 200);
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
