@extends('layout')
@section('title','Dashboard')
@section('content')
@php 
 $userCount = \App\Models\User::where('verified',1)->count();
 $verifiedCount = \App\Models\DonationRequest::where('verified',1)->count();
 $unverifiedCount = \App\Models\DonationRequest::where('verified',0)->count();
 $donation = \App\Models\Donation::count();
@endphp
<div class="row clearfix">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card w_data_1">
            <div class="body">
                <div class="w_icon indigo"><i class="zmdi zmdi-account-circle"></i></div>
                <h4 class="mt-3">{{ $userCount }}</h4>
                <span class="text-muted">Total Users</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card w_data_1">
            <div class="body">
                <div class="w_icon pink"><i class="zmdi zmdi-check-circle"></i></div>
                <h4 class="mt-3">{{ $verifiedCount }}</h4>
                <span class="text-muted">Verified Request</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card w_data_1">
            <div class="body">
                <div class="w_icon orange"><i class="zmdi zmdi-close-circle"></i></div>
                <h4 class="mt-3">{{ $unverifiedCount }}</h4>
                <span class="text-muted">Unverified Request</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card w_data_1">
            <div class="body">
                <div class="w_icon green"><i class="zmdi zmdi-airline-seat-recline-extra"></i></div>
                <h4 class="mt-3">{{ $donation }}</h4>
                <span class="text-muted">Donations</span>
            </div>
        </div>
    </div>
</div>
@endsection