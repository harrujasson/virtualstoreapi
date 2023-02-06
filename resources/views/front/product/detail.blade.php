@extends('layouts.front')
@section('title') {{ $title}} @endsection
@section('description') {{$description}} @endsection
@section('keywords') {{$keyword}} @endsection
@section('css')

<link rel="stylesheet" href="{{ URL::asset('assets/front/css/zoomove.min.css') }}">
<!-- slick slider -->
<link rel="stylesheet" href="{{asset('assets/front/css/slick/slick-theme.css')}}">
<link rel="stylesheet" href="{{asset('assets/front/css/slick/slick.css')}}">

@endsection
@section('content')
<!-- breadcrumb-area -->
<!-- <div class="breadcrumb-area breadcrumb-style-two"
    data-background="{{asset('assets/front/img/bg/s_breadcrumb_bg01.jpg')}}">

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 d-none d-lg-block">
            </div>
            <div class="col-12 col-sm-12 ">
                <div class="breadcrumb-content">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 d-none d-lg-block">
            </div>
        </div>
    </div>
</div> -->

<!-- breadcrumb-area-end -->
@if(configinfo('status'))
<form method="post" action="{{route('cart_add',$r->slug)}}" class="num-block product_cart_main">
@else
<form method="post" action="#" class="num-block product_cart_main">
@endif
    @csrf
    <!-- shop-details-area -->
    <div class="shop-details-area section-padding {{store_available()}}">
        <div class="container">
            <div class="product-details-share">
                <ul>
                    <li>Share:</li>
                    <li><a href="https://www.facebook.com/sharer/sharer.php?u={{route('home')}}" target="_blank"><i
                                class="fab fa-facebook-f"></i></a></li>
                    <li><a href="https://www.twitter.com/sharer/sharer.php?u={{route('home')}}" target="_blank"><i
                                class="fab fa-twitter"></i></a></li>
                    <li><a href="https://www.pinterest.com/sharer/sharer.php?u={{route('home')}}" target="_blank"><i
                                class="fab fa-pinterest-p"></i></a></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-7 mb-lg-0 mb-4">
                    <div class="shop-details-flex-wrap mb-lg-auto mb-md-0">

                        <div class="shop-details-img-wrap ">
                            <div class="main_product_thumb ">
                                <!--Variations Images Load-->
                                @include('front.product.product_variation_main_images',['video'=>$r->video_url])
                            </div>




                        </div>

                        <ul class="list_product_thumb slider slider-nav">
                            @if($r->feature_picture!="")
                            <li class="list_item-thumb">
                                <a class="thumb_link" data-type="image"
                                    href="{{asset('uploads/product/'.$r->feature_picture)}}"
                                    data-standard="{{asset('uploads/product/'.$r->feature_picture)}}"
                                    data-image="{{asset('uploads/product/'.$r->feature_picture)}}">
                                    <img src="{{asset('uploads/product/'.$r->feature_picture)}}" alt=""
                                        class="thumb_picture">
                                </a>

                            </li>
                            @endif
                            @if($r->video_url!="")
                            <li class="list_item-thumb">
                                <a class="thumb_link" data-type="video" data-src="{{ $r->video_url }}">
                                    <video class="video_thumb">
                                        <source src="{{ $r->video_url }}" type="video/mp4">
                                        <source src="{{ $r->video_url }}" type="video/ogg">
                                        Your browser does not support HTML video.
                                    </video>
                                </a>
                            </li>
                            @endif
                            @if($r->gallery_picture!="")
                            @foreach(json_decode($r->gallery_picture) as $g)
                            <li class="list_item-thumb">
                                <a class="thumb_link" data-type="image" href="{{asset('uploads/product/'.$g)}}"
                                    data-standard="{{asset('uploads/product/'.$g)}}"
                                    data-image="{{asset('uploads/product/'.$g)}}">
                                    <img src="{{asset('uploads/product/'.$g)}}" alt="">
                                </a>
                            </li>
                            @php $pic_cnt++; @endphp
                            @endforeach
                            @endif

                        </ul>




                        <!--mobile slider-->
                        <div class="shop-details-flex-wrap shop_detail_mobile d-none">
                            <div class="Shop_mobile_slider">
                                <div class="slider_item">
                                    <img src="{{asset('uploads/product/'.$r->feature_picture)}}" alt="">
                                </div>
                                @php $pic_thumb_cnt=0;@endphp
                                @if($r->gallery_picture!="")
                                @foreach(json_decode($r->gallery_picture) as $g)
                                <div class="slider_item d-none">
                                    <img src="{{asset('uploads/product/'.$g)}}" alt="">
                                </div>
                                @php $pic_thumb_cnt++; @endphp
                                @endforeach
                                @endif
                                @if($r->video_url!="")
                                @php $pic_thumb_cnt++; @endphp
                                <div class="slider_item">
                                    <video class="video_main" controls>
                                        <source src="{{ $r->video_url }}" type="video/mp4">
                                        <source src="{{ $r->video_url }}" type="video/ogg">
                                        Your browser does not support HTML video.
                                    </video>
                                </div>
                                @endif
                                @include('front.product.product_variation_main_images_mobile',['pic_thumb_cnt' =>
                                $pic_thumb_cnt])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 mb-lg-0 mb-4">
                    @include('widget/notifications')
                    <form method="post" action="{{route('product_show',$r->slug)}}" class="num-block">
                        <div class="shop-details-content">
                            <a href="javascript:void(0);" class="product-cat">{{$cat_info}}</a>
                            <h3 class="title mb-0">{{$r->title}}</h3>



                            <div class="main-product-border-containr">
                                <div class="main-prod-border-item">
                                    <div class="shop-detail-field">
                                        <a href="#" class="scroll-down">
                                            <div class="rating" data-rating="<?=get_reviews($r->id)?>"></div>
                                        </a>
                                    </div>
                                    <div class="shop-detail-field">
                                        <p class="style-name">SKU: <span class="product_sku">{{ $r->sku_id }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="shop-detail-field">
                                        <div class="price">Price:
                                            @if($r->sale_price!="")
                                            <span class="cut_price text-secondary">{!!currency() !!}
                                                {{ number_format_m($r->regular_price, 2)}}</span>
                                            <span class="exact_price">{!!currency() !!}
                                                {{ round($r->sale_price)}}</span>
                                            @else
                                            <span class="exact_price">{!!currency() !!}
                                                {{ round($r->regular_price)}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="main-prod-border-item">
                                    <div class="shop-detail-field">
                                        <div class="pro_details">
                                            <p>{!! $r->short_description !!}</p>
                                        </div>
                                    </div>
                                </div>



                                <div class="main-prod-border-item">
                                    <!--QTY--->
                                    <div class="shop-detail-field">
                                        <div class="cart-plus-minus">
                                            <div class="select_item_content">
                                                <span>QTY</span>
                                            </div>
                                            <div class="num-block">

                                                <div class="qtybutton-box">
                                                    <span class="minus dis">
                                                        <i class="fa-solid fa-minus"></i>
                                                    </span>
                                                </div>
                                                <div class="qty-counter"><input type="text" class="in-num" name="qty"
                                                        value="1" readonly=""></div>

                                                <div class="qtybutton-box">
                                                    <span class="plus">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--END QTY-->
                                    <div class="shop-detail-field">
                                        <div class="main_product_buttons">
                                            @if(configinfo('status'))
                                            <button type="button" class="cst_btn btn btn-dark text-white"
                                                data-type="cart">
                                                Add to cart
                                            </button>
                                            @else
                                            <button type="button" disabled class=" btn btn-dark text-white"
                                                >
                                                Not Available
                                            </button>
                                            @endif


                                        </div>
                                    </div>

                                    <div class="shop-detail-field mb-0 mt-0">
                                        <div class="wishlist-compare">
                                            <ul>
                                                <li>
                                                    <a href="javascript:void(0);" data-slug="{{$r->slug}}"
                                                        @if(!Auth::check()) data-toggle="modal"
                                                        data-target="#LoginModel" @endif
                                                        class="{{(Auth::check() =='1' ? 'wishlist_add':'login_popup_alert')}}">
                                                        <i class="far fa-heart"></i> Add to Wishlist </a>
                                                        
                                                </li>
                                                <li>
                                                    @if($r->size_chart!="")

                                                    <div class="size_chart">
                                                        <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->
                                                        <button type="button" data-toggle="modal"
                                                            data-target="#SizeChart" >
                                                            <i class="fa-solid fa-chart-area"></i>
                                                            <span>Size Chart</span>
                                                        </button>
                                                    </div>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!---product_size_popup--->

                            <div class="modal fade" id="SizeChart" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            @if($r->size_chart!="")
                                            <img src="{{asset('uploads/product/'.$r->size_chart)}}"
                                                class="avatar-xl img-fluid">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- whishlist -->
                            <!--Model Login-Form-->
                            <div class="modal fade" id="LoginModel" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="login_form_modal">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="Login_Form">
                                                    <form class="form-horizontal" id="front_login_form" method="POST"
                                                        action="javascript:void(0);">
                                                        @csrf
                                                        <div class="form-group">
                                                            <div class="col-md-12">
                                                                <label>Email</label>
                                                                <input type="email" id="email" name="email"
                                                                    placeholder="Enter Your Email" required
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-12">
                                                                <label>Password</label>
                                                                <input type="Password" id="Password" name="password"
                                                                    placeholder="Enter Your Password" required
                                                                    class="form-control">
                                                                @if (Route::has('password.request'))
                                                                <p class="mt-3 forgot-pswd"><a
                                                                        href="{{ route('password.request') }}">Forgot
                                                                        Password?</a></p>
                                                                @endif
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="col-md-12">
                                                                    <div class="form_submit_buttons">
                                                                        <button type="submit"
                                                                            class="btn btn-md btn-success">Login</button>
                                                                        <a href="{{route('register')}}"
                                                                            class="btn btn-md btn-secondary">Sign
                                                                            Up</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Model Login-Form-->

                        </div>

                </div>
            </div>
        </div>




        <section class="desp-tab-wrapper section-padding pb-0 ">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="product-desc-wrap tablist-content">
                            <ul class="nav nav-tabs mb-3" role="tablist">
                                <li class="nav-item active">
                                    <a class="nav-link " data-toggle="tab" href="#description" role="tab">Description</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews</a>
                                </li>
                               
                            </ul>
                           
                            <div class="tab-content">
                                <div class="tab-pane active" id="description" role="tabpanel">
                                
                                   
                                    <div class="product-desc-title ">
                                        <h4 class="title">Product Description:</h4>
                                    </div>
                                    <div class="product_description">
                                        {!! $r->description !!}
                                    </div>


                                </div>
                                <?php $data = get_reviews_by_numbers($r->id); ?>
                               
                                <div class="tab-pane " id="reviews" role="tabpanel">
                                    
                                    <div class="product-desc-title mb-30">
                                        <h4 class="title">Reviews</h4>
                                    </div>
                                    <div class="product_reviews d-flex mb-4 flex-wrap">
                                        <div class="Review_items col-md-4 mb-md-0 mb-4">
                                            <h5><?=get_reviews($r->id)?><span>/5</span></h5>
                                            <div class="rating" data-rating="<?=get_reviews($r->id)?>"></div>
                                        </div>
                                        <div class="Review_items col-md-4 mb-md-0 mb-4">
                                            <div class="progress_bar_items">
                                                <span>5</span><span> <i class="fas fa-star"></i></span>
                                                <div class="progress">
                                                    <div class="progress-bar"
                                                        style="width:{{get_reviews_by_numbers_percent($r->id,'5')}}%">
                                                    </div>
                                                    <span>{{$data[5]}}</span>
                                                </div>
                                            </div>
                                            <div class="progress_bar_items">
                                                <span>4</span><span> <i class="fas fa-star"></i></span>
                                                <div class="progress">
                                                    <div class="progress-bar"
                                                        style="width:{{get_reviews_by_numbers_percent($r->id,'4')}}%">
                                                    </div>
                                                    <span>{{$data[4]}}</span>
                                                </div>
                                            </div>
                                            <div class="progress_bar_items">
                                                <span>3</span><span> <i class="fas fa-star"></i></span>
                                                <div class="progress">
                                                    <div class="progress-bar"
                                                        style="width:{{get_reviews_by_numbers_percent($r->id,'3')}}%">
                                                    </div>
                                                    <span>{{$data[3]}}</span>
                                                </div>
                                            </div>
                                            <div class="progress_bar_items">
                                                <span>2</span><span> <i class="fas fa-star"></i></span>
                                                <div class="progress">
                                                    <div class="progress-bar"
                                                        style="width:{{get_reviews_by_numbers_percent($r->id,'2')}}%">
                                                    </div>
                                                    <span>{{$data[2]}}</span>
                                                </div>
                                            </div>
                                            <div class="progress_bar_items">
                                                <span>1</span><span> <i class="fas fa-star"></i></span>
                                                <div class="progress">
                                                    <div class="progress-bar" data-info=""
                                                        style="width:{{get_reviews_by_numbers_percent($r->id,'1')}}%">
                                                    </div>
                                                    <span>{{$data[1]}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Review_items col-md-4">
                                            <a class="btn btn-dark" data-toggle="collapse" href="#writeReview"
                                                role="button" aria-expanded="false"
                                                aria-controls="collapseExample">Write A Review</a>
                                        </div>
                                    </div>
                                    <div class="collapse" id="writeReview">
                                        <form method="post" action="javascript:void(0)" id="review" class="num-block">
                                            <div class="mandatory-field-wrapper col-md-12">
                                                <p>Your email address will not be published. Required fields are
                                                    marked
                                                </p>
                                                <p class="adara-review-title mb-0">Be the first to review “General
                                                    Retail”</p>

                                            </div>
                                            <div action="#" class="review_form col-md-12 p-0 mt-4">
                                                <div class="col-md-12">
                                                    <h4 class="review-title-head mb-4">Your review
                                                        *</h4>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="review-rating mb-4">
                                                        <span>Your rating *</span>
                                                        <div class="rating_input">
                                                        </div>
                                                        <input type="hidden" name="rating" id="ratting_input_form">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <textarea name="comment" id="comment-message"
                                                            placeholder="Your Comment" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <input type="text" required name="name" placeholder="Your Name*"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <input type="email" required name="email"
                                                            placeholder="Your Email*" class="form-control">
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <input type="file" id="picture" name="picture"
                                                            placeholder="File upload*" class="form-control">
                                                    </div>

                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <div class="comment-check-box ">
                                                            <label class="custom-check-box"> <span
                                                                    class="checkmark "></span>
                                                                <input type="checkbox" required id="comment-check">
                                                                Save my name and email in this browser for the next
                                                                time
                                                                I
                                                                comment.
                                                                <span class="checkmark"></span>

                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="product_slug" value="{{$r->slug}}">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-success" id="btn-job-submit"
                                                            type="submit">Submit</button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <div class="notification"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="row">
                                        @if(!empty($review))
                                        @foreach($review as $rv)
                                        <div class="col-lg-4">
                                            <div class="client_review">
                                                <p>
                                                    <span>{{$rv->name}} </span>
                                                    @if($rv->picture!="")
                                                    <span>
                                                        <img src="/assets/front/img/verified.png" class="img-fluid">
                                                    </span>
                                                    @endif
                                                </p>
                                                <span class="rating" data-rating="{{$rv->rating}}"></span>
                                                @if($rv->comment!="")
                                                <p class="review_comments">{{$rv->comment}}<p>
                                                        @endif
                                                        @if($rv->picture!="")
                                                        <img src="{{asset('uploads/reviews/'.$rv->picture)}}"
                                                            class="img-fluid">
                                                        @endif
                                            </div>
                                        </div>
                                        @endforeach
                                        {{ $review->appends(['tab'=>'reviews'])->links() }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 ">
                        <div class="related-product-slide section-padding pb-0">
                            @if(!empty($related))
                            <div class="related-product-wrap ">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="related-product-title">
                                            <h4 class="title">Related Products</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="related-product-active section-padding pb-0">

                                    <div class="row">
                                        @foreach($related as $product)

                                        <div class="col-md-6 col-lg-3 mb-lg-0 mb-4">
                                            <div class="related_items">

                                                @include('front.product.loop', ['product' =>
                                                $product,'container'=>'col-12
                                                p-0'])
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>



                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    




</form>



  


<!-- shop-details-area-end -->
@endsection
@section('script')


<script type='text/javascript' src='{{asset("assets/front/js/zoomove.min.js")}}'></script>

<!-- <script type='text/javascript' src='{{asset("assets/front/js/easyzoom.js")}}'></script> -->
<script type='text/javascript' src='{{asset("assets/front/js/product_details.js")}}'></script>
<script type='text/javascript' src='{{asset("assets/front/js/form_post.js")}}'></script>
<!-- slider_script -->
<script src="{{asset('assets/front/css/slick/slick.min.js')}}"></script>

  

<script type='text/javascript'>
    $(".rating_input").starRating({
        totalStars: 5,
        emptyColor: 'grey',
        hoverColor: '#FF7F50',
        activeColor: '#FF7F50',
        ratedColor: '#FF7F50',
        initialRating: 1,
        strokeColor: '#FF7F50',
        useGradient: false,
        minRating: 1,
        useFullStars: true,
        onHover: function (currentIndex, currentRating, $el) {
            $('#ratting_input_form').val(currentIndex);
        },
        onLeave: function (currentIndex, currentRating, $el) {
            $('#ratting_input_form').val(currentRating);
        }
    });
</script>


<script type='text/javascript'>
    $(document).ready(function () {

        $('.zoo-item').ZooMove({
            scale: '3',
            move: 'true',
            over: 'false',
            cursor: 'true'
        });

    })

    // thumbnail script


    $('.slider-for').slick({
        
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav',
    });
    $('.slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        asNavFor: '.slider-for',
        dots: false,


    });
    $(document).ready(function(){
$("#SizeChart,#LoginModel").modal({
show:false,
backdrop:'static'
});
});
</script>



@endsection