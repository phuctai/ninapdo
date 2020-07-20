<?php  
	if(!defined('SOURCES')) die("Error");
	
	/* Lấy bài viết tĩnh */
	$static = $d->rawQueryOne("select id, type, ten$lang, noidung$lang, photo from #_static where type = ?",array($type));

	/* SEO */
	$seoDB = $seo->getSeoDB(0,'static','capnhat',$static['type']);
	$seo->setSeo('h1',$static['ten'.$lang]);
	if($seoDB['title'.$seolang]!='') $seo->setSeo('title',$seoDB['title'.$seolang]);
	else $seo->setSeo('title',$static['ten'.$lang]);
	$seo->setSeo('keywords',$seoDB['keywords'.$seolang]);
	$seo->setSeo('description',$seoDB['description'.$seolang]);
	$seo->setSeo('url',$func->getPageURL());
	$img_json_bar = json_decode($static['options'],true);
	if($img_json_bar['p'] != $static['photo'])
	{
		$img_json_bar = $func->getImgSize($static['photo'],UPLOAD_NEWS_L.$static['photo']);
		$seo->updateSeoDB(json_encode($img_json_bar),'static',$static['id']);
	}
	$seo->setSeo('photo',$config_base.THUMBS.'/'.$img_json_bar['w'].'x'.$img_json_bar['h'].'x2/'.UPLOAD_NEWS_L.$static['photo']);
	$seo->setSeo('photo:width',$img_json_bar['w']);
	$seo->setSeo('photo:height',$img_json_bar['h']);
	$seo->setSeo('photo:type',$img_json_bar['m']);

	/* breadCrumbs */
	if($title_crumb) $breadcr->setBreadCrumbs($com,$title_crumb);
	$breadcrumbs = $breadcr->getBreadCrumbs();
?>