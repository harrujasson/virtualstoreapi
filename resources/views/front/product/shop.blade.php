@extends('layouts.front')

@section('title') Shop @endsection
@section('css')
@endsection
@section('content')
<!-- breadcrumb-area-end -->
<section>
    <div class=" banner-wrapper home-banner">
        <div class="banner-wrapper-height">
            <div class="banner-wrapper-image">
                <img src="{{asset('assets/front/images/cart-bg.jpg')}}" alt="Banner">
            </div>
        </div>
    </div>
</section>

<!-- shop-area -->
<section class="shop-area section-padding">
    <div class="shop-top-wrapper mb-4 pt-2 pb-2">
        <div class="container">
            <div class="shop-top-meta mb-35">
                <div class="row ">
                    <div class="col-md-6">
                        <div class="shop-top-left">
                            <ul>
                                <li><a href="#"><i class="flaticon-menu"></i> FILTER</a></li>
                                <li>Showing {{$products->currentPage()}}-{{$products->lastPage()}} of
                                    {{$products->total()}} results </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 my-auto">
                        <div class="shop-top-right">
                            <form action="" method="get" id='sort_form'>
                                <select class="nice-select sort_ele form-control" name="sortby">
                                    <option value="latest" {{($sort == "latest" ? "selected":"")}}>Sort By Latest
                                    </option>
                                    <option value="title_asc" {{($sort == "title_asc" ? "selected":"")}}>Sort By Name (A
                                        - Z)</option>
                                    <option value="title_desc" {{($sort == "title_desc" ? "selected":"")}}>Sort By Name
                                        (Z - A)</option>
                                    <option value="price_asc" {{($sort == "price_asc" ? "selected":"")}}>Sort By Price
                                        (Low > High)</option>
                                    <option value="price_desc" {{($sort == "price_desc" ? "selected":"")}}>Sort By Price
                                        (High > Low)</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 mx-auto">

                <div class="row">
                    @foreach($products as $product)
                    @include('front.product.loop', ['product' => $product,'container'=>'col-12 col-lg-3 col-md-6  mb-4'])
                    @endforeach
                </div>
                <div class="pagination-wrap">
                    {{ $products->appends(['sortby' => $sort,'search'=>$search])->links() }}
                </div>
            </div>

        </div>
    </div>
</section>
<!-- shop-area-end -->
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $('.sort_ele').change(function () {
            filterform();
        });

        function filterform() {
            $("#sort_form").submit();
        }
    });
</script>
@endsection