@extends('layouts.master')

@section('title') My Profile @endsection
@section('css')
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

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Profile</a>
                    </li>                                                
                    
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active p-3" id="home" role="tabpanel">
                        <form class="needs-validation" novalidate method="post" action="{{ route('merchant.my_profile_save',$r->id) }}"  enctype="multipart/form-data">


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>First Name <code>*</code></label>
                                        <input type="text" class="form-control" name="name" required value="{{ old('name', $r->name) }}">
                                        <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formrow-password-input" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $r->last_name) }}"  >
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>E-Mail <code>*</code></label>
                                        <input type="email" class="form-control" name="email" required value="{{ old('email', $r->email) }}">
                                        <span class="text-danger">{{ $errors->first('email', ':message') }}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label  class="form-label">Telephone</label>
                                        <input type="text" class="form-control" name="phone" value="{{ old('phone', $r->phone) }}"  >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" required value="{{ old('address', $r->address) }}">

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label  class="form-label">Zipcode</label>
                                        <input type="text" class="form-control" name="zipcode" value="{{ old('zipcode', $r->zipcode) }}"  >
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

                                @if($r->picture!="")
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <img class="thumb-xl rounded-circle" src="{{ asset('uploads/profile/'.$r->picture) }}">
                                    </div>
                                </div>
                                @endif
                            </div>

                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>New Password </label>
                                        <input type="password" class="form-control" name="new_password" required >
                                        <span class="text-danger">{{ $errors->first('new_password', ':message') }}</span>
                                    </div>
                                </div>
                            </div>
                            <button type="" class="btn btn-primary w-md mb-2">Update Profile</button>
                            <div>

                            </div>
                        </form>
                    </div>

                    <div class="tab-pane p-3" id="profile" role="tabpanel">
                        <form class="needs-validation" novalidate method="post" action="{{ route('merchant.my_profile_personal_save',$r->id) }}"  enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Name <code>*</code></label>
                                        <input type="text" class="form-control" name="name" required value="{{ old('name', $r->name) }}">
                                        <span class="text-danger">{{ $errors->first('name', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formrow-password-input" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email', $r->email) }}"  >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Trading Name <code>*</code></label>
                                        <input type="text" class="form-control" name="trading_name" required value="{{ old('trading_name', $r->name) }}">
                                        <span class="text-danger">{{ $errors->first('trading_name', ':message') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Registration Number <code>*</code></label>
                                        <input type="text" class="form-control" name="registration_number" required value="{{ old('registration_number', $r->registration_number) }}">
                                        <span class="text-danger">{{ $errors->first('registration_number', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Registeration Date</label>
                                        <input type="text" class="form-control " name="registration_date" value="{{ old('registration_date', $r->registration_date) }}"  >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>VAT Number <code>*</code></label>
                                        <input type="text" class="form-control" name="vat_number" required value="{{ old('vat_number', $r->vat_number) }}">
                                        <span class="text-danger">{{ $errors->first('vat_number', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Hold Code</label>
                                        <input type="text" class="form-control " name="hold_code" value="{{ old('hold_code', $r->hold_code) }}"  >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Address <code>*</code></label>
                                        <input type="text"  class="form-control" name="address" required value="{{ old('address', $r->address) }}">
                                        <span class="text-danger">{{ $errors->first('address', ':message') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Post Code <code>*</code></label>
                                        <select class="form-control" name="postcode_id">
                                            <option value="">Choose</option>
                                            <option value="1">147001</option>
                                            <option value="2">147002</option>
                                            <option value="3">147003</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Mailing Address</label>
                                        <input type="text" class="form-control " name="mailing_address" value="{{ old('mailing_address', $r->mailing_address) }}"  >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Registration Type <code>*</code></label>
                                        <select class="form-control" name="registration_type">
                                            <option value="">Choose</option>
                                            <option value="Company">Company</option>
                                            <option value="Firm">Firm</option>
                                            <option value="Shop">Shop</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control " name="phone_number" value="{{ old('phone_number', $r->phone_number) }}"  >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Logo <code>*</code></label>
                                        <div class="custom-file mb-3">
                                            <input type="file" name="logo" class="custom-file-input" required id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                @if($r->logo!="")
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <img class="thumb-xl rounded-circle" src="{{ asset('uploads/profile/'.$r->logo) }}">
                                    </div>
                                </div>
                                @endif
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Website</label>
                                        <input type="text" class="form-control " name="website" value="{{ old('website', $r->website) }}"  >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Currency </label>
                                        <select class="form-control" name="currency">
                                            <option value="">Choose</option>
                                            <option value="USD">USD</option>
                                            <option value="POUND">POUND</option>                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>KYC Reference</label>
                                        <input type="text" class="form-control " name="kyc_reference" value="{{ old('kyc_reference', $r->kyc_reference) }}"  >
                                    </div>
                                </div>
                            </div>
                            @csrf
                            <button type="" class="btn btn-primary w-md mb-2">Update Profile</button>

                        </form>
                    </div>
                </div>
                
                

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
