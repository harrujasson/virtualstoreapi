@if($r->variations)
    @if(!empty($r->attribute))
        @foreach($r->attribute as $attr)
            @if($call_back_fun->get_attribute_name($attr->attribute_id,'type') == "color")
                @php $variations_info = $call_back_fun->get_attribute_variations_value_price($r->id,$attr->attribute_id);  @endphp
                @if(!empty($variations_info))
                @php $pic_thumb_cnt = 0 @endphp
                @foreach($variations_info as $var)
                    @if($var->attr_value_name_picture!="")
                        <div class="slider_item {{($pic_thumb_cnt ==0 ? 'active show':'')}} main_picture_mobile_{{$var->id}}" id="item-{{$pic_thumb_cnt}}" role="tabpanel" aria-labelledby="item-{{$pic_thumb_cnt}}-tab">
                            
                                <img src="{{asset('uploads/product/'.$var->attr_value_name_picture)}}" alt="">
                            
                        </div>
                        @php $pic_thumb_cnt++; @endphp
                    @endif
                @endforeach
                @endif
            @endif
        @endforeach
    @endif
@endif                        