@extends('layout')
@section('title','Add News')

@section('content')
    <form action="{{route('admin.news-add')}}" method="post" id="add-news">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" required placeholder="Title" name="title">
        </div>
        <div class="form-group">
            <label for="description">News</label>
            <textarea type="text" class="form-control" required placeholder="News" name="description"></textarea>
        </div>
        <div class="form-group">
            <input type="submit" value="Add News" class="btn btn-primary" onclick="document.getElementById('add-news').submit();">
            <a href="{{route('admin.news')}}" class="btn btn-danger">Cancel</a>
        </div>
    </form>
@endsection