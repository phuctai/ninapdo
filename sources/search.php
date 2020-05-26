<?php  
	if(!defined('_SOURCE')) die("Error");

	$title_bar = $title_crumb;

	if(isset($_GET['keyword']))
	{
		$tukhoa = htmlspecialchars($_GET['keyword']);
		$tukhoa = changeTitle($tukhoa);

		/* Tìm kiếm sản phẩm */
		$where = "";
		$where = "type = ? and (ten$lang LIKE ? or tenkhongdauvi LIKE ? or tenkhongdauen LIKE ?) and hienthi=1";
		$params = array("san-pham","%$tukhoa%","%$tukhoa%","%$tukhoa%");

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
	}

	/* breadCrumbs */
	if($title_crumb) $data['breadcrumbs'][] = array('slug'=>"",'name'=>$title_crumb);
	$breadcrumbs = $bc->getUrl(_trangchu, $data['breadcrumbs']);
?>