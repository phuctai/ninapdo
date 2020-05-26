<?php
	session_start();
	@define('_LIB','../../libraries/');
	@define('_SOURCE','../sources/');

    include_once _LIB."config.php";
    include_once _LIB."PDODb.php";
    $d = new PDODb($config['database']);
    include_once _LIB."functions.php";
    include_once _LIB."constant.php";

    if(check_login()==false) die();
?>