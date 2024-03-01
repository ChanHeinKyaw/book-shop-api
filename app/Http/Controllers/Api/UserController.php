<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    public function store(RegisterRequest $request){
        try{
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            
            DB::commit();

            return response()->json(['message' => 'User registration success']);
        }catch(Throwable $th){
            DB::rollBack();
            
            return response()->json([
                'message' => 'User registration fail',
            ], 500);
        }
    }
}
