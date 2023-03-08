@extends('layouts.front')

@section('title') Payment Status @endsection
@section('css')
@endsection
@section('content')

<!-- breadcrumb-area-end -->
<section class="shop-details-area pt-100 pb-95">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="search-error-wrapper">
                        <h1>Cancel</h1>
                        <h2>Transaction has been cancelled.</h2>
                        <p>Try again.</p>
                        <a href="{{route('shop')}}" class="home-bacck-button">Continue Shop</a>
                    </div>
                </div>
            </div>
        </div>
</section>
@stop
@section('script')
@stop

