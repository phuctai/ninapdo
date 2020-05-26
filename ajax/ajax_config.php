<?php
	session_start();
	@define('_LIB','../libraries/');

	if(!isset($_SESSION['lang'])) $_SESSION['lang'] = 'vi';
    $lang = $_SESSION['lang'];

    include_once _LIB."config.php";
    require_once _LIB."lang$lang.php";
    include_once _LIB."constant.php";
    include_once _LIB."PDODb.php";
    $d = new PDODb($config['database']);
    include_once _LIB."functions.php";
    include_once _LIB."functionsCart.php";
?>