<?php  
	if(!defined('SOURCES')) die("Error");

	/* Lấy tất cả video */
	$where = "";
	$where = "hienthi=1 and type = ?";
	$params = array($type);

	$curPage = isset($_GET['p']) ? $_GET['p'] : 1;
	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select photo, link_video, tenvi from #_photo where $where order by stt,id desc $limit";
	$video = $d->rawQuery($sql,$params);
	$sqlNum = "select count(*) as 'num' from #_photo where $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,$params);
	$total = $count['num'];
	$url = getCurrentPageURL();
	$paging = pagination($total,$per_page,$curPage,$url);

	/* SEO */
	$seopage = $d->rawQueryOne("SELECT * FROM table_seopage WHERE type = ?",array($type));
	if($config['website']['seo']['headings'])
	{
		$seo_h1 = $seopage['seo_h1'.$seolangkey];
		$seo_h2 = $seopage['seo_h2'.$seolangkey];
		$seo_h3 = $seopage['seo_h3'.$seolangkey];
	}
	else
	{
		$seo_h1 = $title_crumb;
	}
	if($seopage['title'.$seolangkey]) $title_bar = $seopage['title'.$seolangkey];
	else $title_bar = $title_crumb;
	$keywords_bar = $seopage['keywords'.$seolangkey];
	$description_bar = $seopage['description'.$seolangkey];
	$img_bar = $config_base.UPLOAD_SEOPAGE_L."300x200x2/".$seopage['photo'];
	$url_bar = getPageURL();

	/* breadCrumbs */
	if($title_crumb) $data['breadcrumbs'][] = array('slug'=>get_comlang('video',$lang),'name'=>$title_crumb);
	$breadcrumbs = $bc->getUrl(trangchu, $data['breadcrumbs']);
?>