<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Product\NewProductRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Product;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Mostra una lista di prodotti per una produzione specifica",
     *     description="Recupera tutti i prodotti associati a una specifica produzione utilizzando l'ID di produzione.",
     *     operationId="getProductsByProduction",
     *     @OA\Response(
     *         response=200,
     *         description="Prodotti trovati",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Prodotti trovati"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Product"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nessun prodotto trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Nessun prodotto trovato")
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Crea un nuovo prodotto",
     *     description="Crea un nuovo prodotto e lo memorizza nel database.",
     *     operationId="storeProduct",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Prodotto esempio"),
     *             @OA\Property(property="production_id", type="integer", example=1),
     *             @OA\Property(property="log_number", type="integer", example=1),
     *             @OA\Property(property="lot_id", type="integer" example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Prodotto creato con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Prodotto creato con successo"),
     *             @OA\Property(property="data", ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dati non validi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Errore nella creazione del prodotto")
     *         )
     *     )
     * )
     */
    public function store(NewProductRequest $request)
    {
        $validated = $request->validated();

        $product = Product::create($validated);

        return new ApiResponse('Prodotto creato con successo', $product, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     summary="Mostra un prodotto specifico",
     *     description="Recupera un prodotto utilizzando il suo ID.",
     *     operationId="getProductById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Prodotto trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Prodotto trovato"),
     *             @OA\Property(property="data", ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Prodotto non trovato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Prodotto non trovato")
     *         )
     *     )
     * )
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
