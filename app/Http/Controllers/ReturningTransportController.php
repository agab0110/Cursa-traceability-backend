<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReturningTransport\NewReturningTransportRequest;
use App\Http\Responses\ApiResponse;
use App\Models\ReturningTransport;
use Illuminate\Http\Request;

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
