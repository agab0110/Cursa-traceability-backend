<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\ReturningTransport\NewReturningTransportRequest;
use App\Http\Requests\ReturningTransport\UpdateReturningTransportRequest;
use App\Http\Responses\ApiResponse;
use App\Models\ReturningTransport;

class ReturningTransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        $returningTransport = new ReturningTransport();

        $returningTransport->transport_id = $validated['transport_id'];
        $returningTransport->notes = $validated['notes'];
        $returningTransport->returing_date = $validated['returing_date'];

        $returningTransport->save();

        return new ApiResponse('Trasporto di ritorno creato con successo', $returningTransport, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
