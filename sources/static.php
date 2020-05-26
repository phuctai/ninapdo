<?php  
	if(!defined('_SOURCE')) die("Error");
	
	/* Lấy bài viết tĩnh */
	$static = $d->rawQueryOne("select type, ten$lang, noidung$lang, photo from #_static where type = ?",array($type));

	/* SEO */
	$seo = get_seo(0,'static','capnhat',$static['type']);
	if($config['website']['seo']['headings'])
	{
		$seo_h1 = $seo['seo_h1'.$seolangkey];
		$seo_h2 = $seo['seo_h2'.$seolangkey];
		$seo_h3 = $seo['seo_h3'.$seolangkey];
	}
	else
	{
		$seo_h1 = $static['ten'.$lang];
	}
	if($seo['title'.$seolangkey]) $title_bar = $seo['title'.$seolangkey];
	else $title_bar = $static['ten'.$lang];
	$keywords_bar = $seo['keywords'.$seolangkey];
	$description_bar = $seo['description'.$seolangkey];
	$img_bar = $config_base._upload_news_l."300x200x2/".$static['photo'];
	$url_bar = getPageURL();

	/* breadCrumbs */
	if($title_crumb) $data['breadcrumbs'][] = array('slug'=>get_comlang($type,$lang),'name'=>$title_crumb);
	$breadcrumbs = $bc->getUrl(_trangchu, $data['breadcrumbs']);
?>