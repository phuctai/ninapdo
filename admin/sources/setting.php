<?php
if(!defined('SOURCES')) die("Error");

$act = htmlspecialchars($_REQUEST['act']);

switch($act)
{
	case "capnhat":
		get_setting();
		$template = "setting/man/item_add";
		break;
	case "save":
		save_setting();
		break;
		
	default:
		$template = "404";
}

/* Get setting */
function get_setting()
{
	global $d, $item;

	$item = $d->rawQueryOne("select * from #_setting");
}

/* Save setting */
function save_setting()
{
	global $d, $config, $com;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=setting&act=capnhat",0);

	$id = htmlspecialchars($_POST['id']);
	$row = $d->rawQueryOne("select id from #_setting where id = ?",array($id));

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	
	/* Post Seo */
	$dataSeo = $_POST['dataSeo'];
	foreach($dataSeo as $column => $value) $data[$column] = htmlspecialchars($value);

	if($row['id'])
	{
		$d->where('id',$id);
		if($d->update('setting',$data)) transfer("Cập nhật dữ liệu thành công", "index.php?com=setting&act=capnhat");
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=setting&act=capnhat",0);
	}
	else
	{
		if($d->insert('setting',$data)) transfer("Thêm dữ liệu thành công", "index.php?com=setting&act=capnhat");
		else transfer("Thêm dữ liệu bị lỗi", "index.php?com=setting&act=capnhat",0);
	}
}
?>