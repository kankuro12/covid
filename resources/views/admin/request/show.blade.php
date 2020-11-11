@extends('layout')
@section('title','Request Detail - '.$req->name)
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
      
    </div>
    <hr>
    <div>
        <h2>Request Contacts</h2>
        <div style="padding-left:30px;">
            @foreach ($req->contacts as $contact)
                <div class="row">
                    <div class="col-md-6">
                        <strong>Name : </strong> {{$contact->user->name}}
                    </div>
                    <div class="col-md-6">
                        <strong>phone : </strong> {{$contact->user->info!=null?$contact->user->info->phone:""}}
                    </div>
                    @if ($req->accecpted==0)  
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{route('admin.request-complete',['req'=>$req->id,'user'=>$user->id])}}">Mark Complete</a>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div> 
    </div>
    <hr>
    @if ($req->accecpted==0)  
        <div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="mobile">Search Via Mobile no</label>
                        <input type="text" id="s-phone" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="w-100"></label>
                        <button class="btn btn-primary btn-lg w-100" id="btn-search">Search</button>
                    </div>
                </div>
                <div class="col-md-12">
                    <div  id="search-result">

                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('js')
    <script>
        var url="{{route('admin.user-search-phone',['phone'=>'#pp','req_id'=>$req->id])}}";
        $('#btn-search').click(function(){
            
            data=$('#s-phone').val();
            if(data.length<5){
                alert('Please Ente Phone no');
                return;
            }else{
                u=url.replace("#pp", data);
                $.get(u, function( ret ) {
                    $( "#search-result" ).html( ret );
                });
            }



        });
    </script>
@endsection