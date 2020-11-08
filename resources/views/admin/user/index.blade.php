@extends('layout')
@section('title','Users')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@endsection
@section('toolbar')
    <a class="btn btn-primary" href="{{route('admin.news-add')}}">
        Add User
    </a>
    <hr>
@endsection
@section('content')
    <div class="table-responsive">

        <table id="newstable"class="table table-bordered table-striped table-hover dataTable">
            <thead>
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        email
                    </th>
                    <th>
                        phone
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $user)
                    <tr>
                        <td>
                            {{$user->name}}
                        </td>
                        <td>
                            {{$user->email}}
                        </td>
                        <td>
                            {{$user->phone}}
                        </td>
                        <td>
                            {{$user->created_at->diffForHumans()}}
                        </td>
                        {{-- <td>
                            <a href="{{route('admin.user-edit',['user'=>$user->id])}}">Edit</a> |
                            <a href="{{route('admin.user-del',['user'=>$user->id])}}">Delete</a> 

                        </td> --}}
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