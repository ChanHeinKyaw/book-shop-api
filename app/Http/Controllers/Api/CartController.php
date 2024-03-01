<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\CartUpdateRequest;

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

    public function update(CartUpdateRequest $request){
        $cart = Cart::latest()->where('user_id', auth()->id())
                    ->where('book_id', $request->book_id)
                    ->first();
        
        $cart->update([
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'cart' => $cart,
        ]);
    }

    public function delete(Request $request){
        $cart = Cart::latest()->where('user_id', auth()->id())
                    ->where('book_id', $request->book_id)
                    ->first();

        if($cart){
            $cart->delete();
        }else{
            return response()->json([
                'error' => 'Cart Not Found'
            ]);
        }
        
        return response()->json([
            'message' => 'Cart delete successfully'
        ]);
    }
}
