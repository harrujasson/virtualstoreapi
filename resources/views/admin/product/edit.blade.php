@extends('layouts.master')

@section('title') {{$title}} @endsection
@section('headerStyle')
<link href="{{ URL::asset('/assets/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" /> 
<link href="{{ URL::asset('/assets/plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('title') Edit @endslot
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
            <ul class="nav nav-pills nav-justified" role="tablist">
                <li class="nav-item waves-effect waves-light" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#home-1" role="tab" aria-selected="true">Home</a>
                </li>
                <li class="nav-item waves-effect waves-light" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#profile-1" role="tab" aria-selected="false" tabindex="-1">Profile</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane p-3 active show" id="home-1" role="tabpanel">
                    <form class="needs-validation" novalidate method="post" action="{{ route('admin.product.edit_update',$r->id) }}"  enctype="multipart/form-data">

                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label>Title <code>*</code></label>
                                            <input type="text" class="form-control" name="title" required value="{{ old('title',$r->title) }}">
                                            <span class="text-danger">{{ $errors->first('title', ':message') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label>Short Description </label>
                                            <textarea  class="elm1" name="short_description">{{old('short_description',$r->short_description)}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label>Full Description </label>
                                            <textarea  class="elm1" name="description">{{old('description',$r->description)}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label>Purchase Note </label>
                                            <textarea type="text" class="form-control" name="purchase_note">{{old('purchase_note',$r->purchase_note)}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mt-3">
                                            <label for="formFileFeature" class="form-label">Featured Picture <code></code></label>
                                            <input class="form-control"  type="file" id="formFileFeature" name="feature_picture">
                                        </div>
                                    </div>
                                    @if($r->feature_picture!="")
                                    <div class="col-sm-6">
                                        <div class="mt-3">
                                            <img src="{{asset('uploads/product/'.$r->feature_picture)}}" class="img-thumbnail">
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mt-3">
                                            <label for="formFileFeature" class="form-label">Video URL <code></code></label>
                                            <input class="form-control" type="url" name="video_url" value="{{ old('title',$r->video_url) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mt-4">
                                            <h5 class="font-size-14 mb-4"> Additional Settings</h5>
                                            <div>
                                                
                                                <div class="form-check">
                                                    <input class="form-check-input" name="feature" type="checkbox" id="formCheck3" {{($r->feature == "1" ? "checked":"")}}>
                                                    <label class="form-check-label" for="formCheck3">
                                                        Feature
                                                    </label>
                                                </div>
                                            </div>
                                            <div>
                                                
                                                <div class="form-check">
                                                    <input class="form-check-input" name="new_arrival" type="checkbox" id="formCheck4" {{($r->new_arrival == "1" ? "checked":"")}}>
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
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Price <code>*</code> </label>
                                            <input type="text" required class="form-control" name="regular_price" value="{{old('regular_price',$r->regular_price)}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label>Sale Price </label>
                                            <input type="text" class="form-control" name="sale_price" value="{{old('sale_price',$r->sale_price)}}">
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
                                                    <option value="{{$tx->id}}" {{($tx->id == $r->tax_id ? "selected": "")}}>{{$tx->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Product Highlight</label>
                                            <input type="text" class="form-control" name="ribon" value="{{$r->ribon}}" placeholder="e.g. Sale Or Popular etc..">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>SKU</label>
                                            <input type="text" class="form-control" name="sku_id" value="{{old('sku_id',$r->sku_id)}}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Stock</label>
                                            <select name="stock" class="select2" style="width: 100%">
                                                <option value="1" {{($r->stock == "1" ? "selected":"")}}>In-Stock</option>
                                                <option value="0" {{($r->stock == "0" ? "selected":"")}}>Out-Stock</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Weight</label>
                                            <input type="text" class="form-control" name="weight" value="{{old('weight',$r->weight)}}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Weight Type</label>                                    
                                            <select class="form-control" name="weight_type">
                                                <option value="">Choose Weight Type</option>
                                                <option value="kg" {{($r->weight_type == 'kg' ? "selected":"")}}>KG</option>
                                                <option value="gm" {{($r->weight_type == 'gm' ? "selected":"")}}>GM</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="validationTooltip01">Deminsions</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="length" placeholder="Length" value="{{old('length',$r->length)}}">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="width" value="{{old('width',$r->width)}}" placeholder="Width">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="height" value="{{old('height',$r->height)}}" placeholder="Height">
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
                                    @if($r->size_chart!="")
                                    <div class="col-sm-6">
                                        <div class="mt-3">
                                            <img src="{{asset('uploads/product/'.$r->size_chart)}}" class="img-thumbnail">
                                        </div>
                                    </div>
                                    @endif

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


                                            <ul class="list-unstyled mb-0 mt-1">
                                            @if(!empty($category_main))
                                            @foreach($category_main as $cat)
                                            <li class=" mr-2 mb-1">
                                                <fieldset>
                                                    <div class="checkbox">
                                                        <input type="checkbox" name="category[]"  class="checkbox-input" value="{{$cat->id}}"  id="var_{{$cat->id}}" @if(!empty($r->category)) @foreach($r->category as $cate) {{($cate->category_id == $cat->id ? "checked":"")}}  @endforeach @endif>
                                                    <label for="var_{{$cat->id}}">{{$cat->name}}</label>
                                                    </div>
                                                </fieldset>

                                                @php $child_cat_arr  = category_main_parent_menu($cat->id); @endphp
                                                @if(!empty($child_cat_arr))
                                                <ul class="list-unstyled mb-0 mt-1 ml-4">
                                                    @foreach($child_cat_arr as $child_cat)
                                                    <li class=" mr-2 mb-1 ms-3">
                                                        <fieldset>

                                                            <div class="checkbox">
                                                                <input type="checkbox" class="checkbox-input" value="{{$child_cat->id}}" name="category[]" id="var_sub_{{$child_cat->id}}" @if(!empty($r->category)) @foreach($r->category as $cate) {{($cate->category_id == $child_cat->id ? "checked":"")}}  @endforeach @endif>
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
                                                                        <input type="checkbox" class="checkbox-input" value="{{$child_cat->id}}" name="category[]" id="var_sub_{{$child_cat->id}}" @if(!empty($r->category)) @foreach($r->category as $cate) {{($cate->category_id == $child_cat->id ? "checked":"")}}  @endforeach @endif>
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
                                            @foreach($category_individual as $cat)
                                            <li class=" mr-2 mb-1">
                                                <fieldset>
                                                    <div class="checkbox">
                                                        <input type="checkbox" name="category[]"  class="checkbox-input" value="{{$cat->id}}"  id="var_{{$cat->id}}" @if(!empty($r->category)) @foreach($r->category as $cate) {{($cate->category_id == $cat->id ? "checked":"")}}  @endforeach @endif>
                                                    <label for="var_{{$cat->id}}">{{$cat->name}}</label>
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
                                    <div id="multi_cont">
                                        @if($r->gallery_picture !="")

                                            @php $gallery = json_decode($r->gallery_picture); @endphp

                                            <div class="row app-file-recent-access">
                                                @foreach($gallery as $npic)
                                                <div class="col-md-3 col-6 mt-3">
                                                    <div class="card border shadow-none mb-1 app-file-info">
                                                        <div class="card-content">
                                                        <div class="app-file-content-logo card-img-top">

                                                            <img class="img-thumbnail img-top-card" src="{{asset('uploads/product/'.$npic)}}" alt="Picture">
                                                        </div>
                                                        <div class="card-body p-50">
                                                            <div class="app-file-recent-details mx-auto">
                                                            <button type="button" class="btn btn-danger mr-1 mb-1 remove_picture"  data-id="{{$npic}}"><i class="fas fa-trash-alt"></i></button>
                                                            <input type="hidden" name="gallery_picture[]" value="{{$npic}}">
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    @endforeach

                                            </div>
                                            @endif
                                    </div>
                                    <div style="clear: both"></div>
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
                                                <input type="text" class="form-control " name="mfg_distt" value="{{old('mfg_distt',$r->mfg_distt)}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>State <code>*</code></label>
                                                <input type="text" class="form-control " name="mfg_state" value="{{old('mfg_state',$r->mfg_state)}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label>Country <code>*</code></label>
                                                <input type="text" class="form-control " name="mfg_country" value="{{old('mfg_country',$r->mfg_country)}}" required>
                                            </div>
                                        </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">SEO - Details</h4>
                                <?php $seo =  seo_info_get($r->seo_info);   ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label>Title <code>*</code> </label>
                                            <input type="text" required class="form-control" name="seo[title]" value="{{seo_info_fill_field($seo,'title')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label>Keywords <code>*</code> </label>
                                            <input type="text" class="form-control" name="seo[keywords]" value="{{seo_info_fill_field($seo,'keywords')}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label>Description <code>*</code></label>
                                            <textarea class="form-control" name="seo[description]" required>{{seo_info_fill_field($seo,'description')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label>Canonical URL </label>
                                            <input type="text" class="form-control"  name="seo[canonical_url]" value="{{seo_info_fill_field($seo,'canonical_url')}}">
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
                                                <option value="0" {{ ($r->status == 0 ? "selected":"") }}>Pending</option>
                                                <option value="1" {{ ($r->status == 1 ? "selected":"") }}>Publish</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        @csrf
                        <input type="hidden" id="product_id" value="{{$r->id}}">
                        <button type="" class="btn btn-primary w-md mb-2">Update</button>

                    </form>
                </div>
                <div class="tab-pane p-3" id="profile-1" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-5">Review List</h4>
                                   
                                    @include('widget/notifications')
                                    <table  class="table table-bordered dt-responsive w-100" id="datatable-inline">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>email</th>
                                                <th>comment</th>
                                                <th>rating</th>
                                                <th>Publish</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            @foreach($review as $r)
                                                <tr>
                                                    <td>{{ $r->id }}</td>
                                                    <td>{{ $r->name }}</td>
                                                    <td>{{ $r->email}}</td>
                                                    <td>{{ $r->comment }}</td>
                                                    <td>
                                                        @if($r->approve == 1)
                                                        Published
                                                        @else
                                                        Pending
                                                        @endif
                                                    </td>
                                                    <td>{{ $r-> rating}}</td>
                                                    <td>
                                                        @if($r->approve == 0)

                                                        <a href="javascript:void(0);" data-id="{{$r->id}}" data-update="1" class="on-default publish_review"><i class="fas fa-search-plus"></i> Publish</a>
                                                        @else
                                                        <a href="javascript:void(0);" data-id="{{$r->id}}" data-update="0" class="on-default publish_review"><i class="fas fa-search-plus"></i> Un-Publish</a>
                                                        @endif
                                                    <td>
                                                <tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

        $(".nav-link").click(function(){
            $(".nav-link").removeClass('active');
            $(".tab-pane").removeClass('active');
            $(".tab-pane").removeClass('show');
            var $this = $(this);
            $this.addClass('active')
            $($this.attr('href')).addClass('active')
            $($this.attr('href')).addClass(' show')
        })

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
            
            var $this = $(this);
            $.ajax({
                type:"post",
                data:'name='+$this.attr('data-id')+"&action=product",
                url:"/ajax/picture-delete",
                success:function(data){
                    $this.parent().parent().parent().parent().parent().remove();
                }
            });
        });

        $(".publish_review").click(function(){

            var $this = $(this);

            var id = $this.attr('data-id');
            var type = $this.attr('data-update');
            $.ajax({
                type:"get",
                url:'/admin/product/publish-review/'+id+'/'+type,
                success:function(data){
                    location.reload();
                }
            })

        })
    });
</script>

@endsection
