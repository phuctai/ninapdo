<?php
if(!defined('SOURCES')) die("Error");

/* Kiểm tra active one signal */
if(!$config['onesignal']) $func->transfer("Trang không tồn tại", "index.php",0);

$act = htmlspecialchars($_REQUEST['act']);
$curPage = (isset($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;

switch($act)
{
	case "man":
		get_mans();
		$template = "pushOnesignal/man/items";
		break;

	case "add":
		$template = "pushOnesignal/man/item_add";
		break;

	case "edit":
		get_man();
		$template = "pushOnesignal/man/item_add";
		break;

	case "save":
		save_man();
		break;

	case "sync":
		sendSync();
		break;

	case "delete":
		delete_man();
		break;

	default:
		$template = "404";
}

/* Get onesignal */
function get_mans()
{
	global $d, $func, $curPage, $items, $paging;

	$where = "";
	
	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and (name LIKE '%$keyword%')";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_pushonesignal where id<>0 $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql);
	$sqlNum = "select count(*) as 'num' from #_pushonesignal where id<>0 $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum);
	$total = $count['num'];
	$url = "index.php?com=pushOnesignal&act=man";
	$paging = $func->pagination($total,$per_page,$curPage,$url);
}

/* Edit onesignal */
function get_man()
{
	global $d, $func, $curPage, $item;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) $func->transfer("Không nhận được dữ liệu", "index.php?com=pushOnesignal&act=man&p=".$curPage,0);	

	$item = $d->rawQueryOne("select * from #_pushonesignal where id = ?",array($id));

	if(!$item['id']) $func->transfer("Dữ liệu không có thực", "index.php?com=pushOnesignal&act=man&p=".$curPage,0);
}

/* Save onesignal */
function save_man()
{
	global $d, $func, $curPage;

	if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=pushOnesignal&act=man&p=".$curPage,0);

	$file_name = $func->uploadName($_FILES['file']["name"]);
	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	$data['date'] = time();

	if($id)
	{
		if($photo = $func->uploadImage("file",'.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF',UPLOAD_SYNC,$file_name))
		{
			$data['photo'] = $photo;	
			$row = $d->rawQueryOne("select id, photo from #_pushonesignal where id = ?",array($id));
			if($row['id']) $func->delete_file(UPLOAD_SYNC.$row['photo']);
		}
	
		$d->where('id', $id);
		if($d->update('pushonesignal',$data)) $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=pushOnesignal&act=man&p=".$curPage);
		else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=pushOnesignal&act=man&p=".$curPage,0);
	}
	else
	{
		if($photo = $func->uploadImage("file", 'jpg|png|gif|JPG|jpeg|JPEG', UPLOAD_SYNC,$file_name))
		{
			$data['photo'] = $photo;		
		}

		if($d->insert('pushonesignal',$data)) $func->transfer("Lưu dữ liệu thành công", "index.php?com=pushOnesignal&act=man&p=".$curPage);
		else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=pushOnesignal&act=man&p=".$curPage,0);
	}
}

/* Delete onesignal */
function delete_man()
{
	global $d, $func, $curPage;

	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		$row = $d->rawQueryOne("select id, photo from #_pushonesignal where id = ?",array($id));

		if($row['id'])
		{
			$func->delete_file(UPLOAD_SYNC.$row['photo']);
			$d->rawQuery("delete from #_pushonesignal where id = ?",array($id));
			$func->transfer("Xóa dữ liệu thành công","index.php?com=pushOnesignal&act=man&p=".$curPage);
		}
		else $func->transfer("Xóa dữ liệu bị lỗi","index.php?com=pushOnesignal&act=man&p=".$curPage,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);
			$row = $d->rawQueryOne("select id, photo from #_pushonesignal where id = ?",array($id));

			if($row['id'])
			{
				$func->delete_file(UPLOAD_SYNC.$row['photo']);
				$d->rawQuery("delete from #_pushonesignal where id = ?",array($id));
			}
		}
		$func->transfer("Xóa dữ liệu thành công","index.php?com=pushOnesignal&act=man&p=".$curPage);
	}
	$func->transfer("Không nhận được dữ liệu","index.php?com=pushOnesignal&act=man&p=".$curPage,0);
}

/* Send onesignal */	
function sendMessage_onesignal($heading,$content,$url='https://www.google.com/',$photo)
{
	global $d, $config_base, $config;
	
	$contents = array(
		"en" => $content
	);
	$headings = array(
		"en" => $heading
	);
	$uphoto = $config_base.UPLOAD_SYNC_L.$photo;
	
	$fields = array(
		'app_id' => $config['oneSignal']['id'],
		'included_segments' => array('All'),
		'contents' => $contents,
		'headings' => $headings,
		'url' => $url,
		'chrome_web_image' => $uphoto
	);
	$fields = json_encode($fields);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
	'Authorization: Basic '.$config['oneSignal']['restId']));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	$response = curl_exec($ch);
	curl_close($ch);
	
	return $response;
}

/* Sync onesignal */
function sendSync()
{
	global $d, $func, $curPage, $config;

	$id = htmlspecialchars($_GET['id']);
	
	if($id)
	{
		$row = $d->rawQueryOne("select id,photo,name,description,link from #_pushonesignal where id = ?",array($id));
		
		sendMessage_onesignal($row['name'],$row['description'],$row['link'],$row['photo']);
		$func->transfer("Gửi thông báo thành công", "index.php?com=pushOnesignal&act=man&p=".$curPage);	
	}
	$func->transfer("Không nhận được dữ liệu", "index.php?com=pushOnesignal&act=man&p=".$curPage,0);	
}
?>