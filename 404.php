<?php
    session_start();
    @define('LIBRARIES' ,'./libraries/');

    /* Config */
    require_once LIBRARIES."config.php";
    require_once LIBRARIES.'autoload.php';
    new AutoLoad();
    $injection = new AntiSQLInjection();
    $d = new PDODb($config['database']);

    /* Setting */
    $setting = $d->rawQueryOne("select * from table_setting");

    /* Cấu hình ngôn ngữ */
    if($_REQUEST['lang']!='') $_SESSION['lang'] = $_REQUEST['lang'];
    else if(!isset($_SESSION['lang']) && !isset($_REQUEST['lang'])) $_SESSION['lang'] = $setting['lang_default'];
    $lang = $_SESSION['lang'];

    require_once LIBRARIES."lang/lang$lang.php";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
	<title>404</title>
	<meta name="keywords" content="404">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:700,900" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="assets/404_files/style.css" />
</head>
<body>
	<div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>404</h1>
            </div>
            <h2>Oops! Trang hiện không tồn tại</h2>
            <p>Trang bạn đang tìm kiếm không tồn tại, bị xóa hoặc thông tin đã bị thay đổi. </p>
            <a href="index">Trở lại trang chủ</a>
        </div>
    </div>
</body>
</html>