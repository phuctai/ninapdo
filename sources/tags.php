<?php  
	if(!defined('_SOURCE')) die("Error");
		
	$id = htmlspecialchars($_GET['id']);
	
	if($id)
	{
		/* Lấy tag detail */
		$tags_detail = $d->rawQueryOne("select id, ten$lang, type, photo from #_tags where id = ? and type = ?",array($id,$type));

		if($tags_detail['id']=='')
		{
			redirect($config_base."404.php");	
		}

		/* Lấy mục */
		$where = "";
		$where = "id_tags IN (".$tags_detail['id'].") and type = ?";
		$params = array($type);

		/* Column for sản phẩm */
		if($table == 'product') $col = "photo, ten$lang, giamoi, gia, giakm, id";

		/* Column for bài viết */
		if($table == 'news') $col = "photo, ten$lang, mota$lang, noidung$lang, ngaytao, id";

		$curPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$per_page = 10;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select $col from #_".$table." where $where order by stt,id desc $limit";
		$items = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_".$table." where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = getCurrentPageURL();
		$paging = pagination($total,$per_page,$curPage,$url);

		/* Data for sản phẩm */
		if($table == 'product') $product = $items;

		/* Data for bài viết */
		if($table == 'news') $news = $items;
		
		/* SEO */
		$title_cat = $tags_detail['ten'.$lang];
		$title_crumb = $tags_detail['ten'.$lang];
		$seo = get_seo($tags_detail['id'],'tags','man',$tags_detail['type']);
		if($config['website']['seo']['headings'])
		{
			$seo_h1 = $seo['seo_h1'.$seolangkey];
			$seo_h2 = $seo['seo_h2'.$seolangkey];
			$seo_h3 = $seo['seo_h3'.$seolangkey];
		}
		else
		{
			$seo_h1 = $tags_detail['ten'.$lang];
		}
		if($seo['title'.$seolangkey]) $title_bar = $seo['title'.$seolangkey];
		else $title_bar = $tags_detail['ten'.$lang];
		$keywords_bar = $seo['keywords'.$seolangkey];
		$description_bar = $seo['description'.$seolangkey];
		$img_bar = $config_base._upload_tags_l."300x200x2/".$tags_detail['photo'];
		$url_bar = getPageURL();

		/* breadCrumbs */
		if($title_crumb) $data['breadcrumbs'][] = array('slug'=>get_slug($lang,$tags_detail['id'],'tags'),'name'=>$title_crumb);
		$breadcrumbs = $bc->getUrl(_trangchu, $data['breadcrumbs']);
	}
?>