<?php
	@define('LIBRARIES','./');

	/* Config */
    require_once LIBRARIES."config.php";
    require_once LIBRARIES.'autoload.php';
    require_once LIBRARIES.'config-type.php';
    new AutoLoad();
    $d = new PDODb($config['database']);

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
	
	/* Begin sitemap */
    header("Content-Type: application/xml; charset=utf-8");
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="https://www.sitemaps.org/schemas/sitemap/0.9 https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'; 
	
	/* Page */
	echo '<url><loc>'.$config_base.'</loc><lastmod>'.date('c',time()).'</lastmod><changefreq>daily</changefreq><priority>0.1</priority></url>';
	foreach($config['seopage']['page'] as $k => $v)
	{
		echo '<url><loc>'.$config_base.$k.'</loc><lastmod>'.date('c',time()).'</lastmod><changefreq>daily</changefreq><priority>0.1</priority></url>';
	}

	/* Com: Static */
	foreach($config['sitemap']['static'] as $v)
	{
		echo '<url><loc>'.$config_base.$v.'</loc><lastmod>'.date('c',time()).'</lastmod><changefreq>daily</changefreq><priority>0.1</priority></url>';
	}

	/* Com: Product */
	foreach($config['sitemap']['product'] as $v)
	{
		create_sitemap($v,"product","list","c","daily","1","vi","stt,id");
		create_sitemap($v,"product","cat","c","daily","1","vi","stt,id");
		create_sitemap($v,"product","item","c","daily","1","vi","stt,id");
		create_sitemap($v,"product","sub","c","daily","1","vi","stt,id");
		create_sitemap($v,"product","brand","c","daily","1","vi","stt,id");
		create_sitemap($v,"product","","c","daily","1","vi","stt,id");
	}

	/* Com: News */
	foreach($config['sitemap']['news'] as $v)
	{
		create_sitemap($v,"news","list","c","daily","1","vi","stt,id");
		create_sitemap($v,"news","cat","c","daily","1","vi","stt,id");
		create_sitemap($v,"news","item","c","daily","1","vi","stt,id");
		create_sitemap($v,"news","sub","c","daily","1","vi","stt,id");
		create_sitemap($v,"news","","c","daily","1","vi","stt,id");
	}

	/* Com: Tags */
	foreach($config['sitemap']['tags'] as $v)
	{
		create_sitemap($v,"tags","","c","daily","1","vi","stt,id");
	}

	/* End sitemap */
	echo '</urlset>';
?>