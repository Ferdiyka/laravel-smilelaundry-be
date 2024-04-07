<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all products
        $products = Product::all();

        // generate URL for product images
        $products->transform(function ($product) {
            $product->picture_url = $this->getImageUrl($product->picture); // adjust the attribute name according to your product model
            return $product;
        });

        return response()->json([
            'message' => 'Success',
            'data' => $products
        ], 200);
    }

    // helper method to generate image URL
    private function getImageUrl($imageName)
    {
        // if images are stored in public/images directory
        // adjust the path accordingly if images are stored in a different location
        return url('/storage/products/' . $imageName);
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
