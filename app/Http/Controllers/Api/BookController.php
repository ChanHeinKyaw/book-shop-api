<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function index(){
        $books =  Book::with('user:id,name,email')
                    ->select('title','author','price','user_id')
                    ->get();

        return response()->json([
            'books' => $books
        ]);
    }
}
