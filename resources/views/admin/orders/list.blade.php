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
                @include('widget/notifications')


                <form class="form-parsley" action="{{route('admin.orders.export',[get_route_url()])}}" method="get">
                    <div class="row"> 
                        <div class="col-4">
                            <div class="form-group">
                                <label>Payment Status</label>
                                <select class="form-control" name="payment_status">
                                    <option value="">All</option>
                                    <option value="Paid" {{($payment_status =="Paid" ? "selected":"" )}}>Paid</option>
                                    <option value="non-paid" {{($payment_status =="non-paid" ? "selected":"" )}}>Pending</option>
                                    
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-gradient-purple waves-effect waves-light" >Download Report</button> &nbsp;
                                <button type="button"  onclick="document.getElementById('clearSearchForm').submit();" class="btn btn-gradient-danger waves-effect waves-light" >Clear Search</button> &nbsp;
                                
                            </div>
                        </div>
                    </div>

                </form>
                <form method="get" id="clearSearchForm" action="">

                </form>

                <table id="datatable" class="table  dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Amount</th>
                            <th>Date of order</th>
                            <th>Payment Type</th>
                            <th>Payment Status</th>
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
            ajax: '{!! route('admin.orders.showAjaxList',[get_route_url()]) !!}',
            columns: [
                { data: 'id', name: 'id'},
                { data: 'total', name: 'total' },
                { data: 'date', name: 'date' },
                { data: 'payment_type', name: 'payment_type' },
                { data: 'payment_status', name: 'payment_status' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            "order": [[0, 'desc'],]
        });
        
        $("#Orders").addClass('active');
        $('a[href="#Orders"]').addClass('active');
        $("#orders_manage").addClass('active');
    });
</script>

@endsection
