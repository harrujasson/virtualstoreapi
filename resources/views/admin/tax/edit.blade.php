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

                <form class="needs-validation" novalidate method="post" action="{{ route('admin.tax.edit_update',[get_route_url(),$r->id]) }}"  enctype="multipart/form-data">

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
                                    <label>Rate <code>*</code></label>
                                    <input type="text" class="form-control" name="rate" required value="{{ old('rate',$r->rate) }}">
                                    <span class="text-danger">{{ $errors->first('rate', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Status <code>*</code></label>
                                    <select class="form-control" name="status">
                                        <option value="1" {{{($r->status == "1" ? "selected":"")}}}>Active</option>
                                        <option value="0" {{{($r->status == "0" ? "selected":"")}}}>De-Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @csrf
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
        $("#tax").addClass('active');
    });
</script>

@endsection
