<?php
    session_start();
    @define('LIBRARIES','./libraries/');
    @define('SOURCES','./sources/');
    @define('LAYOUT','layout/');

    /* Config */
    include_once LIBRARIES."AntiSQLInjection.php";
    include_once LIBRARIES."config.php";
    include_once LIBRARIES."PDODb.php";
    include_once LIBRARIES."breadCrumbs.php";
    $d = new PDODb($config['database']);
    $bc = new breadCrumbs($d);

    /* Setting */
    $setting = $d->rawQueryOne("select * from table_setting");

    /* Cấu hình ngôn ngữ */
    if($_REQUEST['lang']!='') $_SESSION['lang'] = $_REQUEST['lang'];
    else if(!isset($_SESSION['lang']) && !isset($_REQUEST['lang'])) $_SESSION['lang'] = $setting['lang_default'];
    $lang = $_SESSION['lang'];

    /* Cấu hình SEO Lang */
    if($config['website']['seo']['lang']) $seolangkey = $lang;
    else $seolangkey = "vi";

    /* Mobile detect */
    include_once LIBRARIES."Mobile_Detect.php";
    $detect = new Mobile_Detect;
    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
    if($deviceType != 'computer') @define('TEMPLATE','./templates-mobile/');
    else @define('TEMPLATE','./templates/');

    /* Libraries */
    include_once LIBRARIES."constant.php";
    require_once LIBRARIES."lang$lang.php";
    include_once LIBRARIES."functions.php";
    include_once LIBRARIES."functionsCart.php";
    include_once LIBRARIES."file_requick.php";
    include_once SOURCES."counter.php";
    include_once SOURCES."allpage.php";

    /* Include template */
    if($deviceType!='computer') include "mobile.php";
    else include "desktop.php";
?>