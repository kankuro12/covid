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
use App\Models\Donation;
use App\Models\RequestResponse;
use App\Models\ContactList;

use App\Notifications\PasswordReset;
use Socialite;

class UserController extends Controller
{
    public function memo(Request $request)
    {
        $user = Auth::user();
        if ($request->getMethod() == "POST") {
            $request->validate(['description' => 'required']);
            $memo = Memo::where('user_id', $user->id)->first();
            if ($memo == null) {
                $memo = new Memo();
            }
            $memo->description = $request->description();
            $memo->save();
            return response()->json(['msg' => 'memo Saved  Sucessfully']);
        } else {
            $memo = Memo::where('user_id', $user->id)->first();
            return response()->json(['memo' => $memo == null ? '' : $memo->description]);
        }
    }

    public function info(Request $request)
    {
        $user = Auth::user();
        if ($request->getMethod() == "POST") {

            $info = UserInfo::where('user_id', $user->id)->first();
            if ($info == null) {
                $info = new UserInfo();
                $info->user_id = $user->id;
            }
            $info->address = $request->address;
            $info->bloodgroup = $request->bloodgroup;
            $info->nvdate = $request->nvdate;
            $info->pdate = $request->pdate;
            $info->testcenter = $request->testcenter;
            $info->waspositive = $request->waspositive;
            $info->description = $request->description ?? '';
            $info->age = $request->age;
            // $info->phone=$request->phone;
            $info->labid = $request->labid;
            $info->swabcollecteddate = $request->swabcollecteddate;
            $info->hasdonated = $request->hasdonated ?? 0;
            $user->ispublic = $request->ispublic ?? 1;
            if ($request->has('name')) {
                $user->name = $request->name;
            }
            $user->save();
            $info->save();
            return response()->json(['msg' => 'Info Saved  Sucessfully', 'info' => $info, 'user' => $user]);
        } else {
            $info = UserInfo::where('user_id', $user->id)->first();
            $data = [];
            if ($info == null) {
                $data['address'] = '';
                $data['bloodgroup'] = '';
                $data['nvdate'] = '';
                $data['waspositive'] = 0;
                $data['age'] = '';
                $data['description'] = '';
                $data['phone'] = '';
                $data['testcenter'] = '';
                $data['pdate'] = '';
                $data['labid'] = '';
                $data['swabcollecteddate'] = '';
                $data['hasdonated'] = 0;
                $data['ispublic'] = $user->ispublic;
                $data['name'] = $user->name;
                $data['email'] = $user->email;
            } else {
                // dfsdh
                $data['address'] = $info->address;
                $data['bloodgroup'] = $info->bloodgroup;
                $data['nvdate'] = $info->nvdate;
                $data['waspositive'] = $info->waspositive;
                $data['ispublic'] = $user->ispublic;
                $data['name'] = $user->name;
                $data['email'] = $user->email;
                $data['age'] = $info->age;
                $data['description'] = $info->description;
                $data['hasdonated'] = $info->hasdonated;
                $data['pdate'] = $info->pdate;
                $data['testcenter'] = $info->testcenter;
                $data['phone'] = $info->phone;
                $data['labid'] = $info->labid;
                $data['swabcollecteddate'] = $info->swabcollecteddate;
            }
            return response()->json($data);
        }
    }

    // kldsfjdslkfjdslkfjkslfjsdlkfjlksdjfklsfjkldfjdsklfjl

    public function bloodRequest()
    {
        return response()->json(Auth::user()->bloodRequests);
    }

    public function addBloodRequest(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'amount' => 'required',
            'hospital' => 'required',
            'needed' => 'required',
            'bloodgroup' => 'required'
        ]);
        $user = Auth::user();

        if ($request->has('id')) {
            $req = DonationRequest::find($request->id);
        } else {
            $req = new DonationRequest();
            $req->user_id = $user->id;
        }
        $req->name = $request->name;
        $req->phone = $request->phone;
        $req->amount = $request->amount;
        $req->hospital = $request->hospital;
        $req->needed = $request->needed;
        $req->description = $request->description ?? "";
        $req->bloodgroup = $request->bloodgroup;
        $req->save();

        return response()->json($req);
    }

    public function getBloodRequest($id)
    {
        return response()->json(DonationRequest::find($id));
    }

    public function reqComplete(Request $request)
    {
        $request->validate([
            'req_id' => 'required',
            'user_id' => 'required'
        ]);
        $com = new RequestResponse();
        $com->donation_request_id = $request->req_id;
        $com->user_id = $request->user_id;
        $com->save();
        $user = User::find($request->user_id);
        $user->hasdonated = 1;
        $user->save();
        $req = DonationRequest::find($request->req_id);
        $req->accecpted = 1;
        $req->save();
        return response()->json(['msg' => "Plasma Request Completed"]);
    }

    public function addcontact(Request $request)
    {
        $request->validate([
            'req_id' => 'required',
            'user_id' => 'required'
        ]);
        $com = new ContactList();
        $com->donation_request_id = $request->req_id;
        $com->user_id = $request->user_id;
        $com->save();

        return response()->json(['msg' => "Contact Added Completed"]);
    }

    public function contacts($req_id)
    {
        $clist = ContactList::where('donation_request_id', $req_id)->get();
        $datas = [];
        foreach ($clist as $contact) {
            $user = User::find($contact->user_id);
            $info = $user->info;
            $data = [];
            $data['address'] = $info->address;
            $data['bloodgroup'] = $info->bloodgroup;
            $data['nvdate'] = $info->nvdate;
            $data['waspositive'] = $info->waspositive;
            $data['ispublic'] = $user->ispublic;
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['age'] = $info->age;
            $data['description'] = $info->description;
            $data['hasdonated'] = $info->hasdonated;
            $data['pdate'] = $info->pdate;
            $data['testcenter'] = $info->testcenter;
            $data['phone'] = $info->phone;
            array_push($datas, $data);
        }
        return response()->json($datas);
    }

    public function donated(Request $request)
    {
        $user = Auth::user();
        if ($request->donationtype == 1) {
            $user_info = UserInfo::where('user_id', $user->id)->first();
            $user_info->donationtype = 1;
            $user_info->save();
            $d = new Donation();
            $d->dname = $user->name;
            $d->dphone = $user->info->phone;
            $d->rname = "Donated To Blood Bank";
            $d->rphone = "-----";
            $d->user_id = $user->id;
            $d->save();
            return response()->json($d);
        } else {
            $check = DonationRequest::where('phone', $request->phone)->where('accecpted', 0)->first();
            if ($check != null) {
                $request->validate([
                    'phone' => 'required'
                ]);
                $d = new Donation();
                $d->dname = $user->name;
                $d->dphone = $user->info->phone;
                $d->rname = $request->name;
                $d->rphone = $request->phone;
                $d->user_id = $user->id;
                $d->save();
                $info = $user->info;
                $info->hasdonated = 1;
                $info->save();
                DonationRequest::where('phone', $request->phone)->update(['accecpted' => 1]);
                return response()->json($d);
            } else {
                return response()->json('Sorry your request has been failed');
            }
        }
    }

    public function myRequest()
    {
        $user = Auth::user();
        $req = DonationRequest::where('user_id', $user->id)->get();
        return response()->json($req);
    }

    public function myDonation()
    {
        $user = Auth::user();
        $mydonation = Donation::where('user_id', $user->id)->get();
        return response()->json($mydonation);
    }
}



// change here
