@extends('layouts.master')

@section('title') {{$title}} @endsection
@section('headerStyle') 
<link href="{{ URL::asset('/assets/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" /> 
<link href="{{ URL::asset('/assets/plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('title') New @endslot
        @slot('item1') Admin @endslot
        @slot('item2') {{$title}} @endslot
    @endcomponent



<div class="row">
    <div class="col-lg-10 col-md-12 mx-auto">

        
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
 
            @include('widget/notifications')

                <form class="form-parsley" novalidate method="post" action="{{ route('admin.product.create') }}"  enctype="multipart/form-data">

                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Title <code>*</code></label>
                                        <input type="text" class="form-control" name="title" required value="{{ old('title') }}">
                                        <span class="text-danger">{{ $errors->first('title', ':message') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Short Description </label>
                                        <textarea  class="elm1" name="short_description">{{old('short_description')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Full Description </label>
                                        <textarea  class="elm1" name="description">{{old('description')}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Purchase Note </label>
                                        <textarea type="text" class="form-control" name="purchase_note">{{old('purchase_note')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mt-3">
                                        <label for="formFileFeature" class="form-label">Featured Picture <code></code></label>
                                        <input class="form-control" required type="file" id="formFileFeature" name="feature_picture">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mt-3">
                                        <label for="formFileFeature" class="form-label">Video URL <code></code></label>
                                        <input class="form-control" type="url" name="video_url" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mt-4">
                                        <h5 class="font-size-14 mb-4"> Additional Settings </h5>
                                        <div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="feature" type="checkbox" id="formCheck3">

                                                <label class="form-check-label" for="formCheck3">
                                                    Feature
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="new_arrival" type="checkbox" id="formCheck4">

                                                <label class="form-check-label" for="formCheck4">
                                                    New Arrival
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Product General Information</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Regular Price <code>*</code> </label>
                                        <input type="text" required class="form-control" name="regular_price" value="{{old('regular_price')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Sale Price </label>
                                        <input type="text" class="form-control" name="sale_price" value="{{old('sale_price')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Tax  </label>
                                        <select name="tax_id" class="select2" style="width: 100%">
                                            <option value="0">Tax Free</option>
                                            @if(!empty($tax))
                                                @foreach($tax as $tx)
                                                    <option value="{{$tx->id}}">{{$tx->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Product Highlight</label>
                                        <input type="text" class="form-control" name="ribon" value="" placeholder="e.g. Sale Or Popular etc..">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>SKU</label>
                                        <input type="text" class="form-control" name="sku_id" value="{{old('sku_id')}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Stock</label>
                                        <select name="stock" class="select2" style="width: 100%">
                                            <option value="1">In-Stock</option>
                                            <option value="0">Out-Stock</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Weight</label>
                                        <input type="text" class="form-control" name="weight" value="{{old('weight')}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Weight Type</label>                                    
                                        <select class="form-control" name="weight_type">
                                            <option value="">Choose Weight Type</option>
                                            <option value="kg">KG</option>
                                            <option value="gm">GM</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="validationTooltip01">Deminsions</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="length" placeholder="Length" value="{{old('length')}}">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="width" value="{{old('width')}}" placeholder="Width">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="height" value="{{old('height')}}" placeholder="Height">
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mt-3">
                                        <label for="formFileFeatureSize" class="form-label">Size Chart Picture <code></code></label>
                                        <input class="form-control"  type="file" id="formFileFeatureSize" name="size_chart">
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Category</h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label></label>
                                        @if(!empty($category_main))
                                        <ul class="list-unstyled mb-0 mt-1">
                                        @foreach($category_main as $cat)
                                        <li class=" mr-2 mb-1">
                                            <fieldset>
                                                <div class="checkbox">
                                                    <input type="checkbox" name="category[]"  class="checkbox-input" value="{{$cat->id}}"  id="var_{{$cat->id}}">
                                                <label for="var_{{$cat->id}}">{{$cat->name}}</label>
                                                </div>
                                            </fieldset>
                                            <ul class="list-unstyled mb-0 mt-1 child ml-4">
                                                @php $child_cat_arr  = category_main_parent_menu($cat->id); @endphp
                                                @if(!empty($child_cat_arr))
                                                @foreach($child_cat_arr as $child_cat)
                                                <li class=" mr-e mb-1 ms-3">
                                                    <fieldset>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" value="{{$child_cat->id}}" name="category[]" id="var_sub_{{$child_cat->id}}">
                                                            <label for="var_sub_{{$child_cat->id}}">{{$child_cat->name}}</label>
                                                        </div>
                                                    </fieldset>

                                                    @php $sub_child_cat_arr  = category_child_parent_menu($cat->id,$child_cat->id); @endphp
                                                    @if(!empty($sub_child_cat_arr))
                                                    <ul class="list-unstyled mb-0 mt-1 child ml-4">
                                                        @foreach($sub_child_cat_arr as $child_cat)
                                                        <li class=" mr-e mb-1 ms-3">
                                                            <fieldset>
                                                                <div class="checkbox">
                                                                    <input type="checkbox" class="checkbox-input" value="{{$child_cat->id}}" name="category[]" id="var_sub_{{$child_cat->id}}">
                                                                    <label for="var_sub_{{$child_cat->id}}">{{$child_cat->name}}</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    @endif

                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>

                                        @endforeach
                                        @endif

                                        @if(!empty($category_individual))
                                        @foreach($category_individual as $child_cat)
                                        <li class="mr-2 mb-1">
                                            <fieldset>
                                                <div class="checkbox">
                                                    <input type="checkbox" class="checkbox-input" value="{{$child_cat->id}}" name="category[]" id="var_sub_{{$child_cat->id}}">
                                                    <label for="var_sub_{{$child_cat->id}}">{{$child_cat->name}}</label>
                                                </div>
                                            </fieldset>
                                        </li>
                                        @endforeach
                                        @endif
                                        </ul>

                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Product Gallery</h4>

                            <div class=" mt-4">
                                <div id="my-awesome-dropzone" class="dropzone">
                                    <div class="fallback">
                                        <input name="file" type="file" multiple="multiple">
                                    </div>
                                    <div class="dz-message needsclick">
                                        <div class="mb-3">
                                            <i class="display-4 fas fa-cloud-upload-alt"></i>
                                        </div>

                                        <h4>Drop files here or click to upload.</h4>
                                    </div>
                                </div>
                                <div id="multi_cont"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">MFG. Region</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>City/Distt. <code>*</code></label>
                                        <input type="text" class="form-control " name="mfg_distt" value="{{old('mfg_distt')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>State <code>*</code></label>
                                        <input type="text" class="form-control " name="mfg_state" value="{{old('mfg_state')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Country <code>*</code></label>
                                        <input type="text" class="form-control " name="mfg_country" value="{{old('mfg_country')}}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">SEO - Details</h4>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Title <code>*</code> </label>
                                        <input type="text" required class="form-control" name="seo[title]" value="{{old('seo[title]')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Keywords <code>*</code> </label>
                                        <input type="text" class="form-control" name="seo[keywords]" value="{{old('seo[keywords]')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Description <code>*</code></label>
                                        <textarea class="form-control" name="seo[description]" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Canonical URL </label>
                                        <input type="text" class="form-control"  name="seo[canonical_url]">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Product Status</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Status <code>*</code> </label>
                                        <select class="form-control" name="status">
                                            <option value="0">Pending</option>
                                            <option value="1">Publish</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @csrf
                    <button type="" class="btn btn-primary w-md mb-2">Create</button>
                    
                </form>

           
       
    </div>
</div>
@endsection

@section('footerScript')
<script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('assets/pages/jquery.validation.init.js') }}"></script>
<script src="{{ URL::asset('/assets/dropzone/dropzone.min.js') }}"></script>

<script src="{{ URL::asset('/assets/plugins/tinymce/tinymce.min.js')}}"></script>
<script src="{{ URL::asset('/assets/pages/jquery.form-editor.init.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript">
    Dropzone.autoDiscover = false;
    $(document).ready(function() {
        $(".select2").select2({
            width: '100%'
        });
        $("#Store").addClass('active');
        $('a[href="#Store"]').addClass('active');
        $("#product").addClass('active');

        /*****Dropzone******/
        var slug ='';
        /*Dropzone*/
        var obj = new Dropzone("div#my-awesome-dropzone",{
            url: '/ajax/ajax-upload',
            addRemoveLinks: true,
            maxFiles: 20,
            paramName:'myfile',
            acceptedFiles:'image/*',
            sending: function(file, xhr, formData) {
                //formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                formData.append("directory", 'product');
            },
        });
        obj.on("addedfile", function(file){
            //$("#sbt").attr("disabled",'disabled');
        });
        obj.on("maxfilesexceeded", function(file){
            this.removeFile(file);
        });

        obj.on("success", function(file, responseText) {
            if(responseText!=""){
                file.serverId = responseText;
                var n=responseText.indexOf(".");
                var idinfo=responseText.substr(0,n)+'"';
                $("#multi_cont").append("<input type='hidden' id="+idinfo+" name='gallery_picture[]' value="+responseText+"/>");
            }
            if (obj.getUploadingFiles().length === 0 && obj.getQueuedFiles().length === 0) {
                    $("#sbt").removeAttr("disabled");
            }
        });

        obj.on("removedfile", function(file) {
            var str=file.serverId;
            var filesend = file.serverId;
            var n=str.indexOf(".");
            var idinfo=str.substr(0,n);
            imgid = idinfo.replace('"', "");
            img_val = filesend.replace('"',"");
            img_val = img_val.replace('"',"");
            console.log("RText " +img_val);
            $("#"+imgid).remove();

            $.ajax({
                type:"post",
                data:"op="+img_val+"&directory=product",
                url:slug+"/ajax/ajax-delete",
                success:function(data){
                }
            });
        });

        $(".remove_picture").click(function(){
            console.log("Run");
            var $this = $(this);
            $.ajax({
                type:"post",
                data:'name='+$this.attr('data-id')+"&action=product",
                url:"/ajax/picture-delete",
                success:function(data){
                    $this.parent().parent().remove();
                }
            });
        });

    });
</script>

@endsection
