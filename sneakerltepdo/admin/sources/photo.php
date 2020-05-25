<?php
if(!defined('_SOURCE')) die("Error");

$act = htmlspecialchars($_REQUEST['act']);
$type = htmlspecialchars($_REQUEST['type']);
$curPage = (isset($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;

/* Kiểm tra active photo */
$arrCheck = array();
$actCheck = '';
if($act=='photo_static' || $act=='save_static') $actCheck = 'photo_static';
else $actCheck = 'man_photo';
foreach($config['photo'][$actCheck] as $k => $v) $arrCheck[] = $k;
if(!count($arrCheck) || !in_array($type,$arrCheck)) transfer("Trang không tồn tại", "index.php",0);

switch($act)
{
	/* Photo static */
	case "photo_static":
		get_photo_static();
		$template = "photo/static/photo_static";
		break;
	case "save_static":
		save_static();
		break;

	/* Photos */
	case "man_photo":
		get_photos();
		$template = "photo/man/photos";
		break;
	case "add_photo":
		$template = "photo/man/photo_add";
		break;
	case "edit_photo":
		get_photo();
		$template = "photo/man/photo_edit";
		break;
	case "save_photo":
		save_photo();
		break;
	case "delete_photo":
		delete_photo();
		break;

	default:
		$template = "404";
}

/* Get photo static */
function get_photo_static()
{
	global $d, $item, $type;

	$item = $d->rawQueryOne("select * from #_photo where act = ? and type = ?",array('photo_static',$type));
}

/* Save photo static */
function save_static()
{
	global $d, $config, $type;

	$file_name = upload_name($_FILES['file']["name"]);
	$row = $d->rawQueryOne("select id from #_photo where act = ? and type = ?",array('photo_static',$type));
	$id = $row['id'];

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	$data['hienthi'] = ($data['hienthi']) ? 1 : 0;
	$data['type'] = $type;
	$data['act'] = 'photo_static';

	if($config['photo']['photo_static'][$type]['removeCacheThumb'])
	{
		/* Xóa Cache Thumb */
		removeCacheThumb("../upload!@#cache");
	}

	if($id)
	{
		if($photo = uploadImage("file", $config['photo']['photo_static'][$type]['img_type'], _upload_photo, $file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['photo']['photo_static'][$type]['thumb_width'], $config['photo']['photo_static'][$type]['thumb_height'], _upload_photo,$file_name,$config['photo']['photo_static'][$type]['thumb_ratio']);

			$row = $d->rawQueryOne("select id, photo, thumb from #_photo where id = ? and act = ? and type = ?",array($id,'photo_static',$type));

			if($row['id'])
			{
				delete_file(_upload_photo.$row['photo']);
				delete_file(_upload_photo.$row['thumb']);
			}
		}

		$data['ngaysua'] = time();

		$d->where('id', $id);
		$d->where('type', $type);
		if($d->update('photo',$data)) transfer("Cập nhật dữ liệu thành công", "index.php?com=photo&act=photo_static&type=".$type);
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=photo&act=photo_static&type=".$type,0);
	}
	else
	{
		if($photo = uploadImage("file", $config['photo']['photo_static'][$type]['img_type'], _upload_photo, $file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['photo']['photo_static'][$type]['thumb_width'], $config['photo']['photo_static'][$type]['thumb_height'], _upload_photo,$file_name,$config['photo']['photo_static'][$type]['thumb_ratio']);
		}
		else
		{
			$data['photo'] = "";
			$data['thumb'] = "";
		}

		$data['ngaytao'] = time();

		if($data['photo']!='' || $data['link_video']!='')
		{
			if($d->insert('photo',$data)) transfer("Lưu dữ liệu thành công", "index.php?com=photo&act=photo_static&type=".$type);
			else transfer("Lưu dữ liệu bị lỗi", "index.php?com=photo&act=photo_static&type=".$type,0);	
		}
		else
		{
			transfer("Dữ liệu rỗng", "index.php?com=photo&act=photo_static&type=".$type,0);
		}
	}
}

/* Get photo */
function get_photos()
{
	global $d, $curPage, $items, $paging, $type;

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_photo where type = ? and act <> ? order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type,'photo_static'));
	$sqlNum = "select count(*) as 'num' from #_photo where type = ? and act <> ? order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type,'photo_static'));
	$total = $count['num'];
	$url = "index.php?com=photo&act=man_photo&type=".$type;
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Edit photo */
function get_photo()
{
	global $d, $curPage, $item, $list_cat, $type;
	
	$id = htmlspecialchars($_GET['id']);

	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=".$type."&p=".$curPage,0);

	$item = $d->rawQueryOne("select * from #_photo where id = ? and act <> ? and type = ?",array($id,'photo_static',$type));

	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=photo&act=man_photo&type=".$type."&p=".$curPage,0);
}

/* Save photo */
function save_photo()
{
	global $d, $curPage, $config, $type;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=".$type."&p=".$curPage,0);
	
	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	$dataMultiTemp = $_POST['dataMulti'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);

	if($id)
	{
		$file_name = upload_name($_FILES["file"]["name"]);
		if($photo = uploadImage("file", $config['photo']['man_photo'][$type]['img_type_photo'], _upload_photo,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['photo']['man_photo'][$type]['thumb_width_photo'], $config['photo']['man_photo'][$type]['thumb_height_photo'], _upload_photo,$file_name,$config['photo']['man_photo'][$type]['thumb_ratio_photo']);
			
			$row = $d->rawQueryOne("select id, photo, thumb from #_photo where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_photo.$row['photo']);
				delete_file(_upload_photo.$row['thumb']);
			}
		}
		
		$data['hienthi'] = ($data['hienthi']) ? 1 : 0;
		$data['act'] = 'photo_multi';

		$d->where('id', $id);
		$d->where('type', $type);
		if($d->update('photo',$data)) transfer("Cập nhật dữ liệu thành công", "index.php?com=photo&act=man_photo&type=".$type."&p=".$curPage);
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=".$type."&p=".$curPage,0);
	}
	else
	{
		$numberPhoto = $config['photo']['man_photo'][$type]['number_photo'];

		if($numberPhoto)
		{
			for($i=0;$i<count($dataMultiTemp);$i++)
			{
				$dataMulti = $dataMultiTemp[$i];
				$dataMulti['hienthi'] = ($dataMultiTemp[$i]['hienthi']) ? 1 : 0;
				$dataMulti['type'] = $type;
				$dataMulti['act'] = 'photo_multi';

				if($config['photo']['man_photo'][$type]['images_photo'])
				{
					$file_name = upload_name($_FILES["file".$i]["name"]);
					if($photo = uploadImage("file".$i, $config['photo']['man_photo'][$type]['img_type_photo'], _upload_photo,$file_name.$i))
					{
						$dataMulti['photo'] = $photo;
						$dataMulti['thumb'] = createThumb($dataMulti['photo'], $config['photo']['man_photo'][$type]['thumb_width_photo'], $config['photo']['man_photo'][$type]['thumb_height_photo'], _upload_photo,$file_name.$i,$config['photo']['man_photo'][$type]['thumb_ratio_photo']);

						if(!$d->insert('photo',$dataMulti)) transfer("Lưu dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=".$type."&p=".$curPage,0);
					}
				}
				else
				{
					if($dataMulti['tenvi']!='' || $dataMulti['link']!='' || $dataMulti['link_video']!='')
					{
						if(!$d->insert('photo',$dataMulti)) transfer("Lưu dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=".$type."&p=".$curPage,0);
					}
				}
			}
			transfer("Lưu dữ liệu thành công", "index.php?com=photo&act=man_photo&type=".$type."&p=".$curPage);
		}
		transfer("Dữ liệu rỗng", "index.php?com=photo&act=man_photo&type=".$type."&p=".$curPage,0);
	}
}

/* Delete photo */
function delete_photo()
{
	global $d, $curPage, $type;
	
	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		$row = $d->rawQueryOne("select id, photo, thumb from #_photo where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			delete_file(_upload_photo.$row['photo']);
			delete_file(_upload_photo.$row['thumb']);
			$d->rawQuery("delete from #_photo where id = ? and type = ?",array($id,$type));
			transfer("Xóa dữ liệu thành công", "index.php?com=photo&act=man_photo&type=".$type."&p=".$curPage);
		}
		else transfer("Xóa dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=".$type."&p=".$curPage,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);
			$row = $d->rawQueryOne("select id, photo, thumb from #_photo where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_photo.$row['photo']);
				delete_file(_upload_photo.$row['thumb']);
				$d->rawQuery("delete from #_photo where id = ? and type = ?",array($id,$type));
			}
		}
		
		transfer("Xóa dữ liệu thành công", "index.php?com=photo&act=man_photo&type=".$type."&p=".$curPage);
	}
	else transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=".$type."&p=".$curPage,0);
}
?>