<?php
	session_start();
	@define('LIBRARIES','../libraries/');
    @define('THUMBS','thumbs');

	if(!isset($_SESSION['lang'])) $_SESSION['lang'] = 'vi';
    $lang = $_SESSION['lang'];

    require_once LIBRARIES."config.php";
    require_once LIBRARIES.'autoload.php';
    new AutoLoad();
    $d = new PDODb($config['database']);
    $func = new Functions($d);
    $cart = new Cart($d);
    require_once LIBRARIES."lang/lang$lang.php";

    /* Slug lang */
    $sluglang = 'tenkhongdauvi';
    if($config['website']['slug']['lang-active'] && $func->check_sluglang($lang)) $sluglang = 'tenkhongdau'.$lang;
?>