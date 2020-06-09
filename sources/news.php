<?php  
	if(!defined('SOURCES')) die("Error");

	@$id = htmlspecialchars($_GET['id']);
	@$idl = htmlspecialchars($_GET['idl']);
	@$idc = htmlspecialchars($_GET['idc']);
	@$idi = htmlspecialchars($_GET['idi']);
	@$ids = htmlspecialchars($_GET['ids']);

	if($id!='')
	{
		/* Lấy bài viết detail */
		$row_detail = $d->rawQueryOne("select id, luotxem, id_list, id_cat, id_item, id_sub, type, ten$lang, noidung$lang, photo from #_news where hienthi=1 and id = ? and type = ?",array($id,$type));

		if($row_detail['id']=='')
		{
			$func->redirect($config_base."404.php");	
		}

		/* Cập nhật lượt xem */
		$data_luotxem['luotxem'] = $row_detail['luotxem'] + 1;
		$d->where('id',$row_detail['id']);
		$d->update('news',$data_luotxem);

		/* Lấy cấp 1 */
		$news_list = $d->rawQueryOne("select id, ten$lang from #_news_list where hienthi=1 and id = ? and type = ?",array($row_detail['id_list'],$type));

		/* Lấy cấp 2 */
		$news_cat = $d->rawQueryOne("select id, ten$lang from #_news_cat where hienthi=1 and id = ? and type = ?",array($row_detail['id_cat'],$type));

		/* Lấy cấp 3 */
		$news_item = $d->rawQueryOne("select id, ten$lang from #_news_item where hienthi=1 and id = ? and type = ?",array($row_detail['id_item'],$type));

		/* Lấy cấp 4 */
		$news_sub = $d->rawQueryOne("select id, ten$lang from #_news_sub where hienthi=1 and id = ? and type = ?",array($row_detail['id_sub'],$type));	
		
		/* Lấy hình ảnh con */
		$hinhanhtt = $d->rawQuery("select photo from #_gallery where hienthi=1 and id_photo = ? and com='news' and type = ? and kind='man' and val = ? order by stt,id desc",array($row_detail['id'],$type,$type));

		/* Lấy bài viết cùng loại */
		$where = "";
		$where = "hienthi=1 and id <> ? and id_list = ? and type = ?";
		$params = array($id,$row_detail['id_list'],$type);

		$curPage = $get_page;
		$per_page = 10;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select id, ten$lang, photo, ngaytao, mota$lang from #_news where $where order by stt,id desc $limit";
		$news = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_news where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = $func->getCurrentPageURL();
		$paging = $func->pagination($total,$per_page,$curPage,$url);

		/* SEO */
		$seo = $func->get_seo($row_detail['id'],'news','man',$row_detail['type']);
		if($config['website']['seo']['headings'])
		{
			$seo_h1 = $seo['seo_h1'.$seolangkey];
			$seo_h2 = $seo['seo_h2'.$seolangkey];
			$seo_h3 = $seo['seo_h3'.$seolangkey];
		}
		else
		{
			$seo_h1 = $row_detail['ten'.$lang];
		}
		if($seo['title'.$seolangkey]!='') $title_bar = $seo['title'.$seolangkey];
		else $title_bar = $row_detail['ten'.$lang];
		$keywords_bar = $seo['keywords'.$seolangkey];
		$description_bar = $seo['description'.$seolangkey];
		$img_bar = $config_base.UPLOAD_NEWS_L."300x200x2/".$row_detail['photo'];
		$url_bar = $func->getPageURL();

		/* breadCrumbs */
		if($title_crumb) $data['breadcrumbs'][] = array('slug'=>$func->get_comlang($type,$lang),'name'=>$title_crumb);
		$data['breadcrumbs'][] = array('slug'=>$func->get_slug($lang,$news_list['id'],'news_list'),'name'=>$news_list['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>$func->get_slug($lang,$news_cat['id'],'news_cat'),'name'=>$news_cat['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>$func->get_slug($lang,$news_item['id'],'news_item'),'name'=>$news_item['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>$func->get_slug($lang,$news_sub['id'],'news_sub'),'name'=>$news_sub['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>$func->get_slug($lang,$row_detail['id'],'news'),'name'=>$row_detail['ten'.$lang]);
		$breadcrumbs = $breadcr->getUrl(trangchu, $data['breadcrumbs']);
	}
	else if($idl!='')
	{
		/* Lấy cấp 1 detail */
		$news_list = $d->rawQueryOne("select id, ten$lang, type, photo from #_news_list where id = ? and type = ?",array($idl,$type));

		if($news_list['id']=='')
		{
			$func->redirect($config_base."404.php");	
		}

		/* SEO */
		$title_cat = $news_list['ten'.$lang];
		$seo = $func->get_seo($news_list['id'],'news','man_list',$news_list['type']);
		if($config['website']['seo']['headings'])
		{
			$seo_h1 = $seo['seo_h1'.$seolangkey];
			$seo_h2 = $seo['seo_h2'.$seolangkey];
			$seo_h3 = $seo['seo_h3'.$seolangkey];
		}
		else
		{
			$seo_h1 = $news_list['ten'.$lang];
		}
		if($seo['title'.$seolangkey]!='') $title_bar = $seo['title'.$seolangkey];
		else $title_bar = $news_list['ten'.$lang];
		$keywords_bar = $seo['keywords'.$seolangkey];
		$description_bar = $seo['description'.$seolangkey];
		$img_bar = $config_base.UPLOAD_NEWS_L."300x200x2/".$news_list['photo'];
		$url_bar = $func->getPageURL();

		/* Lấy bài viết */
		$where = "";
		$where = "id_list = ? and type = ? and hienthi=1";
		$params = array($idl,$type);

		$curPage = $get_page;
		$per_page = 10;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select id, ten$lang, photo, ngaytao, mota$lang from #_news where $where order by stt,id desc $limit";
		$news = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_news where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = $func->getCurrentPageURL();
		$paging = $func->pagination($total,$per_page,$curPage,$url);

		/* breadCrumbs */
		if($title_crumb) $data['breadcrumbs'][] = array('slug'=>$func->get_comlang($type,$lang),'name'=>$title_crumb);
		$data['breadcrumbs'][] = array('slug'=>$func->get_slug($lang,$news_list['id'],'news_list'),'name'=>$news_list['ten'.$lang]);
		$breadcrumbs = $breadcr->getUrl(trangchu, $data['breadcrumbs']);
	}
	else if($idc!='')
	{
		/* Lấy cấp 2 detail */
		$news_cat = $d->rawQueryOne("select id, id_list, ten$lang, type, photo from #_news_cat where id = ? and type = ?",array($idc,$type));

		if($news_cat['id']=='')
		{
			$func->redirect($config_base."404.php");	
		}

		/* Lấy cấp 1 */
		$news_list = $d->rawQueryOne("select id, ten$lang from #_news_list where id = ? and type = ?",array($news_cat['id_list'],$type));
		
		/* Lấy bài viết */
		$where = "";
		$where = "id_cat = ? and type = ? and hienthi=1";
		$params = array($idc,$type);

		$curPage = $get_page;
		$per_page = 10;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select id, ten$lang, photo, ngaytao, mota$lang from #_news where $where order by stt,id desc $limit";
		$news = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_news where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = $func->getCurrentPageURL();
		$paging = $func->pagination($total,$per_page,$curPage,$url);

		/* SEO */
		$title_cat = $news_cat['ten'.$lang];
		$seo = $func->get_seo($news_cat['id'],'news','man_cat',$news_cat['type']);
		if($config['website']['seo']['headings'])
		{
			$seo_h1 = $seo['seo_h1'.$seolangkey];
			$seo_h2 = $seo['seo_h2'.$seolangkey];
			$seo_h3 = $seo['seo_h3'.$seolangkey];
		}
		else
		{
			$seo_h1 = $news_cat['ten'.$lang];
		}
		if($seo['title'.$seolangkey]!='') $title_bar = $seo['title'.$seolangkey];
		else $title_bar = $news_cat['ten'.$lang];
		$keywords_bar = $seo['keywords'.$seolangkey];
		$description_bar = $seo['description'.$seolangkey];
		$img_bar = $config_base.UPLOAD_NEWS_L."300x200x2/".$news_cat['photo'];
		$url_bar = $func->getPageURL();

		/* breadCrumbs */
		if($title_crumb) $data['breadcrumbs'][] = array('slug'=>$func->get_comlang($type,$lang),'name'=>$title_crumb);
		$data['breadcrumbs'][] = array('slug'=>$func->get_slug($lang,$news_list['id'],'news_list'),'name'=>$news_list['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>$func->get_slug($lang,$news_cat['id'],'news_cat'),'name'=>$news_cat['ten'.$lang]);
		$breadcrumbs = $breadcr->getUrl(trangchu, $data['breadcrumbs']);
	}
	else if($idi!='')
	{
		/* Lấy cấp 3 detail */
		$news_item = $d->rawQueryOne("select id, id_list, id_cat, ten$lang, type, photo from #_news_item where id = ? and type = ?",array($idi,$type));

		if($news_item['id']=='')
		{
			$func->redirect($config_base."404.php");	
		}

		/* Lấy cấp 1 */
		$news_list = $d->rawQueryOne("select id, ten$lang from #_news_list where id = ? and type = ?",array($news_item['id_list'],$type));

		/* Lấy cấp 2 */
		$news_cat = $d->rawQueryOne("select id, ten$lang from #_news_cat where id_list = ? and id = ? and type = ?",array($news_item['id_list'],$news_item['id_cat'],$type));

		/* Lấy bài viết */
		$where = "";
		$where = "id_item = ? and type = ? and hienthi=1";
		$params = array($idi,$type);

		$curPage = $get_page;
		$per_page = 10;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select id, ten$lang, photo, ngaytao, mota$lang from #_news where $where order by stt,id desc $limit";
		$news = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_news where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = $func->getCurrentPageURL();
		$paging = $func->pagination($total,$per_page,$curPage,$url);

		/* SEO */
		$title_cat = $news_item['ten'.$lang];
		$seo = $func->get_seo($news_item['id'],'news','man_item',$news_item['type']);
		if($config['website']['seo']['headings'])
		{
			$seo_h1 = $seo['seo_h1'.$seolangkey];
			$seo_h2 = $seo['seo_h2'.$seolangkey];
			$seo_h3 = $seo['seo_h3'.$seolangkey];
		}
		else
		{
			$seo_h1 = $news_item['ten'.$lang];
		}
		if($seo['title'.$seolangkey]!='') $title_bar = $seo['title'.$seolangkey];
		else $title_bar = $news_item['ten'.$lang];
		$keywords_bar = $seo['keywords'.$seolangkey];
		$description_bar = $seo['description'.$seolangkey];
		$img_bar = $config_base.UPLOAD_NEWS_L."300x200x2/".$news_item['photo'];
		$url_bar = $func->getPageURL();

		/* breadCrumbs */
		if($title_crumb) $data['breadcrumbs'][] = array('slug'=>$func->get_comlang($type,$lang),'name'=>$title_crumb);
		$data['breadcrumbs'][] = array('slug'=>$func->get_slug($lang,$news_list['id'],'news_list'),'name'=>$news_list['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>$func->get_slug($lang,$news_cat['id'],'news_cat'),'name'=>$news_cat['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>$func->get_slug($lang,$news_item['id'],'news_item'),'name'=>$news_item['ten'.$lang]);
		$breadcrumbs = $breadcr->getUrl(trangchu, $data['breadcrumbs']);
	}
	else if($ids!='')
	{
		/* Lấy cấp 4 */
		$news_sub = $d->rawQueryOne("select id, id_list, id_cat, id_item, ten$lang, type, photo from #_news_sub where id = ? and type = ?",array($ids,$type));

		if($news_sub['id']=='')
		{
			$func->redirect($config_base."404.php");	
		}

		/* Lấy cấp 1 */
		$news_list = $d->rawQueryOne("select id, ten$lang from #_news_list where id = ? and type = ?",array($news_sub['id_list'],$type));

		/* Lấy cấp 2 */
		$news_cat = $d->rawQueryOne("select id, ten$lang from #_news_cat where id_list = ? and id = ? and type = ?",array($news_sub['id_list'],$news_sub['id_cat'],$type));

		/* Lấy cấp 3 */
		$news_item = $d->rawQueryOne("select id, ten$lang from #_news_item where id_list = ? and id_cat = ? and id = ? and type = ?",array($news_sub['id_list'],$news_sub['id_cat'],$news_sub['id_item'],$type));

		/* Lấy bài viết */
		$where = "";
		$where = "id_sub = ? and type = ? and hienthi=1";
		$params = array($ids,$type);

		$curPage = $get_page;
		$per_page = 10;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select id, ten$lang, photo, ngaytao, mota$lang from #_news where $where order by stt,id desc $limit";
		$news = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_news where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = $func->getCurrentPageURL();
		$paging = $func->pagination($total,$per_page,$curPage,$url);

		/* SEO */
		$title_cat = $news_sub['ten'.$lang];
		$seo = $func->get_seo($news_sub['id'],'news','man_sub',$news_sub['type']);
		if($config['website']['seo']['headings'])
		{
			$seo_h1 = $seo['seo_h1'.$seolangkey];
			$seo_h2 = $seo['seo_h2'.$seolangkey];
			$seo_h3 = $seo['seo_h3'.$seolangkey];
		}
		else
		{
			$seo_h1 = $news_sub['ten'.$lang];
		}
		if($seo['title'.$seolangkey]!='') $title_bar = $seo['title'.$seolangkey];
		else $title_bar = $news_sub['ten'.$lang];
		$keywords_bar = $seo['keywords'.$seolangkey];
		$description_bar = $seo['description'.$seolangkey];
		$img_bar = $config_base.UPLOAD_NEWS_L."300x200x2/".$news_sub['photo'];
		$url_bar = $func->getPageURL();

		/* breadCrumbs */
		if($title_crumb) $data['breadcrumbs'][] = array('slug'=>$func->get_comlang($type,$lang),'name'=>$title_crumb);
		$data['breadcrumbs'][] = array('slug'=>$func->get_slug($lang,$news_list['id'],'news_list'),'name'=>$news_list['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>$func->get_slug($lang,$news_cat['id'],'news_cat'),'name'=>$news_cat['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>$func->get_slug($lang,$news_item['id'],'news_item'),'name'=>$news_item['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>$func->get_slug($lang,$news_sub['id'],'news_sub'),'name'=>$news_sub['ten'.$lang]);
		$breadcrumbs = $breadcr->getUrl(trangchu, $data['breadcrumbs']);
	}
	else
	{
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
		$url_bar = $func->getPageURL();

		/* Lấy tất cả bài viết */
		$where = "";
		$where = "hienthi=1 and type = ?";
		$params = array($type);

		$curPage = $get_page;
		$per_page = 10;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select id, ten$lang, photo, ngaytao, mota$lang from #_news where $where order by stt,id desc $limit";
		$news = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_news where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = $func->getCurrentPageURL();
		$paging = $func->pagination($total,$per_page,$curPage,$url);

		/* breadCrumbs */
		$data['breadcrumbs'][] = array('slug'=>$func->get_comlang($type,$lang),'name'=>$title_crumb);
		$breadcrumbs = $breadcr->getUrl(trangchu, $data['breadcrumbs']);
	}
?>