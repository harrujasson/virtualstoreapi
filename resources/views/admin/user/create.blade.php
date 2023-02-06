@extends('layouts.master')

@section('title') {{$title}} @endsection
@section('headerStyle')  
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('title') New @endslot
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

                <form class="form-parsley" novalidate method="post" action="{{ route('admin.user.create') }}"  enctype="multipart/form-data">


                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Name <code>*</code></label>
                                <input type="text" class="form-control" name="name" required value="{{ old('name') }}">
                                <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formrow-password-input" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}"  >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>E-Mail <code>*</code></label>
                                <input type="email" class="form-control" name="email" required value="{{ old('email') }}">
                                <span class="text-danger">{{ $errors->first('email', ':message') }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label  class="form-label">Telephone</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}"  >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label>Street Address <code>*</code></label>
                                <textarea class="form-control" name="street" required >{{ old('street') }}</textarea>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label>Address <code>*</code></label>
                                <textarea class="form-control" name="address" required >{{ old('address') }}</textarea>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label  class="form-label">City <code>*</code></label>
                                <input type="text" class="form-control" name="city" value="{{ old('city') }}"  >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label  class="form-label">State <code>*</code></label>
                                <input type="text" class="form-control" name="state" value="{{ old('state') }}"  >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label  class="form-label">Country <code>*</code></label>
                                <input type="text" class="form-control" name="country" value="{{ old('country') }}"  >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label  class="form-label">Zipcode</label>
                                <input type="text" class="form-control" name="zipcode" value="{{ old('zipcode') }}"  >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Profile Picture</label>
                                <input class="form-control" name="picture" type="file" id="formFile">
                            </div>
                        </div>    
                    </div>

                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Password <code>*</code></label>
                                <input type="password" class="form-control" name="password" required >
                                <span class="text-danger">{{ $errors->first('password', ':message') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Status <code>*</code></label>
                                <select class="form-control" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">De-Active</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="" class="btn btn-primary w-md mb-2">Create</button>
                    
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
        
        $("#Clients").addClass('active');
        $('a[href="#Clients"]').addClass('active');
        $("#client_new").addClass('active');
    });
</script>

@endsection
