<link rel='stylesheet' type='text/css' href='{{asset('public/assets/plugins/dropzone/css/dropzone.css')}}' /> 
<link rel="stylesheet" href="{{asset('public/assets/front/css/plugins.css')}}">

<div class="col-xl-5 col-lg-6 col-md-5 m-l-10">
    
        <div class="product-details-images">
            <div class="product_details_container">
                <!-- product_big_images start -->
                   <div class="product_big_images-top">
                       
                       @php $big_pic_cnt=0; $pic_cnt=1; @endphp     
                        <div class="portfolio-full-image tab-content">
                            @if($r->feature_picture!="")
                            <div role="tabpanel" class="tab-pane active" id="img-tab-{{$big_pic_cnt}}">
                                <img src="{{asset('public/uploads/product/'.$r->feature_picture)}}" alt="full-image">
                            </div>
                            @endif
                            @if($r->gallery_picture!="")
                            @foreach(json_decode($r->gallery_picture) as $g)
                            <div role="tabpanel" class="tab-pane product-video-position {{($pic_cnt ==0 ? "active":"")}}" id="img-tab-{{$pic_cnt}}">
                                <img src="{{asset('public/uploads/product/'.$g)}}" alt="full-image">
                            </div>
                            @php $pic_cnt++; @endphp 
                            @endforeach
                            @endif
                        </div>
                       
                    </div>
                    @if($r->gallery_picture!="")
                    <ul class="product_small_images-bottom horizantal-product-active nav" role="tablist">
                        <li role="presentation" class="pot-small-img {{($big_pic_cnt==0 ? "active":"")}}">
                            <a href="#img-tab-{{$big_pic_cnt}}" role="tab" data-toggle="tab">
                                <img src="{{asset('public/uploads/product/thumb/'.$r->feature_picture)}}" alt="small-image">
                            </a>
                        </li>
                        @php $pic_cnt_thumb=1; @endphp    
                        @foreach(json_decode($r->gallery_picture) as $g)
                        <li role="presentation" class="pot-small-img {{($pic_cnt_thumb ==0 ? "active":"")}}">
                            <a href="#img-tab-{{$pic_cnt_thumb}}" role="tab" data-toggle="tab">
                                <img src="{{asset('public/uploads/product/thumb/'.$g)}}" alt="small-image">
                            </a>
                        </li>
                        @php $pic_cnt_thumb++; @endphp    
                        @endforeach
                    </ul>
                    @endif
            </div>
        </div>
    
    <div class="clearfix"></div>
    <div class="row">
        <div class="gallery_upload_pictures m-t-40 m-b-10">
            <h1 class="color-title">Document Upload</h1>

                <div id="my-awesome-dropzone" class="dropzone"></div>                      
                

        </div>
    </div>
</div>
<div class="col-lg-1 cat-border"></div>
<div class="col-xl-5 col-lg-4 col-md-5">
<form method="post" id="popup_form" action="#">
@csrf
<div class="alert alert-dismissable" id="notify_alert" style="display:none;">
        <button type="button" class="close" id="close_notify">&#215;</button>
        <strong id="notify_message"></strong> 
    </div>
    <!-- product_details_info start -->
    <div class="product_details_info">
        <h2>{{$r->title}}</h2>

        <!-- pro_details start -->
        <div class="pro_details">
            <p>{!! strip_tags($r->short_description) !!}</p>
        </div>
        <!-- pro_details end -->
        <!-- pro_dtl_prize start -->
        <ul class="pro_dtl_prize">
            @if($r->sale_price!="")
            <li class="old_prize">${{number_format($r->regular_price, 2)}}</li>
            <li> ${{number_format($r->sale_price, 2)}}</li>
            @else
            <li> ${{number_format($r->regular_price, 2)}}</li>
            @endif
        </ul>


        <!--Variations-->     
        @if($r->variations)
        @if(!empty($r->attribute))
        @foreach($r->attribute as $attr)
        <div class="pro_dtl_size">
            <h2 class="title_2">{{$call_back_fun->get_attribute_name($attr->attribute_id)}}</h2>
            <div class="col-md-6 p-l-0">

                @if($call_back_fun->get_attribute_name($attr->attribute_id,'type') == 'dropdown')    
                    <select class="form-control m-b-10 variations" id='{{$call_back_fun->get_attribute_name($attr->attribute_id,'slug')}}' data-attrid="{{$attr->attribute_id}}"  data-type="select"  name="attr[{{$attr->attribute_id}}]" >
                        @php $variations_info = $call_back_fun->get_attribute_variations_value_price($r->id,$attr->attribute_id);  @endphp
                        @if(!empty($variations_info))
                        @foreach($variations_info as $var)
                        <option value="{{$var->attr_value_name}}" data-price='{{$var->attr_value_name_price}}'  {{($var->attr_value_name ==$attr->attribute_value ? "selected":"" )}}>{{$var->attr_value_name}}</option>                                
                        @endforeach    
                        @endif
                    </select>
                @endif

                @if($call_back_fun->get_attribute_name($attr->attribute_id,'type') == 'mulitple')    
                    <select class="form-control m-b-10 variations" id='{{$call_back_fun->get_attribute_name($attr->attribute_id,'slug')}}' data-attrid="{{$attr->attribute_id}}" data-type="multi"  name="attr[{{$attr->attribute_id}}]" multiple="">
                        @php $variations_info = $call_back_fun->get_attribute_variations_value_price($r->id,$attr->attribute_id);  @endphp
                        @if(!empty($variations_info))
                        @foreach($variations_info as $var)
                        <option value="{{$var->attr_value_name}}" data-price='{{$var->attr_value_name_price}}' {{($var->attr_value_name ==$attr->attribute_value ? "selected":"" )}}>{{$var->attr_value_name}}</option>                                
                        @endforeach    
                        @endif
                    </select>
                @endif

                @if($call_back_fun->get_attribute_name($attr->attribute_id,'type') == 'radio')    

                        @php $variations_info = $call_back_fun->get_attribute_variations_value_price($r->id,$attr->attribute_id);  @endphp
                        @if(!empty($variations_info))
                        @foreach($variations_info as $var)
                            <label class="radio-inline m-b-10">
                                <input type="radio" class="variations_rd" data-type="radio"  name="attr[{{$attr->attribute_id}}]" data-attrid="{{$attr->attribute_id}}"  value="{{$var->attr_value_name}}" data-price='{{$var->attr_value_name_price}}' {{($var->attr_value_name ==$attr->attribute_value ? "checked":"" )}}>
                              {{$var->attr_value_name}}
                            </label>
                        @endforeach    
                        @endif

                @endif

                @if($call_back_fun->get_attribute_name($attr->attribute_id,'type') == 'checkbox')    

                        @php $variations_info = $call_back_fun->get_attribute_variations_value_price($r->id,$attr->attribute_id);  @endphp
                        @if(!empty($variations_info))
                        @foreach($variations_info as $var)
                            <label class="checkbox-inline m-b-10">
                                <input type="checkbox" class="variations" data-type="checkbox"  name="attr[{{$attr->attribute_id}}][]" data-attrid="{{$attr->attribute_id}}"  value="{{$var->attr_value_name}}" data-price='{{$var->attr_value_name_price}}' {{($var->attr_value_name ==$attr->attribute_value ? "checked":"" )}}>
                              {{$var->attr_value_name}}
                            </label>
                        @endforeach    
                        @endif

                @endif


                @if($call_back_fun->get_attribute_name($attr->attribute_id,'type') == 'textfield')    

                        @php $variations_info = $call_back_fun->get_attribute_variations_value_price($r->id,$attr->attribute_id);  @endphp
                        @if(!empty($variations_info))
                        @foreach($variations_info as $var)
                        <input type="text"  name="attr[{{$attr->attribute_id}}]" data-type="text"  class="form-control m-b-10 variations" value="{{$var->attr_value_name}}" data-price='{{$var->attr_value_name_price}}'>                                                                   
                        @endforeach    
                        @endif

                @endif

                @if($call_back_fun->get_attribute_name($attr->attribute_id,'type') == 'textarea')    

                        @php $variations_info = $call_back_fun->get_attribute_variations_value_price($r->id,$attr->attribute_id);  @endphp
                        @if(!empty($variations_info))
                        @foreach($variations_info as $var)
                        <textarea name="attr[{{$attr->attribute_id}}]" data-type="textarea" data-attrid="{{$attr->attribute_id}}"  class="form-control m-b-10 variations" data-price='{{$var->attr_value_name_price}}' >{{$var->attr_value_name}}</textarea>                                                               
                        @endforeach    
                        @endif

                @endif

                @if($call_back_fun->get_attribute_name($attr->attribute_id,'type') == 'file_upload')    

                        @php $variations_info = $call_back_fun->get_attribute_variations_value_price($r->id,$attr->attribute_id);  @endphp
                        @if(!empty($variations_info))
                        @foreach($variations_info as $var)
                        <img src="{{asset('public/uploads/product/thumb/'.$var->attr_value_name)}}" data-attrid="{{$attr->attribute_id}}" class="thumbnail m-b-10" >

                        @endforeach    
                        @endif

                @endif



            </div>
        </div>
        @endforeach
        @endif


        <!-- pro_dtl_prize start -->
        <ul class="pro_dtl_prize m-t-20 m-b-20" >
            @if($r->sale_price!="")                        
            <li>Total Price: $<span id="final_price">{{number_format($r->sale_price, 2)}}</span></li>
            @else
            <li>Total Price: $<span id="final_price">{{number_format($r->regular_price, 2)}}</span></li>
            @endif
        </ul>

        @endif
       <!--End Variations-->


        <!-- product-quantity-action start -->
        <div class="product-quantity-action">
            <div class="prodict-statas"><span>Quantity :</span></div>
            <div class="product-quantity">                            
                <div class="product-quantity">
                    <div class="cart-plus-minus">
                        <input value="1" min="1" type="number" name="qty">
                    </div>
                </div>                            
            </div>
        </div>
        <!-- product-quantity-action end -->


        <!-- pro_dtl_btn start -->
        <ul class="pro_dtl_btn">
            <li><button type="button" class="cst_btn" id="popup_submit">buy now</button></li>                        
            <li><a href="javascript:void(0)" data-slug="{{$r->slug}}" id="popup_wishlist"><i class="ion-heart"></i></a></li>
        </ul>

        
    </div>
    <!-- product_details_info end -->
    <div id="multi_cont"></div>
    <input type="hidden" name="slug" value="{{$r->slug}}">
    </form>
</div>   

<!-- main-content-wrap end -->
<script type='text/javascript' src='{{asset('public/assets/plugins/dropzone/dropzone.min.js')}}'></script> 
<script type='text/javascript' src='{{asset('public/assets/js/dropzone_init.js')}}'></script> 
<script type='text/javascript' src='{{asset('public/assets/js/product_details.js')}}'></script>

<script type="text/javascript">
$('.horizantal-product-active').slick({
    slidesToShow: 4,
    autoplay: false,
    vertical:false,
    verticalSwiping:true,
    slidesToScroll: 1,
    prevArrow:'<i class="ion-chevron-left arrow-prv"></i>',
    nextArrow:'<i class="ion-chevron-right arrow-next"></i>',
    button:false,
    responsive: [
        {
          breakpoint: 1024,
          settings: {
          slidesToShow: 4,
          }
        },
        { breakpoint: 991,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 3,
          }
        }
    ]
     
});	     
$('.horizantal-product-active a').on('click', function () {
    $('.horizantal-product-active a').removeClass('active');
});

</script>
        

