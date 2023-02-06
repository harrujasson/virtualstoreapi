<!-- bootstrap_js -->
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script> -->
<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="{{ URL::asset('assets/front/js/init.js') }}"></script>
<script src='{{asset("assets/front/js/jquery.star-rating-svg.js")}}'></script>
<script>
    $(".rating").starRating({
        activeColor: '#FF7F50',          
        strokeColor:'#FF7F50',
        readOnly: true
    });
</script>
<script>
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#header-fixed').addClass('header-scroll');
        } else {
            $('#header-fixed').removeClass('header-scroll');
        }
    });
</script>
@yield('script')
