<?php
if(!defined('_SOURCE')) die("Error");

$act = htmlspecialchars($_REQUEST['act']);
$type = htmlspecialchars($_REQUEST['type']);

/* Kiểm tra active static */
$arrCheck = array();
foreach($config['static'] as $k => $v) $arrCheck[] = $k;
if(!count($arrCheck) || !in_array($type,$arrCheck)) transfer("Trang không tồn tại", "index.php",0);

switch($act)
{
	case "capnhat":
		get_static();
		$template = "static/man/item_add";
		break;
	case "save":
		save_static();
		break;

	default:
		$template = "404";
}

/* Get static */
function get_static()
{
	global $d, $item, $type;

	$item = $d->rawQueryOne("select * from #_static where type = ?",array($type));
}

/* Save static */
function save_static()
{
	global $d, $config, $com, $type;
	
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=static&act=capnhat&type=".$type,0);

	$static = $d->rawQueryOne("select * from #_static where type = ?",array($type));

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	$data['tenkhongdauvi'] = changeTitle($data['tenvi']);
	$data['tenkhongdauen'] = changeTitle($data['tenen']);
	$data['hienthi'] = ($data['hienthi']) ? 1 : 0;
	$data['type'] = $type;

	/* Post Seo */
	if($config['static'][$type]['seo'])
	{
		$dataSeo = $_POST['dataSeo'];
		foreach($dataSeo as $column => $value) $dataSeo[$column] = htmlspecialchars($value);
	}

	$file_name = upload_name($_FILES['file']["name"]);
	if($photo = uploadImage("file", $config['static'][$type]['img_type'],_upload_news,$file_name))
	{
		$data['photo'] = $photo;
		$data['thumb'] = createThumb($data['photo'], $config['static'][$type]['thumb_width'], $config['static'][$type]['thumb_height'], _upload_news,$file_name,$config['static'][$type]['thumb_ratio']);

		$row = $d->rawQueryOne("select id, photo, thumb from #_static where type = ?",array($type));

		if($row['id'])
		{
			delete_file(_upload_news.$row['photo']);
			delete_file(_upload_news.$row['thumb']);
		}
	}

	$file_name = upload_name($_FILES['file-taptin']["name"]);
	if($taptin = uploadImage("file-taptin", $config['static'][$type]['file_type'],_upload_file,$file_name))
	{
		$data['taptin'] = $taptin;			
		
		$row = $d->rawQueryOne("select id, taptin from #_static where type = ?",array($type));

		if($row['id']) delete_file(_upload_file.$row['taptin']);
	}

	if($static['id'])
	{
		$d->where('type',$type);
		if($d->update('static',$data))
		{
			/* SEO */
			if($config['static'][$type]['seo'])
			{
				$d->rawQuery("delete from #_seo where com = ? and act = ? and type = ?",array($com,'capnhat',$type));

				$dataSeo['idmuc'] = 0;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'capnhat';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			transfer("Cập nhật dữ liệu thành công", "index.php?com=static&act=capnhat&type=".$type);
		}
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=static&act=capnhat&type=".$type,0);
	}
	else
	{
		if($data['tenvi']!='' || $data['motavi']!='' || $data['noidungvi']!='')
		{
			if($d->insert('static',$data))
			{
				/* SEO */
				if($config['static'][$type]['seo'])
				{
					$dataSeo['idmuc'] = 0;
					$dataSeo['com'] = $com;
					$dataSeo['act'] = 'capnhat';
					$dataSeo['type'] = $type;
					$d->insert('seo',$dataSeo);
				}

				transfer("Lưu dữ liệu thành công", "index.php?com=static&act=capnhat&type=".$type);
			}
			else transfer("Lưu dữ liệu bị lỗi", "index.php?com=static&act=capnhat&type=".$type,0);
		}
		transfer("Dữ liệu rỗng", "index.php?com=static&act=capnhat&type=".$type,0);
	}
}
?>