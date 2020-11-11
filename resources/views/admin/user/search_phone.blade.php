@foreach ($users as $user)
<div class="row">
    <div class="col-md-6">
        <strong>Name : </strong> {{$user->user->name}}
    </div>
    <div class="col-md-3">
        <strong>phone : </strong> {{$user->phone}}
    </div>
   
        <div class="col-md-3">
            <div class="form-group">
                <a href="{{route('admin.request-complete',['req'=>$req_id,'user'=>$user->user_id])}}">Mark Complete</a>
            </div>
        </div>
  
</div>
@endforeach