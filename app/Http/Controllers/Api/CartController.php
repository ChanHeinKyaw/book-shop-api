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
                ->whereUserId($userId)
                ->whereStatus('pending')
                ->get();

        return response()->json([
            'cart' => $cart,
        ]);
    }

    public function store(CartStoreRequest $request){
        $checkCart = Cart::whereUserId(auth()->id())
                        ->whereBookId($request->book_id)
                        ->whereStatus('pending')
                        ->exists();
        if($checkCart){
            return response()->json([
                'message' => "This Book is Already Add To Cart",
            ]);
        }else{
            $cart = Cart::create([
                'user_id' => auth()->id(),
                'book_id' => $request->book_id,
                'quantity' => $request->quantity,
            ]);
        }
        
        return response()->json([
            'cart' => $cart,
        ]);
    }

    public function update(CartUpdateRequest $request){
        $cart = Cart::whereUserId(auth()->id())
                    ->whereBookId($request->book_id)
                    ->whereStatus('pending')
                    ->first();

        if($cart){
            $cart->update([
                'quantity' => $request->quantity,
            ]);
        }else{
            return response()->json([
                'message' => "Record Not Found",
            ]);
        }
        
        return response()->json([
            'cart' => $cart,
        ]);
    }

    public function delete(Request $request){
        $cart = Cart::whereUserId(auth()->id())
                    ->whereBookId($request->book_id)
                    ->whereStatus('pending')
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
