<?php
if(!defined('SOURCES')) die("Error");

switch($act)
{
	case "man_photo":
		get_photos();
		$template = "gallery/man/photos";
		break;

	case "add_photo":
		$template = "gallery/man/photo_add";
		break;

	case "edit_photo":
		get_photo();
		$template = "gallery/man/photo_edit";
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

/* Get photo */
function get_photos()
{
	global $d, $curPage, $items, $paging, $type, $kind, $val, $idc, $com;
	
	$where = "id_photo = ? and com = ? and type = ? and kind = ? and val = ?";

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_gallery where $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($idc,$com,$type,$kind,$val));
	$sqlNum = "select count(*) as 'num' from #_gallery where $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($idc,$com,$type,$kind,$val));
	$total = $count['num'];
	$url = "index.php?com=".$com."&act=man_photo&idc=".$idc."&type=".$type."&kind=".$kind."&val=".$val;
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Get photo */
function get_photo()
{
	global $d, $curPage, $item, $type, $kind, $val, $idc, $com;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=".$com."&act=man_photo&idc=".$idc."&type=".$type."&kind=".$kind."&val=".$val."&p=".$curPage,0);

	$item = $d->rawQueryOne("select * from #_gallery where id_photo = ? and com = ? and type = ? and kind = ? and val = ? and id = ? order by stt,id desc",array($idc,$com,$type,$kind,$val,$id));

	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=".$com."&act=man_photo&idc=".$idc."&type=".$type."&kind=".$kind."&val=".$val."&p=".$curPage,0);
}

/* Save photo */
function save_photo()
{
	global $d, $curPage, $config, $dfgallery, $type, $kind, $val, $idc, $com;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=".$com."&act=man_photo&idc=".$idc."&type=".$type."&kind=".$kind."&val=".$val."&p=".$curPage,0);

	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	$dataMultiTemp = $_POST['dataMulti'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);

	if($id)
	{
		$file_name = upload_name($_FILES["file"]["name"]);
		if($photo = uploadImage("file", $config[$com][$type][$dfgallery][$val]['img_type_photo'], "../upload/".$com."/",$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config[$com][$type][$dfgallery][$val]['thumb_width_photo'], $config[$com][$type][$dfgallery][$val]['thumb_height_photo'], "../upload/".$com."/",$file_name,$config[$com][$type][$dfgallery][$val]['thumb_ratio_photo']);

			$row = $d->rawQueryOne("select id, photo, thumb from #_gallery where id_photo = ? and com = ? and type = ? and kind = ? and val = ? and id = ? order by stt,id desc",array($idc,$com,$type,$kind,$val,$id));

			if($row['id'])
			{
				delete_file("../upload/".$com."/".$row['photo']);
				delete_file("../upload/".$com."/".$row['thumb']);
			}
		}

		$file_name = upload_name($_FILES["file-taptin"]["name"]);
		if($taptin = uploadImage("file-taptin", $config[$com][$type][$dfgallery][$val]['file_type_photo'],UPLOAD_FILE,$file_name."-taptin"))
		{
			$data['taptin'] = $taptin;

			$row = $d->rawQueryOne("select id, taptin from #_gallery where id_photo = ? and com = ? and type = ? and kind = ? and val = ? and id = ? order by stt,id desc",array($idc,$com,$type,$kind,$val,$id));
			
			if($row['id']) delete_file(UPLOAD_FILE.$row['taptin']);
		}
		
		$data['hienthi'] = ($data['hienthi']) ? 1 : 0;

		$d->where('id', $id);
		$d->where('com', $com);
		$d->where('type', $type);
		$d->where('kind', $kind);
		$d->where('val', $val);
		if($d->update('gallery',$data)) transfer("Cập nhật dữ liệu thành công", "index.php?com=".$com."&act=man_photo&idc=".$idc."&type=".$type."&kind=".$kind."&val=".$val."&p=".$curPage);
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=".$com."&act=man_photo&idc=".$idc."&type=".$type."&kind=".$kind."&val=".$val."&p=".$curPage,0);
	}
	else
	{
		$numberPhoto = $config[$com][$type][$dfgallery][$val]['number_photo'];

		if($numberPhoto)
		{
			for($i=0;$i<count($dataMultiTemp);$i++)
			{
				$dataMulti = $dataMultiTemp[$i];
				$dataMulti['id_mau'] = $data['id_mau'];
				$dataMulti['hienthi'] = ($dataMultiTemp[$i]['hienthi']) ? 1 : 0;
				$dataMulti['com'] = $com;
				$dataMulti['type'] = $type;
				$dataMulti['kind'] = $kind;
				$dataMulti['val'] = $val;
				$dataMulti['id_photo'] = $idc;

				if($config[$com][$type][$dfgallery][$val]['file_photo'])
				{
					$file_name = upload_name($_FILES["file-taptin".$i]["name"]);
					if($taptin = uploadImage("file-taptin".$i, $config[$com][$type][$dfgallery][$val]['file_type_photo'],UPLOAD_FILE,$file_name."-taptin".$i))
					{
						$dataMulti['taptin'] = $taptin;		
					}
				}

				if($config[$com][$type][$dfgallery][$val]['images_photo'])
				{
					$file_name = upload_name($_FILES["file".$i]["name"]);
					if($photo = uploadImage("file".$i, $config[$com][$type][$dfgallery][$val]['img_type_photo'], "../upload/".$com."/",$file_name.$i))
					{
						$dataMulti['photo'] = $photo;
						$dataMulti['thumb'] = createThumb($dataMulti['photo'], $config[$com][$type][$dfgallery][$val]['thumb_width_photo'], $config[$com][$type][$dfgallery][$val]['thumb_height_photo'], "../upload/".$com."/",$file_name.$i,$config[$com][$type][$dfgallery][$val]['thumb_ratio_photo']);

						if(!$d->insert('gallery',$dataMulti)) transfer("Lưu dữ liệu bị lỗi", "index.php?com=".$com."&act=man_photo&idc=".$idc."&type=".$type."&kind=".$kind."&val=".$val."&p=".$curPage,0);
					}
				}
				else
				{
					if($dataMulti['tenvi']!='' || $dataMulti['mau']!='' || $dataMulti['link']!='' || $dataMulti['link_video']!='')
					{
						if(!$d->insert('gallery',$dataMulti)) transfer("Lưu dữ liệu bị lỗi", "index.php?com=".$com."&act=man_photo&idc=".$idc."&type=".$type."&kind=".$kind."&val=".$val."&p=".$curPage,0);
					}
				}
			}

			transfer("Lưu dữ liệu thành công", "index.php?com=".$com."&act=man_photo&idc=".$idc."&type=".$type."&kind=".$kind."&val=".$val."&p=".$curPage);
		}
		else
		{
			transfer("Dữ liệu rỗng", "index.php?com=".$com."&act=man_photo&idc=".$idc."&type=".$type."&kind=".$kind."&val=".$val."&p=".$curPage,0);
		}
	}
}

/* Delete photo */
function delete_photo()
{
	global $d, $curPage, $type, $kind, $val, $idc, $com;

	$id = htmlspecialchars($_GET['id']);
	
	if($id)
	{
		$row = $d->rawQueryOne("select id, photo, thumb, taptin from #_gallery where id = ? and com = ? and type = ? and kind = ? and val = ?",array($id,$com,$type,$kind,$val));

		if($row['id'])
		{
			delete_file("../upload/".$com."/".$row['photo']);
			delete_file("../upload/".$com."/".$row['thumb']);
			delete_file(UPLOAD_FILE.$row['taptin']);

			$d->rawQuery("delete from #_gallery where id = ?",array($id));

			transfer("Xóa dữ liệu thành công", "index.php?com=".$com."&act=man_photo&idc=".$idc."&type=".$type."&kind=".$kind."&val=".$val."&p=".$curPage);
		}
		else transfer("Xóa dữ liệu bị lỗi", "Dữ liệu không có thực", "index.php?com=".$com."&act=man_photo&idc=".$idc."&type=".$type."&kind=".$kind."&val=".$val."&p=".$curPage,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);
			$row = $d->rawQueryOne("select id, photo, thumb, taptin from #_gallery where id = ?",array($id));

			if($row['id'])
			{
				delete_file("../upload/".$com."/".$row['photo']);
				delete_file("../upload/".$com."/".$row['thumb']);
				delete_file(UPLOAD_FILE.$row['taptin']);

				$d->rawQuery("delete from #_gallery where id = ? and com = ? and type = ? and kind = ? and val = ?",array($id,$com,$type,$kind,$val));
			}
		}
		transfer("Xóa dữ liệu thành công", "index.php?com=".$com."&act=man_photo&idc=".$idc."&type=".$type."&kind=".$kind."&val=".$val."&p=".$curPage);
	}
	else transfer("Không nhận được dữ liệu", "index.php?com=".$com."&act=man_photo&idc=".$idc."&type=".$type."&kind=".$kind."&val=".$val."&p=".$curPage,0);
}
?>