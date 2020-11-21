@extends('layout')
@section('title','Requests')
@section('css')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@endsection
@section('toolbar')
<a class="btn btn-primary" href="{{route('admin.request-add')}}">
    Add Request
</a>
<hr>
@endsection
@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs p-0 mb-3">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Varified</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile">Unverified</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane in active" id="home">
                    <div class="table-responsive">

                        <table id="newstable" class="table table-bordered table-striped table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        #ID
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Hospital
                                    </th>
                                    <th>
                                        phone
                                    </th>
                                    <th>
                                        Blood Group
                                    </th>
                                    <th>
                                        Needed
                                    </th>
                                    <th>
                                        Detail
                                    </th>
                                    <th>
                                        status
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $req)
                                @if($req->verified == 1)
                                <tr id="row-{{$req->id}}">
                                    <td>
                                        {{$req->id}}
                                    </td>
                                    <td>
                                        {{$req->name}}
                                    </td>
                                    <td>
                                        {{$req->hospital}}
                                    </td>
                                    <td>
                                        {{$req->phone}}
                                    </td>
                                    <td>
                                        {{$req->bloodgroup}}
                                    </td>
                                    <td>
                                        <div>
                                            <strong>Date: </strong>{{$req->needed}}
                                        </div>
                                        <div>
                                            <strong>Amount: </strong>{{$req->amount}}
                                        </div>

                                    </td>
                                    <td>
                                        {{$req->description}}
                                    </td>
                                    <td>
                                        {{$req->accecpted==1?"Completed":"Incomplete"}}
                                    </td>
                                    <td>
                                        <div class="">
                                            <button id="verify-{{$req->id}}" class="btn btn-success verify {{$req->verified==0?'unverified':'verified'}}" data-uid="{{$req->id}}" data-status="{{$req->verified}}"></button>
                                        </div>
                                        <a href="{{route('admin.request-edit',['req'=>$req->id])}}">Edit</a>
                                        <a href="{{route('admin.request-del',['req'=>$req->id])}}">Del</a>
                                        <a href="{{route('admin.request-show',['req'=>$req->id])}}">Details</a>
                                    </td>

                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="profile">
                    <div class="table-responsive">
                        <table id="newstable" class="table table-bordered table-striped table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        #ID
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Hospital
                                    </th>
                                    <th>
                                        phone
                                    </th>
                                    <th>
                                        Blood Group
                                    </th>
                                    <th>
                                        Needed
                                    </th>
                                    <th>
                                        Detail
                                    </th>
                                    <th>
                                        status
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $req)
                                @if($req->verified == 0)
                                <tr id="row-{{$req->id}}">
                                    <td>
                                        {{$req->id}}
                                    </td>
                                    <td>
                                        {{$req->name}}
                                    </td>
                                    <td>
                                        {{$req->hospital}}
                                    </td>
                                    <td>
                                        {{$req->phone}}
                                    </td>
                                    <td>
                                        {{$req->bloodgroup}}
                                    </td>
                                    <td>
                                        <div>
                                            <strong>Date: </strong>{{$req->needed}}
                                        </div>
                                        <div>
                                            <strong>Amount: </strong>{{$req->amount}}
                                        </div>

                                    </td>
                                    <td>
                                        {{$req->description}}
                                    </td>
                                    <td>
                                        {{$req->accecpted==1?"Completed":"Incomplete"}}
                                    </td>
                                    <td>
                                        <div class="">
                                            <button id="verify-{{$req->id}}" class="btn btn-success verify {{$req->verified==0?'unverified':'verified'}}" data-uid="{{$req->id}}" data-status="{{$req->verified}}"></button>
                                        </div>
                                        <a href="{{route('admin.request-edit',['req'=>$req->id])}}">Edit</a>
                                        <a href="{{route('admin.request-del',['req'=>$req->id])}}">Del</a>
                                        <a href="{{route('admin.request-show',['req'=>$req->id])}}">Details</a>
                                    </td>

                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script>
    $(function() {
        $('#newstable').DataTable();
        $('.verify').click(function() {
            console.log(this);
            vdata = $(this).data();
            console.log(vdata);
            $.ajax({
                url: "{{route('admin.req-verify')}}",
                data: vdata,
                type: "post",
                dataType: 'json',
                success: function(data) {
                    console.log(data.status);
                    $('#verify-' + data.id).data('status', data.status);
                    if (data.status == 1) {
                        $('#verify-' + data.id).addClass('verified').removeClass('unverified');
                    } else {
                        $('#verify-' + data.id).addClass('unverified').removeClass('verified');

                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });


    });
</script>
@endsection