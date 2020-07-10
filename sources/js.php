<!-- Var Js -->
<script type="text/javascript">
    var CONFIG_BASE = '<?=$config_base?>';
    var NN_MSHD = '<?=NN_MSHD?>';
    var WEBSITE_NAME = '<?=($setting['ten'.$lang]) ? $setting['ten'.$lang] : $setting['title'.$seolang]?>';
    var DEBUG_JS = <?=($config['website']['debug-js']) ? 'true' : 'false'?>;
    var TIMENOW = '<?=date("Y/m/d",time())?>';
    var SHIP_CART = <?=($config['order']['ship']) ? 'true' : 'false'?>;
    var GOTOP = 'assets/images/top.png';
    var LANG = {
        'no_keywords': '<?=chuanhaptukhoatimkiem?>',
        'delete_product_from_cart': '<?=banmuonxoasanphamnay?>',
        'no_products_in_cart': '<?=khongtontaisanphamtronggiohang?>',
        'no_coupon': '<?=chuanhapmauudai?>',
        'wards': '<?=phuongxa?>',
        'back_to_home': '<?=vetrangchu?>',
    };
</script>

<!-- All Js -->
<div id="cached-js"></div>

<!-- Cached Js -->
<script src="assets/basket/basket.full.js"></script>
<script type="text/javascript">
    basket.require(
        { url: 'assets/bootstrap/js/bootstrap.js', key: 'bootstrap-'+NN_MSHD, skipCache: DEBUG_JS },
        { url: 'assets/js/wow.min.js', key: 'wow-'+NN_MSHD, skipCache: DEBUG_JS },
        { url: 'assets/mmenu/mmenu.js', key: 'mmenu-'+NN_MSHD, skipCache: DEBUG_JS },
        { url: 'assets/nivoslider/jquery.nivo.slider.js', key: 'nivo-'+NN_MSHD, skipCache: DEBUG_JS },
        { url: 'assets/simplyscroll/jquery.simplyscroll.js', key: 'simplyscroll-'+NN_MSHD, skipCache: DEBUG_JS },
        { url: 'assets/owlcarousel2/owl.carousel.js', key: 'owl-'+NN_MSHD, skipCache: DEBUG_JS },
        { url: 'assets/magiczoomplus/magiczoomplus.js', key: 'magiczoomplus-'+NN_MSHD, skipCache: DEBUG_JS },
        { url: 'assets/slick/slick.js', key: 'slick-'+NN_MSHD, skipCache: DEBUG_JS },
        { url: 'assets/fancybox3/jquery.fancybox.js', key: 'fancybox-'+NN_MSHD, skipCache: DEBUG_JS },
        { url: 'assets/photobox/photobox.js', key: 'photobox-'+NN_MSHD, skipCache: DEBUG_JS },
        { url: 'assets/datetimepicker/php-date-formatter.min.js', key: 'formatter-'+NN_MSHD, skipCache: DEBUG_JS },
        { url: 'assets/datetimepicker/jquery.mousewheel.js', key: 'mousewheel-'+NN_MSHD, skipCache: DEBUG_JS },
        { url: 'assets/datetimepicker/jquery.datetimepicker.js', key: 'datetimepicker-'+NN_MSHD, skipCache: DEBUG_JS },
        { url: 'assets/toc/toc.js', key: 'toc-'+NN_MSHD, skipCache: DEBUG_JS },
        { url: 'assets/js/functions.js', key: 'functions-'+NN_MSHD, skipCache: DEBUG_JS },
        { url: 'assets/js/apps.js', key: 'apps-'+NN_MSHD, skipCache: DEBUG_JS }
    );
    if(DEBUG_JS) basket.clear();
</script>

<?php if($template == 'static/static' || $template == 'news/news_detail' || $template == 'product/product_detail') { ?>
    <!-- Like Share -->
    <?=$func->getAddonsOnline("shareMain","shareMain","shareMain",0,0);?>
<?php } ?>

<!-- Body JS -->
<?=htmlspecialchars_decode($setting['bodyjs'])?>