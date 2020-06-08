<!-- Bootstrap -->
<script src="assets/bootstrap/js/bootstrap.js"></script>

<?php if($popup['hienthi']) { ?>
    <!-- Popup -->
    <script type="text/javascript">
        $(window).load(function(){
            $('#popup').modal('show');
        });
    </script>
<?php } ?>

<!-- WOW JS -->
<script src="assets/js/wow.min.js"></script>  
<script type="text/javascript">
    $(document).ready(function(){new WOW().init();})
</script>

<!-- Menu -->
<script src="assets/ddsmoothmenu/ddsmoothmenu.js"></script>
<script type="text/javascript">
    ddsmoothmenu.init({mainmenuid: "smoothmenu1",orientation: 'h',classname: 'ddsmoothmenu',contentsource: "markup"})
    ddsmoothmenu.init({mainmenuid: "smoothmenu2",orientation: 'v',classname: 'ddsmoothmenu-v',contentsource: "markup"})
</script>

<!-- Mmenu -->
<script src="assets/mmenu/mmenu.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('nav#menu').mmenu();
    });
</script>

<!-- Validation Form -->
<script type="text/javascript">
    function ValidationFormSelf(ele)
    {
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName(ele);
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
            $("."+ele).find("input[type=submit]").removeAttr("disabled");
        }, false);
    }
</script>

<!-- Validate Newsletter -->
<script type="text/javascript">
    ValidationFormSelf("validation-newsletter");
</script>

<!-- Modal -->
<script type="text/javascript">
    function modalNotify(text)
    {
        $("#popup-notify").find(".modal-body").html(text);
        $('#popup-notify').modal('show');
    }
</script>

<!-- Scroll Fixed -->
<script type="text/javascript">
    // $(window).scroll(function() {
    //     if($(window).scrollTop() >= $(".header").height())
    //     {
    //         $(".menu").css({position:"fixed",left:'0px',right:'0px',top:'0px',zIndex:'999'});
    //     }
    //     else
    //     {
    //         $(".menu").css({position:"relative"});
    //     }
    // });
</script>

<!-- Resize Website -->
<script type="text/javascript">
    function ResizeWebsite()
    {
        $(".footer").css({marginBottom:$(".toolbar").innerHeight()});
    }
    $(window).load(function(){
        ResizeWebsite();
    });
    $(window).resize(function(){
        ResizeWebsite();
    });
</script>

<!-- Cart -->
<script type="text/javascript">
    <?php if($template == 'giohang') { ?>
        /* Validate Cart */
        ValidationFormSelf("validation-cart");
    <?php } else { ?>
        function add_to_cart(id,kind)
        {
            var mau = $("input[name=color-pro-detail]:checked").val();
            var size = $("input[name=size-pro-detail]:checked").val();
            if(mau == undefined) mau=0;
            if(size == undefined) size=0;
            var qty = $(".qty-pro").val();

            $.ajax({
                url:'ajax/ajax_add_cart.php',
                type: "POST",
                dataType: 'json',
                async: false,
                data: {cmd:'addcart',id:id,mau:mau,size:size,qty:qty},
                success: function(result){
                    if(kind=='addnow')
                    {
                        $('.count-cart').html(result.countcart);
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
                    else if(kind=='buynow')
                    {
                        window.location="<?=$config_base?>gio-hang";
                    }
                }
            });
        }
    <?php } ?>
</script>

<!-- Tooltips Image -->
<!-- <script src="assets/imagetooltip/ajax_show_popup.js"></script>
<script src="assets/imagetooltip/ajax_show_popup_content.js"></script>
<script src="assets/imagetooltip/ajax_show_popup_hover.js"></script> -->
<!-- <img onmouseover="AJAXShowToolTip('nd_index_cen_ctyvip_ajax.php?ContentID=645'); return false;" onmouseout="AJAXHideTooltip();"> -->

<?php if($source == 'index') { ?>
    <!-- Slider -->
    <script src="assets/nivoslider/js/jquery.nivo.slider.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
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
        });
    </script>

    <!-- Paging ajax -->
    <script type="text/javascript">
        function loadPagingAjax(url,eShow='',rowCount=0)
        {
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    rowCount: rowCount,
                    perpage: 8,
                    eShow: eShow
                },
                success: function(result){
                    $(eShow).html(result);
                }
            });
        }
        loadPagingAjax("ajax/ajax_product.php",'.paging-product',0);
    </script>

    <!-- SimplyScroll -->
    <script src="assets/simplyscroll/jquery.simplyscroll.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
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
        });
    </script>

    <!-- Owl Carousel 2 -->
    <script src="assets/owlcarousel2/owl.carousel.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
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
        });
    </script>
<?php } ?>

<?php if($template == 'product_detail') { ?>
    <!-- Magiczoomplus -->
    <script src="assets/magiczoomplus/magiczoomplus.js"></script>

    <!-- Slick -->
    <script src="assets/slick/slick.js"></script>

    <script type="text/javascript">
        $(document).ready(function() 
        {
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
            })

            $("a.size-pro-detail").click(function(){
                $("a.size-pro-detail").removeClass("active");
                $(this).addClass("active");
            })

            /* Quantity */
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

            /* Thumb */
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
        });
    </script>
<?php } ?>

<?php if($template == 'video') { ?>
    <!-- Video -->
    <script src="assets/fancybox3/jquery.fancybox.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
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
        });
    </script>
<?php } ?>

<?php if($template == 'album_detail') { ?>
    <!-- Photobox -->
    <script src="assets/photobox/photobox.js"></script>
    <script type="text/javascript">
        $(document).ready(function($) {
            $('.album-gallery').photobox('a',{thumbs:true,loop:false});
        });
    </script>
<?php } ?>

<?php if($source == 'user') { ?>
    <!-- Validate User -->
    <script type="text/javascript">
        ValidationFormSelf("validation-user");
    </script>
        
    <?php if($template == 'account/dangky' || $template == 'account/thongtin') { ?>
        <!-- DatePicker -->
        <script src="assets/datetimepicker/php-date-formatter.min.js"></script>
        <script src="assets/datetimepicker/jquery.mousewheel.js"></script>
        <script src="assets/datetimepicker/jquery.datetimepicker.js"></script>
        <script type="text/javascript">
            $('#ngaysinh').datetimepicker({
                timepicker:false,
                format:'d/m/Y',
                formatDate:'d/m/Y',
                // minDate:'1950/01/01',
                maxDate:'<?=date("Y/m/d",time())?>'
            });
        </script>
    <?php } ?>
<?php } ?>

<!-- Search -->
<script type="text/javascript">
    function doEnter(evt,obj)
    {
        if(evt.keyCode == 13 || evt.which == 13) onSearch(obj);
    }
    function onSearch(obj) 
    {           
        var keyword = $("#"+obj).val();
        
        if(keyword=='')
        {
            modalNotify("<?=chuanhaptukhoatimkiem?>");
            return false;
        }
        else
        {
            location.href = "tim-kiem/keyword="+encodeURI(keyword);
            loadPage(document.location);            
        }
    }
    $(document).ready(function(){
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
    });
</script>

<!-- Scroll-Top -->
<div class="scrollToTop"><img src="assets/images/top.png" alt="Go Top"/></div>
<script type="text/javascript">
    $(document).ready(function() {
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) { $('.scrollToTop').fadeIn(); } 
            else { $('.scrollToTop').fadeOut(); }
        });
        $('.scrollToTop').click(function() {
            $('html, body').animate({scrollTop : 0},800);
            return false; 
        });
    })
</script>

<!-- Thêm alt cho hình ảnh -->
<script type="text/javascript">
    $(document).ready(function(e) {
        $('img').each(function(index, element) {
            if(!$(this).attr('alt') || $(this).attr('alt')=='')
            {
                $(this).attr('alt','<?=$setting['ten'.$lang]?>');
            }
        });
    });
</script>

<?php /*
<!-- Login Google -->
<script src="https://apis.google.com/js/api:client.js"></script>
<!-- <script src="https://apis.google.com/js/plus.js?onload=init"></script> -->
<!-- client_id: 390513021674-v8r9laedv7j1bhklt3b8he09vadp2of7.apps.googleusercontent.com -->
<!-- secret_id: ex-a_GtgkQD2_rgidPU-2Nh4 -->
<script type="text/javascript">
    var googleUser = {};
    var auth2;
    var startApp = function() {
        gapi.load('auth2', function(){
            auth2 = gapi.auth2.init({
                client_id: '390513021674-v8r9laedv7j1bhklt3b8he09vadp2of7.apps.googleusercontent.com',
                cookiepolicy: 'single_host_origin'
            });
            attachSignin(document.getElementById('login_gg'));
        });
    };
    function attachSignin(element)
    {
        auth2.attachClickHandler(element, {},
        function(googleUser)
        {
            var profile = googleUser.getBasicProfile();
            $gg_id = profile.getId();
            $gg_name = profile.getName();
            $gg_img = profile.getImageUrl();
            $gg_email = profile.getEmail();
            $.ajax({
                type: "POST",
                dataType: "JSON",
                data: {'id':$gg_id,'name':$gg_name,'img':$gg_img,'email':$gg_email},
                url: '<?=$config_base?>ajax/ajax_google.php',
                success: function(result)
                {
                    if(result.error_return==1)
                    {
                        modalNotify(result.str_return);
                        setTimeout(function(){
                            window.location="<?=$config_base?>lien-he";
                        }, 2000);
                    }
                    else
                    {
                        modalNotify(result.str_return);
                        setTimeout(function(){
                            window.location="<?=$config_base?>";
                        }, 500);
                    }
                }
            });
        }, function(error)
        {
            // modalNotify(JSON.stringify(error, undefined, 2));
        });
    }
    startApp();
</script>

<!-- Login Facebook -->
<script type="text/javascript">
    window.fbAsyncInit = function(){
        FB.init({
            appId      : '847085562137079',
            channelUrl : '<?=$config_base?>ajax/ajax_facebook.php',
            status     : true,
            cookie     : true,
            xfbml      : true
        });
    };
    function login_fb()
    {
        FB.login(function(response)
        {
            if (response.authResponse) 
            {
                getUserInfo_dn();
                return false;
            }
            else 
            {
                console.log('User cancelled login or did not fully authorize.');
            }
        },{scope: 'email,user_photos,user_videos'});
    }
 
    function getUserInfo_dn()
    {
        FB.api('/me?fields=id,first_name,last_name,email,link,gender,locale,picture{url}', function(response) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: '<?=$config_base?>ajax/ajax_facebook.php',
                data: {fbUser:response},
                success : function(result){
                    if(result.error_return==1)
                    {
                        modalNotify(result.str_return);
                        setTimeout(function(){
                            window.location="<?=$config_base?>lien-he";
                        }, 2000);
                    }
                    else
                    {
                        modalNotify(result.str_return);
                        setTimeout(function(){
                            window.location="<?=$config_base?>";
                        }, 500);
                    }
                }           
            });
        });
    }
  
    function Logout()
    {
        FB.logout(function(){document.location.reload();});
    }
    (function(d){
    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    ref.parentNode.insertBefore(js, ref);
    }(document));
</script>
<?php */ ?>

<!-- Combo Phone -->
<script type="text/javascript">
    $(document).ready(function () {
        $(document).ready(function () {
            $('.support-content').hide();
            $('a.btn-support').click(function (e) {
                e.stopPropagation();
                $('.support-content').slideToggle();
            });
            $('.support-content').click(function (e) {
                e.stopPropagation();
            });
            $(document).click(function () {
                $('.support-content').slideUp();
            });
        });
    });
</script>

<?php if($template == 'static' || $template == 'news_detail' || $template == 'product_detail') { ?>
    <!-- Like Share + Zalo Share -->
    <script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55e11040eb7c994c" async="async"></script>
    <script type="text/javascript">
        var addthis_config = addthis_config||{};
        addthis_config.lang = '<?=$lang?>'
    </script>
    <style type="text/css">#at4-share{display: none !important;opacity: 0 !important;visibility: hidden !important;}</style>
    <script src="https://sp.zalo.me/plugins/sdk.js"></script>
<?php } ?>

<?php if($source == 'contact') { ?>
    <!-- Contact -->
    <script type="text/javascript">
        ValidationFormSelf("validation-contact");
    </script>
<?php } ?>

<!-- Body JS -->
<?=htmlspecialchars_decode($setting['bodyjs'])?>