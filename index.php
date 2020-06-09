<?php
    session_start();
    @define('LIBRARIES','./libraries/');
    @define('SOURCES','./sources/');
    @define('LAYOUT','layout/');

    /* Config */
    require_once LIBRARIES."config.php";
    require_once LIBRARIES.'autoload.php';
    new autoload();
    $injection = new AntiSQLInjection();
    $d = new PDODb($config['database']);
    $router = new AltoRouter();
    $func = new functions($d);
    $breadcr = new breadCrumbs($d);
    $statistic = new statistic($d);
    $cart = new cart($d);
    $detect = new Mobile_Detect;

    /* Router */
    require_once LIBRARIES."router.php";

    /* Template */
    if($deviceType!='computer') include "mobile.php";
    else include "desktop.php";
?>