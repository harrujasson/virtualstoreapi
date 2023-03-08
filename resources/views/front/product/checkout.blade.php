@extends('layouts.front')

@section('title') Checkout @endsection
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

<div class="main-content-wrap section-ptb checkout-page section-padding">
    <div class="container">
        <div class="row d-none">
            <div class="col ">
                @include('widget/notifications')
                <div class="coupon-area">

                    @if(Auth::check() == false)
                    <!-- coupon-accordion start -->
                    <div class="coupon-accordion">
                        <h3>Returning customer? <span class="coupon" id="showlogin">Click here to login</span></h3>
                        <div class="coupon-content" id="checkout-login" style="display:none;">
                            <div class="coupon-info">
                                <p>If you have shopped with us before, please enter your details in the boxes below. If
                                    you are a new customer, please proceed to the Billing &amp; Shipping section.</p>
                                <form action="#" method="post" class="form-parsley" novalidate>
                                    @csrf
                                    <p class="coupon-input form-row-first {{ $errors->first('email', 'has-error') }}">
                                        <label>Email <span class="required">*</span></label>
                                        <input type="text" name="email" value="{{old('email')}}">
                                        <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                                    </p>
                                    <p class="coupon-input form-row-last {{ $errors->first('password', 'has-error') }}">
                                        <label>Password <span class="required">*</span></label>
                                        <input type="password" name="password">
                                        <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                                    </p>
                                    <div class="clear"></div>
                                    <p>
                                        <button type="submit" class="button-login btn" name="login"
                                            value="Login">Login</button>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- coupon-accordion end -->
                </div>
            </div>
        </div>
        <form class="form-parsley" novalidate method="post" action="{{ route('order_submit',[get_route_url()]) }}"
            enctype="multipart/form-data">

            @csrf
            <!-- checkout-details-wrapper start -->
            <div class="checkout-details-wrapper">
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-lg-0 mb-4 ">
                        <!-- billing-details-wrap start -->
                        <div class="billing-details-wrap">

                            <h3 class="shoping-checkboxt-title">Billing Details</h3>
                            <div class="row">
                                @if(Auth::check() == false)
                                <div class="col-lg-12 {{ $errors->first('name', 'has-error') }}">
                                    <div class="form-group">
                                        <p class="single-form-row">
                                            <label>Full Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="name" value="{{old('name')}}">
                                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-6 {{ $errors->first('email', 'has-error') }}">
                                    <div class="form-group">
                                        <p class="single-form-row">
                                            <label>Email <span class="required">*</span></label>
                                            <input type="text" name="email" class="form-control"
                                                value="{{old('email')}}">
                                            <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6 {{ $errors->first('password', 'has-error') }}">
                                    <div class="form-group">
                                        <p class="single-form-row">
                                            <label>Password <span class="required">*</span></label>
                                            <input type="password" name="password" class="form-control">
                                            <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <p class="single-form-row">
                                            <label>Company name</label>
                                            <input type="text" name="company" value="{{old('company')}}"
                                                class="form-control">
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-12 {{ $errors->first('street', 'has-error') }}">
                                    <div class="form-group">
                                        <p class="single-form-row">
                                            <label>Street address <span class="required">*</span></label>
                                            <input type="text" placeholder="House number and street name" name="street"
                                                value="{{old('street')}}" class="form-control">
                                            <span class="help-block">{{ $errors->first('street', ':message') }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <p class="single-form-row">
                                            <input type="text" placeholder="Apartment, suite, unit etc. (optional)"
                                                name="address" value="{{old('address')}}" class="form-control">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-12 {{ $errors->first('city', 'has-error') }}">
                                    <div class="form-group">
                                        <p class="single-form-row">
                                            <label>Town / City <span class="required">*</span></label>
                                            <input type="text" name="city" value="{{old('city')}}" class="form-control">
                                            <span class="help-block">{{ $errors->first('city', ':message') }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <p class="single-form-row">
                                            <label>State</label>
                                            <input type="text" name="state" value="{{old('state')}}"
                                                class="form-control">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <p class="single-form-row">
                                            <label>County</label>
                                            <input type="text" name="country" value="{{old('country')}}"
                                                class="form-control">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-12 {{ $errors->first('postcode', 'has-error') }}">
                                    <div class="form-group">
                                        <p class="single-form-row">
                                            <label>Postcode / ZIP <span class="required">*</span></label>
                                            <input type="text" name="postcode" value="{{old('postcode')}}"
                                                class="form-control">
                                            <span class="help-block">{{ $errors->first('postcode', ':message') }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-12 {{ $errors->first('phone', 'has-error') }}">
                                    <div class="form-group">
                                        <p class="single-form-row">
                                            <label>Phone <span class="required">*</span></label>
                                            <input type="text" name="phone" value="{{old('phone')}}"
                                                class="form-control">
                                            <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                                        </p>
                                    </div>
                                </div>
                                @else

                                <div class="col-lg-12 m-b-40">
                                    <p>{{Auth::user()->name}}</p>
                                    {{Auth::user()->street}}, {{Auth::user()->address}}, <br>
                                    {{Auth::user()->city}}, {{Auth::user()->state}}, {{Auth::user()->country}} -
                                    {{Auth::user()->postcode}} <br>
                                    Phone: {{Auth::user()->phone}} </p>
                                    <br>
                                </div>


                                @endif

                                <div class="col-lg-12">
                                    <div class="checkout-box-wrap">
                                        @php $ship = old('ship') @endphp
                                        <label id="chekout-box-2"><input type="checkbox" name="ship" id="ship" value="1"
                                                {{($ship =="1" ? "checked":"" )}}> Ship to a different address?</label>
                                        <div class="ship-box-info">
                                            <div class="row">
                                                <div class="col-lg-12 {{ $errors->first('ship_name', 'has-error') }}">
                                                    <div class="form-group">
                                                        <p class="single-form-row">
                                                            <label>First name <span class="required">*</span></label>
                                                            <input type="text" name="ship_name"
                                                                value="{{old('ship_name')}}" class="form-control">
                                                            <span
                                                                class="help-block">{{ $errors->first('ship_name', ':message') }}</span>
                                                        </p>
                                                    </div>
                                                </div>


                                                <div class="col-lg-12 {{ $errors->first('ship_street', 'has-error') }}">
                                                    <div class="form-group">
                                                        <p class="single-form-row">
                                                            <label>Street address <span
                                                                    class="required">*</span></label>
                                                            <input type="text"
                                                                placeholder="House number and street name"
                                                                name="ship_street" value="{{old('ship_street')}}"
                                                                class="form-control">
                                                            <span
                                                                class="help-block">{{ $errors->first('ship_street', ':message') }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <p class="single-form-row">
                                                            <input type="text"
                                                                placeholder="Apartment, suite, unit etc. (optional)"
                                                                name="ship_address" value="{{old('ship_address')}}"
                                                                class="form-control">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 {{ $errors->first('ship_city', 'has-error') }}">
                                                    <div class="form-group">
                                                        <p class="single-form-row">
                                                            <label>Town / City <span class="required">*</span></label>
                                                            <input type="text" name="ship_city"
                                                                value="{{old('ship_city')}}" class="form-control">
                                                            <span
                                                                class="help-block">{{ $errors->first('ship_city', ':message') }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <p class="single-form-row">
                                                            <label>State</label>
                                                            <input type="text" name="ship_state"
                                                                value="{{old('ship_state')}}" class="form-control">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <p class="single-form-row">
                                                            <label>County</label>
                                                            <input type="text" name="ship_country"
                                                                value="{{old('ship_country')}}" class="form-control">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-lg-12 {{ $errors->first('ship_postcode', 'has-error') }}">
                                                    <div class="form-group">
                                                        <p class="single-form-row">
                                                            <label>Postcode / ZIP <span
                                                                    class="required">*</span></label>
                                                            <input type="text" name="ship_postcode"
                                                                value="{{old('ship_postcode')}}" class="form-control">
                                                            <span
                                                                class="help-block">{{ $errors->first('ship_postcode', ':message') }}</span>
                                                        </p>
                                                        </ediv>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-note-wrapper">
                                        <div class="form-group">
                                            <p class="single-form-row m-0">
                                                <label>Order notes</label>
                                                <textarea
                                                    placeholder="Notes about your order, e.g. special notes for delivery."
                                                    class="checkout-mess form-control" name="order_note" rows="2"
                                                    cols="5">{{old('order_note')}}
                                                </textarea>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- billing-details-wrap end -->
                        </div>

                    </div>

                    <div class="col-lg-6 col-md-12  ">
                        <h3 class="shoping-checkboxt-title">Your Order</h3>
                        <!-- your-order-wrapper start -->
                        <div class="your-order-wrapper">

                            <!-- your-order-wrap start-->
                            <div class="your-order-wrap">
                                <!-- your-order-table start -->
                                <div class="your-order-table table-responsive">
                                    <table class="w-100">
                                        <thead>
                                            <tr>
                                                <th class="product-name">Product</th>
                                                <th class="product-total">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($product))
                                            @php $tax_total = 0; @endphp
                                            @foreach($product as $p)
                                            @php $tax =0; @endphp



                                            <tr class="cart_item">
                                                <td class="product-name">
                                                    {{$p->name}} <strong class="product-quantity d-block w-100 mt-1">
                                                        QTY:<span> {{$p->qty}}</span></strong>
                                                </td>
                                                <td class="product-total">
                                                    @if($p->options->tax) @php $tax = $p->options->tax * $p->qty;
                                                    $tax_total+= $tax; @endphp @endif
                                                    <span class="amount">{!! currency()
                                                        !!}{{number_format(($p->price * $p->qty) + $tax ,2)}}
                                                        (Incl:Tax)</span>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>

                                        <tfoot>
                                            <tr class="cart-subtotal">
                                                <th>Cart Subtotal</th>
                                                <td><span class="amount">{!! currency()
                                                        !!}{{number_format(\Cart::subtotal(),2)}}</span></td>
                                            </tr>
                                            <tr class="cart-subtotal">
                                                <th>Tax Total</th>
                                                <td><span class="amount">{!! currency()
                                                        !!}{{number_format($tax_total,2)}}</span></td>
                                            </tr>

                                            <tr class="cart-subtotal">
                                                <th>Deliver Charge</th>
                                                <td><span class="amount">{!! currency()
                                                        !!}{{deliver_charge()}}</span></td>
                                            </tr>


                                            <tr class="order-total">
                                                <th>Order Total</th>
                                                <td><strong><span class="amount">{!! currency()
                                                            !!}{{number_format(\Cart::subtotal() +$tax_total +deliver_charge() ,2)}}</span></strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- your-order-table end -->

                                <!-- your-order-wrap end -->
                                <div class="payment-method">
                                    <div class="payment-accordion mb-4 mt-md-0 mt-4">
                                        <label class="radio-inline bank_trasfer  mr-4">
                                            <input type="radio" name="paymenttype" value="credit">
                                            <span>Credit Points</span>
                                        </label>
                                        <label class="radio-inline bank_trasfer ">
                                            <input type="radio" name="paymenttype" value="online" checked="">
                                            <span>Online</span>
                                        </label>
                                    </div>

                                    <div class="order-button-payment">
                                        <button type="submit" class="btn btn-success "> Place Order </button>
                                    </div>
                                </div>
                                <!-- your-order-wrapper start -->

                            </div>
                        </div>
                    </div>
                </div>
                <!-- checkout-details-wrapper end -->
        </form>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('assets/pages/jquery.validation.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $(function () {
            $(this).shipaddress();
        });

        $("#ship").change(function () {
            $(this).shipaddress();
        });

        $("#showlogin").click(function () {
            $("#checkout-login").toggle();
        })

        $.fn.shipaddress = function () {
            if ($("#ship").is(":checked")) {
                $(".ship-box-info").show();
                $('.ship-box-info :input').prop('disabled', false);
            } else {
                $(".ship-box-info").hide();
                $('.ship-box-info :input').prop('disabled', true);
            }
        }
    });
</script>
@endsection