<div class="{{ $container }} {{store_available()}}">
    <div class="item-box">
        <a href="{{route('product_show',$product->slug)}}">
        
            @if($product->ribon!="")
            <div class="product_badge">{{ $product->ribon }}</div>
            @endif
            <div class="item-box-head">
                <div class="item-box-image">
                    <div class="image">
                        @if($product->feature_picture!="")
                        <img src="{{asset('uploads/product/'.$product->feature_picture)}}" alt="{{$product->title}}">
                        @else
                        <img src="{{asset('assets/front/images/blank_product.jpg')}}" alt="{{$product->title}}">
                        @endif
                    </div>
                </div>

            </div>

            <div class="item-box-content">
                <p class="title">{{$product->title}}</p>
                <div class="rating" data-rating="<?=get_reviews($product->id)?>"></div>

                <div class="cart-flex d-flex justify-content-between">
                    @if($product->sale_price!="")
                    <span class="price new-price old-price">{!! currency()
                        !!}{{number_format_m($product->regular_price, 2)}}</span>
                    <span class="price new-price">{!! currency() !!}{{number_format_m($product->sale_price, 2)}}</span>
                    @else
                    <span class="price new-price">{!! currency()
                        !!}{{number_format_m($product->regular_price, 2)}}</span>
                    @endif
                </div>
                <div class="add-to-cart-flex">
                    <span class="cart"> {{(configinfo('status') ? "Add to cart":"Not Available")}} </i></span>

                    <a href="javascript:void(0);" class="{{(Auth::check() =='1' ? 'wishlist_add':'login_popup_alert')}}"
                        @if(!Auth::check()) data-toggle="modal" data-target="#LoginModel" @endif
                        data-slug="{{$product->slug}}"><i class="far fa-heart"></i>
                    </a>
                </div>



            </div>
        </a>
    </div>

</div>
