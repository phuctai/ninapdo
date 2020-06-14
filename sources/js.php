<!-- Var Js -->
<script type="text/javascript">
    var CONFIG_BASE = '<?=$config_base?>';
    var WEBSITE_NAME = '<?=$setting['ten'.$lang]?>';
    var TIMENOW = '<?=date("Y/m/d",time())?>';
    var LANG = {
        'no_keywords': '<?=chuanhaptukhoatimkiem?>'
    };
</script>

<!-- Cached Js -->
<script src="assets/basket/basket.full.js"></script>
<script type="text/javascript">
    basket.require(
        { url: 'assets/bootstrap/js/bootstrap.js', expire: 5, key: 'bootstrap', skipCache: false },
        { url: 'assets/js/wow.min.js', expire: 5, key: 'wow', skipCache: false },
        { url: 'assets/ddsmoothmenu/ddsmoothmenu.js', expire: 5, key: 'ddsmoothmenu', skipCache: false },
        { url: 'assets/mmenu/mmenu.js', expire: 5, key: 'mmenu', skipCache: false },
        { url: 'assets/nivoslider/jquery.nivo.slider.js', expire: 5, key: 'nivo', skipCache: false },
        { url: 'assets/simplyscroll/jquery.simplyscroll.js', expire: 5, key: 'simplyscroll', skipCache: false },
        { url: 'assets/owlcarousel2/owl.carousel.js', expire: 5, key: 'owl', skipCache: false },
        { url: 'assets/magiczoomplus/magiczoomplus.js', expire: 5, key: 'magiczoomplus', skipCache: false },
        { url: 'assets/slick/slick.js', expire: 5, key: 'slick', skipCache: false },
        { url: 'assets/fancybox3/jquery.fancybox.js', expire: 5, key: 'fancybox', skipCache: false },
        { url: 'assets/photobox/photobox.js', expire: 5, key: 'photobox', skipCache: false },
        { url: 'assets/datetimepicker/php-date-formatter.min.js', expire: 5, key: 'formatter', skipCache: false },
        { url: 'assets/datetimepicker/jquery.mousewheel.js', expire: 5, key: 'mousewheel', skipCache: false },
        { url: 'assets/datetimepicker/jquery.datetimepicker.js', expire: 5, key: 'datetimepicker', skipCache: false },
        { url: 'assets/js/functions.js', expire: 5, key: 'functions', skipCache: false },
        { url: 'assets/js/apps.js', expire: 5, key: 'apps', skipCache: true }
    );
</script>

<?php if($template == 'static' || $template == 'news_detail' || $template == 'product_detail') { ?>
    <!-- Like Share -->
    <script src="//sp.zalo.me/plugins/sdk.js"></script>
    <script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55e11040eb7c994c" async="async"></script>
    <script type="text/javascript">
        var addthis_config = addthis_config||{};
        addthis_config.lang = '<?=$lang?>'
    </script>
<?php } ?>

<!-- Body JS -->
<?=htmlspecialchars_decode($setting['bodyjs'])?>