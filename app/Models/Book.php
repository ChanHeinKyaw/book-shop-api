<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, $filters){
        $query->when($filters['search'] ?? false, function ($query, $search){
            $query->where(function ($query) use ($search){
                $query->where('title','LIKE', '%' . $search. '%')
                        ->orWhere('author','LIKE', '%' . $search. '%')
                        ->orWhere('price','LIKE', '%' . $search. '%');
            });
        });
    }
}
