@extends('layouts.master')

@section('title') {{$title}} @endsection
@section('headerStyle')  
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('title') Edit @endslot
        @slot('item1') Admin @endslot
        @slot('item2') {{$title}} @endslot
    @endcomponent



<div class="row">
    <div class="col-lg-8 col-md-12 mx-auto">

        <div class="card">
            <div class="card-body">
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

                <form class="form-parsley" novalidate method="post" action="{{ route('admin.category.edit_update',[get_route_url(),$r->id]) }}"  enctype="multipart/form-data">
                    @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Choose Cateogry Type <code>*</code></label>
                                    <select class="form-control type_category" name="type" required>
                                        <option value="">Choose type</option>
                                        <option value="Main" {{ ($r->type == "Main" ? "selected":"") }}>Main</option>
                                        <option value="Parent" {{ ($r->type == "Parent" ? "selected":"") }}>Parent</option>
                                        <option value="Normal" {{ ($r->type == "Normal" ? "selected":"") }}>Normal</option>
                                        <option value="Individual" {{ ($r->type == "Individual" ? "selected":"") }}>Individual</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 main_cateogry">
                                <div class="mb-3">
                                    <label>Main Category </label>
                                    <select class="form-control main_cat" name="main">
                                        <option value="">Select Parent</option>
                                        @if(!empty($main_category))
                                            @foreach($main_category as $cat)
                                            <option value="{{$cat->id}}" {{ ($r->main == $cat->id ? "selected":"") }}>{{$cat->name}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 parent_cateogry">
                                <div class="mb-3">
                                    <label>Parent </label>
                                    <select class="form-control parent_cat" name="parent">
                                        <option value="">Select Parent</option>
                                        @if(!empty($category))
                                            @foreach($category as $cat)
                                            <option value="{{$cat->id}}" {{($r->parent == $cat->id ? "selected":"")}}>{{$cat->name}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Name <code>*</code></label>
                                    <input type="text" class="form-control" name="name" required value="{{ old('name',$r->name) }}">
                                    <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Desktop Banner Picture </label>
                                    <input type="file" name="desktop_picture" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Mobile Banner Picture </label>
                                    <input type="file" name="mobile_picture" class="form-control">
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            @if($r->desktop_picture!="")
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <img class="img-thumbnail thumb-xxl " src="{{asset('uploads/category/'.$r->desktop_picture)}}" class="thumbnail">
                                </div>
                            </div>
                            @endif

                            @if($r->mobile_picture!="")
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <img class="img-thumbnail thumb-xxl " src="{{asset('uploads/category/'.$r->mobile_picture)}}" class="thumbnail">
                                </div>
                            </div>
                            @endif
                        </div> 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="">Desktop Feature Picture </label>
                                    <input type="file" name="picture" class="form-control">
                                </div>
                            </div>
                            @if($r->picture!="")
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <img class="img-thumbnail thumb-xxl " src="{{asset('uploads/category/'.$r->picture)}}" class="thumbnail">
                                </div>
                            </div>
                            @endif
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Status  <code>*</code>  </label>
                                    <select class="form-control" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="1" {{($r->status == 1 ? "selected":"")}}>Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    
                    <button type="" class="btn btn-primary w-md mb-2">Update</button>
                    
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('footerScript')
<script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('assets/pages/jquery.validation.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        
        $("#Store").addClass('active');
        $('a[href="#Store"]').addClass('active');
        $("#category").addClass('active');

        $(".type_category").change(function(){
            var $this = $(this);
            if($this.val() == "Main"){
                $(".main_cateogry select").attr('disabled','disabled');
                $(".parent_cateogry select").attr('disabled','disabled');
                $(".main_cateogry select").removeAttr('required');
                $(".parent_cateogry select").removeAttr('required');
            }else if($this.val() == "Parent"){
                $(".parent_cateogry select").attr('disabled','disabled');
                $(".main_cateogry select").removeAttr('disabled');
                $(".main_cateogry select").attr('required','required');
                $(".parent_cateogry select").removeAttr('required');
            }else if($this.val() == "Individual"){
                $(".parent_cateogry select").attr('disabled','disabled');
                $(".main_cateogry select").attr('disabled','disabled');
                $(".main_cateogry select").removeAttr('required');
                $(".parent_cateogry select").removeAttr('required');
            }else if($this.val() == "Normal"){
                $(".parent_cateogry select").removeAttr('disabled');
                $(".main_cateogry select").removeAttr('disabled');
                $(".main_cateogry select").attr('required','required');
                $(".parent_cateogry select").attr('required','required');
            }
        });

        $(".main_cat").change(function(){
            set_parent_cat($(this).val());
        });
        $(".type_category").change(function(){
            set_parent_cat($(".main_cat").val());
        });

        function set_parent_cat(val){
            $(".parent_cat").html('<option value="">Select Parent</option>');
            if(val!=null){
                $.ajax({
                    type:'GET',
                    data:'id='+val,
                    url:'/get-parent-category',
                    dataType:'json',
                    success:function(obj){
                        var html = '<option value="">Select Parent</option>';
                        if(obj.length > 0 ){
                            for (var i = 0; i < obj.length; i++) {
                                //console.log(obj[i].name);
                                html+='<option value="'+obj[i].id+'">'+obj[i].name+'</option>';
                            }
                        }
                        $(".parent_cat").html(html);
                    }
                });

            }

        }
    });


</script>

@endsection
