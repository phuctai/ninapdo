/* Validation form */
ValidationFormSelf("validation-newsletter");
ValidationFormSelf("validation-cart");
ValidationFormSelf("validation-user");
ValidationFormSelf("validation-contact");

/* Paging ajax */
loadPagingAjax("ajax/ajax_product.php",'.paging-product',0);

/* Window resize */
$(window).resize(function(){
    ResizeWebsite();
});

/* Window scroll */
$(window).scroll(function() {
    /* Fixed menu */
    if($(window).scrollTop() >= $(".header").height())
    {
        $(".menu").css({position:"fixed",left:'0px',right:'0px',top:'0px',zIndex:'999'});
    }
    else
    {
        $(".menu").css({position:"relative"});
    }

    /* Create top */
    if(!$('.scrollToTop').length)
    {
        $("body").append('<div class="scrollToTop"><img src="'+GOTOP+'" alt="Go Top"/></div>');
    }

    /* Go top */
    if($(this).scrollTop() > 100)
    {
        $('.scrollToTop').fadeIn();
    }
    else
    {
        $('.scrollToTop').fadeOut();
    }
});

/* Window ready */
$(document).ready(function(){
    /* Popup */
    $('#popup').modal('show');

    /* Resize */
    ResizeWebsite();

    /* WOW */
    new WOW().init();

    /* Mmenu */
    $('nav#menu').mmenu();

    /* Slider */
    $('#slider-main').nivoSlider({
        effect: 'fade',
        slices: 15,
        boxCols: 8,
        boxRows: 4,
        animSpeed: 500,
        pauseTime: 5000,
        startSlide: 0,
        directionNav: true,
        controlNav: false,
        controlNavThumbs: false,
        pauseOnHover: true,
        manualAdvance: false,
        prevText: 'Prev',
        nextText: 'Next',
        randomStart: false,
        beforeChange: function(){},
        afterChange: function(){},
        slideshowEnd: function(){},
        lastSlide: function(){},
        afterLoad: function(){}
    });

    /* Toc */
    if($(".toc-list").length)
    {
        $(".toc-list").toc({
            content: "div#toc-content",
            headings: "h2,h3,h4"
        });

        if(!$(".toc-list li").length) $(".meta-toc").hide();

        $('.toc-list').find('a').click(function(){
            var x = $(this).attr('data-rel');
            goToByScroll(x);
        });
    }

    /* Cart */
    $("body").on("click",".addcart",function(){
        var mau = ($(".color-pro-detail input:checked").val()) ? $(".color-pro-detail input:checked").val() : 0;
        var size = ($(".size-pro-detail input:checked").val()) ? $(".size-pro-detail input:checked").val() : 0;
        var id = $(this).data("id");
        var action = $(this).data("action");
        var qty = ($(".qty-pro").val()) ? $(".qty-pro").val() : 1;

        if(id)
        {
            $.ajax({
                url:'ajax/ajax_add_cart.php',
                type: "POST",
                dataType: 'json',
                async: false,
                data: {cmd:'addcart',id:id,mau:mau,size:size,qty:qty},
                success: function(result){
                    if(action=='addnow')
                    {
                        $('.count-cart').html(result.max);
                        $.ajax({
                            url:'ajax/ajax_popup_cart.php',
                            type: "POST",
                            dataType: 'html',
                            async: false,
                            success: function(result){
                                $("#popup-cart .modal-body").html(result);
                                $('#popup-cart').modal('show');
                            }
                        });
                    }
                    else if(action=='buynow')
                    {
                        window.location = CONFIG_BASE + "gio-hang";
                    }
                }
            });
        }
    });
    $("body").on("click",".del-procart",function(){
        if(confirm(LANG['delete_product_from_cart']))
        {
            var code = $(this).data("code");
            var ship = $(".price-ship").val();
            var endow = $(".price-endow").val();

            $.ajax({
                type: "POST",
                url:'ajax/ajax_delete_cart.php',
                dataType: 'json',
                data: {code:code,ship:ship,endow:endow},
                success: function(result){
                    $('.count-cart').html(result.max);
                    if(result.max)
                    {
                        $('.price-temp').val(result.temp);
                        $('.load-price-temp').html(result.tempText);
                        $('.price-total').val(result.total);
                        $('.load-price-total').html(result.totalText);
                        $(".procart-"+code).remove();
                    }
                    else
                    {
                        $(".wrap-cart").html('<a href="" class="empty-cart text-decoration-none"><i class="fa fa-cart-arrow-down"></i><p>'+LANG['no_products_in_cart']+'</p><span>'+LANG['back_to_home']+'</span></a>');
                    }
                }
            });
        }
    });
    $("body").on("click",".counter-procart",function(){
        var $button = $(this);
        var input = $button.parent().find("input");
        var pid = input.data('pid');
        var code = input.data('code');
        var oldValue = $button.parent().find("input").val();
        if($button.text() == "+") quantity = parseFloat(oldValue) + 1;
        else if(oldValue > 1) quantity = parseFloat(oldValue) - 1;
        $button.parent().find("input").val(quantity);
        update_cart(pid,code,quantity);
    });
    $("body").on("change","input.quantity-procat",function(){
        var quantity = $(this).val();
        var pid = $(this).data("pid");
        var code = $(this).data("code");
        update_cart(pid,code,quantity);
    });
    $(".apply-coupon").click(function(){
        var coupon = $(".code-coupon").val();
        var ship = $(".price-ship").val();

        if(coupon=='')
        {
            modalNotify(LANG['no_coupon'])
            return false;
        }

        $.ajax({
            type: "POST",
            url:'ajax/ajax_coupon_cart.php',
            dataType: 'json',
            data: {coupon:coupon,ship:ship},
            success: function(result){
                $('.price-total').val(result.total);
                $('.load-price-total').html(result.totalText);
                $('.price-endowType').val(result.endowType);
                $('.price-endowID').val(result.endowID);
                $('.price-endow').val(result.endow);
                $('.load-price-endow').html(result.endowText);
                
                if(result.error!='')
                {
                    $(".code-coupon").val("");
                    modalNotify(result.error);
                }
            }
        });
    });
    $(".payments-label").click(function(){
        var payments = $(this).data("payments");
        $(".payments-cart .payments-label, .payments-info").removeClass("active");
        $(this).addClass("active");
        $(".payments-info-"+payments).addClass("active");
    });

    /* Simply scroll */
    $(".newshome-scroll ul").simplyScroll({
        customClass: 'vert',
        orientation: 'vertical',
        // orientation: 'horizontal',
        auto: true,
        manualMode: 'auto',
        pauseOnHover: 1,
        speed: 1,
        loop: 0
    });

    /* Owl carousel */
    $('.owl-brand').owlCarousel({
        items: 7,
        autoplay: true,
        loop: false,
        lazyLoad: false,
        mouseDrag: true,
        touchDrag: true,
        margin: 10,
        smartSpeed: 250,
        autoplaySpeed: 1000,
        nav: false,
        dots: false,
        responsiveClass:true,
        responsiveRefreshRate: 200,
        responsive: {
            0: {
                items: 7,
                margin: 10
            }
        }
    })
    $('.prev-brand').click(function() {
        $('.owl-brand').trigger('prev.owl.carousel');
    });
    $('.next-brand').click(function() {
        $('.owl-brand').trigger('next.owl.carousel');
    });

    $('.owl-partner').owlCarousel({
        items: 7,
        autoplay: true,
        loop: true,
        lazyLoad: true,
        mouseDrag: true,
        touchDrag: true,
        margin: 10,
        smartSpeed: 250,
        autoplaySpeed: 1000,
        nav: false,
        dots: false,
        responsiveClass:true,
        responsiveRefreshRate: 200,
        responsive: {
            0: {
                items: 7,
                margin: 10
            }
        }
    })
    $('.prev-partner').click(function() {
        $('.owl-partner').trigger('prev.owl.carousel');
    });
    $('.next-partner').click(function() {
        $('.owl-partner').trigger('next.owl.carousel');
    });

    /* Cart */
    $("a.color-pro-detail").click(function(){
        $("a.color-pro-detail").removeClass("active");
        $(this).addClass("active");
        
        var id_mau=$("input[name=color-pro-detail]:checked").val();
        var idpro=$(this).data('idpro');

        $.ajax({
            url:'ajax/ajax_colorthumb.php',
            type: "POST",
            dataType: 'html',
            data: {id_mau:id_mau,idpro:idpro},
            success: function(result){
                if(result!='')
                {
                    $('.left-pro-detail').html(result);
                }
            }
        });
    });
    $("a.size-pro-detail").click(function(){
        $("a.size-pro-detail").removeClass("active");
        $(this).addClass("active");
    });
    $(".quantity-pro-detail span").click(function(){
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if($button.text() == "+")
        {
            var newVal = parseFloat(oldValue) + 1;
        }
        else
        {
            if(oldValue > 1) var newVal = parseFloat(oldValue) - 1;
            else var newVal = 1;
        }
        $button.parent().find("input").val(newVal);
    });

    /* Slick */
    $(".slick-thumb-pro").slick({
        dots: false,
        autoplay: false,
        infinite: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        swipeToSlide: true,
        prevArrow: $('.prev-thumb-pro'),
        nextArrow: $('.next-thumb-pro')
    });

    /* Tabs */
    $(".ul-tabs-pro-detail li").click(function(){
        var tabs = $(this).data("tabs");
        $(".content-tabs-pro-detail, .ul-tabs-pro-detail li").removeClass("active");
        $(this).addClass("active");
        $("."+tabs).addClass("active");
    })

    /* Fancybox */
    // $('[data-fancybox="something"]').fancybox({
    //     // transitionEffect: "fade",
    //     // transitionEffect: "slide",
    //     // transitionEffect: "circular",
    //     // transitionEffect: "tube",
    //     // transitionEffect: "zoom-in-out",
    //     // transitionEffect: "rotate",
    //     transitionEffect: "fade",
    //     transitionDuration: 800,
    //     animationEffect: "fade",
    //     animationDuration: 800,
    //     slideShow: {
    //         autoStart: true,
    //         speed: 3000
    //     },
    //     arrows: true,
    //     infobar: false,
    //     toolbar: false,
    //     hash: false
    // });
    $('[data-fancybox="video"]').fancybox({
        transitionEffect: "fade",
        transitionDuration: 800,
        animationEffect: "fade",
        animationDuration: 800,
        arrows: true,
        infobar: false,
        toolbar: true,
        hash: false
    });

    /* Photobox */
    $('.album-gallery').photobox('a',{thumbs:true,loop:false});

    /* Datetime */
    $('#ngaysinh').datetimepicker({
        timepicker: false,
        format: 'd/m/Y',
        formatDate: 'd/m/Y',
        // minDate: '1950/01/01',
        maxDate: TIMENOW
    });

    /* Search */
    $(".icon-search").click(function(){
        if($(this).hasClass('active'))
        {
            $(this).removeClass('active');
            $(".search-grid").stop(true,true).animate({opacity: "0",width: "0px"}, 200);   
        }
        else
        {
            $(this).addClass('active');                            
            $(".search-grid").stop(true,true).animate({opacity: "1",width: "230px"}, 200);
        }
        document.getElementById($(this).next().find("input").attr('id')).focus();
        $('.icon-search i').toggleClass('fa fa-search fa fa-times');
    });

    /* Go top */
    $('body').on("click",".scrollToTop",function() {
        $('html, body').animate({scrollTop : 0},800);
        return false; 
    });

    /* Alt images */
    $('img').each(function(index, element) {
        if(!$(this).attr('alt') || $(this).attr('alt')=='')
        {
            $(this).attr('alt',WEBSITE_NAME);
        }
    });
})