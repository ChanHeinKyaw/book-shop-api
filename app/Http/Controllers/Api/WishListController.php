<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WishListController extends Controller
{
    public function index(){
        $wishListUser = User::with('wishListBooks')->where('id', auth()->id())->first();

        return response()->json([
            'wishListUser' => $wishListUser,
        ]);
    }

    public function store($bookId){
        if(Book::where('id', $bookId)->doesntExist()){
            throw new ModelNotFoundException('Record not found!');
        }

        $user = Auth::user();
        if($user->wishListBooks()->wherePivot('book_id', $bookId)->doesntExist()){
           $user->wishListBooks()->attach($bookId);
        }else{
            return response()->json([
                'error' => 'This book already added to your wish list.',
            ]);
        }

        return response()->json([
            'success' => 'This book was added to your wish list.',
        ]);
    }

    public function delete($bookId){
        $user = Auth::user();
        if($user->wishListBooks()->wherePivot('book_id', $bookId)->exists()){
            $user->wishListBooks()->detach($bookId);
        }else{
            return response()->json([
                'error' => 'Record not found!',
            ]);
        }

        return response()->json([
            'success' => 'This book was removed from your wish list.',
        ]);
    }
}
