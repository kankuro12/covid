@extends('layout')
@section('title','Edit Request')
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
@endphp 
<form action="{{route('admin.request-add')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$req->value}}">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" required placeholder="Name" name="name" value="{{$req->name}}" >
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="Hospital">Hospital</label>
                <input type="text" class="form-control" required placeholder="Hospital" name="hospital" value="{{$req->hospital}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" required placeholder="Phone" name="phone" value="{{$req->phone}}">
            </div>
        </div>
       
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Blood Group</label>
                <select  class="form-control" required  name="bloodgroup">
                    @foreach ($bg as $b)
                        <option value="{{$b}}"
                        @if ($req->bloodgroup==$b)
                            selected
                        @endif
                        >{{$b}}</option>
                    @endforeach
                </select>
            </div>
        </div>
     
        <div class="col-md-6">
            <div class="form-group">
                <label for="amount">Needed Amount </label>
                <input type="number" class="form-control" min="1"  required placeholder="Needed Amount" name="amount" value="{{$req->amount}}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="needed">Needed Date </label>
                <input type="date" class="form-control" min="1"  required placeholder="Needed date" name="needed" value="{{$req->needed}}">
            </div>
        </div>
       
        <div class="col-md-12">
            <div class="form-group">
                <label for="description">Extra Detail</label>
                <textarea  class="form-control"  placeholder="Extra Details" name="description">{{$req->description}}</textarea>
            </div>
        </div>
       
        <div class="col-md-12">
            <div class="form-group">
                <input type="submit" value="Update Request" class="btn btn-primary" >
                <a href="{{route('admin.requests')}}" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
@section('js')

@endsection