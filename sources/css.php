<!-- Viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

<!-- Css -->
<?php
    $css->setCache("cached");
    $css->setCss("./assets/css/animate.min.css");
    $css->setCss("./assets/bootstrap/css/bootstrap.css");
    $css->setCss("./assets/fontawesome512/all.css");
    $css->setCss("./assets/mmenu/mmenu.css");
    $css->setCss("./assets/fancybox3/jquery.fancybox.css");
    $css->setCss("./assets/fancybox3/jquery.fancybox.style.css");
    $css->setCss("./assets/login/login.css");
    $css->setCss("./assets/css/cart.css");
    $css->setCss("./assets/photobox/photobox.css");
    $css->setCss("./assets/slick/slick.css");
    $css->setCss("./assets/slick/slick-theme.css");
    $css->setCss("./assets/slick/slick-style.css");
    $css->setCss("./assets/simplyscroll/jquery.simplyscroll.css");
    $css->setCss("./assets/simplyscroll/jquery.simplyscroll-style.css");
    $css->setCss("./assets/nivoslider/nivo-slider.css");
    $css->setCss("./assets/fotorama/fotorama.css");
    $css->setCss("./assets/fotorama/fotorama-style.css");
    $css->setCss("./assets/magiczoomplus/magiczoomplus.css");
    $css->setCss("./assets/datetimepicker/jquery.datetimepicker.css");
    $css->setCss("./assets/owlcarousel2/owl.carousel.css");
    $css->setCss("./assets/owlcarousel2/owl.theme.default.css");
    $css->setCss("./assets/css/style.css");
    echo $css->getCss();
?>

<!-- Background -->
<?php
    $bgbody = $d->rawQueryOne("select hienthi, options, photo from #_photo where act = ? and type = ?",array('photo_static','background'));
    $bgbodyOptions = json_decode($bgbody['options'],true)['background'];

    if($bgbody['hienthi'])
    {
        if($bgbodyOptions['loaihienthi']) 
        {
            echo '<style type="text/css">body{background: url('.UPLOAD_PHOTO_L.$bgbody['photo'].') '.$bgbodyOptions['repeat'].' '.$bgbodyOptions['position'].' '.$bgbodyOptions['attachment'].' ;background-size:'.$bgbodyOptions['size'].'}</style>';
        }
        else
        {
            echo ' <style type="text/css">body{background-color:#'.$bgbodyOptions['color'].'}</style>';
        }
    }
?>

<!-- Js min -->
<script src="assets/js/jquery.min.js"></script>

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