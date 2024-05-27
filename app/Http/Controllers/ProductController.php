<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Responses\ApiResponse;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products for a specific production.
     *
     * @param Illuminate\Http\Request $request containing the production id
     * @return App\Http\Responses\ApiResponse containing the products found
     * @throws App\Exceptions\ApiException with an error message if no product is found
     */
    public function index(Request $request)
    {
        $products = Product::where('production_id', $request->production_id)->paginate(15);

        if (!$products) {
            throw new ApiException('Nessun prodotto trovato', 404);
        }

        return new ApiResponse('Prodotti trovati', $products, 200);
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
