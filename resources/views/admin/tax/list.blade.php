@extends('layouts.master')

@section('title') {{$title}} @endsection
@section('headerStyle')
    <link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    
    <link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/plugins/animate/animate.css')}}" rel="stylesheet" type="text/css">

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('title') Manage @endslot
        @slot('item1') Admin @endslot
        @slot('item2') {{$title}} @endslot
    @endcomponent
<div class="row">
    <div class="col-lg-10 col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-5">{{$title}}</h4>
                <div class="row">
                    <div class="mx-auto mb-4 mt-2">
                        <a href="{{route('admin.tax.add_new')}}" class="btn btn-primary">Add New</a>
                    </div>
                </div>
                @include('widget/notifications')
                <table id="datatable" class="table  dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Rate</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footerScript')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{ URL::asset('assets/pages/jquery.sweet-alert.init.js')}}"></script>
<script src="{{ URL::asset('assets/pages-material/jquery.sweet-alert.init.js')}}"></script>   
<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            ajax: '{!! route('admin.tax.showAjaxList') !!}',
            columns: [
                { data: 'id', name: 'id'},
                { data: 'name', name: 'name'},
                { data: 'rate', name: 'rate'},
                { data: 'status', name: 'status'},
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            "order": [[0, 'desc'],]
        });
        
        $("#Store").addClass('active');
        $('a[href="#Store"]').addClass('active');
        $("#tax").addClass('active');
    });
</script>

@endsection
