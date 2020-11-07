@extends('layout')
@section('title','News')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@endsection
@section('toolbar')
    <a class="btn btn-primary" href="{{route('admin.news-add')}}">
        Add News
    </a>
    <hr>
@endsection
@section('content')
    <div class="table-responsive">

        <table id="newstable"class="table table-bordered table-striped table-hover dataTable">
            <thead>
                <tr>
                    <th>
                        Title
                    </th>
                    <th>
                        Added
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $news)
                    <tr>
                        <td>
                            {{$news->title}}
                        </td>
                        <td>
                            {{$news->created_at->diffForHumans()}}
                        </td>
                        <td>
                            <a href="{{route('admin.news-edit',['news'=>$news->id])}}">Edit</a> |
                            <a href="{{route('admin.news-del',['news'=>$news->id])}}">Delete</a> 

                        </td>
                    </tr>
                    
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('js')
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script>
    $(function () {
        $('#newstable').DataTable();
    });
</script>
@endsection