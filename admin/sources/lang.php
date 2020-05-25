<?php
if(!defined('_SOURCE')) die("Error");

$act = htmlspecialchars($_REQUEST['act']);
$id = htmlspecialchars($_REQUEST['id']);
$curPage = (isset($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;

/* Kiểm tra active lang */
if(!$config['website']['debug-developer']) transfer("Trang không tồn tại", "index.php",0);

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$strUrl = (isset($_REQUEST['keyword'])) ? "&keyword=".htmlspecialchars($_REQUEST['keyword']) : "";

switch($act)
{
	case "create":
		get_create();
		break;

	case "man":
		get_items();
		$template = "lang/man/items";
		break;

	case "add":
		$template = "lang/man/item_add";
		break;

	case "edit":		
		get_item();
		$template = "lang/man/item_add";
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

/* Create lang */
function get_create()
{
	global $d, $config, $curPage;

	foreach($config['website']['lang'] as $k => $v)
	{
		$lang = $d->rawQuery("select giatri, lang$k from #_lang");
		$langfile = fopen(_LIB."lang".$k.".php", "w") or transfer("Không thể tạo tập tin.","index.php?com=lang&act=man&p=".$curPage,0);

		$str = '<?php';
		for($i=0;$i<count($lang);$i++) $str .= PHP_EOL.'define("'.$lang[$i]['giatri'].'","'.$lang[$i]['lang'.$k].'");';
		$str .= PHP_EOL.'?>';

		fwrite($langfile, $str);
		fclose($langfile);
	}
	transfer("Tạo tập tin ngôn ngữ thành công","index.php?com=lang&act=man&p=".$curPage);
}

/* Get lang */
function get_items()
{
	global $d, $curPage, $items, $paging, $strUrl;

	$where = "";

	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " where giatri LIKE '%$keyword%'";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_lang $where order by id desc $limit";
	$items = $d->rawQuery($sql);
	$sqlNum = "select count(*) as 'num' from #_lang $where order by id desc";
	$count = $d->rawQueryOne($sqlNum);
	$total = $count['num'];
	$url = "index.php?com=lang&act=man".$strUrl;
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Edit lang */
function get_item()
{
	global $d, $curPage, $item;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=lang&act=man&p=".$curPage,0);	

	$item = $d->rawQueryOne("select * from #_lang where id = ?",array($id));

	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=lang&act=man&p=".$curPage,0);	
}

/* Save lang */
function save_item()
{
	global $d, $curPage, $config;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=lang&act=man&p=".$curPage,0);

	$id = htmlspecialchars($_POST['id']);
	
	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);

	if($id)
	{
		$d->where('id', $id);
		if($d->update('lang',$data)) transfer("Cập nhật dữ liệu thành công", "index.php?com=lang&act=man&p=".$curPage);
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=lang&act=man&p=".$curPage,0);
	}
	else
	{
		if($d->insert('lang',$data)) transfer("Lưu dữ liệu thành công", "index.php?com=lang&act=man&p=".$curPage);
		else transfer("Lưu dữ liệu bị lỗi", "index.php?com=lang&act=man&p=".$curPage,0);
	}
}

/* Delete lang */
function delete_item()
{
	global $d, $curPage;

	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		$row = $d->rawQueryOne("select id from #_lang where id = ?",array($id));

		if($row['id'])
		{
			$d->rawQuery("delete from #_lang where id = ?",array($id));
			transfer("Xóa dữ liệu thành công", "index.php?com=lang&act=man&p=".$curPage);
		}
		else transfer("Xóa dữ liệu bị lỗi", "index.php?com=lang&act=man&p=".$curPage,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);
			$row = $d->rawQueryOne("select id from #_lang where id = ?",array($id));

			if($row['id']) $d->rawQuery("delete from #_lang where id = ?",array($id));
		}
		
		transfer("Xóa dữ liệu thành công", "index.php?com=lang&act=man&p=".$curPage);
	}
	else transfer("Không nhận được dữ liệu", "index.php?com=lang&act=man&p=".$curPage,0);
}
?>