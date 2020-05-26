<?php
	if(!defined('_LIB')) die("Error");
	
	/* Timezone */
	date_default_timezone_set('Asia/Ho_Chi_Minh');

	/* Cấu hình coder */
	define('NN_MSHD','MSHD');
	define('NN_AUTHOR','phuctai.nina@gmail.com');

	/* Cấu hình chung */
	$config = array(
		'arrayDomainSSL' => array(),
		'database' => array(
			'server-name' => $_SERVER["SERVER_NAME"],
			'url' => '/sneakerltepdo/',
			'type' => 'mysql',
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'dbname' => 'sneakerltepdo',
			'port' => 3306,
			'prefix' => 'table_',
			'charset' => 'utf8'
		),
		'author' => array(
			'name' => 'Diệp Phúc Tài',
			'email' => 'phuctai.nina@gmail.com',
			'timefinish' => '04/2020'
		),
		'website' => array(
			'error-reporting' => false,
			'secret' => '$nina@',
			'salt' => 'swKJjeS!t',
			'debug-developer' => true,
			'debug-style' => false,
			'index' => false,
			'lang' => array(
				"vi"=>"Tiếng Việt",
				"en"=>"Tiếng Anh"
			),
			'slug' => array(
				'lang-active' => true
			),
			'seo' => array(
				'lang' => true,
				'headings' => true,
			),
			'comlang' => array(
				"gioi-thieu" => array("vi"=>"gioi-thieu","en"=>"about-us"),
				"san-pham" => array("vi"=>"san-pham","en"=>"product"),
				"tin-tuc" => array("vi"=>"tin-tuc","en"=>"news"),
				"tuyen-dung" => array("vi"=>"tuyen-dung","en"=>"recruitment"),
				"thu-vien-anh" => array("vi"=>"thu-vien-anh","en"=>"gallery"),
				"video" => array("vi"=>"video","en"=>"video"),
				"lien-he" => array("vi"=>"lien-he","en"=>"contact")
			)
		),
		'login' => array(
			'attempt' => 5,
			'delay' => 15
		),
		'googleAPI' => array(
			'recaptcha' => array(
				'active' => true,
				'urlapi' => 'https://www.google.com/recaptcha/api/siteverify',
				'sitekey' => '6LezS5kUAAAAAF2A6ICaSvm7R5M-BUAcVOgJT_31',
				'secretkey' => '6LezS5kUAAAAAGCGtfV7C1DyiqlPFFuxvacuJfdq'
			)
		),
		'oneSignal' => array(
			'active' => true,
			'id' => 'af12ae0e-cfb7-41d0-91d8-8997fca889f8',
			'restId' => 'MWFmZGVhMzYtY2U0Zi00MjA0LTg0ODEtZWFkZTZlNmM1MDg4'
		),
		'ckeditor' => array(
			'folder' => "upload/ckfinder/"
		),
		'license' => array(
			'version' => "7.0.0",
			'powered' => "phuctai.nina@gmail.com"
		)
	);

	/* Error reporting */
	error_reporting(($config['website']['error-reporting']) ? E_ALL & ~E_NOTICE : 0);

	/* Cấu hình lang HTML */
	foreach($config['website']['lang'] as $k => $v) $langHtml .= $k."|";
	$config['website']['langHtml'] = rtrim($langHtml,"|");

	/* Cấu hình lang SEO */
	if($config['website']['seo']['lang']) $langSeo = $config['website']['lang'];
	else $langSeo = array("vi"=>"Tiếng Việt");
	foreach($langSeo as $k => $v) $config['website']['seo']['preview'] .= $k.",";
	$config['website']['seo']['preview'] = rtrim($config['website']['seo']['preview'],",");

	/* Cấu hình slug */
	if($config['website']['slug']['lang-active']) $config['website']['slug']['lang'] = array("vi"=>"Tiếng Việt", "en"=>"Tiếng Anh");
	else $config['website']['slug']['lang'] = array("vi"=>"Tiếng Việt");
	foreach($config['website']['slug']['lang'] as $k => $v) $config['website']['slug']['preview'] .= $k.",";
	$config['website']['slug']['preview'] = rtrim($config['website']['slug']['preview'],",");

	/* Cấu hình base */
	if($config['arrayDomainSSL']) include_once _LIB."checkSSL.php";
	$http = 'http';
    if($_SERVER["HTTPS"] == "on") $http .= "s";
    $http .= "://";
	$config_base = $http.$config['database']['server-name'].$config['database']['url'];

	/* Cấu hình ckeditor */
	$_SESSION['baseUrl'] = $config_base.$config['ckeditor']['folder'];
?>