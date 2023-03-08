@extends('layouts.master')

@section('title') {{$title}} @endsection
@section('headerStyle') 
<link href="{{ URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css" /> 
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('title') New @endslot
        @slot('item1') Admin @endslot
        @slot('item2') {{$title}} @endslot
    @endcomponent

<div class="row">
    <div class="col-xl-8 mx-auto">
        <div class="card">
            <div class="card-body">
            @include('widget/notifications')
                <form class="custom-validation" novalidate autocomplete="off" method="post" action="{{ route('admin.attribute.edit_update',$r->id) }}"  enctype="multipart/form-data">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Name <code>*</code></label>
                                    <input type="text" class="form-control" name="name" required value="{{ old('name',$r->name) }}">
                                    <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Label <code>*</code></label>
                                    <input type="text" class="form-control" name="label" required value="{{ old('label',$r->label) }}">
                                    <span class="text-danger">{{ $errors->first('label', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Input Type </label>
                                    <select style="width:100%" class="select2" id="input_type" name="type">
                                        <!-- <option value="dropdown" {{($r->type == 'dropdown' ? "selected":"")}}>Dropdown</option> -->
                                        <option value="image" {{($r->type == 'color' ? "selected":"")}}>Color</option>
                                        <!-- <option value="mulitple" {{($r->type == 'mulitple' ? "selected":"")}}>Multi Select</option>
                                        <option value="textfield" {{($r->type == 'textfield' ? "selected":"")}}>Text Field</option>
                                        <option value="textarea" {{($r->type == 'textarea' ? "selected":"")}}>Text Area</option>
                                        <option value="file_upload" {{($r->type == 'file_upload' ? "selected":"")}}>File upload</option>
                                        <option value="checkbox" {{($r->type == 'checkbox' ? "selected":"")}}>Checkbox</option>
                                        <option value="radio" {{($r->type == 'radio' ? "selected":"")}}>Radio</option> -->
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row" style="display:none;">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Parent </label>
                                    <select style="width:100%" class="select2"  name="parent">
                                        <option value="0">Select Parent</option>
                                        @if(!empty($attribute))
                                        @foreach($attribute as $attr)
                                            <option value="{{$attr->id}}" {{($r->parent == $attr->id ? "selected":"")}}>{{$attr->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="mb-4 mt-2">Attribute -  Values</h3>
                            </div>
                        </div>

                        <div id="pre_loaded_html" style="display: none;">
                        
                        <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="mb-4 col-4 mr-4">
                                            <label>Color </label>
                                            <div  class="input-group colorpicker" title="Using input value">
                                                <input type="text" class="form-control input-lg" value="#ffffff" name="attribute[value][]"/>
                                                <span class="input-group-append">
                                                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-5 col-3">
                                            <label>Name </label>
                                            <input type="text" class="form-control" name="attribute[name][]">
                                        </div>
                                        <div class="col-1 remove_heading mt-4"><label></label><button type="button" class="remove_container btn btn-danger btn-xs" ><i class="fa fa-times-circle"></i></button></div>

                                    </div>

                                </div>
                            </div>
                            

                        </div>

                        <div class="load_html" id='sortable'>

                            @if(!empty($values))
                            @foreach($values as $val)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        

                                        <div class="mb-4 col-4 mr-4">
                                            <label>Color </label>
                                            <div  class="input-group colorpicker" title="Using input value">
                                                <input type="text" class="form-control input-lg" value="{{$val->data}}" name="attribute[value][]"/>
                                                <span class="input-group-append">
                                                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3 col-5">
                                            <label>Name </label>
                                            <input type="text" class="form-control" name="attribute[name][]" value="{{$val->name}}">
                                        </div>
                                        <div class="col-1 remove_heading mt-4"><label></label><button type="button" class="remove_container btn btn-danger btn-xs" ><i class="fa fa-times-circle"></i></button></div>

                                    </div>

                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="button" id="more_record" class="btn btn-success btn-xs mb-3">Add more </button>
                        </div>

                        @csrf
                        <button type="" class="btn btn-primary w-md mb-2">Update</button>
                </form>
            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->


</div>

@endsection

@section('footerScript')
<script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('assets/pages/jquery.validation.init.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $("#Store").addClass('active');
        $('a[href="#Store"]').addClass('active');
        $("#attribute").addClass('active');
        $('.colorpicker').colorpicker();


        $(function(){
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
            $(this).inputselector($("#input_type"));
            $(".select2").select2({
                width: '100%'
            });
        });
        $("#attribute_first, #attribute_first > a").addClass("mm-active");
        $("#attribute_second").addClass('mm-show');
        $("#new_attribute, #new_attribute > a").addClass("mm-active");


        function add_record(index_val){
            var clone_data = $("#pre_loaded_html").html();
            $(".load_html").append(clone_data);
            $('.colorpicker').colorpicker();
            if(index_val== "1"){
                $( ".load_html :nth-child(1)" ).find('.remove_heading').hide();
                $( ".load_html :nth-child(1)" ).find('input').attr('required','required');
            }
        }
        $("#more_record").click(function(){
            add_record('');
        });

        $("body").on("click",".remove_container",function(){
           var $this = $(this);
           $this.parent().parent().remove();
        });

        $("#input_type").change(function(){
            var $this = $(this);
            $(this).inputselector($this);
        });

        $.fn.inputselector=function($this){

            if($this.val() == "file_upload"){

                $( ".load_html" ).hide();
                $( ".load_html :nth-child(1)" ).find('input').removeAttr('required');
                $( ".load_html :gt(1)" ).find('input').attr("disabled","disabled");
                $( ".load_html :gt(1)" ).filter('.form-group').hide();

                $( ".load_html :gt(2)" ).find('input').attr("disabled","disabled");
                $( ".load_html :gt(2)" ).filter('.form-group').hide();

                $("#more_record").hide();
            }else if($this.val() == "textfield"){
                $( ".load_html" ).show();
                $( ".load_html :nth-child(1)" ).find('input').attr('required','required');

                $( ".load_html :nth-child(1)" ).find('.remove_heading').hide();
                $( ".load_html :gt(2)" ).find('input').attr("disabled","disabled");
                $( ".load_html :gt(2)" ).filter('.form-group').hide();
                $("#more_record").hide();
            }else if($this.val() == "textarea"){
                $( ".load_html" ).show();
                $( ".load_html :nth-child(1)" ).find('input').attr('required','required');
                $( ".load_html :nth-child(1)" ).find('.remove_heading').hide();
                $( ".load_html :gt(2)" ).find('input').attr("disabled","disabled");
                $( ".load_html :gt(2)" ).filter('.form-group').hide();
                $("#more_record").hide();
            }else{
                $( ".load_html" ).show();
                $( ".load_html :nth-child(1)" ).find('input').attr('required','required');
                $( ".load_html :nth-child(1)" ).find('.remove_heading').show();
                $( ".load_html :gt(1)" ).find('input').removeAttr("disabled");
                $( ".load_html :gt(1)" ).filter('.form-group').show();
                $( ".load_html :gt(2)" ).find('input').removeAttr("disabled");
                $( ".load_html :gt(2)" ).filter('.form-group').show();
                $("#more_record").show();
            }
        }

    });
</script>

@endsection
