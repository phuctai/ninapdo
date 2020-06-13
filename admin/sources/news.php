<?php
if(!defined('SOURCES')) die("Error");

$act = htmlspecialchars($_REQUEST['act']);
$id = htmlspecialchars($_REQUEST['id']);
$type = htmlspecialchars($_REQUEST['type']);
$kind = htmlspecialchars($_REQUEST['kind']);
$val = htmlspecialchars($_REQUEST['val']);
$idc = htmlspecialchars($_REQUEST['idc']);
$curPage = (isset($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;

/* Kiểm tra active news */
$arrCheck = array();
foreach($config['news'] as $k => $v) $arrCheck[] = $k;
if(!count($arrCheck) || !in_array($type,$arrCheck)) $func->transfer("Trang không tồn tại", "index.php",0);

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('id_list','id_cat','id_item','id_sub','id_brand');
if(isset($_POST['data']))
{
	$dataUrl = $_POST['data'];
	foreach($arrUrl as $k => $v)
	{
		if($dataUrl[$arrUrl[$k]]) $strUrl .= "&".$arrUrl[$k]."=".htmlspecialchars($dataUrl[$arrUrl[$k]]);
	}
}
else
{
	foreach($arrUrl as $k => $v)
	{
		if($_REQUEST[$arrUrl[$k]]) $strUrl .= "&".$arrUrl[$k]."=".htmlspecialchars($_REQUEST[$arrUrl[$k]]);
	}
	if($_REQUEST['keyword']) $strUrl .= "&keyword=".htmlspecialchars($_REQUEST['keyword']);
}

/* Define gallery: list, cat, item, man */
$dfgallery = ($_REQUEST['kind']=='man_list')?'gallery_list':'gallery';

switch($act)
{
	/* Man */
	case "man":
		get_items();
		$template = "news/man/items";
		break;
	case "add":
		$template = "news/man/item_add";
		break;
	case "edit":
	case "copy":
		if(!$config['news'][$type]['copy'] && $act=='copy')
		{
			$template = "404";
			return false;
		}
		get_item();
		$template = "news/man/item_add";
		break;
	case "save":
	case "save_copy":
		save_item();
		break;
	case "delete":
		delete_item();
		break;

	/* List */
	case "man_list":
		get_lists();
		$template = "news/list/lists";
		break;
	case "add_list":
		$template = "news/list/list_add";
		break;
	case "edit_list":
		get_list();
		$template = "news/list/list_add";
		break;
	case "save_list":
		save_list();
		break;
	case "delete_list":
		delete_list();
		break;

	/* Cat */
	case "man_cat":
		get_cats();
		$template = "news/cat/cats";
		break;
	case "add_cat":
		$template = "news/cat/cat_add";
		break;
	case "edit_cat":
		get_cat();
		$template = "news/cat/cat_add";
		break;
	case "save_cat":
		save_cat();
		break;
	case "delete_cat":
		delete_cat();
		break;

	/* Item */
	case "man_item":
		get_loais();
		$template = "news/item/loais";
		break;
	case "add_item":
		$template = "news/item/loai_add";
		break;
	case "edit_item":
		get_loai();
		$template = "news/item/loai_add";
		break;
	case "save_item":
		save_loai();
		break;
	case "delete_item":
		delete_loai();
		break;

	/* Sub */
	case "man_sub":
		get_subs();
		$template = "news/sub/subs";
		break;
	case "add_sub":
		$template = "news/sub/sub_add";
		break;
	case "edit_sub":
		get_sub();
		$template = "news/sub/sub_add";
		break;
	case "save_sub":
		save_sub();
		break;
	case "delete_sub":
		delete_sub();
		break;
	
	/* Gallery */
	case "man_photo":
	case "add_photo":
	case "edit_photo":
	case "save_photo":
	case "delete_photo":
		include "gallery.php";
		break;

	default:
		$template = "404";
}

/* Get man */
function get_items()
{
	global $d, $func, $strUrl, $curPage, $items, $paging, $type;

	$where = "";
	$idlist = htmlspecialchars($_REQUEST['id_list']);
	$idcat = htmlspecialchars($_REQUEST['id_cat']);
	$iditem = htmlspecialchars($_REQUEST['id_item']);
	$idsub = htmlspecialchars($_REQUEST['id_sub']);

	if($idlist) $where .= " and id_list=$idlist";
	if($idcat) $where .= " and id_cat=$idcat";
	if($iditem) $where .= " and id_item=$iditem";
	if($idsub) $where .= " and id_sub=$idsub";
	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and (tenvi LIKE '%$keyword%' or tenen LIKE '%$keyword%')";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_news where type = ? $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_news where type = ? $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=news&act=man".$strUrl."&type=".$type;
	$paging = $func->pagination($total,$per_page,$curPage,$url);
}

/* Edit man */
function get_item()
{
	global $d, $strUrl, $func, $curPage, $item, $attributes, $gallery, $type, $com;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man&type=".$type."&p=".$curPage.$strUrl,0);

	$item = $d->rawQueryOne("select * from #_news where id = ? and type = ?",array($id,$type));

	if(!$item['id']) $func->transfer("Dữ liệu không có thực", "index.php?com=news&act=man&type=".$type."&p=".$curPage.$strUrl,0);

	/* Lấy hình ảnh con */
	$gallery = $d->rawQuery("select * from #_gallery where id_photo = ? and com = ? and type = ? and kind = ? and val = ? order by stt,id desc",array($id,$com,$type,'man',$type));

	/* Lấy thuộc tính */
	$attributes = $d->rawQuery("select * from #_attribute where idmuc = ? and com = ? and act = ? and type = ? order by stt,id desc",array($id,$com,'man',$type));
}

/* Save man */
function save_item()
{
	global $d, $strUrl, $func, $curPage, $config, $com, $act, $type;

	if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man&type=".$type."&p=".$curPage.$strUrl,0);

	$savehere = (isset($_POST['save-here'])) ? true : false;
	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	if($_POST['slugvi']) $data['tenkhongdauvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
	else $data['tenkhongdauvi'] = $func->changeTitle($data['tenvi']);
	if($_POST['slugen']) $data['tenkhongdauen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
	else $data['tenkhongdauen'] = $func->changeTitle($data['tenen']);
	if($config['news'][$type]['tags'])
	{
		if($_POST['tags_group']!='') $data['id_tags'] = implode(",", $_POST['tags_group']);
		else $data['id_tags'] = "";
	}
	$data['hienthi'] = ($data['hienthi']) ? 1 : 0;
	$data['type'] = $type;

	/* Post seo */
	if($config['news'][$type]['seo'])
	{
		$dataSeo = $_POST['dataSeo'];
		foreach($dataSeo as $column => $value) $dataSeo[$column] = htmlspecialchars($value);
	}

	if($id && $act!='save_copy')
	{
		$file_name = $func->uploadName($_FILES['file']["name"]);
		if($photo = $func->uploadImage("file", $config['news'][$type]['img_type'], UPLOAD_NEWS,$file_name))
		{
			$data['photo'] = $photo;
			$row = $d->rawQueryOne("select id, photo from #_news where id = ? and type = ?",array($id,$type));
			if($row['id']) $func->delete_file(UPLOAD_NEWS.$row['photo']);
		}

		$file_name = $func->uploadName($_FILES['file-taptin']["name"]);
		if($taptin = $func->uploadImage("file-taptin", $config['news'][$type]['file_type'],UPLOAD_FILE,$file_name))
		{
			$data['taptin'] = $taptin;
			$row = $d->rawQueryOne("select id, taptin from #_news where id = ? and type = ?",array($id,$type));
			if($row['id']) $func->delete_file(UPLOAD_FILE.$row['taptin']);
		}	

		/* Cập nhật hình ảnh con */
		if(isset($_FILES['files'])) 
		{
			$arr_chuoi = str_replace('"','',$_POST['jfiler-items-exclude-files-0']);
			$arr_chuoi = str_replace('[','',$arr_chuoi);
			$arr_chuoi = str_replace(']','',$arr_chuoi);
			$arr_chuoi = str_replace('\\','',$arr_chuoi);
			$arr_chuoi = str_replace('0://','',$arr_chuoi);
			$arr_file_del = explode(',',$arr_chuoi);

			$dem = 0;
            $myFile = $_FILES['files'];
            $fileCount = count($myFile["name"]);

            for($i=0;$i<$fileCount;$i++) 
            {
            	if($_FILES['files']['name'][$i]!='')
				{
					if(!in_array(($_FILES['files']['name'][$i]),$arr_file_del,true))
					{
						$file_name = $func->uploadName($myFile["name"][$i]);
						$file_ext = pathinfo($myFile["name"][$i], PATHINFO_EXTENSION);
						if(move_uploaded_file($myFile["tmp_name"][$i], UPLOAD_NEWS."/".$file_name.".".$file_ext))
			            {
							$data1['photo'] = $file_name.".".$file_ext;
							$data1['stt'] = (int)$_POST['stt-filer'][$dem];		
							$data1['tenvi'] = $_POST['ten-filer'][$dem];
							$data1['id_photo'] = $id;
							$data1['com'] = $com;
							$data1['type'] = $type;
							$data1['kind'] = 'man';
							$data1['val'] = $type;
							$data1['hienthi'] = 1;
							$d->insert('gallery',$data1);
			            }
			            $dem++;
					}
	            }
            }
        }

		$data['ngaysua'] = time();

		$d->where('id', $id);
		$d->where('type', $type);
		if($d->update('news',$data))
		{
			/* SEO */
			if($config['news'][$type]['seo'])
			{
				$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man',$type));

				$dataSeo['idmuc'] = $id;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			/* Attribute */
			if($config['news'][$type]['attribute'])
			{
				$dataAttribute = array();
				$dataAttribute['idmuc'] = $id;
				$dataAttribute['com'] = $com;
				$dataAttribute['act'] = 'man';
				$dataAttribute['type'] = $type;

				$d->rawQuery("DELETE FROM table_attribute WHERE idmuc = ? AND com = ? AND act = ? AND type = ?",array($id,$com,'man',$type));

				foreach($_POST['attribute']['stt'] as $k => $v)
				{
					if($_POST['attribute']['stt'][$k])
					{
						$dataAttribute['stt'] = $_POST['attribute']['stt'][$k];
						$dataAttribute['tenkhongdau'] = $func->changeTitle($dataAttribute['tieudevi']);

						foreach($config['website']['lang'] as $key => $value) 
						{
							$dataAttribute['tieude'.$key] = htmlspecialchars($_POST['attribute']['tieude'.$key][$k]);
							$dataAttribute['giatri'.$key] = htmlspecialchars($_POST['attribute']['giatri'.$key][$k]);
						}

						$d->insert('attribute',$dataAttribute);
					}
				}
			}

			if($savehere) $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=news&act=edit&type=".$type."&p=".$curPage.$strUrl."&id=".$id);
			else $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=news&act=man&type=".$type."&p=".$curPage.$strUrl);
		}
		else
		{
			if($savehere) $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=edit&type=".$type."&p=".$curPage.$strUrl."&id=".$id,0);
			else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=man&type=".$type."&p=".$curPage.$strUrl,0);
		}
	}
	else
	{
		$file_name = $func->uploadName($_FILES['file']["name"]);
		if($photo = $func->uploadImage("file", $config['news'][$type]['img_type'], UPLOAD_NEWS,$file_name))
		{
			$data['photo'] = $photo;
		}

		$file_name = $func->uploadName($_FILES['file-taptin']["name"]);
		if($taptin = $func->uploadImage("file-taptin", $config['news'][$type]['file_type'],UPLOAD_FILE,$file_name))
		{
			$data['taptin'] = $taptin;		
		}
	
		$data['ngaytao'] = time();

		if($d->insert('news',$data))
		{
			$id_insert = $d->getLastInsertId();

			/* SEO */
			if($config['news'][$type]['seo'])
			{
				$dataSeo['idmuc'] = $id_insert;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			/* Attribute */
			if($config['news'][$type]['attribute'])
			{
				$dataAttribute = array();
				$dataAttribute['idmuc'] = $id_insert;
				$dataAttribute['com'] = $com;
				$dataAttribute['act'] = 'man';
				$dataAttribute['type'] = $type;

				foreach($_POST['attribute']['stt'] as $k => $v)
				{
					if($_POST['attribute']['stt'][$k])
					{
						$dataAttribute['stt'] = $_POST['attribute']['stt'][$k];
						$dataAttribute['tenkhongdau'] = $func->changeTitle($dataAttribute['tieudevi']);

						foreach($config['website']['lang'] as $key => $value) 
						{
							$dataAttribute['tieude'.$key] = htmlspecialchars($_POST['attribute']['tieude'.$key][$k]);
							$dataAttribute['giatri'.$key] = htmlspecialchars($_POST['attribute']['giatri'.$key][$k]);
						}

						$d->insert('attribute',$dataAttribute);
					}
				}
			}

			/* Lưu hình ảnh con */
			if(isset($_FILES['files'])) 
			{
				$arr_chuoi = str_replace('"','',$_POST['jfiler-items-exclude-files-0']);
				$arr_chuoi = str_replace('[','',$arr_chuoi);
				$arr_chuoi = str_replace(']','',$arr_chuoi);
				$arr_chuoi = str_replace('\\','',$arr_chuoi);
				$arr_chuoi = str_replace('0://','',$arr_chuoi);
				$arr_file_del = explode(',',$arr_chuoi);

				$dem = 0;
	            $myFile = $_FILES['files'];
	            $fileCount = count($myFile["name"]);

	            for($i=0;$i<$fileCount;$i++) 
	            {
	            	if($_FILES['files']['name'][$i]!='')
			    	{
						if(!in_array(($_FILES['files']['name'][$i]),$arr_file_del,true))
						{
							$file_name = $func->uploadName($myFile["name"][$i]);
							$file_ext = pathinfo($myFile["name"][$i], PATHINFO_EXTENSION);
							if(move_uploaded_file($myFile["tmp_name"][$i], UPLOAD_NEWS."/".$file_name.".".$file_ext))
							{
								$data1['photo'] = $file_name.".".$file_ext;
								$data1['stt'] = (int)$_POST['stt-filer'][$dem];		
								$data1['tenvi'] = $_POST['ten-filer'][$dem];		
								$data1['id_photo'] = $id_insert;
								$data1['com'] = $com;
								$data1['type'] = $type;
								$data1['kind'] = 'man';
								$data1['val'] = $type;
								$data1['hienthi'] = 1;
								$d->insert('gallery',$data1);
				            }
				            $dem++;
						}
		            }
	            }
	        }

			if($act=='save_copy')
			{
				if($savehere) $func->transfer("Sao chép dữ liệu thành công", "index.php?com=news&act=edit&type=".$type."&p=".$curPage.$strUrl."&id=".$id_insert);
				else $func->transfer("Sao chép dữ liệu thành công", "index.php?com=news&act=man&type=".$type."&p=".$curPage.$strUrl);
			}
			else
			{
				if($savehere) $func->transfer("Lưu dữ liệu thành công", "index.php?com=news&act=edit&type=".$type."&p=".$curPage.$strUrl."&id=".$id_insert);
				else $func->transfer("Lưu dữ liệu thành công", "index.php?com=news&act=man&type=".$type."&p=".$curPage.$strUrl);
			}
		}
		else
		{
			if($act=='save_copy')
			{
				if($savehere) $func->transfer("Sao chép dữ liệu bị lỗi", "index.php?com=news&act=edit&type=".$type."&p=".$curPage.$strUrl."&id=".$id_insert,0);
				else $func->transfer("Sao chép dữ liệu bị lỗi", "index.php?com=news&act=man&type=".$type."&p=".$curPage.$strUrl,0);
			}
			else
			{
				if($savehere) $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=news&act=edit&type=".$type."&p=".$curPage.$strUrl."&id=".$id_insert,0);
				else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=news&act=man&type=".$type."&p=".$curPage.$strUrl,0);
			}
		}
	}
}

/* Delete man */
function delete_item()
{
	global $d, $strUrl, $func, $curPage, $com, $type;

	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		/* Xóa SEO */
		$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man',$type));
		
		/* Xóa thuộc tính */
		$d->rawQuery("delete from #_attribute WHERE idmuc = ? AND com = ? AND act = ? AND type = ?",array($id,$com,'man',$type));

		/* Lấy dữ liệu */
		$row = $d->rawQueryOne("select id, photo, taptin from #_news where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			$func->delete_file(UPLOAD_NEWS.$row['photo']);
			$func->delete_file(UPLOAD_FILE.$row['taptin']);
			$d->rawQuery("delete from #_news where id = ?",array($id));

			/* Xóa gallery */
			$row = $d->rawQuery("select id, photo, taptin from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man',$com));

			if(count($row))
			{
				foreach($row as $v)
				{
					$func->delete_file(UPLOAD_NEWS.$v['photo']);
					$func->delete_file(UPLOAD_FILE.$v['taptin']);
				}

				$d->rawQuery("delete from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man',$com));
			}

			$func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man&type=".$type."&p=".$curPage.$strUrl);
		}
		else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man&type=".$type."&p=".$curPage.$strUrl,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);

			/* Xóa SEO */
			$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man',$type));

			/* Xóa thuộc tính */
			$d->rawQuery("delete from #_attribute WHERE idmuc = ? AND com = ? AND act = ? AND type = ?",array($id,$com,'man',$type));

			/* Lấy dữ liệu */
			$row = $d->rawQueryOne("select id, photo, taptin from #_news where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				$func->delete_file(UPLOAD_NEWS.$row['photo']);
				$func->delete_file(UPLOAD_FILE.$row['taptin']);
				$d->rawQuery("delete from #_news where id = ?",array($id));

				/* Xóa gallery */
				$row = $d->rawQuery("select id, photo, taptin from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man',$com));

				if(count($row))
				{
					foreach($row as $v)
					{
						$func->delete_file(UPLOAD_NEWS.$v['photo']);
						$func->delete_file(UPLOAD_FILE.$v['taptin']);
					}

					$d->rawQuery("delete from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man',$com));
				}
			}
		}

		$func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man&type=".$type."&p=".$curPage.$strUrl);
	} 
	else $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Get list */
function get_lists()
{
	global $d, $func, $strUrl, $curPage, $items, $paging, $type;
	
	$where = "";

	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and (tenvi LIKE '%$keyword%' or tenen LIKE '%$keyword%')";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_news_list where type = ? $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_news_list where type = ? $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=news&act=man_list&type=".$type;
	$paging = $func->pagination($total,$per_page,$curPage,$url);
}

/* Edit list */
function get_list()
{
	global $d, $strUrl, $func, $curPage, $item, $gallery, $type, $com;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_list&type=".$type."&p=".$curPage.$strUrl,0);

	$item = $d->rawQueryOne("select * from #_news_list where id = ? and type = ?",array($id,$type));
	
	if(!$item['id']) $func->transfer("Dữ liệu không có thực", "index.php?com=news&act=man_list&type=".$type."&p=".$curPage.$strUrl,0);

	/* Lấy hình ảnh con */
	$gallery = $d->rawQuery("select * from #_gallery where id_photo = ? and com = ? and type = ? and kind = ? and val = ? order by stt,id desc",array($id,$com,$type,'man_list',$type));
}

/* Save list */
function save_list()
{
	global $d, $strUrl, $func, $curPage, $config, $com, $type;

	if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_list&type=".$type."&p=".$curPage.$strUrl,0);

	$file_name = $func->uploadName($_FILES['file']["name"]);
	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	if($_POST['slugvi']) $data['tenkhongdauvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
	else $data['tenkhongdauvi'] = $func->changeTitle($data['tenvi']);
	if($_POST['slugen']) $data['tenkhongdauen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
	else $data['tenkhongdauen'] = $func->changeTitle($data['tenen']);
	$data['hienthi'] = ($data['hienthi']) ? 1 : 0;
	$data['type'] = $type;

	/* Post seo */
	if($config['news'][$type]['seo_list'])
	{
		$dataSeo = $_POST['dataSeo'];
		foreach($dataSeo as $column => $value) $dataSeo[$column] = htmlspecialchars($value);
	}

	if($id)
	{					
		if($photo = $func->uploadImage("file", $config['news'][$type]['img_type_list'], UPLOAD_NEWS,$file_name))
		{
			$data['photo'] = $photo;
			$row = $d->rawQueryOne("select id, photo from #_news_list where id = ? and type = ?",array($id,$type));
			if($row['id']) $func->delete_file(UPLOAD_NEWS.$row['photo']);
		}

        /* Cập nhật hình ảnh con */
		if(isset($_FILES['files'])) 
		{
			$arr_chuoi = str_replace('"','',$_POST['jfiler-items-exclude-files-0']);
        	$arr_chuoi = str_replace('[','',$arr_chuoi);
        	$arr_chuoi = str_replace(']','',$arr_chuoi);
        	$arr_chuoi = str_replace('\\','',$arr_chuoi);
        	$arr_chuoi = str_replace('0://','',$arr_chuoi);
        	$arr_file_del = explode(',',$arr_chuoi);

        	$dem = 0;
            $myFile = $_FILES['files'];
            $fileCount = count($myFile["name"]);

            for($i=0;$i<$fileCount;$i++) 
            {
            	if($_FILES['files']['name'][$i]!='')
            	{
					if(!in_array(($_FILES['files']['name'][$i]),$arr_file_del,true))
					{
						$file_name = $func->uploadName($myFile["name"][$i]);
						$file_ext = pathinfo($myFile["name"][$i], PATHINFO_EXTENSION);
						if(move_uploaded_file($myFile["tmp_name"][$i], UPLOAD_NEWS."/".$file_name.".".$file_ext))
						{
							$data1['photo'] = $file_name.".".$file_ext;
							$data1['stt'] = (int)$_POST['stt-filer'][$dem];		
							$data1['tenvi'] = $_POST['ten-filer'][$dem];
							$data1['id_photo'] = $id;
							$data1['com'] = $com;
							$data1['type'] = $type;
							$data1['kind'] = 'man_list';
							$data1['val'] = $type;
							$data1['hienthi'] = 1;
							$d->insert('gallery',$data1);
			            }
			            $dem++;
					}
            	}
            }
        }

		$data['ngaysua'] = time();
		
		$d->where('id', $id);
		$d->where('type', $type);
		if($d->update('news_list',$data))
		{
			/* SEO */
			if($config['news'][$type]['seo_list'])
			{
				$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_list',$type));

				$dataSeo['idmuc'] = $id;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_list';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			$func->transfer("Cập nhật dữ liệu thành công", "index.php?com=news&act=man_list&type=".$type."&p=".$curPage.$strUrl);
		}
		else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=man_list&type=".$type."&p=".$curPage.$strUrl,0);
	}
	else
	{				
		if($photo = $func->uploadImage("file", $config['news'][$type]['img_type_list'], UPLOAD_NEWS,$file_name))
		{
			$data['photo'] = $photo;
		}
		
		$data['ngaytao'] = time();
		
		if($d->insert('news_list',$data))
		{
			$id_insert = $d->getLastInsertId();

			/* SEO */
			if($config['news'][$type]['seo_list'])
			{
				$dataSeo['idmuc'] = $id_insert;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_list';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			/* Lưu hình ảnh con */
			if(isset($_FILES['files'])) 
			{
				$arr_chuoi = str_replace('"','',$_POST['jfiler-items-exclude-files-0']);
				$arr_chuoi = str_replace('[','',$arr_chuoi);
				$arr_chuoi = str_replace(']','',$arr_chuoi);
				$arr_chuoi = str_replace('\\','',$arr_chuoi);
				$arr_chuoi = str_replace('0://','',$arr_chuoi);
				$arr_file_del = explode(',',$arr_chuoi);

				$dem = 0;
	            $myFile = $_FILES['files'];
	            $fileCount = count($myFile["name"]);

	            for($i=0;$i<$fileCount;$i++) 
	            {
	            	if($_FILES['files']['name'][$i]!='')
					{
						if(!in_array(($_FILES['files']['name'][$i]),$arr_file_del,true))
						{
							$file_name = $func->uploadName($myFile["name"][$i]);
							$file_ext = pathinfo($myFile["name"][$i], PATHINFO_EXTENSION);
							if(move_uploaded_file($myFile["tmp_name"][$i], UPLOAD_NEWS."/".$file_name.".".$file_ext))
							{
								$data1['photo'] = $file_name.".".$file_ext;
								$data1['stt'] = (int)$_POST['stt-filer'][$dem];		
								$data1['tenvi'] = $_POST['ten-filer'][$dem];
								$data1['id_photo'] = $id_insert;
								$data1['com'] = $com;
								$data1['type'] = $type;
								$data1['kind'] = 'man_list';
								$data1['val'] = $type;
								$data1['hienthi'] = 1;
								$d->insert('gallery',$data1);
				            }
				            $dem++;
						}
		            }
	            }
	        }

			$func->transfer("Lưu dữ liệu thành công", "index.php?com=news&act=man_list&type=".$type."&p=".$curPage.$strUrl);
		}
		else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=news&act=man_list&type=".$type."&p=".$curPage.$strUrl,0);
	}
}

/* Delete list */
function delete_list()
{
	global $d, $strUrl, $func, $curPage, $com, $type;

	$id = htmlspecialchars($_GET['id']);

	if(isset($_GET['id']))
	{
		/* Xóa SEO */
		$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_list',$type));

		/* Lấy dữ liệu */
		$row = $d->rawQueryOne("select id, photo from #_news_list where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			$func->delete_file(UPLOAD_NEWS.$row['photo']);
			$d->rawQuery("delete from #_news_list where id = ?",array($id));

			/* Xóa gallery */
			$row = $d->rawQuery("select id, photo from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man_list',$com));

			if(count($row))
			{
				foreach($row as $v)
				{
					$func->delete_file(UPLOAD_NEWS.$v['photo']);
				}

				$d->rawQuery("delete from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man_list',$com));
			}

			$func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_list&type=".$type."&p=".$curPage.$strUrl);
		}
		else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man_list&type=".$type."&p=".$curPage.$strUrl,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);

			/* Xóa SEO */
			$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_list',$type));

			/* Lấy dữ liệu */
			$row = $d->rawQueryOne("select id, photo from #_news_list where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				$func->delete_file(UPLOAD_NEWS.$row['photo']);
				$d->rawQuery("delete from #_news_list where id = ?",array($id));

				/* Xóa gallery */
				$row = $d->rawQuery("select id, photo from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man_list',$com));

				if(count($row))
				{
					foreach($row as $v)
					{
						$func->delete_file(UPLOAD_NEWS.$v['photo']);
					}

					$d->rawQuery("delete from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man_list',$com));
				}
			}
		}

		$func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_list&type=".$type."&p=".$curPage.$strUrl);
	}
	else $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_list&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Get cat */
function get_cats()
{
	global $d, $func, $strUrl, $curPage, $items, $paging, $type;
	
	$where = "";
	$idlist = htmlspecialchars($_REQUEST['id_list']);

	if($idlist) $where .= " and id_list=$idlist";
	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and (tenvi LIKE '%$keyword%' or tenen LIKE '%$keyword%')";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_news_cat where type = ? $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_news_cat where type = ? $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=news&act=man_cat".$strUrl."&type=".$type;
	$paging = $func->pagination($total,$per_page,$curPage,$url);
}

/* Edit cat */
function get_cat()
{
	global $d, $strUrl, $func, $curPage, $item, $type;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_cat&type=".$type."&p=".$curPage.$strUrl,0);
	
	$item = $d->rawQueryOne("select * from #_news_cat where id = ? and type = ?",array($id,$type));

	if(!$item['id']) $func->transfer("Dữ liệu không có thực", "index.php?com=news&act=man_cat&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Save cat */
function save_cat()
{
	global $d, $strUrl, $func, $curPage, $config, $com, $type;

	if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_cat&type=".$type."&p=".$curPage.$strUrl,0);

	$file_name = $func->uploadName($_FILES['file']["name"]);
	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	if($_POST['slugvi']) $data['tenkhongdauvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
	else $data['tenkhongdauvi'] = $func->changeTitle($data['tenvi']);
	if($_POST['slugen']) $data['tenkhongdauen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
	else $data['tenkhongdauen'] = $func->changeTitle($data['tenen']);
	$data['hienthi'] = ($data['hienthi']) ? 1 : 0;
	$data['type'] = $type;

	/* Post seo */
	if($config['news'][$type]['seo_cat'])
	{
		$dataSeo = $_POST['dataSeo'];
		foreach($dataSeo as $column => $value) $dataSeo[$column] = htmlspecialchars($value);
	}

	if($id)
	{
		if($photo = $func->uploadImage("file", $config['news'][$type]['img_type_cat'], UPLOAD_NEWS,$file_name))
		{
			$data['photo'] = $photo;
			$row = $d->rawQueryOne("select id, photo from #_news_cat where id = ? and type = ?",array($id,$type));
			if($row['id']) $func->delete_file(UPLOAD_NEWS.$row['photo']);
		}

		$data['ngaysua'] = time();
		
		$d->where('id', $id);
		$d->where('type', $type);
		if($d->update('news_cat',$data))
		{
			/* SEO */
			if($config['news'][$type]['seo_cat'])
			{
				$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_cat',$type));

				$dataSeo['idmuc'] = $id;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_cat';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			$func->transfer("Cập nhật dữ liệu thành công", "index.php?com=news&act=man_cat&type=".$type."&p=".$curPage.$strUrl);
		}
		else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=man_cat&type=".$type."&p=".$curPage.$strUrl,0);
	}
	else
	{		
		if($photo = $func->uploadImage("file", $config['news'][$type]['img_type_cat'], UPLOAD_NEWS,$file_name))
		{
			$data['photo'] = $photo;
		}

		$data['ngaytao'] = time();
		
		if($d->insert('news_cat',$data))
		{
			$id_insert = $d->getLastInsertId();

			/* SEO */
			if($config['news'][$type]['seo_cat'])
			{
				$dataSeo['idmuc'] = $id_insert;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_cat';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}
			$func->transfer("Lưu dữ liệu thành công", "index.php?com=news&act=man_cat&type=".$type."&p=".$curPage.$strUrl);
		}
		else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=news&act=man_cat&type=".$type."&p=".$curPage.$strUrl,0);
	}
}

/* Delete cat */
function delete_cat()
{
	global $d, $strUrl, $func, $curPage, $com, $type;

	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		/* Xóa SEO */
		$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_cat',$type));

		/* Lấy dữ liệu */
		$row = $d->rawQueryOne("select id, photo from #_news_cat where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			$func->delete_file(UPLOAD_NEWS.$row['photo']);
			$d->rawQuery("delete from #_news_cat where id = ?",array($id));

			$func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_cat&type=".$type."&p=".$curPage.$strUrl);
		}
		else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man_cat&type=".$type."&p=".$curPage.$strUrl,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);

			/* Xóa SEO */
			$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_cat',$type));

			/* Lấy dữ liệu */
			$row = $d->rawQueryOne("select id, photo from #_news_cat where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				$func->delete_file(UPLOAD_NEWS.$row['photo']);
				$d->rawQuery("delete from #_news_cat where id = ?",array($id));
			}
		}

		$func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_cat&type=".$type."&p=".$curPage.$strUrl);
	}
	else $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_cat&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Get item */
function get_loais()
{
	global $d, $func, $strUrl, $curPage, $items, $paging, $type;
	
	$where = "";
	$idlist = htmlspecialchars($_REQUEST['id_list']);
	$idcat = htmlspecialchars($_REQUEST['id_cat']);

	if($idlist) $where .= " and id_list=$idlist";
	if($idcat) $where .= " and id_cat=$idcat";
	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and (tenvi LIKE '%$keyword%' or tenen LIKE '%$keyword%')";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_news_item where type = ? $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_news_item where type = ? $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=news&act=man_item".$strUrl."&type=".$type;
	$paging = $func->pagination($total,$per_page,$curPage,$url);
}

/* Edit item */
function get_loai()
{
	global $d, $strUrl, $func, $curPage, $item, $type;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_item&type=".$type."&p=".$curPage.$strUrl,0);
	
	$item = $d->rawQueryOne("select * from #_news_item where id = ? and type = ?",array($id,$type));

	if(!$item['id']) $func->transfer("Dữ liệu không có thực", "index.php?com=news&act=man_item&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Save item */
function save_loai()
{
	global $d, $strUrl, $func, $curPage, $config, $com, $type;

	if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_item&type=".$type."&p=".$curPage.$strUrl,0);

	$file_name = $func->uploadName($_FILES['file']["name"]);
	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	if($_POST['slugvi']) $data['tenkhongdauvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
	else $data['tenkhongdauvi'] = $func->changeTitle($data['tenvi']);
	if($_POST['slugen']) $data['tenkhongdauen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
	else $data['tenkhongdauen'] = $func->changeTitle($data['tenen']);
	$data['hienthi'] = ($data['hienthi']) ? 1 : 0;
	$data['type'] = $type;

	/* Post seo */
	if($config['news'][$type]['seo_item'])
	{
		$dataSeo = $_POST['dataSeo'];
		foreach($dataSeo as $column => $value) $dataSeo[$column] = htmlspecialchars($value);
	}

	if($id)
	{
		if($photo = $func->uploadImage("file", $config['news'][$type]['img_type_item'], UPLOAD_NEWS,$file_name))
		{
			$data['photo'] = $photo;			
			$row = $d->rawQueryOne("select id, photo from #_news_item where id = ? and type = ?",array($id,$type));
			if($row['id']) $func->delete_file(UPLOAD_NEWS.$row['photo']);
		}

		$data['ngaysua'] = time();
		
		$d->where('id', $id);
		$d->where('type', $type);
		if($d->update('news_item',$data))
		{
			/* SEO */
			if($config['news'][$type]['seo_item'])
			{
				$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_item',$type));

				$dataSeo['idmuc'] = $id;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_item';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			$func->transfer("Cập nhật dữ liệu thành công", "index.php?com=news&act=man_item&type=".$type."&p=".$curPage.$strUrl);
		}
		else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=man_item&type=".$type."&p=".$curPage.$strUrl,0);
	}
	else
	{	
		if($photo = $func->uploadImage("file", $config['news'][$type]['img_type_item'], UPLOAD_NEWS,$file_name))
		{
			$data['photo'] = $photo;
		}	

		$data['ngaytao'] = time();
		
		if($d->insert('news_item',$data))
		{
			$id_insert = $d->getLastInsertId();

			/* SEO */
			if($config['news'][$type]['seo_item'])
			{
				$dataSeo['idmuc'] = $id_insert;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_item';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			$func->transfer("Lưu dữ liệu thành công", "index.php?com=news&act=man_item&type=".$type."&p=".$curPage.$strUrl);
		}
		else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=news&act=man_item&type=".$type."&p=".$curPage.$strUrl,0);
	}
}

/* Delete item */
function delete_loai()
{
	global $d, $strUrl, $func, $curPage, $com, $type;

	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		/* Xóa SEO */
		$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_item',$type));

		/* Lấy dữ liệu */
		$row = $d->rawQueryOne("select id, photo from #_news_item where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			$func->delete_file(UPLOAD_NEWS.$row['photo']);
			$d->rawQuery("delete from #_news_item where id = ?",array($id));

			$func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_item&type=".$type."&p=".$curPage.$strUrl);
		}
		else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man_item&type=".$type."&p=".$curPage.$strUrl,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);

			/* Xóa SEO */
			$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_item',$type));

			/* Lấy dữ liệu */
			$row = $d->rawQueryOne("select id, photo from #_news_item where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				$func->delete_file(UPLOAD_NEWS.$row['photo']);
				$d->rawQuery("delete from #_news_item where id = ?",array($id));
			}
		}

		$func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_item&type=".$type."&p=".$curPage.$strUrl);
	}
	else $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_item&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Get sub */
function get_subs()
{
	global $d, $func, $strUrl, $curPage, $items, $paging, $type;

	$where = "";	
	
	$idlist = htmlspecialchars($_REQUEST['id_list']);
	$idcat = htmlspecialchars($_REQUEST['id_cat']);
	$iditem = htmlspecialchars($_REQUEST['id_item']);

	if($idlist) $where .= " and id_list=$idlist";
	if($idcat) $where .= " and id_cat=$idcat";
	if($iditem) $where .= " and id_item=$iditem";
	if($_REQUEST['keyword']!='')
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and (tenvi LIKE '%$keyword%' or tenen LIKE '%$keyword%')";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_news_sub where type = ? $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_news_sub where type = ? $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=news&act=man_sub".$strUrl."&type=".$type;
	$paging = $func->pagination($total,$per_page,$curPage,$url);
}

/* Edit sub */
function get_sub()
{
	global $d, $strUrl, $func, $curPage, $item, $type;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_sub&type=".$type."&p=".$curPage.$strUrl,0);

	$item = $d->rawQueryOne("select * from #_news_sub where id = ? and type = ?",array($id,$type));

	if(!$item['id']) $func->transfer("Dữ liệu không có thực", "index.php?com=news&act=man_sub&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Save sub */
function save_sub()
{
	global $d, $strUrl, $func, $curPage, $config, $com, $type;

	if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_sub&type=".$type."&p=".$curPage.$strUrl,0);

	$file_name = $func->uploadName($_FILES['file']["name"]);
	$id = htmlspecialchars($_POST['id']);
	
	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	if($_POST['slugvi']) $data['tenkhongdauvi'] = $func->changeTitle(htmlspecialchars($_POST['slugvi']));
	else $data['tenkhongdauvi'] = $func->changeTitle($data['tenvi']);
	if($_POST['slugen']) $data['tenkhongdauen'] = $func->changeTitle(htmlspecialchars($_POST['slugen']));
	else $data['tenkhongdauen'] = $func->changeTitle($data['tenen']);
	$data['hienthi'] = ($data['hienthi']) ? 1 : 0;
	$data['type'] = $type;

	/* Post seo */
	if($config['news'][$type]['seo_sub'])
	{
		$dataSeo = $_POST['dataSeo'];
		foreach($dataSeo as $column => $value) $dataSeo[$column] = htmlspecialchars($value);
	}

	if($id)
	{
		if($photo = $func->uploadImage("file", $config['news'][$type]['img_type_sub'], UPLOAD_NEWS,$file_name))
		{
			$data['photo'] = $photo;
			$row = $d->rawQueryOne("select id, photo from #_news_sub where id = ? and type = ?",array($id,$type));
			if($row['id']) $func->delete_file(UPLOAD_NEWS.$row['photo']);
		}

		$data['ngaysua'] = time();
		
		$d->where('id', $id);
		$d->where('type', $type);
		if($d->update('news_sub',$data))
		{
			/* SEO */
			if($config['news'][$type]['seo_sub'])
			{
				$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_sub',$type));

				$dataSeo['idmuc'] = $id;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_sub';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			$func->transfer("Cập nhật dữ liệu thành công", "index.php?com=news&act=man_sub&type=".$type."&p=".$curPage.$strUrl);
		}
		else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=man_sub&type=".$type."&p=".$curPage.$strUrl,0);
	}
	else
	{	
		if($photo = $func->uploadImage("file", $config['news'][$type]['img_type_sub'], UPLOAD_NEWS,$file_name))
		{
			$data['photo'] = $photo;
		}

		$data['ngaytao'] = time();
		
		if($d->insert('news_sub',$data))
		{
			$id_insert = $d->getLastInsertId();

			/* SEO */
			if($config['news'][$type]['seo_sub'])
			{
				$dataSeo['idmuc'] = $id_insert;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_sub';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			$func->transfer("Lưu dữ liệu thành công", "index.php?com=news&act=man_sub&type=".$type."&p=".$curPage.$strUrl);
		}
		else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=news&act=man_sub&type=".$type."&p=".$curPage.$strUrl,0);
	}
}

/* Delete sub */
function delete_sub()
{
	global $d, $strUrl, $func, $curPage, $com, $type;

	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		/* Xóa SEO */
		$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_sub',$type));

		/* Lấy dữ liệu */
		$row = $d->rawQueryOne("select id, photo from #_news_sub where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			$func->delete_file(UPLOAD_NEWS.$row['photo']);
			$d->rawQuery("delete from #_news_sub where id = ?",array($id));

			$func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_sub&type=".$type."&p=".$curPage.$strUrl);
		}
		else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man_sub&type=".$type."&p=".$curPage.$strUrl,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);

			/* Xóa SEO */
			$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_sub',$type));

			/* Lấy dữ liệu */
			$row = $d->rawQueryOne("select id, photo from #_news_sub where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				$func->delete_file(UPLOAD_NEWS.$row['photo']);
				$d->rawQuery("delete from #_news_sub where id = ?",array($id));
			}
		}

		$func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man_sub&type=".$type."&p=".$curPage.$strUrl);
	}
	else $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man_sub&type=".$type."&p=".$curPage.$strUrl,0);
}
?>