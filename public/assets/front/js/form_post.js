
$(document).ready(function () {

    var is_exist_review = getParameterByName("tab");
    if(is_exist_review !=null && is_exist_review == "reviews"){
        $("#description-tab").removeClass('active');
        $("#description").removeClass('active');
        $("#description").removeClass('show');
        $("#reviews-tab").addClass('active');
        $("#reviews").addClass('active');
        $("#reviews").addClass('show');
        $('html,body').animate({scrollTop: $("div#reviews").offset().top}, 1000);
    }    

    $('#review').submit(function (event) {
        event.preventDefault();       
        $('.notification').html("<div class='notification'>Saving...</div>");
        var formData = new FormData($(this)[0]);
        formData.append('picture', $('#picture')[0].files[0]);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        $.ajax({
            url: "/review",
            type: "POST",
            dataType: 'json',
            // data:  $("#review").serialize(),
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {                
                if (data) {
                    $('.notification').html("<div class='successs'>Review has been submited sucessfully!</div>");
                    $("#review")[0].reset();
                    setTimeout(
                        window.location.href=window.location.origin+ "/"+window.location.pathname +'?tab=reviews',
                        1000
                    )
                    
                }
            },
            error:function(){
                $('.notification').html("<div class='error'>Error! Something wennt wronog, Please try afterr some time.</div>");
            }
        });
    });

    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
   
});