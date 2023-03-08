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
                        <a href="{{route('admin.product.add_new',[get_route_url()])}}" class="btn btn-primary">Add New</a>
                    </div>
                </div>
                @include('widget/notifications')
                <table id="datatable" class="table  dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><i class="fa fa-picture-o"></i></th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Publish Date</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="container_filter">
    <div class="row">
        <div class="col-12">
            <div class="col-4 mb-2">
                <label class="ml-2 mr-2">Filter By Status</label>
                <select class="form-control" id="status_info">
                    <option value="">All</option>
                    <option value="1">Active</option>
                    <option value="0">De-Active</option>
                </select>
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
        
        $("#Store").addClass('active');
        $('a[href="#Store"]').addClass('active');
        $("#product").addClass('active');

        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            ajax: {
                url:'{!! route('admin.product.showAjaxList',[get_route_url()]) !!}',
                data:function(d){
                    d.filterextend = $('#status_info').val(),
                    d.createdby = $('#created_by').val()
                }
            },
            columns: [
                { data: 'id', name: 'id'},
                { data:'picture',name:'picture', orderable: false, searchable: false},
                { data: 'title', name: 'title'},
                { data: 'stock', name: 'stock',orderable: false, searchable: false },
                { data: 'price', name: 'price',orderable: false, searchable: false },
                { data: 'status', name: 'status',orderable: false, searchable: false },
                { data: 'publish_date', name: 'publish_date',orderable: false, searchable: false },
                { data: 'category', name: 'category',orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            "order": [
                      [0, 'desc'],
      
                     ]
        });
        $(".container_filter").appendTo("#datatable_wrapper #datatable_length");

        $("body").on("change","#status_info",function(){
            $('#datatable').DataTable().draw();
        });
    });
</script>

@endsection
