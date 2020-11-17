@extends('layout')
@section('title','Welcome Message')

@section('content')
    <form action="{{route('admin.message')}}" method="post" id="add-news" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="desgination" maxlength="60" >Designation</label>
            <input type="text" class="form-control" required placeholder="Desgination" name="desgination" required value="{{$i?$message->degination:''}}">
        </div>
        <div class="form-group">
            <label for="title" maxlength="60" >Name</label>
            <input type="text" class="form-control" required placeholder="Name" name="title" required value="{{$i?$message->title:''}}">
        </div>
        <div class="form-group">
            <label for="org" maxlength="60" >Orgination</label>
            <input type="text" class="form-control" required placeholder="Orgination" name="org" required value="{{$i?$message->org:''}}">
        </div>
        <div class="form-group">
            <label for="message">Message</label>
        <textarea maxlength="160" type="text" class="form-control" required placeholder="Message" required name="message">{{$i?$message->message:''}}</textarea>
        </div>
        <div>
            <label for="image">Image</label>
            @if ($i)
                <img src="{{asset($message->image)}}" style="width:200px"/>
            @endif
            <input type="file" name="image" class="form-control" {{$i?'':'required'}}>
        </div>
        <div class="form-group">
            <input type="submit" value="Update Message" class="btn btn-primary" onclick="document.getElementById('add-news').submit();">
            <a href="{{route('admin.dashboard')}}" class="btn btn-danger">Cancel</a>
        </div>
    </form>
@endsection