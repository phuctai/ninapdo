<?php
	/* Validate URL */
	$func->checkUrl($config['website']['index']);

	/* Check login */
    $func->checkLogin();

	/* Mobile detect */
    $deviceType = ($detect->isMobile() || $detect->isTablet()) ? 'mobile' : 'computer';
    if($deviceType == 'computer') @define('TEMPLATE','./templates/');
    else @define('TEMPLATE','./templates-mobile/');

    /* Watermark */
    $wtmPro = $d->rawQueryOne("SELECT hienthi, photo, position FROM table_photo WHERE type = ? AND act = ?",array('watermark','photo_static'));
	$wtmNews = $d->rawQueryOne("SELECT hienthi, photo, position FROM table_photo WHERE type = ? AND act = ?",array('watermark-news','photo_static'));

    /* Router */
    $router->setBasePath($config['database']['url']);
    $router->map('GET|POST', '', 'index');
    $router->map('GET|POST', 'sitemap.xml', 'sitemap', 'sitemap');
    $router->map('GET|POST', '[a:com]', 'AllPage', 'show');
    $router->map('GET|POST', '[a:com]/[a:lang]/', 'AllPage', 'lang');
    $router->map('GET|POST', '[a:com]/[a:kind]', 'AllPage', 'kind');
    $router->map('GET', THUMBS.'/[i:w]x[i:h]x[i:z]/[**:src]', function($w,$h,$z,$src){
        global $func;
        $func->createThumb($w,$h,$z,$src,null);
    },'thumb');
    $router->map('GET', 'watermark/[i:w]x[i:h]x[i:z]/[**:src]', function($w,$h,$z,$src){
        global $func, $wtmPro;
        $func->createThumb($w,$h,$z,$src,$wtmPro);
    },'watermark');
    $router->map('GET', 'watermark-news/[i:w]x[i:h]x[i:z]/[**:src]', function($w,$h,$z,$src){
        global $func, $wtmNews;
        $func->createThumb($w,$h,$z,$src,$wtmNews);
    },'watermarkNews');
    $match = $router->match();
	if(is_array($match))
	{
		if(is_callable($match['target']))
		{
			call_user_func_array($match['target'], $match['params']); 
		}
		else
		{
			$com = (isset($match['params']['com'])) ? $match['params']['com'] : $match['target'];
			$get_page = isset($_GET['p']) ? $_GET['p'] : 1;
		}
	}
	else
	{
		header($_SERVER["SERVER_PROTOCOL"].'404 Not Found');
		include("404.php");
		exit;
	}

    /* Setting */
    $sqlCache = "select * from table_setting";
    $setting = $cache->getCache($sqlCache,'fetch',600);

    /* Lang */
    if($match['params']['lang']) $_SESSION['lang'] = $match['params']['lang'];
    else if(!isset($_SESSION['lang']) && !isset($match['params']['lang'])) $_SESSION['lang'] = $setting['lang_default'];
    $lang = $_SESSION['lang'];

    /* Slug lang */
    $sluglang = 'tenkhongdauvi';

    /* SEO Lang */
    $seolangkey = "vi";

    /* Require datas */
    require_once LIBRARIES."lang/lang$lang.php";
    require_once SOURCES."allpage.php";

	/* Tối ưu link */
	$requick = array(
		/* Sản phẩm */
		array("tbl"=>"product_list","field"=>"idl","source"=>"product","com"=>"san-pham","type"=>"san-pham"),
		array("tbl"=>"product_cat","field"=>"idc","source"=>"product","com"=>"san-pham","type"=>"san-pham"),
		array("tbl"=>"product_item","field"=>"idi","source"=>"product","com"=>"san-pham","type"=>"san-pham"),
		array("tbl"=>"product_sub","field"=>"ids","source"=>"product","com"=>"san-pham","type"=>"san-pham"),
		array("tbl"=>"product_brand","field"=>"idb","source"=>"product","com"=>"thuong-hieu","type"=>"san-pham"),
		array("tbl"=>"product","field"=>"id","source"=>"product","com"=>"san-pham","type"=>"san-pham"),
		
		/* Tags */
		array("tbl"=>"tags","tbltag"=>"product","field"=>"id","source"=>"tags","com"=>"tags-san-pham","type"=>"san-pham"),
		array("tbl"=>"tags","tbltag"=>"news","field"=>"id","source"=>"tags","com"=>"tags-tin-tuc","type"=>"tin-tuc"),

		/* Thư viện ảnh */
		array("tbl"=>"product","field"=>"id","source"=>"product","com"=>"thu-vien-anh","type"=>"thu-vien-anh"),

		/* Video */
		array("tbl"=>"photo","field"=>"id","source"=>"video","com"=>"video","type"=>"video"),

		/* Tin tức */
		array("tbl"=>"news_list","field"=>"idl","source"=>"news","com"=>"tin-tuc","type"=>"tin-tuc"),
		array("tbl"=>"news_cat","field"=>"idc","source"=>"news","com"=>"tin-tuc","type"=>"tin-tuc"),
		array("tbl"=>"news_item","field"=>"idi","source"=>"news","com"=>"tin-tuc","type"=>"tin-tuc"),
		array("tbl"=>"news_sub","field"=>"ids","source"=>"news","com"=>"tin-tuc","type"=>"tin-tuc"),
		array("tbl"=>"news","field"=>"id","source"=>"news","com"=>"tin-tuc","type"=>"tin-tuc"),

		/* Bài viết */
		array("tbl"=>"news","field"=>"id","source"=>"news","com"=>"tuyen-dung","type"=>"tuyen-dung"),
		array("tbl"=>"news","field"=>"id","source"=>"news","com"=>"chinh-sach","type"=>"chinh-sach"),

		/* Trang tĩnh */
		array("tbl"=>"static","field"=>"id","source"=>"static","com"=>"gioi-thieu","type"=>"gioi-thieu"),
	);

	/* Find data */
	if($com != 'tim-kiem' && $com != 'account' && $com != 'sitemap')
	{
		foreach($requick as $k => $v)
		{
			$url_tbl = $v['tbl'];
			$url_tbltag = $v['tbltag'];
			$url_type = $v['type'];
			$url_field = $v['field'];
			$url_com = $v['com'];
			
			if($url_tbl!='static' && $url_tbl!='photo')
			{
				$row = $d->rawQueryOne("select id from #_$url_tbl where $sluglang = ? and type = ? and hienthi=1",array($com,$url_type));
				
				if($row['id'])
				{
					$_GET[$url_field] = $row['id'];
					$com = $url_com;
					break;
				}
			}
		}
	}

	/* Switch coms */
	switch($com)
	{
		case 'lien-he':
			$source = "contact";
			$template = "contact";
			$type_og = "object";
			$title_crumb = lienhe;
			break;

		case 'gioi-thieu':
			$source = "static";
			$template = "static";
			$type = $com;
			$type_og = "article";
			$title_crumb = gioithieu;
			break;

		case 'tin-tuc':
			$source = "news";
			$template = isset($_GET['id']) ? "news_detail" : "news";
			$type_og = isset($_GET['id']) ? "article" : "object";
			$type = $com;
			$title_crumb = tintuc;
			break;

		case 'tuyen-dung':
			$source = "news";
			$template = isset($_GET['id']) ? "news_detail" : "news";
			$type_og = isset($_GET['id']) ? "article" : "object";
			$type = $com;
			$title_crumb = tuyendung;
			break;

		case 'chinh-sach':
			$source = "news";
			$template = isset($_GET['id']) ? "news_detail" : "";
			$type_og = isset($_GET['id']) ? "article" : "";
			$type = $com;
			break;

		case 'thuong-hieu':
			$source = "product";
			$template = "product";
			$type_og = "object";
			$type = 'san-pham';
			break;

		case 'san-pham':
			$source = "product";
			$template = isset($_GET['id']) ? "product_detail" : "product";
			$type_og = isset($_GET['id']) ? "article" : "object";
			$type = $com;
			$title_crumb = sanpham;
			break;

		case 'tim-kiem':
			$source = "search";
			$template = "product";
			$type_og = "object";
			$title_crumb = timkiem;
			break;

		case 'tags-san-pham':
			$source = "tags";
			$template = "product";
			$type = $url_type;
			$table = $url_tbltag;
			$type_og = "object";
			break;

		case 'tags-tin-tuc':
			$source = "tags";
			$template = "news";
			$type = $url_type;
			$table = $url_tbltag;
			$type_og = "object";
			break;

		case 'thu-vien-anh':
			$source = "product";
			$template = isset($_GET['id']) ? "album_detail" : "album";
			$type_og = isset($_GET['id']) ? "article" : "object";
			$type = $com;
			$title_crumb = thuvienanh;
			break;
		
		case 'video':
			$source = "video";
			$template = "video";
			$type = $com;
			$type_og = "object";
			$title_crumb = "Video";
			break;

		case 'gio-hang':
			$source = "giohang";
			$template = 'giohang';
			$title_crumb = giohang;
			break;

		case 'account':
			$source = "user";
			break;

		case 'ngon-ngu':
			if(isset($lang))
			{
				switch($lang)
				{
					case 'vi':
						$_SESSION['lang'] = 'vi';
						break;
					case 'en':
						$_SESSION['lang'] = 'en';
						break;
					default: 
						$_SESSION['lang'] = 'vi';
						break;
				}
			}
			$func->redirect($_SERVER['HTTP_REFERER']);
			break;

		case 'sitemap':
			include_once LIBRARIES."sitemap.php";
			exit();
			
		case '':
		case 'index':
			$source = "index";
			$template ="index";
			$type_og = "website";
			break;

		default: 
			header('HTTP/1.0 404 Not Found', true, 404);
			include("404.php");
			exit();
	}

	/* Include sources */
	if($source!='') include SOURCES.$source.".php";
	if($template=='')
	{
		header('HTTP/1.0 404 Not Found', true, 404);
		include("404.php");
		exit();
	}
?>