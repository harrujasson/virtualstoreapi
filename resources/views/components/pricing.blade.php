 <div class="col-lg-3">
    <div class="card">
        <div class="card-body">
            @if($popular!="")
                <span class="badge badge-pink a-animate-blink mt-0">{{$popular}}</span>
                    
            @endif
            @if(isset($package_active))
                @if($package_active == "1")
                    <span class="badge badge-success a-animate-blink mt-0">Active</span>
                @endif
            @endif
            <div class="pricingTable1 text-center">

                
                <h6 class="title1 py-3 m-0">{{$title}}</h6>
                <p class="text-muted p-3 mb-0">It is a long established fact that a reader will be distracted by the readable.</p>
                <div class="p-3 m-2">  
                    <h3 class="amount amount-border d-inline-block">{{$price}}</h3>
                    <small class="font-12 text-muted">/{{$per}}</small>
                </div>
                <hr class="hr-dashed">
                @if($service!="")
                <ul class="list-unstyled pricing-content-2 text-left py-3 border-0 mb-0">
                    @foreach(explode(',',$service) as $ser)
                        <li>{{service_info($ser)}}</li>
                    @endforeach
                </ul>
                @endif
                {!! $details !!}
                @if(isset($id))
                    @if(isset($package_active))
                        @if($package_active == "1")
                        <a href="javascript:void(0);" class="btn btn-dark py-2 px-5 font-16"><span>Active</span></a>
                        @else
                        <a href="{{route('merchant.package_bill',encode($id))}}" class="btn btn-dark py-2 px-5 font-16"><span>Buy Again</span></a>
                        @endif
                    @else
                    <a href="{{route('merchant.package_bill',encode($id))}}" class="btn btn-dark py-2 px-5 font-16"><span>Buy Now</span></a>
                    @endif
                @endif   
            </div><!--end pricingTable-->
        </div><!--end card-body-->
    </div> <!--end card-->                                   
</div><!--end col-->