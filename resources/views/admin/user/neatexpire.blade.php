@extends('layout')
@section('title','Users')
@section('css')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@endsection

@section('content')

<div class="col-sm-12">
    <div class="card">
        <div class="body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs p-0 mb-3">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Near to expire list</a></li>
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
                                        phone
                                    </th>

                                    <th>
                                        INFO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $user)
                                <tr id="verified-{{ $user->id }}">
                                    <td>
                                        {{$user->id}}
                                    </td>
                                    <td>
                                        {{$user->name}}
                                    </td>

                                    <td>
                                        {{$user->phone}}
                                    </td>
                                    
                                    <td>
                                        
                                        <div>
                                            <strong>Blood Group : </strong> {{ $user->bloodgroup }}
                                        </div>
                                        <div>
                                            <strong>Lab Id : </strong>{{$user->labid}}
                                        </div>
                                        <div>
                                            <strong>Swab Collected Date : </strong>{{$user->swabcollecteddate}}
                                        </div>
                                        <div>
                                            <strong>Test Center : </strong>{{$user->testcenter}}
                                        </div>
                                        <div>
                                            <strong>+ve Date : </strong>{{$user->pdate}}
                                        </div>
                                        <div>
                                            <strong>-ve Date : </strong> {{$user->nvdate??'Not +ve yet'}}
                                        </div>
                                    </td>
                                </tr>
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
        $('#newstable1').DataTable();
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