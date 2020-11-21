@extends('layout')
@section('title','Donations')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@endsection
@section('toolbar')
<a class="btn btn-primary" href="{{route('admin.donation-add')}}">
    Add Donation
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
                        Donor
                    </th>
                    <th>
                        Donor Phone
                    </th>
                    <th>
                        Receiver
                    </th>
                    <th>
                        Receiver Phone
                    </th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($donations as $donation)
                    <tr>
                        <td>
                            {{$donation->id}}
                        </td>
                        <td>
                            {{$donation->dname}}
                        </td>
                        <td>
                            {{$donation->dphone}}
                        </td>
                        <td>
                            {{$donation->rname}}
                        </td>
                        <td>
                            {{$donation->rphone}}
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