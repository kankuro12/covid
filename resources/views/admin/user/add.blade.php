@extends('layout')
@section('title','Add User')
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
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" required placeholder="Name" name="name" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" required placeholder="Email" name="email">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Phone</label>
                <input type="text" class="form-control" required placeholder="Email" name="email">
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection