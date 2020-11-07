<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\PasswordReset;
use Socialite;
class SocialController extends Controller
{
    public function user(Request $request){
        $request->validate([
            'provider'=>"required",
            'token'=>'required'
        ]);
        $socialuser=Socialite::driver($request->provider)->userFromToken($request->token);
        if($socialuser==null){
            return response()->json(['err'=>'cannot verify token'],404);
        }

        $email=$socialuser->getEmail();
        $new=false;
        $user=User::where('email',$email)->first();
        if($user==null){
            $user=new user();
            $user->provider_id=$socialuser->getId();
            $user->provider=$request->provider;
            $user->name=$socialuser->getName();
            $user->password=bcrypt('social123');
            $user->save();
            $new=true;
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addYear(1);
        // if ($request->remember_me)
        $token->save();
        return response()->json([
            'new'=>$new,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
           
        ]);


    }
}
