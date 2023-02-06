$(document).ready(function() {
    /*=============================================
    	=    		 Slider Main 	         =
    =============================================*/
    var default_thumb = 0;
    $(".thumb_link").each(function(){
        if($(this).hasClass('thumb_active')){
            default_thumb =1;
        }
    });

        
    if(default_thumb == 1){
        $(".main_slider_image").attr('data-zoo-image',$(".thumb_active").attr('data-image'));    
    }else{
        $(".main_slider_image").attr('data-zoo-image',$(".thumb_link:first").attr('data-image'));    
    }
    
    $(".thumb_link").on("click",function(e){
        e.preventDefault();
        var $this = $(this);

        if($this.attr('data-type') == "image"){   
            $(".video_container").hide();
            $(".main_picture").show();            
            var video_player = $("#video_main").get(0);
            if(video_player){
                video_player.pause();
                video_player.currentTime = 0;
            }            
            $(".thumb_link").removeClass('thumb_active');
            $(this).addClass('thumb_active');
            $(".main_slider_image").attr('data-zoo-image',$this.attr('data-image'));
            $('.zoo-item').ZooMove({
                scale: '3',
                move: 'true',
                over: 'false',
                cursor: 'true'
            });

        }else{
            $(".video_container").show();
            $(".main_picture").hide();
        }
        
    });
    /*=============================================
    	=    		 Cart Active  	         =
    =============================================*/
    
/*=============================================
    	=    		 Cart Active  	         =
    =============================================*/
    $('.qtybutton-box span').click(function() {
        var $input = $(this).parent().parent('.num-block').find('input.in-num');
        if ($(this).hasClass('minus')) {
            var count = parseFloat($input.val()) - 1;
            count = count < 1 ? 0 : count;
            if (count < 1) {
                $(this).addClass('dis');
            } else {
                $(this).removeClass('dis');
            }
            $input.val(count);
        } else {
            var count = parseFloat($input.val()) + 1
            $input.val(count);
            if (count > 1) {
                $(this).parents('.num-block').find(('.minus')).removeClass('dis');
            }
        }
        $input.change();
       
    });
    /***Add to cart */
    $(".cst_btn").click(function(){
        var cnt_qty = 0;
        cnt_qty+= parseInt($('input.in-num').val());
        
        if(cnt_qty > 0){            
            $(".extra_info").html('<input type="hidden" name="form_type" value="'+$(this).attr('data-type')+'">');
            $(".product_cart_main").submit();

        }else{
            alert("Please add atleast one qty")
        }
    });

    

});