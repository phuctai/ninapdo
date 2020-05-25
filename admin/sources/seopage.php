<?php
if(!defined('_SOURCE')) die("Error");

$act = htmlspecialchars($_REQUEST['act']);
$type = htmlspecialchars($_REQUEST['type']);

/* Kiểm tra active seopage */
$arrCheck = array();
foreach($config['seopage']['page'] as $k => $v) $arrCheck[] = $k;
if(!count($arrCheck) || !in_array($type,$arrCheck)) transfer("Trang không tồn tại", "index.php",0);

switch($act)
{
	case "capnhat":
		get_seopage();
		$template = "seopage/man/item_add";
		break;
	case "save":
		save_seopage();
		break;

	default:
		$template = "404";
}

/* Get Seopage */
function get_seopage()
{
	global $d, $item, $type;

	$item = $d->rawQueryOne("select * from #_seopage where type = ?",array($type));
}

/* Save Seopage */
function save_seopage()
{
	global $d, $config, $com, $type;
	
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=seopage&act=capnhat&type=".$type,0);

	$seopage = $d->rawQueryOne("select * from #_seopage where type = ?",array($type));
	
	/* Post dữ liệu */
	$dataSeo = $_POST['dataSeo'];
	foreach($dataSeo as $column => $value) $dataSeo[$column] = htmlspecialchars($value);
	$dataSeo['type'] = $type;

	$file_name = upload_name($_FILES['file']["name"]);
	if($photo = uploadImage("file", $config['seopage']['img_type'],_upload_seopage,$file_name))
	{
		$dataSeo['photo'] = $photo;
		$dataSeo['thumb'] = createThumb($dataSeo['photo'], $config['seopage']['thumb_width'], $config['seopage']['thumb_height'], _upload_seopage,$file_name,$config['seopage']['thumb_ratio']);
		
		$row = $d->rawQueryOne("select id, photo, thumb from #_seopage where type = ?",array($type));

		if($row['id'])
		{
			delete_file(_upload_seopage.$row['photo']);
			delete_file(_upload_seopage.$row['thumb']);
		}
	}

	if($seopage['id'])
	{
		$d->where('type',$type);	
		if($d->update('seopage',$dataSeo)) transfer("Cập nhật dữ liệu thành công", "index.php?com=seopage&act=capnhat&type=".$type);
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=seopage&act=capnhat&type=".$type,0);
	}
	else
	{
		if($d->insert('seopage',$dataSeo)) transfer("Lưu dữ liệu thành công", "index.php?com=seopage&act=capnhat&type=".$type);
		else transfer("Lưu dữ liệu bị lỗi", "index.php?com=seopage&act=capnhat&type=".$type,0);
	}
}
?>