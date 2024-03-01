<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartStoreRequest;

class CartController extends Controller
{
    public function index($userId){
        $cart = Cart::with('user','book')
                ->where('user_id',$userId)
                ->whereDoesntHave('order')
                ->get();

        return response()->json([
            'cart' => $cart,
        ]);
    }

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
