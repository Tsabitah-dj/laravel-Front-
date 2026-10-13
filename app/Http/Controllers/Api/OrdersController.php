<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with('product')->get()->map(function ($order) {
            return [
                'id' => $order->id,
                'nama_pelanggan' => $order->nama_pelanggan,
                'nama_produk' => $order->product->nama_produk,
                'qty' => $order->qty,
                'total_harga' => $order->total_harga,
                'status' => $order->status,
            ];
        });

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string',
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        $order = Order::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'product_id' => $request->product_id,
            'qty' => $request->qty,
            'total_harga' => 0, // akan dihitung
            'catatan' => $request->catatan,
            'status' => 'Menunggu',
        ]);

        // Hitung total harga
        $order->total_harga = $order->product->harga_produk * $order->qty;
        $order->save();

        return response()->json([
            'message' => 'Pesanan berhasil dibuat',
            'data' => $order->load('product'),
        ], 201);
    }
}