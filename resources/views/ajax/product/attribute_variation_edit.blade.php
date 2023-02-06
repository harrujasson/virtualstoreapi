@if(!empty($attr_all))
@foreach($attr_all as $attr)
@php $attr_value = $attr_call_edit->attribute_value_exist($attr->id); @endphp
<div class="form-row">

<!----Color--->
@if($attr->type == 'color')
<div class="col-md-6 mb-3">
<label>{{$attr->label}}</label>

    <select name="attr[{{$attr->id}}][]" class="form-control">
        @if(!empty($attr_value))
        @foreach($attr_value as $attr_val)
            <option value="{{$attr_val->data}}"  {{($attr_call_edit->attribute_value_exist_fill($product_id,$attr->id) ==$attr_val->data ? "selected":"")}} >{{$attr_val->data}}</option>
        @endforeach
        @endif
    </select>
    @if(!empty($attr_value))
    <div class="row">
        <div class="col-sm-12 ms-2 mt-2">
            <ul class="list-unstyled">
                @foreach($attr_value as $attr_val)
                <li class="mt-2 mb-3">

                <div class="row">
                    <div class="col-6">
                        <div  style="background:{{$attr_val->data}};width: 100px;height: 33px;border: 1px solid #ccc;border-radius: 4px;margin-bottom: 10px;"></div>                        
                        <input type="text" class="form-control" value="{{$attr_call_edit->attribute_value_call_exist($product_id,$attr->id,$attr_val->data)}}" placeholder="Enter price" name="attr_val_variation[{{$attr_val->attribute_id}}][{{$attr_val->data}}][color]" >

                    </div>
                    <div class="col-6">
                        <div class="mt-3">
                            @php $var_img = $attr_call_edit->attribute_value_call_exist($product_id,$attr->id,$attr_val->data,'attr_value_name_picture') @endphp
                            <label for="formFileFeature_{{$attr_val->attribute_id}}" class="form-label">Picture </label>
                            <input class="form-control variation_file_upload" type="file" id="formFileFeature_{{$attr_val->attribute_id}}" name="attr_val_variation[{{$attr_val->attribute_id}}][{{$attr_val->data}}][color_picture]">
                            <input type="hidden" name="attr_val_variation[{{$attr_val->attribute_id}}][{{$attr_val->data}}][color_picture]" value="{{$var_img}}" class="variation_img">
                            <input type="hidden" name="attr_val_variation[{{$attr_val->attribute_id}}][{{$attr_val->data}}][color_name]" value="{{$attr_val->name}}" >
                            <div class="img_container mt-2">
                                @if($var_img!="")
                                <img src="{{asset('uploads/product/'.$var_img)}}" class="rounded avatar-lg">
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>
                    
                    <button type="button" class="btn btn-danger btn-xs remove_attr mt-1 mb-1"><i class="bx bx-trash"></i></button>    
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>
<!--<div class="col-md-3 remove_heading  mt-2" ><button type="button" class="remove_container_attr btn btn-danger btn-xs" data-id="{{$attr->id}}"><i class="bx bx-trash"></i></button></div> --->
@endif
<!--End Color-->
@if($attr->type == 'dropdown')
<div class="col-md-6 mb-3">
<label>{{$attr->label}}</label>

    <select name="attr[{{$attr->id}}][]" class="form-control">
        @if(!empty($attr_value))
        @foreach($attr_value as $attr_val)
            <option value="{{$attr_val->data}}"  {{($attr_call_edit->attribute_value_exist_fill($product_id,$attr->id) ==$attr_val->data ? "selected":"")}} >{{$attr_val->data}}</option>
        @endforeach
        @endif
    </select>

    @if(!empty($attr_value))
    <div class="row">
        <div class="col-sm-6 ms-2 mt-2">
            <ul class="list-unstyled">
                @foreach($attr_value as $attr_val)
                <li class="mt-2 mb-1">
                    @if($attr->name == "COLOR")
                    <div  style="background:#{{$attr_val->data}};width: 100px;height: 33px;border: 1px solid #ccc;border-radius: 4px;margin-bottom: 10px;"></div>
                    @else
                    {{$attr_val->data}} 
                    @endif
                    <input type="text" class="form-control" value="{{$attr_call_edit->attribute_value_call_exist($product_id,$attr->id,$attr_val->data)}}" placeholder="Enter price" name="attr_val_variation[{{$attr_val->attribute_id}}][{{$attr_val->data}}]" >
                    <button type="button" class="btn btn-danger btn-xs remove_attr mt-1 mb-1"><i class="bx bx-trash"></i></button>    
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>
<div class="col-md-3 remove_heading  mt-2"><button type="button" class="remove_container_attr btn btn-danger btn-xs" data-id="{{$attr->id}}"><i class="bx bx-trash"></i></button></div>
@endif

@if($attr->type == 'mulitple')
<div class="col-md-6 mb-3">
<label>{{$attr->label}}</label>

    <select name="attr[{{$attr->id}}]" class="form-control" multiple="">
        @if(!empty($attr_value))
        @foreach($attr_value as $attr_val)
            <option value="{{$attr_val->data}}" {{($attr_call_edit->attribute_value_exist_fill($product_id,$attr->id) ==$attr_val->data ? "selected":"")}}>{{$attr_val->data}}</option>
        @endforeach
        @endif
    </select>
    @if(!empty($attr_value))
    <div class="row">
        <div class="col-sm-6 ms-2 mt-2">
            <ul class="list-unstyled">
                @foreach($attr_value as $attr_val)
                <li class="mt-2 mb-1">{{$attr_val->data}} <input type="text" class="form-control" value="{{$attr_call_edit->attribute_value_call_exist($product_id,$attr->id,$attr_val->data)}}" name="attr_val_variation[{{$attr_val->attribute_id}}][{{$attr_val->data}}]" placeholder="Enter price" ></li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>
<div class="col-md-3 remove_heading  mt-2"><button type="button" class="remove_container_attr btn btn-danger btn-xs" data-id="{{$attr->id}}"><i class="bx bx-trash"></i></button></div>
@endif

@if($attr->type == 'radio')
<div class="col-md-6 mb-3">
<label>{{$attr->label}}</label>
<div class="col-sm-6">
    @if(!empty($attr_value))
    <ul class="list-unstyled mb-0 mt-1">
        @foreach($attr_value as $attr_val)

            <li class="d-inline-block mr-2 mb-1">
                <fieldset>
                  <div class="radio">
                      <input type="radio" name="attr[{{$attr->id}}]"  value="{{$attr_val->data}}" class="variation" id="var_{{$attr->id}}" {{($attr_call_edit->attribute_value_exist_fill($product_id,$attr->id) ==$attr_val->data ? "checked":"")}}>
                    <label for="var_{{$attr->id}}">{{$attr_val->data}}</label>
                  </div>
                </fieldset>
            </li>
        @endforeach
    </ul>
    @endif

    @if(!empty($attr_value))
    <div class="row">
        <div class="col-sm-6 ms-2 mt-2">
            <ul class="list-unstyled">
                @foreach($attr_value as $attr_val)
                <li class="mt-2 mb-2">{{$attr_val->data}} <input type="text" class="form-control" value="{{$attr_call_edit->attribute_value_call_exist($product_id,$attr->id,$attr_val->data)}}" name="attr_val_variation[{{$attr_val->attribute_id}}][{{$attr_val->data}}]" placeholder="Enter price" ></li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>
<div class="col-md-3 remove_heading  mt-2"><button type="button" class="remove_container_attr btn btn-danger btn-xs" data-id="{{$attr->id}}"><i class="bx bx-trash"></i></button></div>
@endif

@if($attr->type == 'checkbox')
<div class="col-md-6 mb-3">
<label>{{$attr->label}}</label>

    @if(!empty($attr_value))
    <ul class="list-unstyled mb-0 mt-1">
        @foreach($attr_value as $attr_val)

            <li class="d-inline-block mr-2 mb-1">
                <fieldset>
                  <div class="checkbox">
                      <input type="checkbox" name="attr[{{$attr->id}}]"  class="checkbox-input" value="{{$attr_val->data}}"  id="var_{{$attr->id}}" {{($attr_call_edit->attribute_value_exist_fill($product_id,$attr->id) ==$attr_val->data ? "checked":"")}}>
                    <label for="var_{{$attr->id}}">{{$attr_val->data}}</label>
                  </div>
                </fieldset>
            </li>
        @endforeach
    </ul>
    @endif
    @if(!empty($attr_value))
    <div class="row">
        <div class="col-sm-6 ms-2 mt-2">
            <ul class="list-unstyled">
                @foreach($attr_value as $attr_val)
                <li class="mt-2 mb-1">{{$attr_val->data}} <input type="text" class="form-control" value="{{$attr_call_edit->attribute_value_call_exist($product_id,$attr->id,$attr_val->data)}}" name="attr_val_variation[{{$attr_val->attribute_id}}][{{$attr_val->data}}]" placeholder="Enter price" ></li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>
<div class="col-md-3 remove_heading  mt-2"><button type="button" class="remove_container_attr btn btn-danger btn-xs" data-id="{{$attr->id}}" ><i class="bx bx-trash"></i></button></div>
@endif


@if($attr->type == 'textfield')
<div class="col-md-6 mb-3">
<label>{{$attr->label}}</label>

    @if(!empty($attr_value))
        @foreach($attr_value as $attr_val)
        <input type="text" name="attr[{{$attr->id}}]" class="form-control" value="{{$attr_call_edit->attribute_value_exist_fill($product_id,$attr->id)}}">
        @endforeach
    @endif

    @if(!empty($attr_value))
    <div class="row">
        <div class="col-sm-6 ms-2 mt-2">
            <ul class="list-unstyled ----">
                @foreach($attr_value as $attr_val)
                <li class="mt-2 mb-1">{{$attr_val->data}} <input type="text" class="form-control" value="{{$attr_call_edit->attribute_value_call_exist($product_id,$attr->id,$attr_val->data)}}" name="attr_val_variation[{{$attr_val->attribute_id}}][{{$attr_val->data}}]" placeholder="Enter price" ></li>
                <button type="button" class="btn btn-danger btn-xs remove_attr"><i class="bx bx-trash"></i></button>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

</div>
<div class="col-md-3 remove_heading --- mt-2"><button type="button" class="remove_container_attr btn btn-danger btn-xs" data-id="{{$attr->id}}"><i class="bx bx-trash"></i></button></div>
@endif


@if($attr->type == 'textarea')
<div class="col-md-6 mb-3">
<label>{{$attr->label}}</label>

    @if(!empty($attr_value))
        @foreach($attr_value as $attr_val)
            <textarea name="attr[{{$attr->id}}]" class="form-control">{{$attr_call_edit->attribute_value_exist_fill($product_id,$attr->id)}}</textarea>
        @endforeach
    @endif

    @if(!empty($attr_value))
    <div class="row">
        <div class="col-sm-6 ms-2 mt-2">
            <ul class="list-unstyled">
                @foreach($attr_value as $attr_val)
                <li class="mt-2 mb-1">{{$attr_val->data}} <input type="text" class="form-control" value="{{$attr_call_edit->attribute_value_call_exist($product_id,$attr->id,$attr_val->data)}}" name="attr_val_variation[{{$attr_val->attribute_id}}][{{$attr_val->data}}]" placeholder="Enter price" ></li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

</div>
<div class="col-md-3 remove_heading  mt-2"><button type="button" class="remove_container_attr btn btn-danger btn-xs" data-id="{{$attr->id}}"><i class="bx bx-trash"></i></button></div>
@endif


@if($attr->type == 'file_upload')
<div class="col-md-6 mb-3">
<label class="col-sm-3 control-label">{{$attr->label}}</label>

    <input type="file" name="file_attr[{{$attr->id}}]" class="form-control">
    <br>
    @if($attr_call_edit->attribute_value_exist_fill($product_id,$attr->id) !="")
        <img src="{{asset('public/uploads/product/thumb/'.$attr_call_edit->attribute_value_exist_fill($product_id,$attr->id))}}" class="thumbnail">
    @endif
</div>
<div class="col-md-3 remove_heading  mt-2"><button type="button" class="remove_container_attr btn btn-danger btn-xs" data-id="{{$attr->id}}"><i class="bx bx-trash"></i></button></div>
@endif

</div>
@endforeach
@endif

