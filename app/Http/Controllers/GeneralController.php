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
use App\Models\News;
use App\Models\RequestResponse;
use App\Models\WelcomeMessage;
use App\Models\About;
use App\Models\Donation;
class GeneralController extends Controller
{
    public function GetDonar(Request $request){
        $date=Carbon::now()->addDays(-35);
        $donar=DB::table('user_infos')->join('users','user_infos.user_id','=','users.id')->
        where('user_infos.waspositive',1)->where('user_infos.hasdonated',0)->whereNotNull('user_infos.nvdate')->where('user_infos.nvdate','>',$date)->where('users.verified',1);
        if($request->has('bloodgroup')){
            $donar=$donar->where('user_infos.bloodgroup',$request->bloodgroup);
        }

        if($request->has('address')){
            $donar=$donar->where('user_infos.address','like','%'.$request->address.'%');
        }
        if($request->has('phone')){
            $donar=$donar->where('user_infos.phone','like','%'.$request->address.'%');
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
        $donar=$donar->select('user_infos.*','users.email','users.name','users.ispublic');
        return response()->json($donar->get());
    }

    public function getWinner(Request $request){
     
        $donar=DB::table('user_infos')::join('users','user_infos.user_id','=','users.id')->
        where('user_infos.waspositive',1)->whereNotNull('user_infos.nvdate');
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
        $donar=$donar->select('user_infos.*','users->email','users.name','users.ispublic');
        return response()->json($donar->get());
    }

    public function news(Request $request){
        $news=News::where('id','>',0);
        if($request->has('sort') ){
            if($request->has('sort_type')){
                $news=$news->orderBy($request->sort,$request->sort_type);
            }else{
                $news=$news->orderBy($request->sort,'desc');
            }
        }
        return response()->json($news->get());
    }
    public function  singlenews($id){
        return response()->json(News::find($id));
    }

    public function bloodRequest(Request $request){
        $req=DonationRequest::where('accecpted',0)->where('verified',1);
        if($request->has('bloodgroup')){
            $req=$req->where('bloodgroup',$request->bloodgroup);
        }
        if($request->has('sort') ){
            if($request->has('sort_type')){
                $req=$req->orderBy(''.$request->sort,$request->sort_type);
            }else{
                $req=$req->orderBy(''.$request->sort,'desc');
            }
        }else{
            $req=$req->orderBy('created_at','desc');
        }
        return response()->json($req->get());
    }

    public function donations(Request $request){
        // $donations =RequestResponse::join('users','users.id','=','request_responses.user_id')
        // ->join('donation_requests','donation_requests.id','=','request_responses.donation_request_id')
        // ->join('user_infos','users.id','=','user_infos.user_id')
        // ->where('donation_requests.accecpted',0);
        // if($request->has('bloodgroup')){
        //     $donations=  $donations ->where('donation_requests.bloodgroup',0);
        // }
        // $dd=$donations->select( DB::raw('donation_requests.name as rname','donation_requests.phone as rphone','user_infos.phone as dphone','users.name as dname','request_responses.created_at'))->orderBy('donation_requests.created_at','desc')->get();
        $dd=Donation::orderBy('created_at','desc')->get();
        return response()->json($dd);
    }
    public function aboutus(){
        $about=About::first();
        $desc=$about!=null?$about->description:"";
        return response()->json(['aboutus'=>$desc]);
    }
    public function message(){
        $message=WelcomeMessage::first();
        return response()->json($message);
    }
}
