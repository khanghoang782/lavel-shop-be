<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $user = (new User)->create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone_number'=>$request->phone_number,
        ]);
        return ResponseHelper::success(message: "Register successfully");
    }
    public function login(LoginRequest $request){
        $credentials = $request->only('email', 'password');
        try{
            if(!$token=JWTAuth::attempt($credentials)){
                return ResponseHelper::error(message: "Invalid Credentials",statusCode: 401);
            }
            $user = auth()->user();

            return ResponseHelper::success(message: "Login successfully",data:['token'=>$token]);

        }catch (JWTException $e){
            return ResponseHelper::error(message: "Failed to create token",statusCode: 500);
        }
    }
}
