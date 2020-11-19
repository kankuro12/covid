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
class RequestController extends Controller
{
    public function index(Request $request){
        
        $day=Carbon::now()->addDays(-5);
        // dd($day);
        $list=DonationRequest::where('created_at','>',$day)->get();
        return view('admin.request.index',['list'=>$list]);
    }

    public function verify(Request $request){
        $request->validate([
            'status'=>'required',
            'uid'=>'required'
        ]);
        $req=DonationRequest::find($request->uid);
        $req->verified=$request->status==0?1:0;
        $req->save();
        return response()->json(['status'=>$req->verified,'id'=>$req->id]);
    }

    public function expired(Request $request){
        
        $day=Carbon::now()->addDays(-4);
        $list=DonationRequest::where('created_at','<',$day)->get();
        return view('admin.request.exindex',['list'=>$list]);
    }

    public function add(Request $request){
        if($request->getMethod()=="POST"){
            $request->validate([
                'name'=>'required',
                'phone'=>'required',
                'amount'=>'required',
                'hospital'=>'required',
                'needed'=>'required',
                'bloodgroup'=>'required'
            ]);
            $user=Auth::user();
    
            $msg="Request Added Sucessfully";
            if ($request->has('id')) {
                $req=DonationRequest::find($request->id); 
                $msg="Request Updated Sucessfully";

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
            $req->bloodgroup=$request->bloodgroup;
            $req->save();        
    
            return redirect()->route('admin.requests')->with('message',$msg);

        }else{
            return view('admin.request.add');
        }
    }

    public function edit(DonationRequest $req){
        return view('admin.request.edit',compact('req'));
    }
    public function del(DonationRequest $req){
       $req->delete();
       return redirect()->route('admin.requests')->with('message',"Request Deleted Successfully");
    }

    public function show(DonationRequest $req){
        return view('admin.request.show',compact('req'));
     }

     public function complete(DonationRequest $req,User $user){
        $com=new RequestResponse();
        $com->donation_request_id=$req->id;
        $com->user_id=$user->id;
        $com->save();
       
        $user->hasdonated=1;
        $user->save();
      
        $req->accecpted=1;
        $req->save();
        return redirect()->back()->with('message','Request Completed');
     }
}
