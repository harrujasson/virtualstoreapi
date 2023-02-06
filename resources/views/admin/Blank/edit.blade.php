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

                <form class="needs-validation" novalidate method="post" action="{{ route('admin.tax.edit_update',$r->id) }}"  enctype="multipart/form-data">

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
        
        $("#Clients").addClass('active');
        $('a[href="#Clients"]').addClass('active');
        $("#client_manage").addClass('active');
    });
</script>

@endsection
