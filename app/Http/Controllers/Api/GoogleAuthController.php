<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class GoogleAuthController extends Controller
{

    public function getGoogleUrl(){
        $url=Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return response()-> json(['url'=>$url]);
    }
    public function callback(Request $request){
        $gUser=Socialite::driver('google')->stateless()->user();
        $user=User::where('email',$gUser->email)->first();
        if(!$user){
            $newUser=(new User())->create([
                'name'=>$gUser->name,
                'email'=>$gUser->email,
                'password'=>Hash::make(str()->password()),
            ]);
            $newUser=auth()->user();
            $token=JWTAuth::claims(['role'=>$newUser->role,'username'=>$newUser->username])->fromUser($newUser);
            return response()->json(['token'=>$token,'role'=>$newUser->role,'name'=>$newUser->name],200);
        }
        //$user = auth()->user();
        $token = JWTAuth::claims(['role'=>$user->role,'username'=>$user->name])->fromUser($user);
        return response()->json(['token'=>$token,'role'=>$user->role,'name'=>$user->name],200);
    }


}
