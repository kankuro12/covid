<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Memo;
use App\Models\UserInfo;
use App\Models\DonationRequest;

use App\Notifications\PasswordReset;
use Socialite;
class UserController extends Controller
{
    public function memo(Request $request){
        $user=Auth::user();
        if($request->getMethod()=="POST"){
            $request->validate(['description'=>'required']);
            $memo=Memo::where('user_id',$user->id)->first();
            if($memo==null){
                $memo=new Memo();
            }
            $memo->description=$request->description();
            $memo->save();
            return response()->json(['msg'=>'memo Saved  Sucessfully']);

        }else{
            $memo=Memo::where('user_id',$user->id)->first();
            return response()->json(['memo'=>$memo==null?'':$memo->description]);
        }
    }

    public function info(Request $request){
        $user=Auth::user();
        if($request->getMethod()=="POST"){
        
            $info=UserInfo::where('user_id',$user->id)->first();
            if($info==null){
                $info=new UserInfo();
            }
            $info->address=$request->address;
            $info->bloodgroup=$request->bloodgroup;
            $info->nvdate=$request->nvdate;
            $info->waspositive=$request->waspositive;
            $info->description=$request->description??'';
            $info->age=$request->age;
            $info->phone=$request->phone;
            $user->phone=$request->phone;
            $user->ispublic=$request->ispublic??1;
            $user->save();
            $info->save();
            return response()->json(['msg'=>'Info Saved  Sucessfully']);

        }else{
            $info=UserInfo::where('user_id',$user->id)->first();
            $data=[];
            if($info==null){
                $data['address']='';
                $data['bloodgroup']='';
                $data['nvdate']='';
                $data['waspositive']=0;
                $data['age']='';
                $data['description']='';
                $data['phone']='';
                $data['ispublic']=$user->ispublic;
            }else{
                $data['address']=$info->address;
                $data['bloodgroup']=$info->bloodgroup;
                $data['nvdate']=$info->nvdate;
                $data['waspositive']=$info->waspositive;
                $data['ispublic']=$user->ispublic;
                $data['age']=$info->age;
                $data['description']=$info->description;
                $data['phone']=$info->phone;
            }
            return response()->json($data);
        }
    }

    public function bloodRequest(){
        return response()->json(Auth::user()->bloodRequests);
    }

    public function addBloodRequest(){
        $request->validate([
            'name'=>'required',
            'phone'=>'required',
            'amount'=>'required',
            'hospital'=>'required',
            'needed'=>'required',
        ]);
        $user=Auth::user();

        if ($request->has('id')) {
            $req=DonationRequest::find($request->id); 
        }else{
            $req=new DonationRequest();
            $req->user_id=$user->id;
        }
        $req->name=$request->name;
        $req->phone=$request->phone;
        $req->amount=$request->amount;
        $req->hospital=$request->hospital;
        $req->needed=$request->needed;
        $req->description=$request->description;
        $req->save();        
    }

    public function getBloodRequest(){

    }
}
