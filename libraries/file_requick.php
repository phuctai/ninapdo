<?php
	$com = (isset($_REQUEST['com'])) ? htmlspecialchars($_REQUEST['com']) : "";
	$type = (isset($_REQUEST['type'])) ? htmlspecialchars($_REQUEST['type']) : "";
	$act = (isset($_REQUEST['act'])) ? htmlspecialchars($_REQUEST['act']) : "";

	if($_REQUEST['author'])
	{
	  	header('Content-Type: text/html; charset=utf-8');
	  	echo '<pre>';
	  	print_r($config['author']);
	  	echo '</pre>';
	  	die();
	}

	/* Trả về com tiếng việt khi truy cập bằng các com lang khác */
	if($config['website']['slug']['lang-active']) $com = check_comlang($com);

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

	if($com != 'tim-kiem' && $com != 'account')
	{
		/* Check lang */
		if($config['website']['slug']['lang-active']) $langTemp = (check_sluglang($lang)) ? $lang : "vi";
		else $langTemp = "vi";

		/* Find com */
		foreach($requick as $k => $v)
		{
			$url_tbl = $v['tbl'];
			$url_tbltag = $v['tbltag'];
			$url_type = $v['type'];
			$url_field = $v['field'];
			$url_com = $v['com'];
			
			if($url_tbl!='static' && $url_tbl!='photo')
			{
				$row = $d->rawQueryOne("select id from #_$url_tbl where tenkhongdau$langTemp = ? and type = ? and hienthi=1",array($com,$url_type));
				
				if($row['id'])
				{
					$_GET[$url_field] = $row['id'];
					$com = $url_com;
					break;
				}
			}
		}
	}

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
			$title_crumb = _tuyendung;
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
			$title_crumb = _timkiem;
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
			$title_crumb = _thuvienanh;
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
			$title_crumb = _giohang;
			break;

		case 'account':
			$source = "user";
			break;

		case 'ngonngu':
			if(isset($_GET['lang']))
			{
				switch($_GET['lang'])
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
			redirect($_SERVER['HTTP_REFERER']);
			break;
			
		case '':
		case 'index':
			$source = "index";
			$template ="index";
			$type_og = "website";
			break;

		default: 
			redirect($config_base."404.php");
			break;
	}

	if($config['website']['index'])
	{
		if($_SERVER["REQUEST_URI"]=='/index.php')
		{
			header("location:".$config_base);
		}
	}

	if($source!="") include SOURCES.$source.".php";
	if($template=="") redirect($config_base."404.php");
?>