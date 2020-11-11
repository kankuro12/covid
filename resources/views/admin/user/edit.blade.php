@extends('layout')
@section('title','Edit User - '.$user->name)
@section('css')
@endsection
{{-- @section('toolbar')
    <a class="btn btn-primary" href="{{route('admin.news-add')}}">
        User Detail
    </a>
    <hr>
@endsection --}}
@section('content')
@php
    $bg=[
                'A+',
                'B+',
                'O+',
                'AB+',
                'A-',
                'B-',
                'O-',
                'AB-'
            ];
            
                            
    $info=$user->info;
    $null=$info==null;
    
@endphp 
<form action="{{route('admin.user-add')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" required placeholder="Name" name="name" value="{{$user->name}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" required placeholder="Email" name="email" value="{{$user->email}}" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="[hone]">Phone</label>
                <input type="text" class="form-control" required placeholder="Phone" name="phone" value="{{$null?'':$info->phone}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" required placeholder="Address" name="address" value="{{$null?'':$info->address}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Blood Group</label>
                <select  class="form-control" required  name="bloodgroup">
                    @foreach ($bg as $b)
                        <option value="{{$b}}"
                            @if (!$null)
                                @if ($info->bloodgroup==$b)
                                    selected
                                @endif
                            @endif
                        >{{$b}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="pdate">Positive Date</label>
                <input type="date" class="form-control" required placeholder="Positive Date" name="pdate" value="{{$null?'':$info->pdate}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="nvdate">Negative Date</label>
                <input type="date" class="form-control"  placeholder="Negative Date" name="nvdate" value="{{$null?'':$info->ndate}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" class="form-control" min="1"  required placeholder="Age" name="age" value="{{$null?'':$info->age}}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="testcenter">Test Center</label>
                <input type="text" class="form-control" required placeholder="Test Center" name="testcenter" value="{{$null?'':$info->testcenter}}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="description">Medical History</label>
                <textarea  class="form-control"  placeholder="Medical history" name="description">{{$null?'':$info->description}}</textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input type="checkbox" name="hasdonated" value="1" style="margin-right:10px"
                @if (!$null)
                    @if ($info->hasdonated==1)
                        checked
                    @endif
                @endif
                > Has Already Donated
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <input type="submit" value="Update Donor" class="btn btn-primary" >
                <a href="{{route('admin.users')}}" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
@section('js')

@endsection