@extends('layout')
@section('title','Add Donation')
@section('css')
@endsection

@section('content')

<form action="{{route('admin.donation-add')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Doner Name</label>
                <input type="text" class="form-control" required placeholder="Doner Name" name="dname" >
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="Hospital">Receiver Name</label>
                <input type="text" class="form-control" required placeholder="Receiver Name" name="rname">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="[hone]">Doner Phone</label>
                <input type="text" class="form-control" required placeholder="Doner Phone" name="dphone">
            </div>
        </div>

     
        <div class="col-md-6">
            <div class="form-group">
                <label for="rphone">Receiver Phone </label>
                <input type="text" class="form-control" required placeholder="Receiver Phone" name="rphone">

            </div>
        </div>
       
        <div class="col-md-12">
            <div class="form-group">
                <input type="submit" value="Add Donation" class="btn btn-primary" >
                <a href="{{route('admin.donations')}}" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection
@section('js')

@endsection