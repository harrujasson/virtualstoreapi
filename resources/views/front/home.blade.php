@extends('layouts.front')
@section('title') Home @endsection
@section('css')
<!-- slick slider -->
<link rel="stylesheet" href="{{asset('assets/front/css/slick/slick-theme.css')}}">
<link rel="stylesheet" href="{{asset('assets/front/css/slick/slick.css')}}">
@endsection
@section('content')
<section>
    <div class=" banner-wrapper home-banner-height">
        <div class="banner-wrapper-height">
            <div class="banner-wrapper-image">
                <img src="{{asset('assets/front/images/home-banner.jpg')}}" alt="" srcset="">
            </div>
        </div>
    </div>
</section>

<!-- featured-product-wrapper start -->
<section>
    <div class="featured-product-wrapper section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrapper">
                        <h3 class="title-main">Featured offers</h3>
                    </div>
                </div>
            </div>
            <div class="featured-item-slider">
                <!-- item-1 -->
                <div class="featured-item common-slide-padding ">
                    <a href="#">

                        <div class="common-slide-box">
                            <div class="common-box-head">
                                <div class="image">
                                    <img src="{{asset('assets/front/images/deal__img.png')}}" alt="">
                                </div>
                            </div>
                            <div class="common-box-content">
                                <h5 class="title">5% Discount for members</h5>
                                <p class="subtitle">Applies to members only</p>
                                <p class="cost mb-0"><span>Cost:</span> <strong>25 Loyalty Points</strong> </p>
                            </div>

                            <div class="common-box-actions">
                                <div class="common-actions">
                                    <i class="fa-regular fa-heart"></i>
                                </div>
                                <div class="common-actions">
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                </div>
                            </div>

                        </div>

                    </a>
                </div>
                <!-- end -->
                <!-- item-1 -->
                <div class="featured-item common-slide-padding ">
                    <a href="#">

                        <div class="common-slide-box">
                            <div class="common-box-head">
                                <div class="image">
                                    <img src="{{asset('assets/front/images/deal__img.png')}}" alt="">
                                </div>
                            </div>
                            <div class="common-box-content">
                                <h5 class="title">5% Discount for members</h5>
                                <p class="subtitle">Applies to members only</p>
                                <p class="cost mb-0"><span>Cost:</span> <strong>25 Loyalty Points</strong> </p>
                            </div>

                            <div class="common-box-actions">
                                <div class="common-actions">
                                    <i class="fa-regular fa-heart"></i>
                                </div>
                                <div class="common-actions">
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                </div>
                            </div>

                        </div>

                    </a>
                </div>
                <!-- end -->
                <!-- item-1 -->
                <div class="featured-item common-slide-padding ">
                    <a href="#">

                        <div class="common-slide-box">
                            <div class="common-box-head">
                                <div class="image">
                                    <img src="{{asset('assets/front/images/deal__img.png')}}" alt="">
                                </div>
                            </div>
                            <div class="common-box-content">
                                <h5 class="title">5% Discount for members</h5>
                                <p class="subtitle">Applies to members only</p>
                                <p class="cost mb-0"><span>Cost:</span> <strong>25 Loyalty Points</strong> </p>
                            </div>

                            <div class="common-box-actions">
                                <div class="common-actions">
                                    <i class="fa-regular fa-heart"></i>
                                </div>
                                <div class="common-actions">
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                </div>
                            </div>

                        </div>

                    </a>
                </div>
                <!-- end -->
                <!-- item-1 -->
                <div class="featured-item common-slide-padding ">
                    <a href="#">

                        <div class="common-slide-box">
                            <div class="common-box-head">
                                <div class="image">
                                    <img src="{{asset('assets/front/images/deal__img.png')}}" alt="">
                                </div>
                            </div>
                            <div class="common-box-content">
                                <h5 class="title">5% Discount for members</h5>
                                <p class="subtitle">Applies to members only</p>
                                <p class="cost mb-0"><span>Cost:</span> <strong>25 Loyalty Points</strong> </p>
                            </div>

                            <div class="common-box-actions">
                                <div class="common-actions">
                                    <i class="fa-regular fa-heart"></i>
                                </div>
                                <div class="common-actions">
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                </div>
                            </div>

                        </div>

                    </a>
                </div>
                <!-- end -->
            </div>
        </div>
    </div>
</section>
<!-- featured-product-wrapper end -->

<!-- filter-tab-wrappr start -->
<section>
    <div class="section-padding filter-tab-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="tablist-content">
                    
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            <li class="nav-item active">
                                <a class="nav-link " data-toggle="tab" href="#Shop" role="tab">Shop now</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#Discounts" role="tab">Discounts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#Redemption" role="tab">Redemption</a>
                            </li>
                        </ul>
                   
            

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="Shop" role="tabpanel">
                                <div class="btns d-flex justify-content-center mb-4">
                                    <button type="button" data-menu="all" class ="filter-item-button all">All</button>
                                    <button type="button" data-menu="men" class ="filter-item-button men">Men</button>
                                    <button type="button" data-menu="women" class ="filter-item-button women">Women</button>
                                    <button type="button" data-menu="new-arrival" class ="filter-item-button new-arrival">New Arrivals</button>
        
                                </div>
                                <div class="allwrps">
                                    <div data-menu="a" class="single" >
                                            <div class="item-box-wrapper" >
                                                <div class="item-box-container">
                                                    <div class="row justify-content-center  " >
                                                        @if(!empty($feature))
                                                        @foreach($feature as $product)
                                                        @include('front.product.loop', ['product' => $product,'container'=>'col-12
                                                        mb-lg-0 mb-4 col-md-6 col-lg-3'])

                                                        @endforeach
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                    </div>
                                    
                                </div>
                                <!-- <div class="filter-tab-flex "> -->
                                                <!-- <div class="filter-items-slider btns"> -->
                                                    <!-- item-1 -->
                                                    <!-- <div class="filter-item">
                                                        <div class="filter-item-button ">
                                                            <button class="btn" type="button" data-menu="all">All</button>
                                                        </div>
                                                    </div> -->
                                                    <!-- end -->

                                                    <!-- item-2 -->
                                                    <!-- <div class="filter-item">
                                                        <div class="filter-item-button">
                                                            <button class="btn" type="button" data-menu="new">New arrivals</button>
                                                        </div>
                                                    </div> -->
                                                    <!-- end -->

                                                    <!-- item-3 -->
                                                    <!-- <div class="filter-item">
                                                        <div class="filter-item-button">
                                                            <button class="btn" type="button" data-menu="men">Men</button>
                                                        </div>
                                                    </div> -->
                                                    <!-- end -->

                                                    <!-- item-4 -->
                                                    <!-- <div class="filter-item">
                                                        <div class="filter-item-button">
                                                            <button class="btn" type="button" data-menu="women">Women</button>
                                                        </div>
                                                    </div> -->
                                                    <!-- end -->
                                                <!-- </div> -->
                                        
                                            <!-- <div class="item-box-wrapper" >
                                                <div class="item-box-container">
                                                    <div class="row " data-menu="men" class="single">
                                                        @if(!empty($feature))
                                                        @foreach($feature as $product)
                                                        @include('front.product.loop', ['product' => $product,'container'=>'col-12
                                                        mb-lg-0 mb-4 col-md-6 col-lg-3'])

                                                        @endforeach
                                                        @endif
                                                    </div>

                                                </div>
                                            </div> -->
                                <!-- </div> -->
                            </div>
                            <div class="tab-pane" id="Discounts" role="tabpanel">
                            <div class="btns d-flex justify-content-center mb-4">
                                    <button type="button" data-menu="all" class ="filter-item-button all">All</button>
                                    <button type="button" data-menu="men" class ="filter-item-button men">Men</button>
                                    <button type="button" data-menu="women" class ="filter-item-button women">Women</button>
                                    <button type="button" data-menu="new-arrival" class ="filter-item-button new-arrival">New Arrivals</button>
        
                                </div>
                                <div class="allwrps">
                                    <div data-menu="a" class="single" >
                                            <div class="item-box-wrapper" >
                                                <div class="item-box-container">
                                                    <div class="row justify-content-center">
                                                        @if(!empty($feature))
                                                        @foreach($feature as $product)
                                                        @include('front.product.loop', ['product' => $product,'container'=>'col-12 mb-lg-0 mb-4 col-md-6 col-lg-3'])
                                                        @endforeach
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <div class="tab-pane" id="Redemption" role="tabpanel">
                                <div class="coupon-wrapper">
                                                <div class="row">
                                                    <!-- item-1 -->
                                                    <div class="col-md-6 col-12">
                                                        <div class="coupon-item d-flex  align-items-center pt-2 pb-2">
                                                            <div class="coupon-head">
                                                                <div class="coupon-logo">
                                                                    <div class="image">
                                                                        <img src="{{asset('assets/front/images/Gong Cha 1.png')}}"
                                                                            alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="coupon-content">
                                                                <p class="title mb-1">Self Pick-up - 20% off your order</p>
                                                                <p class="desp mb-0">Select ‘self pick-up’ as your order type to
                                                                    enjoy 20% off your order</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end -->

                                                    <!-- item-2 -->
                                                    <div class="col-md-6 col-12">
                                                        <div class="coupon-item d-flex  align-items-center pt-2 pb-2">
                                                            <div class="coupon-head">
                                                                <div class="coupon-logo">
                                                                    <div class="image">
                                                                        <img src="{{asset('assets/front/images/imagine.png')}}" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="coupon-content">
                                                                <p class="title mb-1">Free 500MB data</p>
                                                                <p class="desp mb-0">Spend $100 in a single receipt to enjoy this
                                                                    offer</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end -->

                                                    <!-- item-3 -->
                                                    <div class="col-md-6 col-12">
                                                        <div class="coupon-item d-flex  align-items-center pt-2 pb-2 claimed-coupon">
                                                            <div class="coupon-head">
                                                                <div class="coupon-logo">
                                                                    <div class="image">
                                                                        <img src="{{asset('assets/front/images/imagine.png')}}" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="coupon-content">
                                                                <p class="title mb-1">10% off total receipt</p>
                                                                <p class="desp mb-0">Already claimed on 27.07.2022</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end -->
                                                </div>
                                    </div>
                            </div>
                            
                        
                        </div>
                    </div>
                </div>
            </div>


           
        </div>

    </div>
    </div>
</section>
<!-- filter-tab-wrappr end -->

@endsection
@section('script')
<!-- slider_script -->
<script src="{{asset('assets/front/css/slick/slick.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.banner_slider ').slick({
            arrows: false,
            dots: true
        });
    });
    $(function () {
        $('.featured-item-slider').slick({
            dots: true,
            arrows: true,
            infinite: true,
            slidesToScroll: 3,
            slidesToShow: 3,
            accessibility: true,
            variableWidth: true,
            focusOnSelect: false,
            centerMode: false,
            responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToScroll: 2,
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToScroll: 1,
                        slidesToShow: 1
                    }
                }
            ]
        });
    });

    // tabs-filter
    
    $( ".all" ).click(
  function() {
    $('.btns').toggleClass('btn-all');
  
  });
  $( ".men" ).click(
  function() {
    $('.btns').toggleClass('btn-men');
   
  
  });
  $( ".women" ).click(
  function() {
    $('.btns').toggleClass('btn-women');
  
  });
  $( ".new-arrival" ).click(
  function() {
    $('.btns').toggleClass('btn-new-arrival');
  
  });




    function Filtering() {
            let buttons = document.querySelectorAll('.btns button')
            let blocks  = document.querySelectorAll('.single')
            buttons.forEach(button => {
                button.addEventListener('click', (e) => {
                    blocks.forEach(block => {
                        block.classList.remove('active')
                        block.style.transform = `scale(0)`;
                        block.style.opacity = `0`;
                        block.style.visibility = `hidden`; 
                        block.style.width = `0`;
                        block.style.marginLeft = `0`;
                        block.style.marginRight = `0`;
                        block.style.height = `0`;
                    })

                    blocks.forEach(blk => {
                        if (e.target.dataset.menu == blk.dataset.menu) {
                            blk.classList.add('active')
                            blk.style.transform = `scale(1)`;
                            blk.style.opacity = `1`;
                            blk.style.visibility = `visible`; 
                            blk.style.width = `100%`;
                            blk.style.marginLeft = `5px`;
                            blk.style.marginRight = `5px`;
                            blk.style.height = `100%`;
                        }
                    })
                if (e.target.dataset.menu == 'all'){
                    blocks.forEach(block => {
                        block.classList.add('active')
                            block.style.transform = `scale(1)`;
                            block.style.opacity = `1`;
                            block.style.visibility = `visible`; 
                            block.style.width = `100%`;
                            block.style.marginLeft = `5px`;
                            block.style.marginRight = `5px`;
                            block.style.height = `100%`;
                    })
                }


                })
            })
        }
        Filtering()

</script>
@endsection