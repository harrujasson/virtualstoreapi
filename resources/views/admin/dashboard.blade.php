@extends('layouts.master')

@section('title') My Profile @endsection
@section('headerStyle')    
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('title') View @endslot
        @slot('item1') Admin @endslot
        @slot('item2') Dashboard @endslot
    @endcomponent

    <div class="row mt-5">
    @component('components.crm-widget')
        @slot('iconClass') align-self-center icon-lg icon-dual-danger  @endslot
        @slot('title') Pending Orders  @endslot
        @slot('cost') 90 @endslot
        @slot('progressCost') 55 @endslot
        @slot('progressClass') progress-bar bg-danger @endslot
    @endcomponent
    @component('components.crm-widget')
        @slot('iconClass') align-self-center icon-lg icon-dual-warning  @endslot
        @slot('title') Processing  @endslot
        @slot('cost') 65K @endslot
        @slot('progressCost') 55 @endslot
        @slot('progressClass') progress-bar bg-warning @endslot
    @endcomponent
    @component('components.crm-widget')
        @slot('iconClass') align-self-center icon-lg icon-dual-success  @endslot
        @slot('title') Completed  @endslot
        @slot('cost') 85K @endslot
        @slot('progressCost') 70 @endslot
        @slot('progressClass') progress-bar bg-warning @endslot
    @endcomponent
    @component('components.crm-widget')
        @slot('iconClass') align-self-center icon-lg icon-dual-danger  @endslot
        @slot('title') Rejected  @endslot
        @slot('cost') 10K @endslot
        @slot('progressCost') 70 @endslot
        @slot('progressClass') progress-bar bg-danger @endslot
    @endcomponent
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
