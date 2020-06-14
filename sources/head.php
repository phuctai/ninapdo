<!-- Basehref -->
<base href="<?=$config_base?>"/>

<!-- UTF-8 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Title, Keywords, Description -->
<title><?=$title_bar?></title>
<meta name="keywords" content="<?=$keywords_bar?>"/>
<meta name="description" content="<?=$description_bar?>"/>

<!-- Robots -->
<meta name="robots" content="index,follow" />

<!-- Favicon -->
<link href="<?=UPLOAD_PHOTO_L.$favicon['photo']?>" rel="shortcut icon" type="image/x-icon" />

<!-- Webmaster Tool -->
<?=$setting['mastertool']?>

<?php if(count($config['arrayDomainSSL'])) { ?>
	<!-- Security Policy -->
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<?php } ?>

<!-- GEO -->
<meta name="geo.region" content="VN" />
<meta name="geo.placename" content="Hồ Chí Minh" />
<meta name="geo.position" content="10.823099;106.629664" />
<meta name="ICBM" content="10.823099, 106.629664" />

<!-- Author - Copyright -->
<meta name='revisit-after' content='1 days' />
<meta name="author" content="<?=$setting['ten'.$lang]?>" />
<meta name="copyright" content="<?=$setting['ten'.$lang]." - [".$setting['email']."]"?>" />

<!-- Facebook -->
<meta property="og:type" content="<?=$type_og?>" />
<meta property="og:site_name" content="<?=$setting['ten'.$lang]?>" />
<meta property="og:title" content="<?=$title_bar?>" />
<meta property="og:description" content="<?=$description_bar?>" />
<meta property="og:url" content="<?=$url_bar?>" />
<meta property="og:image" content="<?=$img_bar?>" />
<meta property="og:image:alt" content="<?=$title_bar?>" />
<meta property="og:image:width" content="675" />
<meta property="og:image:height" content="1000" />

<!-- Twitter -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="<?=$title_bar?>" />
<meta name="twitter:description" content="<?=$description_bar?>" />

<!-- Canonical -->
<link rel="canonical" href="<?=$func->getCurrentPageURL()?>" />

<!-- Chống đổi màu trên IOS -->
<meta name="format-detection" content="telephone=no">

<!-- Theme color -->
<meta name="theme-color" content="#ec2d3f">