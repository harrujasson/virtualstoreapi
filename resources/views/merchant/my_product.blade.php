@extends('layouts.master')

@section('title') Package Payment @endsection
@section('headerStyle')

@endsection
@section('content')
<div class="container-fluid">


@component('components.breadcrumb')
    @slot('title') My Products @endslot
    @slot('item1') Merchant @endslot
    @slot('item2') Dashboard @endslot
@endcomponent


    <div class="row m-4">
        
        @if(!empty($package))
        <div class="col-lg-6">
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-3 align-self-center text-center">
                        <img class="" height="80" src="{{URL::asset('assets/images/small/btc.png')}}" alt="Card image">
                        
                    </div>
                    <div class="col-md-9">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">                      
                                    <h4 class="card-title">{{package_info($package->service_id,'name')}}</h4>               
                                </div><!--end col-->  
                                <div class="col-auto">    
                                    @if(Auth::user()->picture!="")
                                    <img src="{{ asset('uploads/profile/'.Auth::user()->picture) }}"  class="rounded-circle" height="24">
                                    
                                    @else
                                    <img src="{{ URL::asset('assets/images/users/user-4.jpg')}}"  class="rounded-circle" height="24" /> 
                                    @endif
                                               
                                </div><!--end col-->                                                                            
                            </div>  <!--end row-->                                  
                        </div><!--end card-header-->
                        <div class="card-body">
                            <div class="card-text">
                                @php  $service = package_info($package->service_id,'service_id') @endphp
                                @if($service!="")
                                <ul class="list-unstyled pricing-content-2 text-left py-3 border-0 mb-0">
                                    @foreach(explode(',',$service) as $ser)
                                        <li class="mb-1"><i class="la la-check text-success me-2"></i> {{service_info($ser)}}</li>
                                    @endforeach
                                </ul>
                                @endif
                                {!! package_info($package->service_id,'details') !!}
                            </div>
                            <p class="card-text"><small class="text-muted">Purchased at <strong>{{date('d-m-Y',strtotime($package->created_at))}}</strong> valid for <strong>{{$package->duration}}</strong> days</small></p>
                        </div><!--end card-body-->
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end card-->
        </div>
        @else
        <div class="col-lg-6">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="card-body border">
                        <p class="card-text">Yet no package purchased</p>
                        <a href="{{route('merchant.package')}}" class="btn btn-primary">Buy Now</a>
                    </div>
                </div>
            </div>            
        </div>
        @endif

        
        <div class="col-lg-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="card-title">Purchased Services</h4>
                    <p class="text-muted mb-0">Additional services runing</p>
                </div><!--end card-header-->
                <div class="card-body">  
                    <div class="row">
                        <div class="col-lg-12">
                            @if(!empty($service_in))
                            <ul class="list-group">
                                @foreach($service_in as $in)
                                    <li class="list-group-item"><i class="la la-check text-success me-2 mr-2"></i>{{service_info($in->service_id)}}</li>
                                    
                                @endforeach
                            </ul>
                        @else
                        <p>No service available</p>    
                        @endif
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->
            </div>
        </div>
       

        
    </div>


@endsection
</div>
@section('footerScript')    
<script type="text/javascript">
    $(document).ready(function() {        
        $("#Dashboard").addClass('active');
        $('a[href="#Dashboard"]').addClass('active');
        $("#my_product").addClass('active');
    });
</script>
@endsection