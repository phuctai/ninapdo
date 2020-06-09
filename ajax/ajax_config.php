<?php
	session_start();
	@define('LIBRARIES','../libraries/');

	if(!isset($_SESSION['lang'])) $_SESSION['lang'] = 'vi';
    $lang = $_SESSION['lang'];

    include_once LIBRARIES."config.php";
    require_once LIBRARIES.'autoload.php';
    new autoload();
    $d = new PDODb($config['database']);
    $func = new functions($d);
    $cart = new cart($d);
    require_once LIBRARIES."lang$lang.php";
?>