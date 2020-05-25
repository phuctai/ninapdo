<?php
if(!defined('_SOURCE')) die("Error");

$act = htmlspecialchars($_REQUEST['act']);
$curPage = (isset($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;

switch($act)
{
	case "man":
		get_items();
		$template = "contact/man/items";
		break;

	case "edit":
		get_item();
		$template = "contact/man/item_add";
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

/* Get contact */
function get_items()
{
	global $d, $curPage, $items, $paging;

	$where = "";

	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and ten LIKE '%$keyword%'";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_contact where id<>0 $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql);
	$sqlNum = "select count(*) as 'num' from #_contact where id<>0 $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum);
	$total = $count['num'];
	$url = "index.php?com=contact&act=man";
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Edit contact */
function get_item()
{
	global $d, $curPage, $item;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=contact&act=man&p=".$curPage,0);

	$item = $d->rawQueryOne("select * from #_contact where id = ?",array($id));

	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=contact&act=man&p=".$curPage,0);
}

/* Save contact */
function save_item()
{
	global $d, $curPage;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=contact&act=man&p=".$curPage,0);

	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	
	if($id)
	{
		$data['hienthi'] = 1;
		$data['ngaysua'] = time();
		
		$d->where('id', $id);
		if($d->update('contact',$data)) transfer("Cập nhật dữ liệu thành công", "index.php?com=contact&act=man&p=".$curPage);
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=contact&act=man&p=".$curPage,0);
	}
	else
	{
		transfer("Dữ liệu rỗng", "index.php?com=contact&act=man&p=".$curPage,0);
	}
}

/* Delete contact */
function delete_item()
{
	global $d, $curPage;
	
	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		$row = $d->rawQueryOne("select id, taptin from #_contact where id = ?",array($id));

		if($row['id'])
		{
			delete_file(_upload_file.$row['taptin']);
			$d->rawQuery("delete from #_contact where id = ?",array($id));
			transfer("Xóa dữ liệu thành công", "index.php?com=contact&act=man&p=".$curPage);
		}
		else transfer("Xóa dữ liệu bị lỗi", "index.php?com=contact&act=man&p=".$curPage,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);
			$row = $d->rawQueryOne("select id, taptin from #_contact where id = ?",array($id));
			
			if($row['id'])
			{
				delete_file(_upload_file.$row['taptin']);
				$d->rawQuery("delete from #_contact where id = ?",array($id));
			}
		}
		
		transfer("Xóa dữ liệu thành công", "index.php?com=contact&act=man&p=".$curPage);
	}
	else transfer("Không nhận được dữ liệu", "index.php?com=contact&act=man&p=".$curPage,0);
}
?>