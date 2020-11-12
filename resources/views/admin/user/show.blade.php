@extends('layout')
@section('title','User Detail - '.$user->name)
@section('css')
@endsection
{{-- @section('toolbar')
    <a class="btn btn-primary" href="{{route('admin.news-add')}}">
        User Detail
    </a>
    <hr>
@endsection --}}
@section('content')
    <div class="row">
        <div class="col-md-6">
            <strong>Name : </strong>{{$user->name}}
        </div>
        <div class="col-md-6">
            <strong>Email : </strong>{{$user->email}}
        </div>
        @php    
            $info=$user->info;
            $null=$info==null;
        @endphp
        @if (!$null)
            <div class="col-md-6">
                <strong>Phone : </strong>{{$info->phone}}
            </div>
            <div class="col-md-6">
                <strong>Blood Group : </strong>{{$info->bloodgroup}}
            </div>
            <div class="col-md-6">
                <strong>Swab Collected Date: </strong>{{$info->swabcollecteddate}}
            </div>
            <div class="col-md-6">
                <strong>Lab Id: </strong>{{$info->labid}}
            </div>
            <div class="col-md-6">
                <strong>Test Center: </strong>{{$info->testcenter}}
            </div>
            <div class="col-md-6">
                <strong>Positive Date: </strong>{{$info->pdate}}
            </div>
            <div class="col-md-6">
                <strong>Negative Date: </strong>{{$info->nvdate}}
            </div>
            <div class="col-md-6">
                <strong>Age</strong>{{$info->age}}
            </div>
            <div class="col-md-12">
                <hr>
                <div>
                    <strong>Previous Medical History</strong>
                </div>
                <div>
                    {{$info->description}}
                </div>
            </div>
        @endif
    </div>
    <hr>
    <div>
        @foreach ($user->requests as $req)
        
        <div class="row">
            <div class="col-md-6">
                <strong>Name: </strong>{{$req->name}}
            </div>
            <div class="col-md-6">
                <strong>Hospital: </strong>{{$req->hospital}}
            </div>
                <div class="col-md-3">
                    <strong>Phone: </strong>{{$req->phone}}
                </div>
                <div class="col-md-3">
                    <strong>Blood Group : </strong>{{$req->bloodgroup}}
                </div>
                <div class="col-md-3">
                    <strong>Needed Date: </strong>{{$req->needed}}
                </div>
                <div class="col-md-3">
                    <strong>Needed Amount: </strong>{{$req->amount}}
                </div>
                <div class="col-md-12">
                    <hr>
                    <div>
                        <strong>Extra Detail</strong>
                    </div>
                    <div>
                        {{$req->description}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <a href="{{route('admin.request-show',['req'=>$req->id])}}">Details</a>
                    </div>
                </div>
          
        </div>
        @endforeach
    </div>
@endsection
@section('js')

@endsection