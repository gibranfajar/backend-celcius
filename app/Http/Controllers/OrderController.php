<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Orders';
        $data = Order::orderBy('id', 'desc')->get();

        return view('orders.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Order $order)
    {
        $title = 'Detail Order';
        $item = Order::where('id', $order->id)->first();
        $orderitems = OrderItem::where('order_id', $order->id)->get();

        // mengambil image product berdasarkan product_id
        foreach ($orderitems as $orderitem) {
            $product = ProductImage::where('product_id', $orderitem->product_id)->first();
            $orderitem->image = $product->image;
        }

        return view('orders.detail', compact('title', 'item', 'orderitems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required',
            'resi' => 'nullable'
        ]);

        Order::where('id', $order->id)->update([
            'status' => $request->status,
            'resi' => $request->resi
        ]);

        return redirect()->route('orders.index')->with('success', 'Order berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
