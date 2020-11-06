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

class GeneralController extends Controller
{
    public function GetDonar(Request $request){
        $date=Carbon::now()->addDays(-35);
        $donar=UserInfo::where('waspositive',1)->whereNotNull('nvdate')->where('nvdate','>',$date);
        if($request->has('bloodgroup')){
            $donar=$donar->where('bloodgroup',$request->bloodgroup);
        }
        if($request->has('sort') ){
            if($request->has('sort_type')){
                $donar=$donar->orderBy($request->sort,$request->sort_type);
            }else{
                $donar=$donar->orderBy($request->sort,'desc');
            }
        }
        return response()->json($donar->get());
    }

    public function getWinner(Request $request){
     
        $donar=UserInfo::where('waspositive',1)->whereNotNull('nvdate');
        if($request->has('bloodgroup')){
            $donar=$donar->where('bloodgroup',$request->bloodgroup);
        }
        if($request->has('sort') ){
            if($request->has('sort_type')){
                $donar=$donar->orderBy($request->sort,$request->sort_type);
            }else{
                $donar=$donar->orderBy($request->sort,'desc');
            }
        }
        return response()->json($donar->get());
    }

    public function news(Request $request){
        $news=News::where('id'>0);
        if($request->has('sort') ){
            if($request->has('sort_type')){
                $news=$news->orderBy($request->sort,$request->sort_type);
            }else{
                $news=$news->orderBy($request->sort,'desc');
            }
        }
        return response()->json($news->get());

    }
}
