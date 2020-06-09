<!-- Viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

<!-- CSS DESKTOP -->
<?php
    $miniCss = "";
    $miniCss .= $func->miniCssSet("./assets/css/animate.min.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/bootstrap/css/bootstrap.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/css/font-awesome-5.12.0/css/all.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/ddsmoothmenu/ddsmoothmenu.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/ddsmoothmenu/ddsmoothmenu-v.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/mmenu/mmenu.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/fancybox3/jquery.fancybox.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/fancybox3/jquery.fancybox.style.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/login/login.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/css/cart.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/photobox/photobox.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/slick/slick.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/slick/slick-theme.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/slick/slick-style.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/simplyscroll/jquery.simplyscroll.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/simplyscroll/jquery.simplyscroll-style.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/nivoslider/themes/default/default.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/nivoslider/css/nivo-slider.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/fotorama/fotorama.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/fotorama/fotorama-style.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/magiczoomplus/magiczoomplus.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/datetimepicker/jquery.datetimepicker.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/owlcarousel2/owl.carousel.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/owlcarousel2/owl.theme.default.css",$config['website']['debug-style']);
    $miniCss .= $func->miniCssSet("./assets/css/style.css",$config['website']['debug-style']);
    echo ($config['website']['debug-style']) ? $miniCss : '<style type="text/css">'.$miniCss.'</style>';
?>

<!-- Background -->
<?php
    $bgbody=$d->rawQueryOne("select hienthi, loaihienthi, mau, photo, background_repeat, background_position, background_attachment, background_size from #_photo where act = ? and type = ?",array('photo_static','background'));

    if($bgbody['hienthi'])
    {
        if($bgbody['loaihienthi'] == 0) 
        {
            echo ' <style type="text/css">body{ background:'.$bgbody['mau'].'}</style>';    
        }
        else
        {
            echo '<style type="text/css">body{ background: url('.UPLOAD_PHOTO_L.$bgbody['photo'].') '.$bgbody['background_repeat'].' '.$bgbody['background_position'].' '.$bgbody['background_attachment'].' ;background-size:'.$bgbody['background_size'].' } </style>';
        }
    }
?>

<!-- JS DESKTOP -->
<script type="text/javascript" src="assets/js/jquery.min.js"></script>

<?php if($config['googleAPI']['recaptcha']['active']) { ?>
    <!-- Google Recaptcha V3 -->
    <script src="https://www.google.com/recaptcha/api.js?render=<?=$config['googleAPI']['recaptcha']['sitekey']?>"></script>
    <script type="text/javascript">
        grecaptcha.ready(function () {
            grecaptcha.execute('<?=$config['googleAPI']['recaptcha']['sitekey']?>', { action: 'Newsletter' }).then(function (token) {
                var recaptchaResponseNewsletter = document.getElementById('recaptchaResponseNewsletter');
                recaptchaResponseNewsletter.value = token;
            });
            <?php if($source=='contact') { ?>
                grecaptcha.execute('<?=$config['googleAPI']['recaptcha']['sitekey']?>', { action: 'contact' }).then(function (token) {
                    var recaptchaResponseContact = document.getElementById('recaptchaResponseContact');
                    recaptchaResponseContact.value = token;
                });
            <?php } ?>
        });
    </script>
<?php } ?>

<?php if($config['oneSignal']['active']) { ?>
	<!-- OneSignal --> 
	<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
	<script type="text/javascript">
	    var OneSignal = window.OneSignal || [];
	    OneSignal.push(function() {
	        OneSignal.init({
	            appId: "<?=$config['oneSignal']['id']?>"
	        });
	    });
	</script>
<?php } ?>

<!-- Google Analytic -->
<?=htmlspecialchars_decode($setting['analytics'])?>

<!-- Head JS -->
<?=htmlspecialchars_decode($setting['headjs'])?>