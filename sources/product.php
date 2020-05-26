<?php  
	if(!defined('_SOURCE')) die("Error");

	@$id = htmlspecialchars($_GET['id']);
	@$idl = htmlspecialchars($_GET['idl']);
	@$idc = htmlspecialchars($_GET['idc']);
	@$idi = htmlspecialchars($_GET['idi']);
	@$ids = htmlspecialchars($_GET['ids']);
	@$idb = htmlspecialchars($_GET['idb']);

	if($id!='')
	{
		/* Lấy sản phẩm detail */
		$row_detail = $d->rawQueryOne("select type, id, ten$lang, mota$lang, noidung$lang, masp, luotxem, id_brand, id_mau, id_size, id_list, id_cat, id_item, id_sub, id_tags, photo from #_product where hienthi=1 and id = ? and type = ?",array($id,$type));

		if($row_detail['id']=='')
		{
			redirect($config_base."404.php");	
		}

		/* Cập nhật lượt xem */
		$data_luotxem['luotxem'] = $row_detail['luotxem'] + 1;
		$d->where('id',$row_detail['id']);
		$d->update('product',$data_luotxem);

        /* Lấy tags */
		$pro_tags = $d->rawQuery("select id, ten$lang from #_tags where id in (".$row_detail['id_tags'].") and type='".$type."'");

		/* Lấy thương hiệu */
		$pro_brand = $d->rawQuery("select ten$lang, id from #_product_brand where hienthi=1 and id = ? and type = ?",array($row_detail['id_brand'],$type));

		/* Lấy màu */
		$mau = $d->rawQuery("select loaihienthi, thumb, mau, id from #_product_mau where hienthi=1 and type='".$type."' and find_in_set(id,'".$row_detail['id_mau']."') order by stt,id desc");

		/* Lấy size */
		$size = $d->rawQuery("select id, ten$lang from #_product_size where hienthi=1 and type='".$type."' and find_in_set(id,'".$row_detail['id_size']."') order by stt,id desc");

		/* Lấy cấp 1 */
		$pro_list = $d->rawQueryOne("select id, ten$lang from #_product_list where hienthi=1 and id = ? and type = ?",array($row_detail['id_list'],$type));

		/* Lấy cấp 2 */
		$pro_cat = $d->rawQueryOne("select id, ten$lang from #_product_cat where hienthi=1 and id = ? and type = ?",array($row_detail['id_cat'],$type));

		/* Lấy cấp 3 */
		$pro_item = $d->rawQueryOne("select id, ten$lang from #_product_item where hienthi=1 and id = ? and type = ?",array($row_detail['id_item'],$type));

		/* Lấy cấp 4 */
		$pro_sub = $d->rawQueryOne("select id, ten$lang from #_product_sub where hienthi=1 and id = ? and type = ?",array($row_detail['id_sub'],$type));
		
		/* Lấy hình ảnh con */
		$hinhanhsp = $d->rawQuery("select photo from #_gallery where hienthi=1 and id_photo = ? and com='product' and type = ? and kind='man' and val = ? order by stt,id desc",array($row_detail['id'],$type,$type));

		/* Lấy sản phẩm cùng loại */
		$where = "";
		$where = "hienthi=1 and id <> ? and id_list = ? and type = ?";
		$params = array($id,$row_detail['id_list'],$type);

		$curPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$per_page = 8;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select photo, ten$lang, giamoi, gia, giakm, id from #_product where $where order by stt,id desc $limit";
		$product = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_product where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = getCurrentPageURL();
		$paging = pagination($total,$per_page,$curPage,$url);

		/* SEO */
		$seo = get_seo($row_detail['id'],'product','man',$row_detail['type']);
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
		$img_bar = $config_base._upload_product_l."300x200x2/".$row_detail['photo'];
		$url_bar = getPageURL();

		/* breadCrumbs */
		if($title_crumb) $data['breadcrumbs'][] = array('slug'=>get_comlang($type,$lang),'name'=>$title_crumb);
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$pro_list['id'],'product_list'),'name'=>$pro_list['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$pro_cat['id'],'product_cat'),'name'=>$pro_cat['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$pro_item['id'],'product_item'),'name'=>$pro_item['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$pro_sub['id'],'product_sub'),'name'=>$pro_sub['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$row_detail['id'],'product'),'name'=>$row_detail['ten'.$lang]);
		$breadcrumbs = $bc->getUrl(_trangchu, $data['breadcrumbs']);
	}
	else if($idl!='')
	{
		/* Lấy cấp 1 detail */
		$pro_list = $d->rawQueryOne("select id, ten$lang, type, photo from #_product_list where id = ? and type = ?",array($idl,$type));

		if($pro_list['id']=='')
		{
			redirect($config_base."404.php");	
		}

		/* SEO */
		$title_cat = $pro_list['ten'.$lang];
		$seo = get_seo($pro_list['id'],'product','man_list',$pro_list['type']);
		if($config['website']['seo']['headings'])
		{
			$seo_h1 = $seo['seo_h1'.$seolangkey];
			$seo_h2 = $seo['seo_h2'.$seolangkey];
			$seo_h3 = $seo['seo_h3'.$seolangkey];
		}
		else
		{
			$seo_h1 = $pro_list['ten'.$lang];
		}
		if($seo['title'.$seolangkey]!='') $title_bar = $seo['title'.$seolangkey];
		else $title_bar = $pro_list['ten'.$lang];
		$keywords_bar = $seo['keywords'.$seolangkey];
		$description_bar = $seo['description'.$seolangkey];
		$img_bar = $config_base._upload_product_l."300x200x2/".$pro_list['photo'];
		$url_bar = getPageURL();

		/* Lấy sản phẩm */
		$where = "";
		$where = "id_list = ? and type = ? and hienthi=1";
		$params = array($idl,$type);

		$curPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$per_page = 20;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select photo, ten$lang, giamoi, gia, giakm, id from #_product where $where order by stt,id desc $limit";
		$product = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_product where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = getCurrentPageURL();
		$paging = pagination($total,$per_page,$curPage,$url);

		/* breadCrumbs */
		if($title_crumb) $data['breadcrumbs'][] = array('slug'=>get_comlang($type,$lang),'name'=>$title_crumb);
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$pro_list['id'],'product_list'),'name'=>$pro_list['ten'.$lang]);
		$breadcrumbs = $bc->getUrl(_trangchu, $data['breadcrumbs']);	
	}
	else if($idc!='')
	{
		/* Lấy cấp 2 detail */
		$pro_cat = $d->rawQueryOne("select id, id_list, ten$lang, type, photo from #_product_cat where id = ? and type = ?",array($idc,$type));

		if($pro_cat['id']=='')
		{
			redirect($config_base."404.php");	
		}

		/* Lấy cấp 1 */
		$pro_list = $d->rawQueryOne("select id, ten$lang from #_product_list where id = ? and type = ?",array($pro_cat['id_list'],$type));

		/* Lấy sản phẩm */
		$where = "";
		$where = "id_cat = ? and type = ? and hienthi=1";
		$params = array($idc,$type);

		$curPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$per_page = 20;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select photo, ten$lang, giamoi, gia, giakm, id from #_product where $where order by stt,id desc $limit";
		$product = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_product where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = getCurrentPageURL();
		$paging = pagination($total,$per_page,$curPage,$url);

		/* SEO */
		$title_cat = $pro_cat['ten'.$lang];
		$seo = get_seo($pro_cat['id'],'product','man_cat',$pro_cat['type']);
		if($config['website']['seo']['headings'])
		{
			$seo_h1 = $seo['seo_h1'.$seolangkey];
			$seo_h2 = $seo['seo_h2'.$seolangkey];
			$seo_h3 = $seo['seo_h3'.$seolangkey];
		}
		else
		{
			$seo_h1 = $pro_cat['ten'.$lang];
		}
		if($seo['title'.$seolangkey]!='') $title_bar = $seo['title'.$seolangkey];
		else $title_bar = $pro_cat['ten'.$lang];
		$keywords_bar = $seo['keywords'.$seolangkey];
		$description_bar = $seo['description'.$seolangkey];
		$img_bar = $config_base._upload_product_l."300x200x2/".$pro_cat['photo'];
		$url_bar = getPageURL();

		/* breadCrumbs */
		if($title_crumb) $data['breadcrumbs'][] = array('slug'=>get_comlang($type,$lang),'name'=>$title_crumb);
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$pro_list['id'],'product_list'),'name'=>$pro_list['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$pro_cat['id'],'product_cat'),'name'=>$pro_cat['ten'.$lang]);
		$breadcrumbs = $bc->getUrl(_trangchu, $data['breadcrumbs']);
	}
	else if($idi!='')
	{
		/* Lấy cấp 3 detail */
		$pro_item = $d->rawQueryOne("select id, id_list, id_cat, ten$lang, type, photo from #_product_item where id = ? and type = ?",array($idi,$type));

		if($pro_item['id']=='')
		{
			redirect($config_base."404.php");	
		}

		/* Lấy cấp 1 */
		$pro_list = $d->rawQueryOne("select id, ten$lang from #_product_list where id = ? and type = ?",array($pro_item['id_list'],$type));

		/* Lấy cấp 2 */
		$pro_cat = $d->rawQueryOne("select id, ten$lang from #_product_cat where id_list = ? and id = ? and type = ?",array($pro_item['id_list'],$pro_item['id_cat'],$type));

		/* Lấy sản phẩm */
		$where = "";
		$where = "id_item = ? and type = ? and hienthi=1";
		$params = array($idi,$type);

		$curPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$per_page = 20;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select photo, ten$lang, giamoi, gia, giakm, id from #_product where $where order by stt,id desc $limit";
		$product = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_product where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = getCurrentPageURL();
		$paging = pagination($total,$per_page,$curPage,$url);

		/* SEO */
		$title_cat = $pro_item['ten'.$lang];
		$seo = get_seo($pro_item['id'],'product','man_item',$pro_item['type']);
		if($config['website']['seo']['headings'])
		{
			$seo_h1 = $seo['seo_h1'.$seolangkey];
			$seo_h2 = $seo['seo_h2'.$seolangkey];
			$seo_h3 = $seo['seo_h3'.$seolangkey];
		}
		else
		{
			$seo_h1 = $pro_item['ten'.$lang];
		}
		if($seo['title'.$seolangkey]!='') $title_bar = $seo['title'.$seolangkey];
		else $title_bar = $pro_item['ten'.$lang];
		$keywords_bar = $seo['keywords'.$seolangkey];
		$description_bar = $seo['description'.$seolangkey];
		$img_bar = $config_base._upload_product_l."300x200x2/".$pro_item['photo'];
		$url_bar = getPageURL();

		/* breadCrumbs */
		if($title_crumb) $data['breadcrumbs'][] = array('slug'=>get_comlang($type,$lang),'name'=>$title_crumb);
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$pro_list['id'],'product_list'),'name'=>$pro_list['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$pro_cat['id'],'product_cat'),'name'=>$pro_cat['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$pro_item['id'],'product_item'),'name'=>$pro_item['ten'.$lang]);
		$breadcrumbs = $bc->getUrl(_trangchu, $data['breadcrumbs']);
	}
	else if($ids!='')
	{
		/* Lấy cấp 4 */
		$pro_sub = $d->rawQueryOne("select id, id_list, id_cat, id_item, ten$lang, type, photo from #_product_sub where id = ? and type = ?",array($ids,$type));

		if($pro_sub['id']=='')
		{
			redirect($config_base."404.php");	
		}

		/* Lấy cấp 1 */
		$pro_list = $d->rawQueryOne("select id, ten$lang from #_product_list where id = ? and type = ?",array($pro_sub['id_list'],$type));

		/* Lấy cấp 2 */
		$pro_cat = $d->rawQueryOne("select id, ten$lang from #_product_cat where id_list = ? and id = ? and type = ?",array($pro_sub['id_list'],$pro_sub['id_cat'],$type));

		/* Lấy cấp 3 */
		$pro_item = $d->rawQueryOne("select id, ten$lang from #_product_item where id_list = ? and id_cat = ? and id = ? and type = ?",array($pro_sub['id_list'],$pro_sub['id_cat'],$pro_sub['id_item'],$type));

		/* Lấy sản phẩm */
		$where = "";
		$where = "id_sub = ? and type = ? and hienthi=1";
		$params = array($ids,$type);

		$curPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$per_page = 20;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select photo, ten$lang, giamoi, gia, giakm, id from #_product where $where order by stt,id desc $limit";
		$product = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_product where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = getCurrentPageURL();
		$paging = pagination($total,$per_page,$curPage,$url);

		/* SEO */
		$title_cat = $pro_sub['ten'.$lang];
		$seo = get_seo($pro_sub['id'],'product','man_sub',$pro_sub['type']);
		if($config['website']['seo']['headings'])
		{
			$seo_h1 = $seo['seo_h1'.$seolangkey];
			$seo_h2 = $seo['seo_h2'.$seolangkey];
			$seo_h3 = $seo['seo_h3'.$seolangkey];
		}
		else
		{
			$seo_h1 = $pro_sub['ten'.$lang];
		}
		if($seo['title'.$seolangkey]!='') $title_bar = $seo['title'.$seolangkey];
		else $title_bar = $pro_sub['ten'.$lang];
		$keywords_bar = $seo['keywords'.$seolangkey];
		$description_bar = $seo['description'.$seolangkey];
		$img_bar = $config_base._upload_product_l."300x200x2/".$pro_sub['photo'];
		$url_bar = getPageURL();

		/* breadCrumbs */
		if($title_crumb) $data['breadcrumbs'][] = array('slug'=>get_comlang($type,$lang),'name'=>$title_crumb);
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$pro_list['id'],'product_list'),'name'=>$pro_list['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$pro_cat['id'],'product_cat'),'name'=>$pro_cat['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$pro_item['id'],'product_item'),'name'=>$pro_item['ten'.$lang]);
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$pro_sub['id'],'product_sub'),'name'=>$pro_sub['ten'.$lang]);
		$breadcrumbs = $bc->getUrl(_trangchu, $data['breadcrumbs']);
	}
	else if($idb!='')
	{
		/* Lấy brand detail */
		$pro_brand = $d->rawQueryOne("select ten$lang, id, type, photo from #_product_brand where id = ? and type = ?",array($idb,$type));

		if($pro_brand['id']=='')
		{
			redirect($config_base."404.php");	
		}

		/* SEO */
		$title_cat = $pro_brand['ten'.$lang];
		$seo = get_seo($pro_brand['id'],'product','man_brand',$pro_brand['type']);
		if($config['website']['seo']['headings'])
		{
			$seo_h1 = $seo['seo_h1'.$seolangkey];
			$seo_h2 = $seo['seo_h2'.$seolangkey];
			$seo_h3 = $seo['seo_h3'.$seolangkey];
		}
		else
		{
			$seo_h1 = $pro_brand['ten'.$lang];
		}
		if($seo['title'.$seolangkey]!='') $title_bar = $seo['title'.$seolangkey];
		else $title_bar = $pro_brand['ten'.$lang];
		$keywords_bar = $seo['keywords'.$seolangkey];
		$description_bar = $seo['description'.$seolangkey];
		$img_bar = $config_base._upload_product_l."300x200x2/".$pro_brand['photo'];
		$url_bar = getPageURL();

		/* Lấy sản phẩm */
		$where = "";
		$where = "id_brand = ? and type = ? and hienthi=1";
		$params = array($pro_brand['id'],$type);

		$curPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$per_page = 20;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select photo, ten$lang, giamoi, gia, giakm, id from #_product where $where order by stt,id desc $limit";
		$product = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_product where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = getCurrentPageURL();
		$paging = pagination($total,$per_page,$curPage,$url);

		/* breadCrumbs */
		$data['breadcrumbs'][] = array('slug'=>get_slug($lang,$pro_brand['id'],'product_brand'),'name'=>$title_cat);
		$breadcrumbs = $bc->getUrl(_trangchu, $data['breadcrumbs']);
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
		$img_bar = $config_base._upload_seopage_l."300x200x2/".$seopage['photo'];
		$url_bar = getPageURL();

		/* Lấy tất cả sản phẩm */
		$where = "";
		$where = "hienthi=1 and type = ?";
		$params = array($type);

		$curPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$per_page = 20;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select photo, ten$lang, giamoi, gia, giakm, id from #_product where $where order by stt,id desc $limit";
		$product = $d->rawQuery($sql,$params);
		$sqlNum = "select count(*) as 'num' from #_product where $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum,$params);
		$total = $count['num'];
		$url = getCurrentPageURL();
		$paging = pagination($total,$per_page,$curPage,$url);

		/* breadCrumbs */
		$data['breadcrumbs'][] = array('slug'=>get_comlang($type,$lang),'name'=>$title_crumb);
		$breadcrumbs = $bc->getUrl(_trangchu, $data['breadcrumbs']);
	}
?>