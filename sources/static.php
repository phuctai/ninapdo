<?php  
	if(!defined('SOURCES')) die("Error");
	
	/* Lấy bài viết tĩnh */
	$static = $d->rawQueryOne("select type, ten$lang, noidung$lang, photo from #_static where type = ?",array($type));

	/* SEO */
	$seo = $func->get_seo(0,'static','capnhat',$static['type']);
	$seo_h1 = $static['ten'.$lang];
	if($seo['title'.$seolangkey]) $title_bar = $seo['title'.$seolangkey];
	else $title_bar = $static['ten'.$lang];
	$keywords_bar = $seo['keywords'.$seolangkey];
	$description_bar = $seo['description'.$seolangkey];
	$img_bar = $config_base.THUMBS.'/300x200x2/'.UPLOAD_NEWS_L.$static['photo'];
	$url_bar = $func->getPageURL();

	/* breadCrumbs */
	if($title_crumb) $data['breadcrumbs'][] = array('slug'=>$com,'name'=>$title_crumb);
	$breadcrumbs = $breadcr->getUrl(trangchu, $data['breadcrumbs']);
?>