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

    public function show(User $user){
        return view('admin.user.show',compact('user'));
    }

    public function edit(Request $request,User $user){
        if($request->getMethod()=="POST"){
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email',
            ]);
           
            $info=$user->info;
            if($info==null){
                $info=new UserInfo();
                $info->user_id=$user->id;
            }
            $info->address=$request->address;
            $info->bloodgroup=$request->bloodgroup;
            $info->nvdate=$request->nvdate;
            $info->pdate=$request->pdate;
            $info->testcenter=$request->testcenter;
            $info->waspositive=1;
            $info->description=$request->description??'';
            $info->age=$request->age;
            $info->phone=$request->phone;
            $info->hasdonated=$request->hasdonated??0;
            $info->labid=$request->labid;
            $info->swabcollecteddate=$request->swabcollecteddate;
            $info->save();

            $user->name=$request->name;
            $user->email=$request->email;
            $user->ispublic=$request->ispublic??1;
            $user->verified=1;
            $user->save();

            return redirect()->route('admin.user-edit',['user'=>$user->id])->with('message','Donor Updated Sucessfully');

        }else{
            return view('admin.user.edit',compact('user'));
        }
    }
    public function add(Request $request){
        if($request->getMethod()=="POST"){
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
            ]);
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('user@123456')
            ]);
            $user->save();

            $info=new UserInfo();
            $info->user_id=$user->id;
            $info->address=$request->address;
            $info->bloodgroup=$request->bloodgroup;
            $info->nvdate=$request->nvdate;
            $info->pdate=$request->pdate;
            $info->testcenter=$request->testcenter;
            $info->waspositive=1;
            $info->description=$request->description??'';
            $info->age=$request->age;
            $info->phone=$request->phone;
            $info->hasdonated=$request->hasdonated??0;
            $info->labid=$request->labid;
            $info->swabcollecteddate=$request->swabcollecteddate;
            $user->ispublic=$request->ispublic??1;
            $user->verified=1;
            $info->save();
            $user->save();
            return redirect()->route('admin.user-add')->with('message','Donor Added Sucessfully');

        }else{
            return view('admin.user.add');
        }
    }

    public function updateReq(Request $request,DonationRequest $req){
        $request->validate([
            'name'=>'required',
            'phone'=>'required',
            'amount'=>'required',
            'hospital'=>'required',
            'needed'=>'required',
            'bloodgroup'=>'required'
        ]);
       
        $req->name=$request->name;
        $req->phone=$request->phone;
        $req->amount=$request->amount;
        $req->hospital=$request->hospital;
        $req->needed=$request->needed;
        $req->description=$request->description;
        $req->bloodgroup=$request->bloodgroup;
        $req->save();  

        return redirect()->route('admin.user-show',['user'=>$req->user_id])->with('message','Request Updated Sucessfully');;
    }

    public function search($phone,$req_id){
        $users=UserInfo::where('phone','like','%'.$phone.'%')->get();
        return view('admin.user.search_phone',compact('users','req_id'));
        
    }
}
