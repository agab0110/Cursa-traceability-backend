<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Responses\ApiResponse;
use App\Models\Transport;
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
