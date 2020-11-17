@extends('layout')
@section('title','About')

@section('content')
    <form action="{{route('admin.about')}}" method="post" >
        @csrf
        
        <div class="form-group">
            <label for="description">About us</label>
            <textarea required type="text" class="form-control" style="height: 400px;" required placeholder="About Us" name="description">{{$i?$about->description:""}}</textarea>
        </div>
        <div class="form-group">
            <input type="submit" value="Update About Us" class="btn btn-primary" >
            <a href="{{route('admin.dashboard')}}" class="btn btn-danger">Cancel</a>
        </div>
    </form>
@endsection