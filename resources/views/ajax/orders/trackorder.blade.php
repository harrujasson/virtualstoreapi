<link rel="stylesheet" href="{{ URL::asset('/assets/libs/owl.carousel/owl.carousel.min.css') }}">

<div class="panel panel-info">
    <div class="panel-body">
        <h3 class="display-8 mb-5">Order Tracking  Status</h3>
        @if(!empty($tracking))
        <div class="">
            <ul class="verti-timeline list-unstyled">
                @foreach($tracking as  $value)
                <li class="event-list">
                    <div class="event-timeline-dot">
                        <i class="bx bx-right-arrow-circle"></i>
                    </div>
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <i class="bx {{ order_status_icon($value->track_type) }} h2 text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div>
                                <h5>{{ $value->track_type }}</h5>
                                <p>{{ date('d M y',strtotime($value->created_at)) }}</p>
                                <p class="text-muted">{{ $value->track_message }}</p>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        @else
        <p>No update available</p>
        @endif

    </div>
</div>


@section('script')
<!-- owl.carousel js -->
<script src="{{ URL::asset('/assets/libs/owl.carousel/owl.carousel.min.js') }}"></script>

<!-- timeline init js -->
<script src="{{ URL::asset('/assets/js/pages/timeline.init.js') }}"></script>
@endsection
