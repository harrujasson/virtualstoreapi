@if(!empty($attr))

<div class="form-row mb-2">

@if($attr->type == 'dropdown')
<div class="col-md-6 mb-3">
    <label>{{$attr->label}}</label>
        <select name="attr[{{$attr->id}}]" class="form-control">
            @if(!empty($attr_value))
            @foreach($attr_value as $attr_val)
                <option value="{{$attr_val->data}}">{{$attr_val->data}}</option>
            @endforeach
            @endif
        </select>

</div>
<div class="col-md-3 remove_heading mt-2"><button type="button" class="remove_container_attr btn btn-danger btn-xs" data-id="{{$attr->id}}" ><i class="bx bx-trash"></i></button></div>
@endif

@if($attr->type == 'mulitple')
<div class="col-md-6 mb-3">
<label>{{$attr->label}}</label>

    <select name="attr[{{$attr->id}}][]" class="form-control" multiple="">
        @if(!empty($attr_value))
        @foreach($attr_value as $attr_val)
            <option value="{{$attr_val->data}}">{{$attr_val->data}}</option>
        @endforeach
        @endif
    </select>
</div>
<div class="col-md-3 remove_heading mt-2"><button type="button" class="remove_container_attr btn btn-danger btn-xs" data-id="{{$attr->id}}"><i class="bx bx-trash"></i></button></div>
@endif

@if($attr->type == 'radio')
<div class="col-md-6 mb-3">
<label >{{$attr->label}}</label>

    @if(!empty($attr_value))
    <ul class="list-unstyled mb-0 mt-1">
        @foreach($attr_value as $attr_val)
            <li class="d-inline-block mr-2 mb-1">
                <fieldset>
                  <div class="radio">
                      <input type="radio" name="attr[{{$attr->id}}]"  value="{{$attr_val->data}}" class="variation" id="var_{{$attr->id}}" checked="">
                    <label for="var_{{$attr->id}}">{{$attr_val->data}}</label>
                  </div>
                </fieldset>
            </li>
        @endforeach
    </ul>
    @endif
</div>
<div class="col-md-3 remove_heading mt-2"><button type="button" class="remove_container_attr btn btn-danger btn-xs" data-id="{{$attr->id}}"><i class="bx bx-trash"></i></button></div>
@endif

@if($attr->type == 'checkbox')
<div class="col-md-6 mb-3">
<label >{{$attr->label}}</label>

    @if(!empty($attr_value))
    <ul class="list-unstyled mb-0 mt-1">
        @foreach($attr_value as $attr_val)


            <li class="d-inline-block mr-2 mb-1">
                <fieldset>
                  <div class="checkbox">
                      <input type="checkbox" name="attr[{{$attr->id}}]"  class="checkbox-input" value="{{$attr_val->data}}"  id="var_{{$attr->id}}" checked="">
                    <label for="var_{{$attr->id}}">{{$attr_val->data}}</label>
                  </div>
                </fieldset>
            </li>

        @endforeach
    </ul>
    @endif
</div>
<div class="col-md-3 remove_heading mt-2"><button type="button" class="remove_container_attr btn btn-danger btn-xs" data-id="{{$attr->id}}"><i class="bx bx-trash"></i></button></div>
@endif


@if($attr->type == 'textfield')
<div class="col-md-6 mb-3">
<label >{{$attr->label}}</label>

    @if(!empty($attr_value))
        @foreach($attr_value as $attr_val)
            <input type="text" name="attr[{{$attr->id}}]" class="form-control" value="{{$attr_val->data}}">
        @endforeach
    @endif

</div>
<div class="col-md-3 remove_heading mt-2"><button type="button" class="remove_container_attr btn btn-danger btn-xs" data-id="{{$attr->id}}"><i class="bx bx-trash"></i></button></div>
@endif

@if($attr->type == 'textarea')
<div class="col-md-6 mb-3">
<label >{{$attr->label}}</label>

    @if(!empty($attr_value))
        @foreach($attr_value as $attr_val)
            <textarea name="attr[{{$attr->id}}]" class="form-control">{{$attr_val->data}}</textarea>
        @endforeach
    @endif

</div>
<div class="col-md-3 remove_heading mt-2"><button type="button" class="remove_container_attr btn btn-danger btn-xs" data-id="{{$attr->id}}"><i class="bx bx-trash"></i></button></div>
@endif

@if($attr->type == 'file_upload')
<div class="col-md-6 mb-3">
<label>{{$attr->label}}</label>

    <input type="file" name="file_attr[{{$attr->id}}]" class="form-control" data-id="{{$attr->id}}">
</div>
<div class="col-md-3 remove_heading mt-2"><button type="button" class="remove_container_attr btn btn-danger btn-xs" ><i class="bx bx-trash"></i></button></div>
@endif
</div>
@endif
<script type="text/javascript">

</script>
