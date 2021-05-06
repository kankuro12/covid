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
use App\Models\WelcomeMessage;
use App\Models\About;
use App\Models\Donation;
class GeneralController extends Controller
{
    public function about(Request $request){

        if($request->getMethod()=="POST"){
            $about=About::first();
            if($about==null){
                $about=new About();
            }
            $about->description=$request->description;
            $about->save();

            return redirect()->route('admin.about')->with('message','About Us Updated Sucessfully');


        }else{

            $about=About::first();
            $i=$about!=null;
            return view('admin.general.about',compact('about','i'));
        }
    }

    public function message(Request $request){

        if($request->getMethod()=="POST"){
            $message=WelcomeMessage::first();
            if($message==null){
                $message=new WelcomeMessage();
            }
            $message->org=$request->org;
            $message->title=$request->title;
            $message->degination=$request->desgination;
            $message->message=$request->message;
            if ($request->hasFile('image')) {
                if ($request->file('image')->isValid()) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension(); // getting image extension
                    $filename =time().'.'.$extension;
                    $file->move(public_path().'/images', $filename);
                    $message->image='images/'.$filename;

                }
            }
            $message->save();

            return redirect()->route('admin.message')->with('message','message Updated Sucessfully');


        }else{

            $message=WelcomeMessage::first();
            $i=$message!=null;
            return view('admin.general.message',compact('message','i'));
        }
    }

    public function  donations(){
        return view('admin.general.donations',['donations'=>User::join('user_infos','users.id','=','user_infos.user_id')->where('hasdonated',1)->get()]);
    }


    public function donationsStore(Request $request){
        if($request->isMethod('post')){

            $user=Auth::user();
            $d=new Donation();
            $d->dname=$request->dname;
            $d->dphone=$request->dphone;
            $d->rname=$request->rname;
            $d->rphone=$request->rphone;
            $uu=UserInfo::where('phone',$request->dphone)->first();
            if($uu!=null){
                $d->user_id=$uu->user_id;
                $uu->hasdonated=1;
                $uu->save();
            }else{

                $d->user_id=$user->id;
            }
            $d->save();
            return redirect()->route('admin.donations')->with('message','Donation added Sucessfully');

        }else{
          return view('admin.general.donationadd');
        }

    }
}
