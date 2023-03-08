@extends('layouts.front')

@section('title') Cart @endsection
@section('css')
@endsection
@section('content')

<!-- <section>
    <div class=" banner-wrapper home-banner">
        <div class="banner-wrapper-height">
            <div class="banner-wrapper-image">
                <img src="{{asset('assets/front/images/cart-bg.jpg')}}" alt="Banner">
            </div>
        </div>
    </div>
</section> -->

<section>
    <div class="cart-wrapper section-padding">
        <div class="container">
            <div class="row">
                @if($product_count)
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="title-wrapper d-flex justify-content-between">
                        <h3 class="title-main">My Shopping Cart({{Cart::count()}} item)</h3>
                        <p class="total-ammount mb-0">Total: {!! currency() !!} {{ \Cart::subtotal()}}</p>
                    </div>
                    <div class="shoping-cart-box">
                        @include('widget/notifications')
                        <form action="{{route('cart_update',[get_route_url()])}}" method="post" class="cart-table">
                            @csrf
                            @if(!empty($product))
                            @php $tax_total = 0; @endphp
                            @foreach($product as $p)
                            @php
                            $tax =0;
                            $picture = $call_back->get_product_info($p->id,'feature_picture');

                            $slug = $call_back->get_product_info($p->id,'slug');
                            $amount = $p->price;
                            @endphp

                            <div class="shopping-cart-item d-flex align-items-center flex-md-nowrap flex-wrap">

                                <div class="shop-cart-head text-center   pb-md-0 pb-4 mb-md-0 mb-4">
                                    @if($picture!="")
                                    <a href="{{route('product_show',[get_route_url(),$slug])}}">
                                        <div class="image">
                                            <img src="{{asset('uploads/product/'.$picture)}}" alt="{{$p->name}}">

                                        </div>
                                    </a>
                                    @endif
                                </div>

                                <div class="shop-cart-desp w-100">
                                    <div class="shop-cart-desp-head d-flex justify-content-between mb-3">
                                        <p class="cart-title mb-0"> <a target="_blank"
                                                href="{{route('product_show',[get_route_url(),$slug])}}">{{$p->name}}</a></p>
                                        <div class="shop-cart-price">
                                            <span class="actual-price">{!! currency()
                                                !!}{{number_format($p->price,2)}}</span>

                                        </div>

                                    </div>

                                    <div class="size-box d-flex justify-content-between align-items-center mb-3">
                                        <span class="size-field">S</span>
                                        <!--QTY-->
                                        <div class="num-block d-flex justify-content-between align-items-center">

                                            <div class="qtybutton-box">
                                                <span class="minus dis">
                                                    <i class="fa-solid fa-minus"></i>
                                                </span>
                                            </div>

                                            <div class="qty-counter">
                                                <input type="text" class="in-num form-control" name="qty[]"
                                                    value="{{$p->qty}}" readonly="">
                                            </div>

                                            <input type="hidden" name="id[]" value="{{$p->rowId}}">
                                            <div class="qtybutton-box">
                                                <span class="plus">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <!--END QTY-->

                                        <span class="colour-field">Navy Blue</span>



                                    </div>


                                    <div class="place-order ">
                                        <a href="{{route('cart_list_remove',[get_route_url(),$p->rowId])}}"
                                            class="btn  remove-item bg-secondary text-white">Remove</a>
                                        <button class="btn  update-item">Place Order</button>
                                    </div>
                                </div>



                            </div>
                            @endforeach
                            <input class="submit btn ml-auto d-block" value="Update cart" type="submit">
                            @endif
                        </form>
                    </div>
                </div>

                <div class="col-lg-4   pb-md-0 pb-4">
                    <div class="title-wrapper d-flex justify-content-between">
                        <h3 class="title-main">Price Details</h3>
                    </div>
                    @php $subtotal = floatval(preg_replace("/[^-0-9\.]/","",\Cart::subtotal())); @endphp
                    <div class="cart-payment-wrapper ">
                        <ul>
                            <li><span class="price">Total MRP</span> <span>{!! currency()
                                    !!}{{number_format(\Cart::subtotal(),2)}}</span></li>
                            <li><span class="Tax">Tax</span> <span>{!! currency()
                                    !!}{{number_format($tax_total,2)}}</span></li>
                            <li><span class="Delivery charges">Delivery charges</span> <span
                                    class="text-success">{{deliver_charge()}}</span></li>
                        </ul>
                        <div class="place-order text-center checkout-btn">
                            <p class="total d-flex justify-content-between mt-4">Total <span>{!! currency()
                                    !!}{{number_format(\Cart::subtotal() +$tax_total + deliver_charge() ,2)}}</span></p>
                            <a href="{{route('checkout',[get_route_url()])}}" class="btn mt-4">Checkout</a>
                        </div>
                    </div>


                </div>
                @else
                <div class="col-12">
                    <div class="empty-cart-wrapper">
                        <!-- <h3>Empty Cart</h3> -->

                        <div class="empty-cart-flex text-center">
                            <div class="image">

                                <img src='{{asset("assets/front/images/Online-shopping.svg")}}'>



                            </div>
                            <a href="{{route('shop',[get_route_url()])}}" class="btn btn-success mt-4">Continue Shop</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
</section>
<!-- cart-wrapper end -->

@endsection
@section('script')
<script type='text/javascript' src='{{asset("assets/front/js/product_details.js")}}'></script>
@endsection