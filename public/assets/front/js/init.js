$(document).ready(function() {
    $("select[name=sortby]").change(function() {
        var $this = $(this);
        $this.parent('#sort_form').submit();
    });

    $(".wishlist_add").click(function(){
        $("#loader-notificaiton").show();
        var slug = $(this).attr('data-slug');
        $.ajax({
            type:'GET',
            url:'/wishlist-add-ajax/'+slug,
            dataType:'json',
            success:function(data){
                $("#loader-notificaiton").hide();
                if(data.status == 1){
                    $("#wishlist_count").text(data.total);
                }else{
                    alert("Error: Note - Only valid customer can add wishlist")
                }
                
            },
            error:function(){
                $("#loader-notificaiton").hide();
                alert("Error:Something went wrong, please try after somme time!")
            }
        });
    });

    $(".login_popup_alert").click(function(){
        $("#LoginModel").modal('show');
    });

    $("#searchTopbar").click(function(){
        $("#searchModal").modal('show');
    });

    $("#front_login_form").on('submit',function(e){
        e.preventDefault();
        $("#loader-notificaiton").show();
        $.ajax({
            type: 'POST',
            data: $(this).serialize(),
            url: '/front-login',
            dataType:'json',
            success:function(data){
                $("#loader-notificaiton").hide(); 
                if(data.status == 1){
                    window.location.reload();
                }else{
                    alert("Something went wrong, Please try with valid login details!");
                }
            },
            error:function(){
                $("#loader-notificaiton").hide();
                alert("Something went wrong, Please try with valid login details!");
            }
        })
    })
});