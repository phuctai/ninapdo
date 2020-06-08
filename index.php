<?php
    session_start();
    @define('LIBRARIES','./libraries/');
    @define('SOURCES','./sources/');
    @define('LAYOUT','layout/');

    /* Config */
    include_once LIBRARIES."config.php";
    require_once LIBRARIES.'autoload.php';
    new autoload();
    $injection = new AntiSQLInjection();
    $d = new PDODb($config['database']);
    $func = new functions($d);
    $breadcr = new breadCrumbs($d);
    $statistic = new statistic($d);
    $cart = new cart($d);
    $detect = new Mobile_Detect;

    /* Mobile detect */
    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
    if($deviceType != 'computer') @define('TEMPLATE','./templates-mobile/');
    else @define('TEMPLATE','./templates/');

    /* Setting */
    $setting = $d->rawQueryOne("select * from table_setting");

    /* Cấu hình ngôn ngữ */
    if($_REQUEST['lang']!='') $_SESSION['lang'] = $_REQUEST['lang'];
    else if(!isset($_SESSION['lang']) && !isset($_REQUEST['lang'])) $_SESSION['lang'] = $setting['lang_default'];
    $lang = $_SESSION['lang'];

    /* Cấu hình SEO Lang */
    if($config['website']['seo']['lang']) $seolangkey = $lang;
    else $seolangkey = "vi";

    /* Libraries */
    require_once LIBRARIES."lang$lang.php";
    include_once LIBRARIES."requick.php";
    include_once SOURCES."allpage.php";

    /* Include template */
    if($deviceType!='computer') include "mobile.php";
    else include "desktop.php";
?>