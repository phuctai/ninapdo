<?php
if(!defined('SOURCES')) die("Error");

$act = htmlspecialchars($_REQUEST['act']);
$id = htmlspecialchars($_REQUEST['id']);
$type = htmlspecialchars($_REQUEST['type']);
$curPage = (isset($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;

/* Kiểm tra active tags */
$arrCheck = array();
foreach($config['tags'] as $k => $v) $arrCheck[] = $k;
if(!count($arrCheck) || !in_array($type,$arrCheck)) transfer("Trang không tồn tại", "index.php",0);

switch($act)
{
	case "man":
		get_items();
		$template = "tags/man/items";
		break;

	case "add":		
		$template = "tags/man/item_add";
		break;

	case "edit":		
		get_item();
		$template = "tags/man/item_add";
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

/* Get tags */
function get_items()
{
	global $d, $curPage, $items, $paging, $type;

	$where = "";
	
	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and (tenvi LIKE '%$keyword%' or tenen LIKE '%$keyword%')";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_tags where type = ? $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_tags where type = ? $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=tags&act=man&type=".$type;
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Edit tags */
function get_item()
{
	global $d, $curPage, $item, $type;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=tags&act=man&type=".$type."&p=".$curPage,0);

	$item = $d->rawQueryOne("select * from #_tags where id = ? and type = ?",array($id,$type));

	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=tags&act=man&type=".$type."&p=".$curPage,0);
}

/* Save tags */
function save_item()
{
	global $d, $curPage, $config, $com, $type;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=tags&act=man&type=".$type."&p=".$curPage,0);

	$file_name = upload_name($_FILES['file']["name"]);
	$id = htmlspecialchars($_POST['id']);
	
	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	if($_POST['slugvi']) $data['tenkhongdauvi'] = changeTitle(htmlspecialchars($_POST['slugvi']));
	else $data['tenkhongdauvi'] = changeTitle($data['tenvi']);
	if($_POST['slugen']) $data['tenkhongdauen'] = changeTitle(htmlspecialchars($_POST['slugen']));
	else $data['tenkhongdauen'] = changeTitle($data['tenen']);
	$data['hienthi'] = ($data['hienthi']) ? 1 : 0;
	$data['type'] = $type;

	/* Post seo */
	if($config['tags'][$type]['seo'])
	{
		$dataSeo = $_POST['dataSeo'];
		foreach($dataSeo as $column => $value) $dataSeo[$column] = htmlspecialchars($value);
	}

	if($id)
	{
		if($photo = uploadImage("file", $config['tags'][$type]['img_type'], UPLOAD_TAGS,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['tags'][$type]['thumb_width'], $config['tags'][$type]['thumb_height'], UPLOAD_TAGS,$file_name,$config['tags'][$type]['thumb_ratio']);			
			
			$row = $d->rawQueryOne("select id, photo, thumb from #_tags where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(UPLOAD_TAGS.$row['photo']);
				delete_file(UPLOAD_TAGS.$row['thumb']);
			}
		}

		$data['ngaysua'] = time();

		$d->where('id', $id);
		$d->where('type', $type);
		if($d->update('tags',$data))
		{
			/* SEO */
			if($config['tags'][$type]['seo'])
			{
				$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man',$type));

				$dataSeo['idmuc'] = $id;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			transfer("Cập nhật dữ liệu thành công", "index.php?com=tags&act=man&type=".$type."&p=".$curPage);
		}
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=tags&act=man&type=".$type."&p=".$curPage,0);
	}
	else
	{
		if($photo = uploadImage("file", $config['tags'][$type]['img_type'], UPLOAD_TAGS,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['tags'][$type]['thumb_width'], $config['tags'][$type]['thumb_height'], UPLOAD_TAGS,$file_name,$config['tags'][$type]['thumb_ratio']);				
		}					
		
		$data['ngaytao'] = time();

		if($d->insert('tags',$data))
		{
			$id_insert = $d->getLastInsertId();

			/* SEO */
			if($config['tags'][$type]['seo'])
			{
				$dataSeo['idmuc'] = $id_insert;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			transfer("Lưu dữ liệu thành công", "index.php?com=tags&act=man&type=".$type."&p=".$curPage);
		}
		else transfer("Lưu dữ liệu bị lỗi", "index.php?com=tags&act=man&type=".$type."&p=".$curPage,0);
	}
}

/* Delete tags */
function delete_item()
{
	global $d, $curPage, $com, $type;

	$id = htmlspecialchars($_GET['id']);
	if($id)
	{
		/* Xóa SEO */
		$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man',$type));

		/* Lấy dữ liệu */
		$row = $d->rawQueryOne("select id, photo, thumb from #_tags where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			delete_file(UPLOAD_TAGS.$row['photo']);
			delete_file(UPLOAD_TAGS.$row['thumb']);
			$d->rawQuery("delete from #_tags where id = ?",array($id));

			transfer("Xóa dữ liệu thành công", "index.php?com=tags&act=man&type=".$type."&p=".$curPage);
		}
		else transfer("Xóa dữ liệu bị lỗi", "index.php?com=tags&act=man&type=".$type."&p=".$curPage,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);

			/* Xóa SEO */
			$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man',$type));

			/* Lấy dữ liệu */
			$row = $d->rawQueryOne("select id, photo, thumb from #_tags where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(UPLOAD_TAGS.$row['photo']);
				delete_file(UPLOAD_TAGS.$row['thumb']);
				$d->rawQuery("delete from #_tags where id = ?",array($id));
			}
		}
		
		transfer("Xóa dữ liệu thành công", "index.php?com=tags&act=man&type=".$type."&p=".$curPage);
	} 
	else transfer("Không nhận được dữ liệu", "index.php?com=tags&act=man&type=".$type."&p=".$curPage,0);
}
?>