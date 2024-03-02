<?php

namespace App\Models;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','cart_id','shipping_address','payment_info'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
