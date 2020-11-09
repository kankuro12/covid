<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Memo;
use App\Models\UserInfo;
use App\Models\DonationRequest;
use App\Models\News;
class UserController extends Controller
{
    //
    public function index(){
        $list=User::where('role',0)->get();
        return  view('admin.user.index',compact('list'));
    }

    public function donors(){
        $donar=DB::table('user_infos')::join('users','user_infos.user_id','=','users.id')->
        where('user_infos.waspositive',1)->where('user_infos.hasdonated',0)->whereNotNull('user_infos.nvdate')->where('user_infos.nvdate','>',$date)->where('users.verified',1)->where('users.ispublic',1);
        if($request->has('bloodgroup')){
            $donar=$donar->where('user_infos.bloodgroup',$request->bloodgroup);
        }

        if($request->has('address')){
            $donar=$donar->where('user_infos.address','like','%'.$request->address.'%');
        }
        if($request->has('phone')){
            $donar=$donar->where('user_infos.phone',$request->address);
        }

        if($request->has('name')){
            $donar=$donar->where('users.name','like','%'.$request->name.'%');
        }

        if($request->has('email')){
            $donar=$donar->where('users.email','like','%'.$request->email.'%');
        }

        if($request->has('sort') ){
            if($request->has('sort_type')){
                $donar=$donar->orderBy('user_infos.'.$request->sort,$request->sort_type);
            }else{
                $donar=$donar->orderBy('user_infos.'.$request->sort,'desc');
            }
        }else{
            $donar=$donar->orderBy('user_infos.nvdate','desc');
        }
        $donar=$donar->select('user_infos.*','users->email','users.name');
        return response()->json($donar->get());
    }

    public function verify(Request $request){
        $request->validate([
            'status'=>'required',
            'uid'=>'required'
        ]);
        $user=User::find($request->uid);
        $user->verified=$request->status==0?1:0;
        $user->save();
        return response()->json(['status'=>$user->verified,'id'=>$user->id]);
    }
}
