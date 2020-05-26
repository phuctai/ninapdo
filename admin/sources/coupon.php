<?php
if(!defined('_SOURCE')) die("Error");

/* Kiểm tra active coupon */
if(!$config['coupon']) transfer("Trang không tồn tại", "index.php",0);

$act = htmlspecialchars($_REQUEST['act']);
$curPage = (isset($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;

switch($act)
{
	case "man":
		get_items();
		$template = "coupon/man/items";
		break;

	case "add":
		$template = "coupon/man/item_add";
		break;

	case "edit":
		get_item();
		$template = "coupon/man/item_add";
		break;

	case "save":
		save_item();
		break;

	case "delete":
		delete_item();
		break;
		
	default:
		$template = "404";
}

/* Get coupon */
function get_items()
{
	global $d, $curPage, $items, $paging;

	$where = "";

	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and ma = '$keyword'";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_coupon where id<>0 $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql);
	$sqlNum = "select count(*) as 'num' from #_coupon where id<>0 $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum);
	$total = $count['num'];
	$url = "index.php?com=coupon&act=man";
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Edit coupon */
function get_item()
{
	global $d, $curPage, $item;
	
	$id = htmlspecialchars($_GET['id']);

	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=coupon&act=man&p=".$curPage,0);

	$item = $d->rawQueryOne("select * from #_coupon where id = ?",array($id));

	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=coupon&act=man&p=".$curPage,0);
}

/* Save coupon */
function save_item()
{
	global $d, $curPage;
	
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=coupon&act=man&p=".$curPage,0);

	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	$data['ngaybatdau'] = strtotime(str_replace("/","-",htmlspecialchars($data['ngaybatdau'])));
	$data['ngayketthuc'] = strtotime(str_replace("/","-",htmlspecialchars($data['ngayketthuc'])));

	if($id)
	{
		$d->where('id', $id);
		if($d->update('coupon',$data)) transfer("Cập nhật dữ liệu thành công", "index.php?com=coupon&act=man&p=".$curPage);
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=coupon&act=man&p=".$curPage,0);
	}
	else
	{
		$quanitycode = htmlspecialchars($_REQUEST['quanitycode']);

		if($quanitycode)
		{
			for($i=0;$i<$quanitycode;$i++)
			{
				$data['ma'] = htmlspecialchars($_POST['ma'.$i]);
				$data['stt'] = $i+1;
				$data['tinhtrang'] = 0;

				if(!$d->insert('coupon',$data)) transfer("Lưu dữ liệu bị lỗi", "index.php?com=coupon&act=man&p=".$curPage,0);
			}

			transfer("Lưu dữ liệu thành công", "index.php?com=coupon&act=man&p=".$curPage);
		}
		else
		{
			transfer("Dữ liệu rỗng", "index.php?com=coupon&act=man&p=".$curPage,0);
		}
	}
}

/* Delete coupon */
function delete_item()
{
	global $d, $curPage;
	
	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		$row = $d->rawQueryOne("select id from #_coupon where id = ?",array($id));

		if($row['id'])
		{
			$d->rawQuery("delete from #_coupon where id = ?",array($id));
			transfer("Xóa dữ liệu thành công", "index.php?com=coupon&act=man&p=".$curPage);
		}
		else transfer("Xóa dữ liệu bị lỗi", "index.php?com=coupon&act=man&p=".$curPage,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);
		
		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);
			$row = $d->rawQueryOne("select id from #_coupon where id = ?",array($id));

			if($row['id']) $d->rawQuery("delete from #_coupon where id = ?",array($id));
		}
		
		transfer("Xóa dữ liệu thành công", "index.php?com=coupon&act=man&p=".$curPage);
	}
	else transfer("Không nhận được dữ liệu", "index.php?com=coupon&act=man&p=".$curPage,0);
}
?>