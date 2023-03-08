<link rel='stylesheet' type='text/css' href='{{asset('public/assets/plugins/dropzone/css/dropzone.css')}}' /> 
<link rel='stylesheet' type='text/css' href='{{asset('public/assets/product_slider/product_slider.css')}}' />
<link rel="stylesheet" media="screen" href="{{asset('public/assets/zoomer/styles/zoomple.css')}}" type="text/css" />
<style>
img{
    max-width: fit-content !important;
}
img.inner_img{
    width: 100%;
}
</style>
<div class="col-xl-5 col-lg-6 col-md-5 m-l-10">
    
        <div class="product-details-images">
            <div class="product_details_container">
                <!-- product_big_images start -->
                <div class="product_big_images m-b-20 ">
                    <div class="portfolio-full-image tab-content">
                        @php $pic_cnt=0;@endphp                                
                        @if($r->feature_picture!="")                                
                        <div role="tabpanel" class="tab-pane active product-image-position" id="img-tab-{{$pic_cnt}}">
                            <a href="javascript:void(0);" class="zoompleFixed">
                                <img src="{{asset('public/uploads/product/'.$r->feature_picture)}}" class="inner_img" >
                            </a>
                        </div>
                        @endif
                        @if($r->gallery_picture!="")
                        @foreach(json_decode($r->gallery_picture) as $g)
                        @php $pic_cnt++; @endphp    
                        <div role="tabpanel" class="tab-pane product-image-position {{($pic_cnt ==0 ? "active":"")}} " id="img-tab-{{$pic_cnt}}">
                                    <a href="javascript:void(0);" class="zoompleFixed">
                                        <img src="{{asset('public/uploads/product/'.$g)}}" class="inner_img">
                                    </a>
                                </div>

                        @endforeach
                        @endif
                    </div>
                </div>
                <!-- product_big_images end -->

                <!-- Start Small images -->

                <ul class="product_small_images-thumb horizantal-product-active nav " role="tablist">

                    @php $pic_thumb_cnt=0;@endphp                                
                    @if($r->feature_picture!="")

                    <li role="presentation" class="pot-small-img active">
                        <a href="#img-tab-{{$pic_thumb_cnt}}" role="tab" data-toggle="tab">
                            <img src="{{asset('public/uploads/product/thumb/'.$r->feature_picture)}}" alt="#">
                        </a>
                    </li>
                    @endif
                    @if($r->gallery_picture!="")
                        @foreach(json_decode($r->gallery_picture) as $g)
                        @php $pic_thumb_cnt++; @endphp     
                        <li role="presentation" class="pot-small-img {{($pic_thumb_cnt ==0 ? "active":"")}}">
                            <a href="#img-tab-{{$pic_thumb_cnt}}" role="tab" data-toggle="tab">
                                <img src="{{asset('public/uploads/product/thumb/'.$g)}}" alt="#">
                            </a>
                        </li>

                    @endforeach
                    @endif
                </ul>
                <!-- End Small images -->
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
            <p>{!! $r->short_description !!}</p>
        </div>
        <!-- pro_details end -->
        <!-- pro_dtl_prize start -->
        <ul class="pro_dtl_prize">
            @if($r->sale_price!="")
            <li class="old_prize">{!! currency() !!}{{$r->regular_price}}</li>
            <li> {!! currency() !!}{{$r->sale_price}}</li>
            @else
            <li> {!! currency() !!}{{$r->regular_price}}</li>
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
            <li>Total Price: {!! currency() !!}<span id="final_price">{{$r->sale_price}}</span></li>
            @else
            <li>Total Price: {!! currency() !!}<span id="final_price">{{$r->regular_price}}</span></li>
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
<script type='text/javascript' src='{{asset("public/assets/plugins/dropzone/dropzone.min.js")}}'></script> 
<script type='text/javascript' src='{{asset("public/assets/js/dropzone_init.js")}}'></script> 
<script type='text/javascript' src='{{asset("public/assets/js/product_details.js")}}'></script>

<script type='text/javascript' src='{{asset("public/assets/product_slider/easyzoom.js")}}'></script>
<script type='text/javascript' src='{{asset("public/assets/product_slider/init.js")}}'></script>


<script src="{{asset('public/assets/zoomer/zoomple.js')}}" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() { 	
	$('.zoomple').zoomple({ 
		blankURL : '{!! asset("public/assets/zoomer/images/blank.gif") !!}',
		bgColor : '#90D5D9',
		loaderURL : '{!! asset("public/assets/zoomer/images/loader.gif") !!}',
		offset : {x:-150,y:-150},
		zoomWidth : 300,  
		zoomHeight : 300,
		roundedCorners : true
	});
	$('.zoomple2').zoomple({ 
		blankURL : '{!! asset("public/assets/zoomer/images/blank.gif") !!}',
		loaderURL : '{!! asset("public/assets/zoomer/images/loader.gif") !!}',
		offset : {x:5,y:5},
		zoomWidth : 300,  
		zoomHeight : 300			
	});
	
	$('.zoompleFixed').zoomple({
		offset : {x:5,y:0},
		showOverlay : true , 
		roundedCorners: false, 
		windowPosition : {x:'right',y:'top'}, 
		zoomWidth : 500,  
		zoomHeight : 500, 
		attachWindowToMouse : false,
                blankURL : '{!! asset("public/assets/zoomer/images/blank.gif") !!}',		
		loaderURL : '{!! asset("public/assets/zoomer/images/loader.gif") !!}',
	}); 
	$('.zoompleDiffWidth').zoomple({
		offset : {x:10,y:0},
		showOverlay : true , 
		zoomWidth : 250, 
		showCursor : true, 
		delay : 1000, 
		zoomHeight : 250
	}); 
	$('.zoomplecross').zoomple({
		offset : {x:10,y:10},		
		zoomWidth : 250, 
		showCursor : true, 
		zoomHeight : 250
	}); 
 }); 
</script> 