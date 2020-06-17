<?php
    require_once LIBRARIES.'config-type.php';
    header("Content-Type: text/xml; charset=utf-8");
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="https://www.sitemaps.org/schemas/sitemap/0.9 https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'; 
	echo '<url><loc>'.$config_base.'</loc><lastmod>'.date('c',time()).'</lastmod><changefreq>daily</changefreq><priority>0.1</priority></url>';
	foreach($config['seopage']['page'] as $k => $v)
	{
		echo '<url><loc>'.$config_base.$k.'</loc><lastmod>'.date('c',time()).'</lastmod><changefreq>daily</changefreq><priority>0.1</priority></url>';
	}
	foreach($config['sitemap']['static'] as $v)
	{
		echo '<url><loc>'.$config_base.$v.'</loc><lastmod>'.date('c',time()).'</lastmod><changefreq>daily</changefreq><priority>0.1</priority></url>';
	}
	foreach($config['sitemap']['product'] as $v)
	{
		$func->createSitemap($v,"product","list","c","daily","1","vi","stt,id");
		$func->createSitemap($v,"product","cat","c","daily","1","vi","stt,id");
		$func->createSitemap($v,"product","item","c","daily","1","vi","stt,id");
		$func->createSitemap($v,"product","sub","c","daily","1","vi","stt,id");
		$func->createSitemap($v,"product","brand","c","daily","1","vi","stt,id");
		$func->createSitemap($v,"product","","c","daily","1","vi","stt,id");
	}
	foreach($config['sitemap']['news'] as $v)
	{
		$func->createSitemap($v,"news","list","c","daily","1","vi","stt,id");
		$func->createSitemap($v,"news","cat","c","daily","1","vi","stt,id");
		$func->createSitemap($v,"news","item","c","daily","1","vi","stt,id");
		$func->createSitemap($v,"news","sub","c","daily","1","vi","stt,id");
		$func->createSitemap($v,"news","","c","daily","1","vi","stt,id");
	}
	foreach($config['sitemap']['tags'] as $v)
	{
		$func->createSitemap($v,"tags","","c","daily","1","vi","stt,id");
	}
	echo '</urlset>';
?>