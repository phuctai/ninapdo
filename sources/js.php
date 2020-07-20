<!-- Js -->
<script type="text/javascript">
    var CONFIG_BASE = '<?=$config_base?>';
    var WEBSITE_NAME = '<?=($setting['ten'.$lang]) ? $setting['ten'.$lang] : $setting['title'.$seolang]?>';
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
<?php
    $js->setJs("./assets/bootstrap/js/bootstrap.js");
    $js->setJs("./assets/js/wow.min.js");
    $js->setJs("./assets/mmenu/mmenu.js");
    $js->setJs("./assets/nivoslider/jquery.nivo.slider.js");
    $js->setJs("./assets/simplyscroll/jquery.simplyscroll.js");
    $js->setJs("./assets/owlcarousel2/owl.carousel.js");
    $js->setJs("./assets/magiczoomplus/magiczoomplus.js");
    $js->setJs("./assets/slick/slick.js");
    $js->setJs("./assets/fancybox3/jquery.fancybox.js");
    $js->setJs("./assets/photobox/photobox.js");
    $js->setJs("./assets/datetimepicker/php-date-formatter.min.js");
    $js->setJs("./assets/datetimepicker/jquery.mousewheel.js");
    $js->setJs("./assets/datetimepicker/jquery.datetimepicker.js");
    $js->setJs("./assets/toc/toc.js");
    $js->setJs("./assets/js/functions.js");
    $js->setJs("./assets/js/apps.js");
    echo $js->getJs();
?>

<?php if($template == 'static/static' || $template == 'news/news_detail' || $template == 'product/product_detail') { ?>
    <!-- Like Share -->
    <?=$func->getAddonsOnline("shareMain","shareMain","shareMain",0,0);?>
<?php } ?>

<!-- Body JS -->
<?=htmlspecialchars_decode($setting['bodyjs'])?>