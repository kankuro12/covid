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

<div class="col-sm-12">
    <div class="card">
        <div class="body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs p-0 mb-3">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Verified</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile">Unverified</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#noncovid">Non Covid</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane in active" id="home">
                    <div class="table-responsive">

                        <table id="newstable" class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>
                                        #ID
                                    </th>
                                    <th>
                                        Name
                                    </th>

                                    <th>
                                        phone
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
                                @if($user->verified == 1)
                                <tr id="verified-{{ $user->id }}">
                                    <td>
                                        {{$user->id}}
                                    </td>
                                    <td>
                                        {{$user->name}}
                                    </td>

                                    <td>
                                        {{$user->info->phone}}
                                    </td>
                                    @php

                                    $info=$user->info;
                                    $null=$info==null;
                                    @endphp

                                    <td>
                                        @if ($null)
                                        --
                                        @else
                                        @if ($info->waspositive)
                                        <div>
                                            <strong>Blood Group : </strong> {{ $user->info->bloodgroup }}
                                        </div>
                                        <div>
                                            <strong>Lab Id : </strong>{{$info->labid}}
                                        </div>
                                        <div>
                                            <strong>Swab Collected Date : </strong>{{$info->swabcollecteddate}}
                                        </div>
                                        <div>
                                            <strong>Test Center : </strong>{{$info->testcenter}}
                                        </div>
                                        <div>
                                            <strong>+ve Date : </strong>{{$info->pdate}}
                                        </div>
                                        <div>
                                            <strong>-ve Date : </strong> {{$info->nvdate??'Not +ve yet'}}
                                        </div>
                                        @else
                                        Not covid Patient
                                        @endif
                                        @endif
                                    </td>
                                    {{-- <td>

                                          </td> --}}
                                    <td>

                                        <div class="">
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
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="profile">
                    <div class="table-responsive">

                        <table id="newstable1" class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>
                                        #ID
                                    </th>
                                    <th>
                                        Name
                                    </th>

                                    <th>
                                        phone
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
                                @if($user->info->waspositive == 1 && $user->verified == 0)
                                <tr id="unverified-{{ $user->id }}">
                                    <td>
                                        {{$user->id}}
                                    </td>
                                    <td>
                                        {{$user->name}}
                                    </td>

                                    <td>
                                        {{$user->info->phone}}
                                    </td>
                                    @php

                                    $info=$user->info;
                                    $null=$info==null;
                                    @endphp

                                    <td>
                                        @if ($null)
                                        --
                                        @else
                                        @if ($info->waspositive)
                                        <div>
                                            <strong>Blood Group : </strong> {{ $user->info->bloodgroup }}
                                        </div>
                                        <div>
                                            <strong>Lab Id : </strong>{{$info->labid}}
                                        </div>
                                        <div>
                                            <strong>Swab Collected Date : </strong>{{$info->swabcollecteddate}}
                                        </div>
                                        <div>
                                            <strong>Test Center : </strong>{{$info->testcenter}}
                                        </div>
                                        <div>
                                            <strong>+ve Date : </strong>{{$info->pdate}}
                                        </div>
                                        <div>
                                            <strong>-ve Date : </strong> {{$info->nvdate??'Not +ve yet'}}
                                        </div>
                                        @else
                                        Not covid Patient
                                        @endif
                                        @endif
                                    </td>
                                    {{-- <td>

                                    </td> --}}
                                    <td>

                                        <div class="">
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
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="noncovid">
                    <div class="table-responsive">

                        <table id="newstable2" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        #ID
                                    </th>
                                    <th>
                                        Name
                                    </th>

                                    <th>
                                        phone
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
                                @if($user->info->waspositive == 0)
                                <tr id="verified-{{ $user->id }}">
                                    <td>
                                        {{$user->id}}
                                    </td>
                                    <td>
                                        {{$user->name}}
                                    </td>

                                    <td>
                                        {{$user->info->phone}}
                                    </td>
                                    @php

                                    $info=$user->info;
                                    $null=$info==null;
                                    @endphp

                                    <td>
                                        @if ($null)
                                        --
                                        @else
                                        @if ($info->waspositive)
                                        <div>
                                            <strong>Blood Group : </strong> {{ $user->info->bloodgroup }}
                                        </div>
                                        <div>
                                            <strong>Lab Id : </strong>{{$info->labid}}
                                        </div>
                                        <div>
                                            <strong>Swab Collected Date : </strong>{{$info->swabcollecteddate}}
                                        </div>
                                        <div>
                                            <strong>Test Center : </strong>{{$info->testcenter}}
                                        </div>
                                        <div>
                                            <strong>+ve Date : </strong>{{$info->pdate}}
                                        </div>
                                        <div>
                                            <strong>-ve Date : </strong> {{$info->nvdate??'Not +ve yet'}}
                                        </div>
                                        @else
                                        Not covid Patient
                                        @endif
                                        @endif
                                    </td>
                                    {{-- <td>

                                   </td> --}}
                                    <td>

                                        <div class="">
                                            <!-- <button id="verify-{{$user->id}}" class="btn btn-success verify {{$user->verified==0?'unverified':'verified'}}" data-uid="{{$user->id}}" data-status="{{$user->verified}}"></button> -->
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
        $('.verify').click(function() {
            console.log(this);
            vdata = $(this).data();
            console.log(vdata);
            $.ajax({
                url: "{{route('admin.user-verify')}}",
                data: vdata,
                type: "post",
                dataType: 'json',
                success: function(data) {
                    console.log(data.status);
                    $('#verify-' + data.id).data('status', data.status);
                    if (data.status == 1) {
                        window.location.reload();
                        $('#verify-' + data.id).addClass('verified').removeClass('unverified');
                    } else {
                        window.location.reload();
                        $('#verify-' + data.id).addClass('unverified').removeClass('verified');

                    }
                    // $('#verified-'+data.id).hide();
                   

                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

    });

</script>
@endsection