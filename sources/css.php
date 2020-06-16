<!-- Viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

<!-- Css -->
<?php
    $css->addCss("./assets/css/animate.min.css");
    $css->addCss("./assets/bootstrap/css/bootstrap.css");
    $css->addCss("./assets/fontawesome512/all.css");
    $css->addCss("./assets/ddsmoothmenu/ddsmoothmenu.css");
    $css->addCss("./assets/ddsmoothmenu/ddsmoothmenu-v.css");
    $css->addCss("./assets/mmenu/mmenu.css");
    $css->addCss("./assets/fancybox3/jquery.fancybox.css");
    $css->addCss("./assets/fancybox3/jquery.fancybox.style.css");
    $css->addCss("./assets/login/login.css");
    $css->addCss("./assets/css/cart.css");
    $css->addCss("./assets/photobox/photobox.css");
    $css->addCss("./assets/slick/slick.css");
    $css->addCss("./assets/slick/slick-theme.css");
    $css->addCss("./assets/slick/slick-style.css");
    $css->addCss("./assets/simplyscroll/jquery.simplyscroll.css");
    $css->addCss("./assets/simplyscroll/jquery.simplyscroll-style.css");
    $css->addCss("./assets/nivoslider/nivo-slider.css");
    $css->addCss("./assets/fotorama/fotorama.css");
    $css->addCss("./assets/fotorama/fotorama-style.css");
    $css->addCss("./assets/magiczoomplus/magiczoomplus.css");
    $css->addCss("./assets/datetimepicker/jquery.datetimepicker.css");
    $css->addCss("./assets/owlcarousel2/owl.carousel.css");
    $css->addCss("./assets/owlcarousel2/owl.theme.default.css");
    $css->addCss("./assets/css/style.css");
    echo $css->optimizeCss();
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