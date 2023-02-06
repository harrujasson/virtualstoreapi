@extends('layouts.master')

@section('title') My Profile @endsection
@section('headerStyle')
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('title') Edit @endslot
        @slot('item1') Merchant @endslot
        @slot('item2') My Profile @endslot
    @endcomponent



<div class="row">
    <div class="col-lg-8 col-md-12 mx-auto">

        <div class="card">
            <div class="card-body">
                @include('widget/notifications')

                <div class="row">
                    <div class="col-md-6"><h3>User Details</h3></div>
                </div>
                <form class="form-parsley" novalidate method="post" action="{{ route('merchant.my_profile_save',$r->id) }}"  enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>New Password </label>
                                <input type="password" id="pass2" class="form-control" name="new_password" required >
                                <span class="text-danger">{{ $errors->first('new_password', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Confirm Password </label>
                                <input type="password" data-parsley-equalto="#pass2" class="form-control" name="new_password" required >
                                <span class="text-danger">{{ $errors->first('new_password', ':message') }}</span>
                            </div>
                        </div>
                    </div>
                    <button type="" class="btn btn-primary w-md mb-2">Update Profile</button>
                </form>
                

            </div>
        </div>
    </div>
</div>
@endsection

@section('footerScript')
<!-- Parsley js -->
<script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
<script src="{{ URL::asset('assets/pages/jquery.validation.init.js')}}"></script>


<script src="{{ URL::asset('assets/js/jquery.core.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        
        $("#Dashboard").addClass('active');
        $('a[href="#Dashboard"]').addClass('active');
        $("#my_profile").addClass('active');
    });
</script>
@endsection
