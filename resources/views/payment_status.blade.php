@extends('layouts.master')

@section('title') My Profile @endsection
@section('headerStyle')    
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('title') Status @endslot
        @slot('item1') Transaction @endslot
        @slot('item2') Dashboard @endslot
    @endcomponent

    <div class="row mt-5">
        <div class="col-lg-8 mx-auto">
            @if($status == 1 && $payment == "Paid")
            <div class="alert alert-outline-success" role="alert">
                <strong>Transaction:</strong> Plan has been purchased successfully!
            </div>
            @elseif($status == 1&& $payment != "Paid")
            <div class="alert alert-outline-danger" role="alert">
                <strong>Transaction:</strong> Your transaction has been failed.
            </div>
            @elseif($status == 0)
            <div class="alert alert-outline-danger" role="alert">
                <strong>Transaction:</strong> Your transaction has been failed.
            </div>
            @elseif($status == 2)
            <div class="alert alert-outline-danger" role="alert">
                <strong>Transaction:</strong> Your transaction not proccessed.
            </div>
            @endif
        </div>
        
    </div>
@endsection

@section('footerScript')
<script type="text/javascript">
    $(document).ready(function() {
        
        $("#Dashboard").addClass('active');
        $('a[href="#Dashboard"]').addClass('active');
        $("#dashboard").addClass('active');
    });
</script>
@endsection
