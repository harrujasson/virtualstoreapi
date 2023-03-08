@extends('layouts.front')

@section('title') Category @endsection
@section('css')
@endsection
@section('content')

<!-- breadcrumb-area -->

@if($catinfo->desktop_picture!= "")
<section class="breadcrumb-area breadcrumb-bg desktop_banner" data-background="">
   
   <img src="{{asset('uploads/category/'.$catinfo->desktop_picture)}}"  class="banner_img_top">
    <div class="container">
        <div class="row">
            <div class="col-12">              
            </div>
        </div>
    </div>
</section>
@else
<section class="breadcrumb-area breadcrumb-bg desktop_banner" data-background="{{ asset('assets/front/img/bg/shop_image.avif') }}">
   
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2>{{$catname}}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            @if($catMain!="")
                            <li class="breadcrumb-item"><a href="{{route('category',$catMainSlug)}}">{{$catMain}}</a></li>
                            @endif
                            <li class="breadcrumb-item active" aria-current="page">{{$catname}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($catinfo->mobile_picture != "")
<section class="breadcrumb-area breadcrumb-bg mobile_banner" data-background="{{asset('uploads/category/'.$catinfo->mobile_picture)}}">
   
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2>{{$catname}}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
                            @if($catMain!="")
                            <li class="breadcrumb-item"><a href="{{route('category',$catMainSlug)}}">{{$catMain}}</a></li>
                            @endif
                            <li class="breadcrumb-item active" aria-current="page">{{$catname}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@else
<section class="breadcrumb-area breadcrumb-bg mobile_banner" data-background="{{ asset('assets/front/img/bg/shop_image.avif') }}">
   
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h2>{{$catname}}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
                            @if($catMain!="")
                            <li class="breadcrumb-item"><a href="{{route('category',$catMainSlug)}}">{{$catMain}}</a></li>
                            @endif
                            <li class="breadcrumb-item active" aria-current="page">{{$catname}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- breadcrumb-area-end -->

<!-- shop-area -->
<nav aria-label="breadcrumb" class="catname">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
        @if($catMain!="")
        <li class="breadcrumb-item"><a href="{{route('category',$catMainSlug)}}">{{$catMain}}</a></li>
        @endif
        <li class="breadcrumb-item active" aria-current="page">{{$catname}}</li> 
    </ol>
</nav>
<section class="shop-area pt-100 pb-100">

    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="shop-top-meta mb-35">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="shop-top-left">
                                <ul>
                                    <li><a href="#"><i class="flaticon-menu"></i> FILTER</a></li>
                                    <li>Showing {{$products->currentPage()}}-{{$products->lastPage()}} of {{$products->total()}} results </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="shop-top-right">
                                <form action="" method="get" id='sort_form' >
                                    <select class="nice-select sort_ele" name="sortby">
                                        <option value="latest" {{($sort == "latest" ? "selected":"")}}>Sort By Latest</option>
                                        <option value="title_asc" {{($sort == "title_asc" ? "selected":"")}}>Sort By Name (A - Z)</option>
                                        <option value="title_desc" {{($sort == "title_desc" ? "selected":"")}}>Sort By Name (Z - A)</option>
                                        <option value="price_asc" {{($sort == "price_asc" ? "selected":"")}}>Sort By Price (Low > High)</option>
                                        <option value="price_desc" {{($sort == "price_desc" ? "selected":"")}}>Sort By Price (Hight > Low)</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-xl-4 col-sm-12">
                        @include('front.product.loop', ['product' => $product,'container'=>'col-12 col-lg-3 col-md-6'])
                    </div>
                    @endforeach

                </div>
                <div class="pagination-wrap">
                    {{ $products->appends(['sortby' => $sort])->links() }}
                </div>
            </div>
            
        </div>
    </div>
</section>
<!-- shop-area-end -->
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('.sort_ele').change(function(){
            filterform();
        });
        function filterform(){
            $("#sort_form").submit();
        }
    });
</script>
@endsection
