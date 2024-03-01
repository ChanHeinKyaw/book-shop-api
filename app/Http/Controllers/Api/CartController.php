<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartStoreRequest;

class CartController extends Controller
{
    public function store(CartStoreRequest $request){
        $cart = Cart::create([
            'user_id' => auth()->id(),
            'book_id' => $request->book_id,
            'quantity' => $request->quantity,
        ]);
        
        return response()->json([
            'cart' => $cart,
        ]);
    }
}
