<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::all();

        foreach ($products as $product) {
            $product->gambar_produk = asset('storage/' . $product->gambar_produk);
        }

        return response()->json($products);
    }

    public function show($id)
    {
        $product = Products::findOrFail($id);

        $product->gambar_produk = asset('storage/' . $product->gambar_produk);

        return response()->json($product);
    }
}