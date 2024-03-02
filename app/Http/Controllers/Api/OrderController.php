<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\OrderStoreRequest;

class OrderController extends Controller
{
    public function checkout(OrderStoreRequest $request){
        $carts = Cart::whereUserId(auth()->id())
                        ->whereStatus('pending')
                        ->get();

        if(count($carts) > 0){
            $payment_info_name = null;
            if ($request->hasFile('payment_info')) {
                $payment_info_file = $request->file('payment_info');
                $payment_info_name = uniqid() . '_' . time() . '.' . $payment_info_file->getClientOriginalExtension();
                Storage::disk('public')->put('payment/' . $payment_info_name, file_get_contents($payment_info_file));
            }
    
            foreach($carts as $cart){
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'cart_id' => $cart->id,
                    'shipping_address' => $request->shipping_address,
                    'payment_info' => $payment_info_name,
                ]);
    
                $order->cart()->update([
                    'status' => 'complete',
                ]);
            }
        }else{
            return response()->json([
                'success' => "Record Not Found",
            ]);
        }

        

        return response()->json([
            'success' => "Order Contrimation Was Success",
        ]);
    }
}
