@extends('layouts.master')

@section('title') {{$title}} @endsection
@section('headerStyle')  
<link href="{{ URL::asset('/assets/plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('title') View @endslot
        @slot('item1') Admin @endslot
        @slot('item2') {{$title}} @endslot
    @endcomponent



    <div class="row">
    <div class="col-xl-12 mx-auto">
        <div class="card">
            <div class="card-body">
            @include('widget/notifications')
                <form class="custom-validation" novalidate autocomplete="off" method="post" action="{{ route('admin.orders.update',[get_route_url(),$r->id]) }}"  enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel panel-info">

                                <div class="panel-body">
                                    <h4 class="display-8 mb-4">Order - #{{$r->id}}</h4>
                                    <hr class=" mb-4" />

                                    <div class="row">
                                        <label class="col-sm-3">Order Date:</label>
                                        <div class="col-sm-7">
                                            {{date('M-d-Y h:i',strtotime($r->created_at))}}
                                        </div>
                                    </div>
                                    @if($r->discount!="")
                                    <div class="row">
                                        <label class="col-sm-3">Discount:</label>
                                        <div class="col-sm-8">
                                            {{number_format($r->discount,2)}}
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <label class="col-sm-3">Total Tax:</label>
                                        <div class="col-sm-8">
                                            {{number_format($r->tax,2)}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3">Deliver Charge:</label>
                                        <div class="col-sm-8">
                                            {{number_format($r->deliver_charge,2)}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3">Total Amount:</label>
                                        <div class="col-sm-8">
                                            {{number_format($r->total,2)}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3"><strong>Order Note:</strong></label>
                                        <div class="col-sm-8">
                                            <strong><i> {{$r->order_note}}</i></strong>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <label class="col-sm-4"><strong>Payment Method:</strong></label>
                                        <div class="col-sm-7">
                                            <strong>{{$r->payment_type}}</strong>
                                        </div>
                                    </div>
                                    @if($r->payment_type =="paypal")
                                    <div class="row">
                                        <label class="col-sm-3">Transaction ID:</label>
                                        <div class="col-sm-8">
                                            {{$r->transaction_id}}
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row mb-4 mt-4">
                                        <label class="col-sm-3">Payment Status:</label>
                                        <div class="col-sm-4">
                                            <select style="width:100%" class="select2" name="payment_status">
                                                <option value="non-paid" {{($r->payment_status =="non-paid" ? "selected":"")}}>Non Paid</option>
                                                <option value="Paid" {{($r->payment_status =="Paid" ? "selected":"")}}>Paid</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            @if($r->payment_status =="non-paid")
                                                <span class="label label-danger"><strong><i>Not Paid</i></strong></span>
                                            @elseif($r->payment_status =="Paid")
                                                <span class="label label-success"><strong><i>Paid</i></strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-4 mt-4">
                                        <label class="col-sm-3">Cancel:</label>
                                        <div class="col-sm-9">
                                            @if($r->cancel =="1")
                                                <span class="label label-success"><strong><i>Cacnelled</i></strong></span>
                                                <hr class="mt-2 mb-2">
                                                
                                                    {{$r->reason_cancel}}
                                                
                                            @else
                                            <div class="form-check form-check-warning mb-3">
                                                
                                                <input class="form-check-input" type="checkbox" value="1" name="cancel" id="cancelorderControl">
                                                <label class="" for="cancelorderControl">
                                                    Yes
                                                </label>
                                            </div>
                                            
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-sm-12 col-sm-offset-3">
                                            <div class="btn-toolbar">
                                                @csrf
                                                <input type="hidden" id="product_id" value="{{$r->id}}">
                                                <button class="btn-primary btn" type="submit">Update</button> &nbsp;
                                                <a class="btn btn-primary waves-effect waves-light w-sm" download="" href="{{ asset('invoice/invoice_order_') }}{{ $r->id }}.pdf">Download Order as PDF</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="panel panel-info">
                                <div class="panel-body">
                                    <h4 class="display-8 mb-4">Billing Address</h4>
                                    <hr class=" mb-4" />
                                    <div class="row">
                                        <label class="col-sm-3">Name:</label>
                                        <div class="col-sm-8">
                                            {{$r->user->name}}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-sm-3">Address:</label>
                                        <div class="col-sm-8">
                                            {{$r->user->company_name}}
                                            <br>
                                            {{$r->user->street}}, {{$r->user->address}}
                                            <br>{{$r->user->city}}, {{$r->user->state}}
                                            <br>{{$r->user->country}} - {{$r->user->postcode}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3">Email:</label>
                                        <div class="col-sm-8">
                                            {{$r->user->email}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3">Phone:</label>
                                        <div class="col-sm-8">
                                            {{$r->user->phone}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <h4 class="display-8 mb-4">Shipping Address</h4>
                                <hr class=" mb-4" />
                                <div class="row">
                                    <label class="col-sm-3">Name:</label>
                                    <div class="col-sm-8">
                                        {{$r->shipping->ship_name ?? ''}}
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-3">Address:</label>
                                    <div class="col-sm-8">
                                        {{$r->shipping->ship_street}}, {{$r->shipping->ship_address}} <br>
                                        {{$r->shipping->ship_city}}, {{$r->shipping->ship_state}} <br>
                                        {{$r->shipping->ship_country}} - {{$r->shipping->ship_postcode}}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->


</div>

<div class="row">
    <div class="col-xl-12 mx-auto">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <h4 class="display-8">Items</h4>
                                <div class="table-vertical">
                                    <table class="table table-striped">
                                      <thead>
                                        <tr>
                                          <th style="padding-right:100px">Product</th>
                                          <th>Price</th>
                                          <th>Qty</th>
                                          <th>Discount</th>
                                          <th>Tax</th>
                                          <th>Total</th>
                                          <th>Variations</th>
                                          <th>Product Track</th>
                                          <th>Return</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @if(!empty($r->order_details))
                                        @foreach($r->order_details as $ord)
                                            <tr>
                                                <td align="left" data-title="Product"><i><a href="{{route('admin.product.editForm',[get_route_url(),$ord->product_id])}}" target="_blank">{{$ord->product_name}}</a></i></td>
                                                <td data-title="Price">{{number_format($ord->price,2)}}</td>
                                                <td data-title="Qty">{{$ord->qty}}</td>
                                                <td data-title="Discount">{{number_format($ord->discount,2)}}</td>
                                                <td data-title="Tax">{{number_format($ord->tax,2)}} <i>({{$ord->tax_rate}}%)</i></td>
                                                <td data-title="Total">{{number_format($ord->total,2)}} </td>
                                                <td data-title="Variations">
                                                    @if($ord->product_variations!="")
                                                    <button type="button" class="view_variation btn btn-danger" data-id="{{$ord->id}}">Check Variations</button>
                                                    @endif
                                                </td>
                                                
                                                <td data-title="Product Track">
                                                    
                                                </td>
                                                <td data-title="Return">
                                                    @if($ord->return=="1")
                                                        <span class="label label-danger">-Returned</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 mx-auto">
        <div class="card">
            <div class="card-body">
               <div class="row">
                    <div class="col-md-6">

                        <h4 class="display-8 mb-5">Order Tracking</h4>
                        <form class="custom-validation" novalidate autocomplete="off" method="post" action="{{ route('admin.orders.track_order',[get_route_url(),$r->id]) }}"  enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-4">
                                <label class="col-sm-3">Status <code>*</code></label>
                                <div class="col-sm-8">
                                    <select style="width:100%" class="select2" required name="track_type">
                                        <option value="">Choose status</option>
                                        <option value="Processing" >Processing</option>
                                        <option value="Pending Payment">Pending Payment</option>
                                        <option value="On Hold">On Hold</option>
                                        <option value="Cancelled">Cancelled</option>
                                        <option value="Refund">Refund</option>
                                        <option value="Shipped">Shipped</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Failed">Failed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-sm-3">Comment <code>*</code></label>
                                <div class="col-sm-8">
                                    <textarea class="form-control autosize" required name="track_message"></textarea>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <h4 class="display-8 mb-5">Order Tracking  Status</h4>
                                
                                @if(!empty($tracking))
                                <div class="slimscroll activity-scroll">
                                    <div class="activity">
                                        @foreach($tracking as  $value)
                                        <div class="activity-info">
                                            <div class="icon-info-activity">
                                                <i class="mdi {{ order_status_icon($value->track_type) }} bg-soft-success"></i>
                                            </div>
                                            <div class="activity-info-text">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="m-0 w-75">{{ $value->track_type }}</h6>
                                                    <span class="text-muted d-block">{{ date('d M y',strtotime($value->created_at)) }}</span>
                                                </div>
                                                <p class="text-muted mt-3">{{ $value->track_message }}</p>
                                            </div>
                                        </div>
                                        @endforeach 
                                    </div>
                                </div>
                                @else
                                <p>No update available</p>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-sm-12">
    <div class="modal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
              <p>One fine body…</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
@endsection

@section('footerScript')
<script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('assets/pages/jquery.validation.init.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".select2").select2({
            width: '100%'
        });
        $("#Orders").addClass('active');
        $('a[href="#Orders"]').addClass('active');
        $("#orders_manage").addClass('active');
    });
</script>

@endsection
