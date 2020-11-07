@extends('layout')
@section('title','Add News')

@section('content')
    <form action="{{route('admin.news-edit',['news'=>$news->id])}}" method="post" id="edit-news">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" required placeholder="Title" name="title" value="{{$news->title}}">
        </div>
        <div class="form-group">
            <label for="description">News</label>
            <textarea type="text" class="form-control" required placeholder="News" name="description">{{$news->description}}</textarea>
        </div>
        <div class="form-group">
            <input type="submit" value="update News" class="btn btn-primary" >
            <a href="{{route('admin.news')}}" class="btn btn-danger">Cancel</a>
        </div>
    </form>
@endsection