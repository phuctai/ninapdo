<?php
    session_start();
    @define('LIBRARIES','./libraries/');
    @define('SOURCES','./sources/');
    @define('LAYOUT','layout/');
    @define('THUMBS','thumbs');
    @define('WATERMARK','watermark');

    /* Config */
    require_once LIBRARIES."config.php";
    require_once LIBRARIES.'autoload.php';
    new AutoLoad();
    $injection = new AntiSQLInjection();
    $d = new PDODb($config['database']);
    $router = new AltoRouter();
    $cache = new FileCache($d);
    $func = new Functions($d);
    $breadcr = new BreadCrumbs($d);
    $statistic = new Statistic($d);
    $cart = new Cart($d);
    $detect = new MobileDetect();
    $css = new CssMinify($config['website']['debug-style'], $func);

    /* Router */
    require_once LIBRARIES."router.php";

    /* Template */
    include TEMPLATE."index.php";
?>