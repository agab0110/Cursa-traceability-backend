<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\ReturningTransport\NewReturningTransportRequest;
use App\Http\Requests\ReturningTransport\UpdateReturningTransportRequest;
use App\Http\Responses\ApiResponse;
use App\Models\ReturningTransport;
use Illuminate\Http\Request;

class ReturningTransportController extends Controller
{
    /**
     * Display a listing of the returning transport for a pre production.
     *
     * @param Illuminate\Http\Request $request containing the pre-production id
     * @return App\Http\Responses\ApiResponse with the list of transports
     * @throws App\Exceptions\ApiException with an error message if no trasport is found
     */
    public function index(Request $request)
    {
        $transports = ReturningTransport::where('pre_production_id', $request->pre_production_id)->get();

        if (!$transports) {
            throw new ApiException('Nessun trasporto di ritorno trovato', 404);
        }

        return new ApiResponse('Trasporti trovati', $transports, 200);
    }

    /**
     * Store a newly created returning transport in storage.
     *
     * @param App\Http\Requests\ReturningTransport\NewReturningTransportRequest $request containing the required field
     * @return App\Http\Responses\ApiResponse with the returning transport created
     */
    public function store(NewReturningTransportRequest $request)
    {
        $validated = $request->validated();

        $returningTransport = ReturningTransport::create($validated);

        return new ApiResponse('Trasporto di ritorno creato con successo', $returningTransport, 201);
    }

    /**
     * Display a listing of the returning transport for a production.
     *
     * @param Illuminate\Http\Request $request containing the production id
     * @return App\Http\Responses\ApiResponse with the list of transports
     * @throws App\Exceptions\ApiException with an error message if no trasport is found
     */
    public function show(Request $request)
    {
        $transports = ReturningTransport::where('production_id', $request->production_id)->get();

        if (!$transports) {
            throw new ApiException('Nessun trasporto di ritorno trovato', 404);
        }

        return new ApiResponse('Trasporti trovati', $transports, 200);
    }

    /**
     * Update the specified retuning transport in storage.
     *
     * @param App\Http\Requests\ReturningTransport\UpdateReturningTransportRequest $request containing the changes to be made
     * @param int $id the id of the retuning transport to update
     * @return App\Http\Responses\ApiResponse with the updated returning transport
     * @throws App\Exceptions\ApiException with an error message if the returning transport is not found
     */
    public function update(UpdateReturningTransportRequest $request, $id)
    {
        $returningTransport = ReturningTransport::find($id);

        if (!$returningTransport) {
            throw new ApiException('Trasporto di ritorno non trovato', 404);
        }

        $validated = $request->validated();

        $returningTransport->update($validated);

        return new ApiResponse('Trasporto di ritono aggiornato con successo', $returningTransport, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
