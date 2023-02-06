@extends('layouts.master')

@section('title') Wishlist @endsection
@section('headerStyle')  
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('title') List @endslot
        @slot('item1') Customer @endslot
        @slot('item2') {{$title}} @endslot
    @endcomponent

<div class="row">
    <div class="col-lg-10 col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-5">{{$title}}</h4>
                
                @include('widget/notifications')
                <table  class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Product</th>
                            <th>Unit Price</th>
                            <th>Stock Status</th>
                            <th>Add to cart</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$record->isEmpty())
                        @foreach($record as $p)
                        @if(!empty($p->products))
                        <tr>
                            <td style="width: 100px;">
                                @if($p->products->feature_picture!="")
                                <a href="{{route('product_show',$p->products->slug)}}" target="_blank">
                                    <img src="{{asset('uploads/product/'.$p->products->feature_picture)}}" class="avatar-md h-auto d-block rounded">
                                </a>
                                @endif
                            </td>
                            <td>
                                <h5 class="font-size-13 text-truncate mb-1">
                                    <a href="{{route('product_show',$p->products->slug)}}" target="_blank" class="text-dark">{{$p->products->title}}</a>
                                </h5>
                            </td>
                            <td>{!! currency() !!}
                                @if($p->products->sale_price!='')
                                <span class="amount">{{number_format($p->products->sale_price,2)}}</span>
                                @else
                                <span class="amount">{{number_format($p->products->regular_price,2)}}</span>
                                @endif
                            </td>
                            <td>
                                @if($p->products->stock)
                                <span class="badge badge-pill badge-soft-success font-size-15">in stock</span>
                                @else
                                <span class="badge badge-pill badge-soft-danger font-size-15">out stock</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('product_show',$p->products->slug)}}"><i class="dripicons-cart"></i></a>
                            </td>
                            <td>
                                <a href="{{route('customer.wishlist_remove',$p->products->id)}}"><i class="dripicons-cross"></i></a>
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="6">No item found</td>
                        </tr>
                        @endif
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6">No item found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footerScript')

<script type="text/javascript">
    $(document).ready(function() {
        $("#Dashboard").addClass('active');
        $('a[href="#Dashboard"]').addClass('active');
        $("#wishlist").addClass('active');
    });
</script>

@endsection
