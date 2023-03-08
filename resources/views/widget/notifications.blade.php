@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible fade show">

    <strong>Sucess: </strong> {!! $message !!}
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissable fade show">

    <strong>Error: </strong> {!! $message !!}
</div>
@endif


@if ($message = Session::get('warning'))
<div class="alert alert-danger alert-dismissable fade show">

    <strong>Warning: </strong> {{ $message }}
</div>
@endif
@if ($message = Session::get('information'))
<div class="alert alert-info alert-dismissable fade show">

    <strong>Information: </strong> {{ $message }}
</div>
@endif

