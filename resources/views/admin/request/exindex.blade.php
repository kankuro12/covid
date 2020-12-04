@extends('layout')
@section('title','Expired Requests')
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
    <div class="table-responsive">

        <table id="newstable"class="table table-bordered table-striped table-hover dataTable">
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
                    <tr>
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
                            <a href="{{route('admin.request-edit',['req'=>$req->id])}}">Edit</a>
                            <a href="{{route('admin.request-del',['req'=>$req->id])}}">Del</a>
                            <a href="{{route('admin.request-show',['req'=>$req->id])}}">Details</a>
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

   
    $('#newstable').DataTable();
    $(function () {
        $('.verify').click(function(){
            console.log(this);
            vdata=$(this).data();
            console.log(vdata);
            $.ajax({
                url:"{{route('admin.user-verify')}}",
                data:vdata,
                type: "post",
                dataType  : 'json',
                success   : function(data) {
                    console.log(data.status);
                    $('#verify-'+data.id).data('status',data.status);
                    if(data.status==1){
                        window.location.reload();
                        $('#verify-'+data.id).addClass('verified').removeClass('unverified');
                    }else{
                        window.location.reload();
                        $('#verify-'+data.id).addClass('unverified').removeClass('verified');

                    }
                },
                error:function(data){
                    console.log(data);
                }
            });
        });


    });
</script>
@endsection