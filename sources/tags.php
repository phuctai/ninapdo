<?php  
	if(!defined('SOURCES')) die("Error");
		
	$id = htmlspecialchars($_GET['id']);
	
	if($id)
	{
		/* Lấy tag detail */
		$tags_detail = $d->rawQueryOne("select id, ten$lang, type, photo from #_tags where id = ? and type = ?",array($id,$type));

		if($tags_detail['id']=='')
		{
			$func->redirect($config_base."404.php",404);	
		}

		/* Lấy mục */
		$where = "";
		$where = "id_tags IN (".$tags_detail['id'].") and type = ?";
		$params = array($type);

		/* Column for sản phẩm */
		if($table == 'product') $col = "photo, ten$lang, tenkhongdauvi, tenkhongdauen, giamoi, gia, giakm, id";

		/* Column for bài viết */
		if($table == 'news') $col = "photo, ten$lang, tenkhongdauvi, tenkhongdauen, mota$lang, noidung$lang, ngaytao, id";

		$curPage = $get_page;
		$per_page = 10;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select $col from #_".$table." where $where order by stt,id desc $limit";
		$items = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_".$table." where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = $func->getCurrentPageURL();
		$paging = $func->pagination($total,$per_page,$curPage,$url);

		/* Data for sản phẩm */
		if($table == 'product') $product = $items;

		/* Data for bài viết */
		if($table == 'news') $news = $items;
		
		/* SEO */
		$title_cat = $tags_detail['ten'.$lang];
		$title_crumb = $tags_detail['ten'.$lang];
		$seo = $func->get_seo($tags_detail['id'],'tags','man',$tags_detail['type']);
		$seo_h1 = $tags_detail['ten'.$lang];
		if($seo['title'.$seolangkey]) $title_bar = $seo['title'.$seolangkey];
		else $title_bar = $tags_detail['ten'.$lang];
		$keywords_bar = $seo['keywords'.$seolangkey];
		$description_bar = $seo['description'.$seolangkey];
		$img_bar = $config_base.THUMBS.'/300x200x2/'.UPLOAD_TAGS_L.$tags_detail['photo'];
		$url_bar = $func->getPageURL();

		/* breadCrumbs */
		if($title_crumb) $data['breadcrumbs'][] = array('slug'=>$tags_detail[$sluglang],'name'=>$title_crumb);
		$breadcrumbs = $breadcr->getUrl(trangchu, $data['breadcrumbs']);
	}
?>