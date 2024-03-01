<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Validation\ValidationException;

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

    public function login(LoginRequest $request){
        $user = User::where(['email' => $request->email])->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = auth()->user();
            $token = $user->createToken($user->email)->accessToken;
        }

        return response()->json([
            'token' => $token,
            'user' => $user->only('id', 'name', 'email'),
        ]);
    }

    public function profile($id) {
        $user = User::with('orders.cart.user', 'orders.cart.book')->where('id',$id)->get();

        return response()->json([
            'user' => $user,
        ]);
    }   
}
