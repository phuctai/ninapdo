<?php
	@define('_LIB','./libraries/');

	if(!isset($_SESSION['lang'])) $_SESSION['lang'] = 'vi';
	$lang = $_SESSION['lang'];

	include_once _LIB."AntiSQLInjection.php";
	include_once _LIB."config.php";
	require_once _LIB."lang$lang.php";
	include_once _LIB."PDODb.php";
    $d = new PDODb($config['database']);
	include_once _LIB."functions.php";

    header("Content-Type: application/xml; charset=utf-8");
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="https://www.sitemaps.org/schemas/sitemap/0.9 https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'; 
	echo '<url><loc>'.$config_base.'index</loc><lastmod>'.date('c',time()).'</lastmod><changefreq>daily</changefreq><priority>0.1</priority></url>';
	echo '<url><loc>'.$config_base.'gioi-thieu</loc><lastmod>'.date('c',time()).'</lastmod><changefreq>daily</changefreq><priority>0.1</priority></url>';
	echo '<url><loc>'.$config_base.'san-pham</loc><lastmod>'.date('c',time()).'</lastmod><changefreq>daily</changefreq><priority>0.1</priority></url>';
	echo '<url><loc>'.$config_base.'tuyen-dung</loc><lastmod>'.date('c',time()).'</lastmod><changefreq>daily</changefreq><priority>0.1</priority></url>';
	echo '<url><loc>'.$config_base.'tin-tuc</loc><lastmod>'.date('c',time()).'</lastmod><changefreq>daily</changefreq><priority>0.1</priority></url>';
	echo '<url><loc>'.$config_base.'lien-he</loc><lastmod>'.date('c',time()).'</lastmod><changefreq>daily</changefreq><priority>0.1</priority></url>';

	function create_sitemap($type='',$table='',$level='',$time='',$changefreq='',$priority='',$lang,$orderby='')
	{
		global $d, $sitemap, $config_base;

		if($level != "" && $table != 'tags')
		{
			$tablesitemap = $table;
			$table = $table."_".$level;
		}

		$sitemap = $d->rawQuery("select tenkhongdau$lang, ngaytao from #_$table where type = ? order by $orderby desc",array($type));

		for($i=0;$i<count($sitemap);$i++)
		{
			$urlsm = "";
			$urlsm = $config_base.$sitemap[$i]['tenkhongdau'.$lang];

			echo '<url>'; 
			echo '<loc>'.$urlsm.'</loc>'; 
			echo '<changefreq>'.$changefreq.'</changefreq>';
			echo '<lastmod>'.date($time,$sitemap[$i]['ngaytao']).'</lastmod>';
			echo '<priority>'.$priority.'</priority>';
			echo '</url>';
		}
	}

	/* Sản phẩm */
	create_sitemap("san-pham","product","list","c","daily","1","vi","stt,id");
	create_sitemap("san-pham","product","cat","c","daily","1","vi","stt,id");
	create_sitemap("san-pham","product","item","c","daily","1","vi","stt,id");
	create_sitemap("san-pham","product","sub","c","daily","1","vi","stt,id");
	create_sitemap("san-pham","product","brand","c","daily","1","vi","stt,id");
	create_sitemap("san-pham","product","","c","daily","1","vi","stt,id");

	/* Tags sản phẩm */
	create_sitemap("san-pham","tags","","c","daily","1","vi","stt,id");
	create_sitemap("tin-tuc","tags","","c","daily","1","vi","stt,id");
	
	/* Bài Viết */
	create_sitemap("tuyen-dung","news","","c","daily","1","vi","stt,id");
	create_sitemap("tin-tuc","news","","c","daily","1","vi","stt,id");

	/* Kết Thúc Tạo Sitemap */
	echo '</urlset>';
?>