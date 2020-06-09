<?php
	session_start();
	@define('LIBRARIES','../../libraries/');
	@define('SOURCES','../sources/');

    include_once LIBRARIES."config.php";
    require_once LIBRARIES.'autoload.php';
    new autoload();
    $d = new PDODb($config['database']);
    $func = new functions($d);

    if($func->check_login()==false) die();
?>