@extends('layout')
@section('title','Users')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@endsection
@section('toolbar')
    <a class="btn btn-primary" href="{{route('admin.user-add')}}">
        Add Donor
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
                        email
                    </th>
                    <th>
                        phone
                    </th>
                    <th>
                        Blood Group
                    </th>
                    <th>
                        INFO
                    </th>
                    <th>

                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $user)
                    <tr>
                        <td>
                            {{$user->id}}
                        </td>
                        <td>
                            {{$user->name}}
                        </td>
                        <td>
                            {{$user->email}}
                        </td>
                        <td>
                            {{$user->phone}}
                        </td>
                        @php
                            
                            $info=$user->info;
                            $null=$info==null;
                        @endphp
                        <td>
                            {{$null?'--':$info->bloodgroup}}
                        </td>
                        <td>
                            @if ($null)
                                --
                            @else
                                @if ($info->waspositive)
                                    <div>
                                        <strong>Test Center : </strong>{{$info->testcenter}}
                                    </div>
                                    <div>
                                        <strong>+ve Date : </strong>{{$info->pdate}}
                                    </div>
                                    <div>
                                        <strong>-ve Date : </strong> {{$info->nvdate??'Not -ve yet'}}
                                    </div>
                                @else
                                    Not covid Patient
                                @endif
                            @endif
                        </td>
                        {{-- <td>

                        </td> --}}
                        <td>
                            
                            <div class="" >
                                    <button id="verify-{{$user->id}}" class="btn btn-success verify {{$user->verified==0?'unverified':'verified'}}" data-uid="{{$user->id}}" data-status="{{$user->verified}}"></button>
                            </div>
                            <div>
                                <a href="{{route('admin.user-show',['user'=>$user->id])}}">Detail</a>|
                                <a href="{{route('admin.user-edit',['user'=>$user->id])}}">Edit</a>
                            </div>
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
                        $('#verify-'+data.id).addClass('verified').removeClass('unverified');
                    }else{
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