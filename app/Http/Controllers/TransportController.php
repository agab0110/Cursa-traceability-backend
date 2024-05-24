<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Transport\NewTransportRequest;
use App\Http\Requests\Transport\UpdateTransportRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Transport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    /**
     * Display a listing of the transport for a specific company.
     *
     * @param Illuminate\Http\Request $request containing the company name
     * @return App\Http\Responses\ApiResponse with the list of transprts
     * @throws App\Exceptions\ApiException with an error message if no transports are found
     */
    public function index(Request $request)
    {
        $transports = Transport::where('company_name', $request->query('company_name'));

        if (!$transports) {
            throw new ApiException('Trasporti non trovati', 404);
        }

        return new ApiResponse('Trasporti trovati', $transports, 200);
    }

    /**
     * Store a newly created transport in storage.
     *
     * @param App\Http\Requests\Transport\NewTransportReques $request containing the field required
     * @return App\Http\Responses\ApiResponse with the created transport
     */
    public function store(NewTransportRequest $request)
    {
        $validated = $request->validated();

        $transport = new Transport();
        $transport->plate = $validated['plate'];
        $transport->driver = $validated['driver'];
        $transport->company = $validated['company'];
        $transport->lot_id = $validated['lot_id'];
        $transport->pre_production_id = $validated['pre_production_id'];
        $transport->production_id = $validated['production_id'];
        $transport->shipping = $validated['shipping'];
        $transport->shipping_date = $validated['shipping_date'];

        $transport->save();

        return new ApiResponse('Trasporto creato con successo', $transport, 200);
    }

    /**
     * Display the specified transport.
     *
     * @param App\Models\Transport $transport containing the id of the transport to be found
     * @return App\Http\Responses\ApiResponse with the found transport
     * @throws App\Exceptions\ApiException with an error message if no transport is found
     */
    public function show(Transport $transport)
    {
        if (!$transport) {
            throw new ApiException('Trasporto non trovato', 404);
        }

        return new ApiResponse('Trasporto trovato', $transport, 200);
    }

    /**
     * Update the specified transport in storage.
     *
     * @param App\Http\Requests\Transport\UpdateTransportRequest $request containing the changes to be made
     * @param int $id the id of the transport to update
     * @return App\Http\Responses\ApiResponse with the updated transport
     * @throws App\Exceptions\ApiException with an error message if no transport is found
     */
    public function update(UpdateTransportRequest $request, $id)
    {
        $transport = Transport::find($id);

        if (!$transport) {
            throw new ApiException('Trasporto non trovato', 404);
        }

        $validated = $request->validated();

        $transport->update($validated);

        return new ApiResponse('Trasporto aggiornato con successo', $transport, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Display a listing of the transport for a specific pre-production.
     *
     * @param Illuminate\Http\Request $request containing the pre-production id
     * @return App\Http\Responses\ApiResponse with a list of transports
     * @throws App\Exceptions\ApiException with an error message if no transports are found
     */
    public function getPreProductionTransports(Request $request) {
        $transports = Transport::Where('pre_production_id', $request['pre_production_id']);

        if (!$transports) {
            throw new ApiException('Trasporti non trovati', 404);
        }

        return new ApiResponse('Trasporti trovati', $transports, 200);
    }

    /**
     * Display a listing of the transport for a specific production.
     *
     * @param Illuminate\Http\Request $request containing the production id
     * @return App\Http\Responses\ApiResponse with a list of transports
     * @throws App\Exceptions\ApiException with an error message if no transports are found
     */
    public function getProductionTransports(Request $request) {
        $transports = Transport::Where('production_id', $request['production_id']);

        if (!$transports) {
            throw new ApiException('Trasporti non trovati', 404);
        }

        return new ApiResponse('Trasporti trovati', $transports, 200);
    }
}
