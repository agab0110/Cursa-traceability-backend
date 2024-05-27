<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Product\NewProductRequest;
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
     * Store a newly created product in storage.
     *
     * @param App\Http\Requests\Product\NewProductRequest $request containig the requested fields
     * @return App\Http\Responses\ApiResponse with the created product
     */
    public function store(NewProductRequest $request)
    {
        $validated = $request->validated();

        $product = Product::create($validated);

        return new ApiResponse('Prodotto creato con successo', $product, 201);
    }

    /**
     * Display the specified product.
     *
     * @param App\Models\Product $product containing the id of the product to be found
     * @return App\Http\Responses\ApiResponse containing the found product
     * @throws App\Exceptions\ApiException with an error message if no product is found
     */
    public function show(Product $product)
    {
        if (!$product) {
            throw new ApiException('Prodotto non trovato', 404);
        }

        return new ApiResponse('Prodotto trovato', $product, 200);
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
