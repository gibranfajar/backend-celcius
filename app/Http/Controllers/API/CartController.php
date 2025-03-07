<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'user_id' => 'required',
            'size_id' => 'required',
            'color_id' => 'required',
            'price' => 'required',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $cart = Cart::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'size_id' => $request->size_id,
            'color_id' => $request->color_id,
            'price' => $request->price,
            'qty' => $request->qty,
        ]);

        $data = [
            'user' => $cart->user->name,
            'product' => $cart->product->name,
            'color' => $cart->color->color,
            'size' => $cart->size->size,
            'price' => $cart->price,
            'qty' => $cart->qty,
        ];

        return response()->json([
            'message' => 'Cart created successfully',
            'cart' => $data,
        ], 201);
    }

    public function show()
    {
        $user = auth()->user();
        $carts = CartResource::collection(Cart::where('user_id', $user->id)->get());

        return response()->json([
            'carts' => $carts,
        ], 200);
    }

    public function destroy(Cart $cart)
    {

        if ($cart->user_id != auth()->user()->id) {
            return response()->json([
                'message' => 'product not found',
            ], 404);
        }

        $cart->delete();
        return response()->json([
            'message' => 'Cart deleted successfully',
        ], 200);
    }
}
