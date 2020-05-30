<?php
	session_start();
	@define('LIBRARIES','../../libraries/');
	@define('SOURCES','../sources/');

    include_once LIBRARIES."config.php";
    include_once LIBRARIES."PDODb.php";
    $d = new PDODb($config['database']);
    include_once LIBRARIES."functions.php";
    include_once LIBRARIES."constant.php";

    if(check_login()==false) die();
?>