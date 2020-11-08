<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\PasswordReset;
class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addYear(1);
        // if ($request->remember_me)
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
        // return response()->json([
        //     'message' => 'Successfully created user!'
        // ], 201);
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
         
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addYear(1);
        // if ($request->remember_me)
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function forgot(Request $request){
        $request->validate([
            'email' => 'required|string|email',
        ]);
        $user = User::where('email', '=', $request->email)->first();
        //Check if the user exists
        if ($user==null) {
            return response()->json(['email' => trans('User does not exist')]);
        }

        $token=mt_Rand(100000,999999);
        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
 
        $user->notify(new PasswordReset($token));
        return response()->json(['sucess',1]);
    }

    public function reset(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed',
            'token' => 'required' ]);
        
            $tokenData = DB::table('password_resets')
            ->where('token', $request->token)->where('email',$request->email)->first();   
            if($tokenData==null){
                return response()->json(['error'=>"Invalid Token"]);
            }
            $user=User::where('email',$request->email)->first();
            $user->password= bcrypt($request->password);
            $user->save();
            DB::table('password_resets')->where('email',$request->email)->delete();
            return response()->json(['msg'=>"Password reset successFull"]);
    }

    public function changePassword(Request $request){
        $request->validate([
            'password' => 'required|confirmed',
             'oldpassword' => 'required'
             ]);
            $user=Auth::user();
            if(Hash::check($user->password,bcrypt($request->oldpassword))){
                $user->password=bcrypt($request->password);
                $user->save();
                return response()->json(['msg'=>'password changed']);

            }else{
                return response()->json(['err'=>'old Password Wrong'],500);
            }
    }

    public function social(){
        
    }

    public function frontLogin(Request $request){
        if($request->getMethod()=="POST"){

            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
             
            ]);
            $email=$request->email;
            $password=$request->password;
            if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
                
                if(Auth::user()->role==0){
                    return redirect()->route('user.dashboard');
                }else{
                    return redirect()->route('admin.dashboard');
    
                }
            }else{
                return redirect()->back()->withErrors('Credential do not match');
            }
        }else{
            return view('auth.login');
        }
    }
}
