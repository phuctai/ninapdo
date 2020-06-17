<?php  
	if(!defined('SOURCES')) die("Error");

	/* Lấy tất cả video */
	$where = "";
	$where = "hienthi=1 and type = ? and act <> ?";
	$params = array($type,'photo_static');

	$curPage = $get_page;
	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select photo, link_video, tenvi from #_photo where $where order by stt,id desc $limit";
	$video = $d->rawQuery($sql,$params);
	$sqlNum = "select count(*) as 'num' from #_photo where $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,$params);
	$total = $count['num'];
	$url = $func->getCurrentPageURL();
	$paging = $func->pagination($total,$per_page,$curPage,$url);

	/* SEO */
	$seopage = $d->rawQueryOne("SELECT * FROM table_seopage WHERE type = ?",array($type));
	$seo_h1 = $title_crumb;
	if($seopage['title'.$seolangkey]) $title_bar = $seopage['title'.$seolangkey];
	else $title_bar = $title_crumb;
	$keywords_bar = $seopage['keywords'.$seolangkey];
	$description_bar = $seopage['description'.$seolangkey];
	$img_bar = $config_base.THUMBS.'/300x200x2/'.UPLOAD_SEOPAGE_L.$seopage['photo'];
	$url_bar = $func->getPageURL();

	/* breadCrumbs */
	if($title_crumb) $data['breadcrumbs'][] = array('slug'=>$com,'name'=>$title_crumb);
	$breadcrumbs = $breadcr->getUrl(trangchu, $data['breadcrumbs']);
?>