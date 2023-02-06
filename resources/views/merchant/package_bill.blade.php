@extends('layouts.master')

@section('title') Package Payment @endsection
@section('headerStyle')

@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('title') Packages Payment @endslot
        @slot('item1') Merchant @endslot
        @slot('item2') Dashboard @endslot
    @endcomponent

    <div class="row m-4">
        
        @if(!empty($r))
            @component('components.pricing')
                <?php 
                    $price = currency().number_format($r->regular_price,2);
                    if($r->sale_price != ""){
                        $price = currency().number_format($r->sale_price,2);
                        $price.= ' <del class="text-muted font-10">  '.currency().number_format($r->regular_price,2).'</del>';                
                    }

                    if($r->duration == "30"){
                        $duration = 'Month';
                    }elseif($r->duration == "365"){
                        $duration = 'Year';
                    }
                ?>
                @slot('title') {{$r->name}} @endslot
                @slot('price') {!! $price !!} @endslot
                @slot('per') {{$duration}} @endslot
                @slot('service') {!! $r->service_id !!} @endslot
                @slot('details') {!! $r->details !!} @endslot
                @slot('popular') {{$r->flash}} @endslot
            @endcomponent
        @endif

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Buy Additional Services</h4>                      
                        </div>                          
                    </div>
                </div>
                <div class="card-body">
                    <div class="accordion-body">
                        <div class="row">  
                            <div class="col-md-12 mb-5">
                                @if(!empty($service))
                                    @foreach($service as $s)
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="service_addon custom-control-input" data-id="{{$s->id}}" id="service{{$s->id}}" data-name="{{$s->name}}" data-currency="{!! currency()!!}" value="{{$s->price}}">
                                            <label class="custom-control-label" for="service{{$s->id}}">{{$s->name}} - {!! currency()!!} {{number_format($s->price,2)}}</label>
                                        </div>
                                    @endforeach
                                @endif                                
                            </div>  
                            <button type="button" class="btn btn-primary">Add Service</button> 
                        </div><!--end row-->
                    </div>     
                </div>
            </div>
        </div>
        @if(!empty($r))            
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">                      
                            <h4 class="card-title">Total Invoice  - <strong> {{currency()}} <span id="total_bill"></span> </strong></h4>                      
                        </div>                          
                    </div>
                </div>
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

                    <form method="post" action="{{route('merchant.package_bill_process',$id)}}" >
                        @csrf
                        <div class="table-responsive shopping-cart">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Service</th>                                                                                          
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody class="service_list">
                                    @php
                                    $price = currency().number_format($r->regular_price,2);
                                    $price_raw = $r->regular_price;
                                    if($r->sale_price != ""){
                                        $price = currency().number_format($r->sale_price,2);
                                        $price.= '<del class="text-muted font-10">  '.currency().number_format($r->regular_price,2).'</del>';                
                                        $price_raw = $r->sale_price;
                                    }  
                                    @endphp
                                    <tr class="tr_service_list" data-price = "{{$price_raw}}">
                                        <td>
                                            <p class="d-inline-block align-middle mb-0 product-name">{{$r->name}}</p> 
                                        </td>
                                        <td>
                                        {{$price}}
                                        </td>
                                        
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div> 
                        <div class="row mt-2">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Process Payment</button>        
                            </div>
                        </div>  
                    </form>         
                </div>
            </div>
        </div>
        @endif
       
    </div>
@endsection

@section('footerScript')
<script type="text/javascript">
    $(document).ready(function() {        
        $("#Dashboard").addClass('active');
        $('a[href="#Dashboard"]').addClass('active');
        $("#package").addClass('active');

        total_service();

        $(".service_addon").change(function(){
            var $this = $(this);
            var html ='';
            if($this.is(':checked')){
                html+='<tr id="list_'+$this.attr('id')+'" class="tr_service_list" data-price = "'+$this.val()+'">';
                html+='<td>';
                html+='<p class="d-inline-block align-middle mb-0 product-name">'+$this.attr('data-name')+'</p>';
                html+='</td>';
                html+='<td>';
                html+=$this.attr('data-currency')+$this.val();
                html+='</td>';
                html+='<input type="hidden" name="service_list[]" value="'+$this.attr('data-id')+'">';
                html+='</tr>';
                $(".service_list").append(html);
                total_service();
            }else{
                $("#list_"+$this.attr('id')).remove();
                total_service();
            }
        })
       
        function total_service(){
            var price = 0;
            $.each($(".tr_service_list"),function(){
                 price = Math.round( parseFloat(price) + parseFloat($(this).attr('data-price')) );

            })
            $("#total_bill").text(price)
        }
    });
</script>
@endsection
