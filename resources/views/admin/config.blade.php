@extends('layouts.master')

@section('title') {{$title}} @endsection
@section('headerStyle')  
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('title') Update @endslot
        @slot('item1') Admin @endslot
        @slot('item2') {{$title}} @endslot
    @endcomponent



<div class="row">
    <div class="col-lg-8 col-md-12 mx-auto">

        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
 
            @include('widget/notifications')

                <form class="needs-validation" novalidate method="post" action="{{ route('admin.config_save',[get_route_url()]) }}"  enctype="multipart/form-data">

                @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label>Store Open <code>*</code></label>
                                <?php $status = $r->status ?? old('status'); ?>
                                <select class="form-control" name="status">
                                    <option value="1" {{($status == 1 ? 'selected' :'')}}>Open</option>
                                    <option value="0" {{($status == 0 ? 'selected' :'')}}>Close</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label>Store Name <code>*</code></label>
                                <input type="text" class="form-control" name="store_name" required value="{{ $r->store_name ?? old('store_name') }}">
                                <span class="text-danger">{{ $errors->first('store_name', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>E-Mail <code>*</code></label>
                                <input type="email" class="form-control" name="email" required value="{{ $r->email ?? old('email') }}">
                                <span class="text-danger">{{ $errors->first('email', ':message') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label  class="form-label">Telephone</label>
                                <input type="text" class="form-control" name="phone" value="{{ $r->phone ?? old('phone') }}"  >
                            </div>
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label>Address <code>*</code></label>
                                <textarea class="form-control" name="address" required >{{ $r->address ?? old('address') }}</textarea>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Logo</label>
                                <input class="form-control" name="logo" type="file" id="formFile">
                            </div>
                        </div> 
                        @if(isset($r->logo))  
                        @if($r->logo!="")
                        <div class="col-md-6">
                            <div class="mb-3">
                                <img class="thumb-xl rounded-circle" src="{{ asset('uploads/profile/'.$r->logo) }}">
                            </div>
                        </div>
                        @endif 
                        @endif
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <h4>Invoice Information</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label>Address <code>*</code></label>
                                <textarea class="form-control" name="invoice_address" required >{{ $r->invoice_address ?? old('invoice_address') }}</textarea>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Logo</label>
                                <input class="form-control" name="invoice_logo" type="file" id="formFile">
                            </div>
                        </div> 
                        @if(isset($r->invoice_logo))  
                        @if($r->invoice_logo!="")
                        <div class="col-md-6">
                            <div class="mb-3">
                                <img class="thumb-xl rounded-circle" src="{{ asset('uploads/profile/'.$r->invoice_logo) }}">
                            </div>
                        </div>
                        @endif 
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <h4>Delivery Information</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Pickup from <code>*</code></label>
                                <input type="time" required class="form-control" name="pickup_from" value="{{ $r->pickup_from ?? old('pickup_from') }}"  >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Pickup to <code>*</code></label>
                                <input type="time" required class="form-control" name="pickup_to" value="{{ $r->pickup_to ?? old('pickup_to') }}"  >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Delivery Charge <code>*</code></label>
                                <input type="text" class="form-control" name="deliver_charge" value="{{ $r->deliver_charge ?? old('deliver_charge') }}"  >
                            </div>
                        </div>
                        
                    </div>

                    <button type="" class="btn btn-primary w-md mb-2">Update</button>
                    
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('footerScript')
<script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('assets/pages/jquery.validation.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        
        $("#Dashboard").addClass('active');
        $('a[href="#Dashboard"]').addClass('active');
        $("#config").addClass('active');
    });
</script>

@endsection
