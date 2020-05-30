<?php
	session_start();
	@define('LIBRARIES','../libraries/');

	if(!isset($_SESSION['lang'])) $_SESSION['lang'] = 'vi';
    $lang = $_SESSION['lang'];

    include_once LIBRARIES."config.php";
    require_once LIBRARIES."lang$lang.php";
    include_once LIBRARIES."constant.php";
    include_once LIBRARIES."PDODb.php";
    $d = new PDODb($config['database']);
    include_once LIBRARIES."functions.php";
    include_once LIBRARIES."functionsCart.php";
?>