@extends('layouts.master')

@section('title') Packages @endsection
@section('headerStyle')    
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('title') Packages @endslot
        @slot('item1') Merchant @endslot
        @slot('item2') Dashboard @endslot
    @endcomponent

    <div class="row m-4">
        
        @if(!empty($record))
        @foreach($record as $r)
        @component('components.pricing')
        <?php 
            $price = currency().number_format($r->regular_price,2);
            if($r->sale_price != ""){
                $price = currency().number_format($r->sale_price,2);
                $price.= ' <del class="text-muted font-10">  '.currency().number_format($r->regular_price,2).'</del>';                
            }

            if($r->duration == "30"){
                $duration = 'Month';
            }elseif($r->duration == "365"){
                $duration = 'Year';
            }
        ?>
                @slot('title') {{$r->name}} @endslot
                @slot('price') {!! $price !!} @endslot
                @slot('per') {{$duration}} @endslot
                @slot('service') {!! $r->service_id !!} @endslot
                @slot('details') {!! $r->details !!} @endslot
                @slot('popular') {{$r->flash}} @endslot
                @slot('package_active') {{is_active_package(Auth::id(),$r->id)}} @endslot
                @slot('id') {{$r->id}} @endslot
        @endcomponent
        @endforeach
        @endif
    </div>
@endsection

@section('footerScript')
<script type="text/javascript">
    $(document).ready(function() {
        
        $("#Dashboard").addClass('active');
        $('a[href="#Dashboard"]').addClass('active');
        $("#package").addClass('active');
    });
</script>
@endsection
