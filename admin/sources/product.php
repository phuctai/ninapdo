<?php
if(!defined('_SOURCE')) die("Error");

$act = htmlspecialchars($_REQUEST['act']);
$id = htmlspecialchars($_REQUEST['id']);
$type = htmlspecialchars($_REQUEST['type']);
$kind = htmlspecialchars($_REQUEST['kind']);
$val = htmlspecialchars($_REQUEST['val']);
$idc = htmlspecialchars($_REQUEST['idc']);
$curPage = (isset($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;

/* Kiểm tra active product */
$arrCheck = array();
foreach($config['product'] as $k => $v) $arrCheck[] = $k;
if(!count($arrCheck) || !in_array($type,$arrCheck)) transfer("Trang không tồn tại", "index.php",0);

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
		$template = "product/man/items";
		break;
	case "add":
		$template = "product/man/item_add";
		break;
	case "edit":
	case "copy":
		if(!$config['product'][$type]['copy'] && $act=='copy')
		{
			$template = "404";
			return false;
		}
		get_item();
		$template = "product/man/item_add";
		break;
	case "save":
	case "save_copy":
		save_item();
		break;
	case "delete":
		delete_item();
		break;

	/* Size */
	case "man_size":
		get_items_size();
		$template = "product/size/items";
		break;
	case "add_size":
		$template = "product/size/item_add";
		break;
	case "edit_size":
		get_item_size();
		$template = "product/size/item_add";
		break;
	case "save_size":
		save_item_size();
		break;
	case "delete_size":
		delete_item_size();
		break;

	/* Color */
	case "man_mau":
		get_items_mau();
		$template = "product/mau/items";
		break;
	case "add_mau":
		$template = "product/mau/item_add";
		break;
	case "edit_mau":
		get_item_mau();
		$template = "product/mau/item_add";
		break;
	case "save_mau":
		save_item_mau();
		break;
	case "delete_mau":
		delete_item_mau();
		break;

	/* Brand */
	case "man_brand":
		get_brands();
		$template = "product/brand/brand";
		break;
	case "add_brand":
		$template = "product/brand/brand_add";
		break;
	case "edit_brand":
		get_brand();
		$template = "product/brand/brand_add";
		break;
	case "save_brand":
		save_brand();
		break;
	case "delete_brand":
		delete_brand();
		break;

	/* List */
	case "man_list":
		get_lists();
		$template = "product/list/lists";
		break;
	case "add_list":
		$template = "product/list/list_add";
		break;
	case "edit_list":
		get_list();
		$template = "product/list/list_add";
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
		$template = "product/cat/cats";
		break;
	case "add_cat":
		$template = "product/cat/cat_add";
		break;
	case "edit_cat":
		get_cat();
		$template = "product/cat/cat_add";
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
		$template = "product/item/loais";
		break;
	case "add_item":
		$template = "product/item/loai_add";
		break;
	case "edit_item":
		get_loai();
		$template = "product/item/loai_add";
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
		$template = "product/sub/subs";
		break;
	case "add_sub":
		$template = "product/sub/sub_add";
		break;
	case "edit_sub":
		get_sub();
		$template = "product/sub/sub_add";
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
	global $d, $strUrl, $curPage, $items, $paging, $type;

	$where = "";
	$idlist = htmlspecialchars($_REQUEST['id_list']);
	$idcat = htmlspecialchars($_REQUEST['id_cat']);
	$iditem = htmlspecialchars($_REQUEST['id_item']);
	$idsub = htmlspecialchars($_REQUEST['id_sub']);
	$idbrand = htmlspecialchars($_REQUEST['id_brand']);

	if($idlist) $where .= " and id_list=$idlist";
	if($idcat) $where .= " and id_cat=$idcat";
	if($iditem) $where .= " and id_item=$iditem";
	if($idsub) $where .= " and id_sub=$idsub";
	if($idbrand) $where .= " and id_brand=$idbrand";
	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and (tenvi LIKE '%$keyword%' or tenen LIKE '%$keyword%')";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_product where type = ? $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_product where type = ? $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=product&act=man".$strUrl."&type=".$type;
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Edit man */
function get_item()
{
	global $d, $strUrl, $curPage, $item, $attributes, $gallery, $type, $com;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man&type=".$type."&p=".$curPage.$strUrl,0);

	$item = $d->rawQueryOne("select * from #_product where id = ? and type = ?",array($id,$type));

	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=product&act=man&type=".$type."&p=".$curPage.$strUrl,0);

	/* Lấy hình ảnh con */
	$gallery = $d->rawQuery("select * from #_gallery where id_photo = ? and com = ? and type = ? and kind = ? and val = ? order by stt,id desc",array($id,$com,$type,'man',$type));

	/* Lấy thuộc tính */
	$attributes = $d->rawQuery("select * from #_attribute where idmuc = ? and com = ? and act = ? and type = ? order by stt,id desc",array($id,$com,'man',$type));
}

/* Save man */
function save_item()
{
	global $d, $strUrl, $curPage, $config, $com, $act, $type;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man&type=".$type."&p=".$curPage.$strUrl,0);

	$savehere = (isset($_POST['save-here'])) ? true : false;
	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	if($_POST['slugvi']) $data['tenkhongdauvi'] = changeTitle(htmlspecialchars($_POST['slugvi']));
	else $data['tenkhongdauvi'] = changeTitle($data['tenvi']);
	if($_POST['slugen']) $data['tenkhongdauen'] = changeTitle(htmlspecialchars($_POST['slugen']));
	else $data['tenkhongdauen'] = changeTitle($data['tenen']);
	if($config['product'][$type]['size']) 
	{
		if($_POST['size_group']!='') $data['id_size'] = implode(",", $_POST['size_group']);
		else $data['id_size'] = "";
	}
	if($config['product'][$type]['mau'])
	{
		if($_POST['mau_group']!='') $data['id_mau'] = implode(",", $_POST['mau_group']);
		else $data['id_mau'] = "";
	}
	if($config['product'][$type]['tags'])
	{
		if($_POST['tags_group']!='') $data['id_tags'] = implode(",", $_POST['tags_group']);
		else $data['id_tags'] = "";
	}
	$data['gia'] = str_replace(",","",$data['gia']);
	$data['giamoi'] = str_replace(",","",$data['giamoi']);
	$data['hienthi'] = ($data['hienthi']) ? 1 : 0;
	$data['type'] = $type;

	/* Post seo */
	if($config['product'][$type]['seo'])
	{
		$dataSeo = $_POST['dataSeo'];
		foreach($dataSeo as $column => $value) $dataSeo[$column] = htmlspecialchars($value);
	}

	if($id && $act!='save_copy')
	{
		$file_name = upload_name($_FILES['file']["name"]);
		if($photo = uploadImage("file", $config['product'][$type]['img_type'], _upload_product,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['product'][$type]['thumb_width'], $config['product'][$type]['thumb_height'], _upload_product,$file_name,$config['product'][$type]['thumb_ratio']);
			
			$row = $d->rawQueryOne("select id, photo, thumb from #_product where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_product.$row['photo']);
				delete_file(_upload_product.$row['thumb']);
			}
		}

		$file_name = upload_name($_FILES['file-taptin']["name"]);
		if($taptin = uploadImage("file-taptin", $config['product'][$type]['file_type'],_upload_file,$file_name))
		{
			$data['taptin'] = $taptin;
			
			$row = $d->rawQueryOne("select id, taptin from #_product where id = ? and type = ?",array($id,$type));

			if($row['id']) delete_file(_upload_file.$row['taptin']);
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
            $file_name = digitalRandom(0,9,6);

            for($i=0;$i<$fileCount;$i++) 
            {
            	if($_FILES['files']['name'][$i]!='')
				{
					if(!in_array(($_FILES['files']['name'][$i]),$arr_file_del,true))
					{
						if(move_uploaded_file($myFile["tmp_name"][$i], _upload_product."/".$file_name."_".$myFile["name"][$i]))
			            {
							$data1['photo'] = $file_name."_".$myFile["name"][$i];
							$data1['thumb'] = createThumb($data1['photo'], $config['product'][$type]['gallery'][$type]['thumb_width_photo'], $config['product'][$type]['gallery'][$type]['thumb_height_photo'], _upload_product, $file_name."_".$myFile["name"][$i],$config['product'][$type]['gallery'][$type]['thumb_ratio_photo']);	
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
		if($d->update('product',$data))
		{
			/* SEO */
			if($config['product'][$type]['seo'])
			{
				$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man',$type));

				$dataSeo['idmuc'] = $id;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			/* Attribute */
			if($config['product'][$type]['attribute'])
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
						$dataAttribute['tenkhongdau'] = changeTitle($dataAttribute['tieudevi']);

						foreach($config['website']['lang'] as $key => $value) 
						{
							$dataAttribute['tieude'.$key] = htmlspecialchars($_POST['attribute']['tieude'.$key][$k]);
							$dataAttribute['giatri'.$key] = htmlspecialchars($_POST['attribute']['giatri'.$key][$k]);
						}

						$d->insert('attribute',$dataAttribute);
					}
				}
			}

			if($savehere) transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=edit&type=".$type."&p=".$curPage.$strUrl."&id=".$id);
			else transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man&type=".$type."&p=".$curPage.$strUrl);
		}
		else
		{
			if($savehere) transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=edit&type=".$type."&p=".$curPage.$strUrl."&id=".$id,0);
			else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man&type=".$type."&p=".$curPage.$strUrl,0);
		}
	}
	else
	{
		$file_name = upload_name($_FILES['file']["name"]);
		if($photo = uploadImage("file", $config['product'][$type]['img_type'], _upload_product,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['product'][$type]['thumb_width'], $config['product'][$type]['thumb_height'], _upload_product,$file_name,$config['product'][$type]['thumb_ratio']);			
		}

		$file_name = upload_name($_FILES['file-taptin']["name"]);
		if($taptin = uploadImage("file-taptin", $config['product'][$type]['file_type'],_upload_file,$file_name))
		{
			$data['taptin'] = $taptin;		
		}
	
		$data['ngaytao'] = time();

		if($d->insert('product',$data))
		{
			$id_insert = $d->getLastInsertId();

			/* SEO */
			if($config['product'][$type]['seo'])
			{
				$dataSeo['idmuc'] = $id_insert;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			/* Attribute */
			if($config['product'][$type]['attribute'])
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
						$dataAttribute['tenkhongdau'] = changeTitle($dataAttribute['tieudevi']);

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
	            $file_name = digitalRandom(0,9,6);

	            for($i=0;$i<$fileCount;$i++) 
	            {
	            	if($_FILES['files']['name'][$i]!='')
			    	{
						if(!in_array(($_FILES['files']['name'][$i]),$arr_file_del,true))
						{
							if(move_uploaded_file($myFile["tmp_name"][$i], _upload_product."/".$file_name."_".$myFile["name"][$i]))
				            {
								$data1['photo'] = $file_name."_".$myFile["name"][$i];
								$data1['thumb'] = createThumb($data1['photo'], $config['product'][$type]['gallery'][$type]['thumb_width_photo'], $config['product'][$type]['gallery'][$type]['thumb_height_photo'], _upload_product, $file_name."_".$myFile["name"][$i],$config['product'][$type]['gallery'][$type]['thumb_ratio_photo']);	
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
				if($savehere) transfer("Sao chép dữ liệu thành công", "index.php?com=product&act=edit&type=".$type."&p=".$curPage.$strUrl."&id=".$id_insert);
				else transfer("Sao chép dữ liệu thành công", "index.php?com=product&act=man&type=".$type."&p=".$curPage.$strUrl);
			}
			else
			{
				if($savehere) transfer("Lưu dữ liệu thành công", "index.php?com=product&act=edit&type=".$type."&p=".$curPage.$strUrl."&id=".$id_insert);
				else transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man&type=".$type."&p=".$curPage.$strUrl);
			}
		}
		else
		{
			if($act=='save_copy')
			{
				if($savehere) transfer("Sao chép dữ liệu bị lỗi", "index.php?com=product&act=edit&type=".$type."&p=".$curPage.$strUrl."&id=".$id_insert,0);
				else transfer("Sao chép dữ liệu bị lỗi", "index.php?com=product&act=man&type=".$type."&p=".$curPage.$strUrl,0);
			}
			else
			{
				if($savehere) transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=edit&type=".$type."&p=".$curPage.$strUrl."&id=".$id_insert,0);
				else transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man&type=".$type."&p=".$curPage.$strUrl,0);
			}
		}
	}
}

/* Delete man */
function delete_item()
{
	global $d, $strUrl, $curPage, $com, $type;

	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		/* Xóa SEO */
		$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man',$type));
		
		/* Lấy dữ liệu */
		$row = $d->rawQueryOne("select id, photo, thumb, taptin from #_product where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			delete_file(_upload_product.$row['photo']);
			delete_file(_upload_product.$row['thumb']);
			delete_file(_upload_file.$row['taptin']);
			$d->rawQuery("delete from #_product where id = ?",array($id));

			/* Xóa gallery */
			$row = $d->rawQuery("select id, photo, thumb, taptin from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man',$com));

			if(count($row))
			{
				foreach($row as $v)
				{
					delete_file(_upload_product.$v['photo']);
					delete_file(_upload_product.$v['thumb']);
					delete_file(_upload_file.$v['taptin']);
				}

				$d->rawQuery("delete from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man',$com));
			}

			transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man&type=".$type."&p=".$curPage.$strUrl);
		}
		else transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man&type=".$type."&p=".$curPage.$strUrl,0);
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
			$row = $d->rawQueryOne("select id, photo, thumb, taptin from #_product where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_product.$row['photo']);
				delete_file(_upload_product.$row['thumb']);
				delete_file(_upload_file.$row['taptin']);
				$d->rawQuery("delete from #_product where id = ?",array($id));

				/* Xóa gallery */
				$row = $d->rawQuery("select id, photo, thumb, taptin from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man',$com));

				if(count($row))
				{
					foreach($row as $v)
					{
						delete_file(_upload_product.$v['photo']);
						delete_file(_upload_product.$v['thumb']);
						delete_file(_upload_file.$v['taptin']);
					}

					$d->rawQuery("delete from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man',$com));
				}
			}
		}

		transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man&type=".$type."&p=".$curPage.$strUrl);
	} 
	else transfer("Không nhận được dữ liệu", "index.php?com=product&act=man&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Get size */
function get_items_size()
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
	$sql = "select * from #_product_size where type = ? $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_product_size where type = ? $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=product&act=man_size&type=".$type;
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Edit size */
function get_item_size()
{
	global $d, $curPage, $item, $type;

	$id = htmlspecialchars($_GET['id']);
	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_size&type=".$type."&p=".$curPage,0);

	$item = $d->rawQueryOne("select * from #_product_size where id = ?",array($id));

	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=product&act=man_size&type=".$type."&p=".$curPage,0);
}

/* Save size */
function save_item_size()
{
	global $d, $curPage, $config, $type;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_size&type=".$type."&p=".$curPage,0);

	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	$data['gia'] = str_replace(",","",$data['gia']);			
	$data['hienthi'] = ($data['hienthi']) ? 1 : 0;
	$data['type'] = $type;

	if($id)
	{
		$data['ngaysua'] = time();

		$d->where('id', $id);
		$d->where('type', $type);
		if($d->update('product_size',$data)) transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_size&type=".$type."&p=".$curPage);
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_size&type=".$type."&p=".$curPage,0);
	}
	else
	{
		$data['ngaytao'] = time();

		if($d->insert('product_size',$data)) transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_size&type=".$type."&p=".$curPage);
		else transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_size&type=".$type."&p=".$curPage,0);
	}
}

/* Delete size */
function delete_item_size()
{
	global $d, $curPage, $type;

	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		$row = $d->rawQueryOne("select id from #_product_size where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			$d->rawQuery("delete from #_product_size where id = ? and type = ?",array($id,$type));
			transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_size&type=".$type."&p=".$curPage);
		}
		else transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_size&type=".$type."&p=".$curPage,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);
			$row = $d->rawQueryOne("select id from #_product_size where id = ? and type = ?",array($id,$type));

			if($row['id']) $d->rawQuery("delete from #_product_size where id = ? and type = ?",array($id,$type));
		}

		transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_size&type=".$type."&p=".$curPage);
	} 
	else transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_size&type=".$type."&p=".$curPage,0);
}

/* Get color */
function get_items_mau()
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
	$sql = "select * from #_product_mau where type = ? $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_product_mau where type = ? $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=product&act=man_mau&type=".$type;
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Edit color */
function get_item_mau()
{
	global $d, $curPage, $item, $type;

	$id = htmlspecialchars($_GET['id']);
	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_mau&type=".$type."&p=".$curPage,0);

	$item = $d->rawQueryOne("select * from #_product_mau where id = ?",array($id));

	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=product&act=man_mau&type=".$type."&p=".$curPage,0);
}

/* Save color */
function save_item_mau()
{
	global $d, $curPage, $config, $type;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_mau&type=".$type."&p=".$curPage,0);

	$file_name = upload_name($_FILES['file']["name"]);
	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	$data['gia'] = str_replace(",","",$data['gia']);
	$data['hienthi'] = ($data['hienthi']) ? 1 : 0;
	$data['type'] = $type;

	if($id)
	{
		if($photo = uploadImage("file", $config['product'][$type]['img_type_mau'], _upload_mau,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['product'][$type]['thumb_width_mau'], $config['product'][$type]['thumb_height_mau'], _upload_mau,$file_name,$config['product'][$type]['thumb_ratio_mau']);
			
			$row = $d->rawQueryOne("select id, photo, thumb from #_product_mau where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_mau.$row['photo']);
				delete_file(_upload_mau.$row['thumb']);
			}
		}

		$data['ngaysua'] = time();

		$d->where('id', $id);
		$d->where('type', $type);
		if($d->update('product_mau',$data)) transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_mau&type=".$type."&p=".$curPage);
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_mau&type=".$type."&p=".$curPage,0);
	}
	else
	{	
		if($photo = uploadImage("file", $config['product'][$type]['img_type_mau'], _upload_mau,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['product'][$type]['thumb_width_mau'], $config['product'][$type]['thumb_height_mau'], _upload_mau,$file_name,$config['product'][$type]['thumb_ratio_mau']);			
		}

		$data['ngaytao'] = time();

		if($d->insert('product_mau',$data)) transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_mau&type=".$type."&p=".$curPage);
		else transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_mau&type=".$type."&p=".$curPage,0);
	}
}

/* Delete color */
function delete_item_mau()
{
	global $d, $curPage, $type;

	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		$row = $d->rawQueryOne("select * from #_product_mau where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			delete_file(_upload_mau.$row['photo']);
			delete_file(_upload_mau.$row['thumb']);
			$d->rawQuery("delete from #_product_mau where id = ?",array($id));

			transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_mau&type=".$type."&p=".$curPage);
		}
		else transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_mau&type=".$type."&p=".$curPage,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);
			$row = $d->rawQueryOne("select * from #_product_mau where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_mau.$row['photo']);
				delete_file(_upload_mau.$row['thumb']);
				$d->rawQuery("delete from #_product_mau where id = ?",array($id));
			}
		}
		transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_mau&type=".$type."&p=".$curPage);
	} 
	else transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_mau&type=".$type."&p=".$curPage,0);
}

/* Get list */
function get_lists()
{
	global $d, $strUrl, $curPage, $items, $paging, $type;
	
	$where = "";

	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and (tenvi LIKE '%$keyword%' or tenen LIKE '%$keyword%')";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_product_list where type = ? $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_product_list where type = ? $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=product&act=man_list&type=".$type;
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Edit list */
function get_list()
{
	global $d, $strUrl, $curPage, $item, $gallery, $type, $com;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_list&type=".$type."&p=".$curPage.$strUrl,0);

	$item = $d->rawQueryOne("select * from #_product_list where id = ? and type = ?",array($id,$type));
	
	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=product&act=man_list&type=".$type."&p=".$curPage.$strUrl,0);

	/* Lấy hình ảnh con */
	$gallery = $d->rawQuery("select * from #_gallery where id_photo = ? and com = ? and type = ? and kind = ? and val = ? order by stt,id desc",array($id,$com,$type,'man_list',$type));
}

/* Save list */
function save_list()
{
	global $d, $strUrl, $curPage, $config, $com, $type;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_list&type=".$type."&p=".$curPage.$strUrl,0);

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
	if($config['product'][$type]['seo_list'])
	{
		$dataSeo = $_POST['dataSeo'];
		foreach($dataSeo as $column => $value) $dataSeo[$column] = htmlspecialchars($value);
	}

	if($id)
	{					
		if($photo = uploadImage("file", $config['product'][$type]['img_type_list'], _upload_product,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['product'][$type]['thumb_width_list'], $config['product'][$type]['thumb_height_list'], _upload_product,$file_name,$config['product'][$type]['thumb_ratio_list']);
			
			$row = $d->rawQueryOne("select id, photo, thumb from #_product_list where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_product.$row['photo']);
				delete_file(_upload_product.$row['thumb']);
			}
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
            $file_name = digitalRandom(0,9,6);

            for($i=0;$i<$fileCount;$i++) 
            {
            	if($_FILES['files']['name'][$i]!='')
            	{
					if(!in_array(($_FILES['files']['name'][$i]),$arr_file_del,true))
					{
						if(move_uploaded_file($myFile["tmp_name"][$i], _upload_product."/".$file_name."_".$myFile["name"][$i]))
			            {
							$data1['photo'] = $file_name."_".$myFile["name"][$i];
							$data1['thumb'] = createThumb($data1['photo'], $config['product'][$type]['gallery_list'][$type]['thumb_width_photo'], $config['product'][$type]['gallery_list'][$type]['thumb_height_photo'], _upload_product, $file_name."_".$myFile["name"][$i],$config['product'][$type]['gallery_list'][$type]['thumb_ratio_photo']);	
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
		if($d->update('product_list',$data))
		{
			/* SEO */
			if($config['product'][$type]['seo_list'])
			{
				$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_list',$type));

				$dataSeo['idmuc'] = $id;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_list';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_list&type=".$type."&p=".$curPage.$strUrl);
		}
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_list&type=".$type."&p=".$curPage.$strUrl,0);
	}
	else
	{				
		if($photo = uploadImage("file", $config['product'][$type]['img_type_list'], _upload_product,$file_name)){
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['product'][$type]['thumb_width_list'], $config['product'][$type]['thumb_height_list'], _upload_product,$file_name,$config['product'][$type]['thumb_ratio_list']);	
		}
		
		$data['ngaytao'] = time();
		
		if($d->insert('product_list',$data))
		{
			$id_insert = $d->getLastInsertId();

			/* SEO */
			if($config['product'][$type]['seo_list'])
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
	            $file_name = digitalRandom(0,9,6);

	            for($i=0;$i<$fileCount;$i++) 
	            {
	            	if($_FILES['files']['name'][$i]!='')
					{
						if(!in_array(($_FILES['files']['name'][$i]),$arr_file_del,true))
						{
							if(move_uploaded_file($myFile["tmp_name"][$i], _upload_product."/".$file_name."_".$myFile["name"][$i]))
				            {
								$data1['photo'] = $file_name."_".$myFile["name"][$i];
								$data1['thumb'] = createThumb($data1['photo'], $config['product'][$type]['gallery_list'][$type]['thumb_width_photo'], $config['product'][$type]['gallery_list'][$type]['thumb_height_photo'], _upload_product, $file_name."_".$myFile["name"][$i],$config['product'][$type]['gallery_list'][$type]['thumb_ratio_photo']);	
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

			transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_list&type=".$type."&p=".$curPage.$strUrl);
		}
		else transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_list&type=".$type."&p=".$curPage.$strUrl,0);
	}
}

/* Delete list */
function delete_list()
{
	global $d, $strUrl, $curPage, $com, $type;

	$id = htmlspecialchars($_GET['id']);

	if(isset($_GET['id']))
	{
		/* Xóa SEO */
		$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_list',$type));

		/* Lấy dữ liệu */
		$row = $d->rawQueryOne("select id, photo, thumb from #_product_list where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			delete_file(_upload_product.$row['photo']);
			delete_file(_upload_product.$row['thumb']);
			$d->rawQuery("delete from #_product_list where id = ?",array($id));

			/* Xóa gallery */
			$row = $d->rawQuery("select id, photo, thumb from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man_list',$com));

			if(count($row))
			{
				foreach($row as $v)
				{
					delete_file(_upload_product.$v['photo']);
					delete_file(_upload_product.$v['thumb']);
				}

				$d->rawQuery("delete from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man_list',$com));
			}

			transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_list&type=".$type."&p=".$curPage.$strUrl);
		}
		else transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_list&type=".$type."&p=".$curPage.$strUrl,0);
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
			$row = $d->rawQueryOne("select id, photo, thumb from #_product_list where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_product.$row['photo']);
				delete_file(_upload_product.$row['thumb']);
				$d->rawQuery("delete from #_product_list where id = ?",array($id));

				/* Xóa gallery */
				$row = $d->rawQuery("select id, photo, thumb from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man_list',$com));

				if(count($row))
				{
					foreach($row as $v)
					{
						delete_file(_upload_product.$v['photo']);
						delete_file(_upload_product.$v['thumb']);
					}

					$d->rawQuery("delete from #_gallery where id_photo = ? and kind = ? and com = ?",array($id,'man_list',$com));
				}
			}
		}

		transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_list&type=".$type."&p=".$curPage.$strUrl);
	}
	else transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_list&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Get cat */
function get_cats()
{
	global $d, $strUrl, $curPage, $items, $paging, $type;
	
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
	$sql = "select * from #_product_cat where type = ? $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_product_cat where type = ? $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=product&act=man_cat".$strUrl."&type=".$type;
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Edit cat */
function get_cat()
{
	global $d, $strUrl, $curPage, $item, $type;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_cat&type=".$type."&p=".$curPage.$strUrl,0);
	
	$item = $d->rawQueryOne("select * from #_product_cat where id = ? and type = ?",array($id,$type));

	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=product&act=man_cat&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Save cat */
function save_cat()
{
	global $d, $strUrl, $curPage, $config, $com, $type;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_cat&type=".$type."&p=".$curPage.$strUrl,0);

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
	if($config['product'][$type]['seo_cat'])
	{
		$dataSeo = $_POST['dataSeo'];
		foreach($dataSeo as $column => $value) $dataSeo[$column] = htmlspecialchars($value);
	}

	if($id)
	{
		if($photo = uploadImage("file", $config['product'][$type]['img_type_cat'], _upload_product,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['product'][$type]['thumb_width_cat'], $config['product'][$type]['thumb_height_cat'], _upload_product,$file_name,$config['product'][$type]['thumb_ratio_cat']);			
			
			$row = $d->rawQueryOne("select id, photo, thumb from #_product_cat where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_product.$row['photo']);
				delete_file(_upload_product.$row['thumb']);
			}
		}

		$data['ngaysua'] = time();
		
		$d->where('id', $id);
		$d->where('type', $type);
		if($d->update('product_cat',$data))
		{
			/* SEO */
			if($config['product'][$type]['seo_cat'])
			{
				$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_cat',$type));

				$dataSeo['idmuc'] = $id;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_cat';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_cat&type=".$type."&p=".$curPage.$strUrl);
		}
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_cat&type=".$type."&p=".$curPage.$strUrl,0);
	}
	else
	{		
		if($photo = uploadImage("file", $config['product'][$type]['img_type_cat'], _upload_product,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['product'][$type]['thumb_width_cat'], $config['product'][$type]['thumb_height_cat'], _upload_product,$file_name,$config['product'][$type]['thumb_ratio_cat']);		
		}

		$data['ngaytao'] = time();
		
		if($d->insert('product_cat',$data))
		{
			$id_insert = $d->getLastInsertId();

			/* SEO */
			if($config['product'][$type]['seo_cat'])
			{
				$dataSeo['idmuc'] = $id_insert;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_cat';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}
			transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_cat&type=".$type."&p=".$curPage.$strUrl);
		}
		else transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_cat&type=".$type."&p=".$curPage.$strUrl,0);
	}
}

/* Delete cat */
function delete_cat()
{
	global $d, $strUrl, $curPage, $com, $type;

	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		/* Xóa SEO */
		$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_cat',$type));

		/* Lấy dữ liệu */
		$row = $d->rawQueryOne("select id, photo, thumb from #_product_cat where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			delete_file(_upload_product.$row['photo']);
			delete_file(_upload_product.$row['thumb']);
			$d->rawQuery("delete from #_product_cat where id = ?",array($id));

			transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_cat&type=".$type."&p=".$curPage.$strUrl);
		}
		else transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_cat&type=".$type."&p=".$curPage.$strUrl,0);
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
			$row = $d->rawQueryOne("select id, photo, thumb from #_product_cat where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_product.$row['photo']);
				delete_file(_upload_product.$row['thumb']);
				$d->rawQuery("delete from #_product_cat where id = ?",array($id));
			}
		}

		transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_cat&type=".$type."&p=".$curPage.$strUrl);
	}
	else transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_cat&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Get item */
function get_loais()
{
	global $d, $strUrl, $curPage, $items, $paging, $type;
	
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
	$sql = "select * from #_product_item where type = ? $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_product_item where type = ? $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=product&act=man_item".$strUrl."&type=".$type;
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Edit item */
function get_loai()
{
	global $d, $strUrl, $curPage, $item, $type;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_item&type=".$type."&p=".$curPage.$strUrl,0);
	
	$item = $d->rawQueryOne("select * from #_product_item where id = ? and type = ?",array($id,$type));

	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=product&act=man_item&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Save item */
function save_loai()
{
	global $d, $strUrl, $curPage, $config, $com, $type;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_item&type=".$type."&p=".$curPage.$strUrl,0);

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
	if($config['product'][$type]['seo_item'])
	{
		$dataSeo = $_POST['dataSeo'];
		foreach($dataSeo as $column => $value) $dataSeo[$column] = htmlspecialchars($value);
	}

	if($id)
	{
		if($photo = uploadImage("file", $config['product'][$type]['img_type_item'], _upload_product,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['product'][$type]['thumb_width_item'], $config['product'][$type]['thumb_height_item'], _upload_product,$file_name,$config['product'][$type]['thumb_ratio_item']);		
			
			$row = $d->rawQueryOne("select id, photo, thumb from #_product_item where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_product.$row['photo']);
				delete_file(_upload_product.$row['thumb']);
			}
		}

		$data['ngaysua'] = time();
		
		$d->where('id', $id);
		$d->where('type', $type);
		if($d->update('product_item',$data))
		{
			/* SEO */
			if($config['product'][$type]['seo_item'])
			{
				$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_item',$type));

				$dataSeo['idmuc'] = $id;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_item';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_item&type=".$type."&p=".$curPage.$strUrl);
		}
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_item&type=".$type."&p=".$curPage.$strUrl,0);
	}
	else
	{	
		if($photo = uploadImage("file", $config['product'][$type]['img_type_item'], _upload_product,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['product'][$type]['thumb_width_cat'], $config['product'][$type]['thumb_height_cat'], _upload_product,$file_name,$config['product'][$type]['thumb_ratio_cat']);		
		}	

		$data['ngaytao'] = time();
		
		if($d->insert('product_item',$data))
		{
			$id_insert = $d->getLastInsertId();

			/* SEO */
			if($config['product'][$type]['seo_item'])
			{
				$dataSeo['idmuc'] = $id_insert;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_item';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_item&type=".$type."&p=".$curPage.$strUrl);
		}
		else transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_item&type=".$type."&p=".$curPage.$strUrl,0);
	}
}

/* Delete item */
function delete_loai()
{
	global $d, $strUrl, $curPage, $com, $type;

	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		/* Xóa SEO */
		$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_item',$type));

		/* Lấy dữ liệu */
		$row = $d->rawQueryOne("select id, photo, thumb from #_product_item where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			delete_file(_upload_product.$row['photo']);
			delete_file(_upload_product.$row['thumb']);
			$d->rawQuery("delete from #_product_item where id = ?",array($id));

			transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_item&type=".$type."&p=".$curPage.$strUrl);
		}
		else transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_item&type=".$type."&p=".$curPage.$strUrl,0);
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
			$row = $d->rawQueryOne("select id, photo, thumb from #_product_item where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_product.$row['photo']);
				delete_file(_upload_product.$row['thumb']);
				$d->rawQuery("delete from #_product_item where id = ?",array($id));
			}
		}

		transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_item&type=".$type."&p=".$curPage.$strUrl);
	}
	else transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_item&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Get sub */
function get_subs()
{
	global $d, $strUrl, $curPage, $items, $paging, $type;

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
	$sql = "select * from #_product_sub where type = ? $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_product_sub where type = ? $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=product&act=man_sub".$strUrl."&type=".$type;
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Edit sub */
function get_sub()
{
	global $d, $strUrl, $curPage, $item, $type;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_sub&type=".$type."&p=".$curPage.$strUrl,0);

	$item = $d->rawQueryOne("select * from #_product_sub where id = ? and type = ?",array($id,$type));

	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=product&act=man_sub&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Save sub */
function save_sub()
{
	global $d, $strUrl, $curPage, $config, $com, $type;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_sub&type=".$type."&p=".$curPage.$strUrl,0);

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
	if($config['product'][$type]['seo_sub'])
	{
		$dataSeo = $_POST['dataSeo'];
		foreach($dataSeo as $column => $value) $dataSeo[$column] = htmlspecialchars($value);
	}

	if($id)
	{
		if($photo = uploadImage("file", $config['product'][$type]['img_type_sub'], _upload_product,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['product'][$type]['thumb_width_sub'], $config['product'][$type]['thumb_height_sub'], _upload_product,$file_name,$config['product'][$type]['thumb_ratio_sub']);			
			
			$row = $d->rawQueryOne("select id, photo, thumb from #_product_sub where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_product.$row['photo']);
				delete_file(_upload_product.$row['thumb']);
			}
		}

		$data['ngaysua'] = time();
		
		$d->where('id', $id);
		$d->where('type', $type);
		if($d->update('product_sub',$data))
		{
			/* SEO */
			if($config['product'][$type]['seo_sub'])
			{
				$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_sub',$type));

				$dataSeo['idmuc'] = $id;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_sub';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_sub&type=".$type."&p=".$curPage.$strUrl);
		}
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_sub&type=".$type."&p=".$curPage.$strUrl,0);
	}
	else
	{	
		if($photo = uploadImage("file", $config['product'][$type]['img_type_sub'], _upload_product,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['product'][$type]['thumb_width_sub'], $config['product'][$type]['thumb_height_sub'], _upload_product,$file_name,$config['product'][$type]['thumb_ratio_sub']);		
		}

		$data['ngaytao'] = time();
		
		if($d->insert('product_sub',$data))
		{
			$id_insert = $d->getLastInsertId();

			/* SEO */
			if($config['product'][$type]['seo_sub'])
			{
				$dataSeo['idmuc'] = $id_insert;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_sub';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_sub&type=".$type."&p=".$curPage.$strUrl);
		}
		else transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_sub&type=".$type."&p=".$curPage.$strUrl,0);
	}
}

/* Delete sub */
function delete_sub()
{
	global $d, $strUrl, $curPage, $com, $type;

	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		/* Xóa SEO */
		$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_sub',$type));

		/* Lấy dữ liệu */
		$row = $d->rawQueryOne("select id, photo, thumb from #_product_sub where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			delete_file(_upload_product.$row['photo']);
			delete_file(_upload_product.$row['thumb']);
			$d->rawQuery("delete from #_product_sub where id = ?",array($id));

			transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_sub&type=".$type."&p=".$curPage.$strUrl);
		}
		else transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_sub&type=".$type."&p=".$curPage.$strUrl,0);
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
			$row = $d->rawQueryOne("select id, photo, thumb from #_product_sub where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_product.$row['photo']);
				delete_file(_upload_product.$row['thumb']);
				$d->rawQuery("delete from #_product_sub where id = ?",array($id));
			}
		}

		transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_sub&type=".$type."&p=".$curPage.$strUrl);
	}
	else transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_sub&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Get brand */
function get_brands()
{
	global $d, $strUrl, $curPage, $items, $paging, $type;

	$where = "";

	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and (tenvi LIKE '%$keyword%' or tenen LIKE '%$keyword%')";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_product_brand where type = ? $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_product_brand where type = ? $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=product&act=man_brand&type=".$type;
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Edit brand */
function get_brand()
{
	global $d, $strUrl, $curPage, $item, $gallery, $type, $com;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_brand&type=".$type."&p=".$curPage.$strUrl,0);

	$item = $d->rawQueryOne("select * from #_product_brand where id = ? and type = ?",array($id,$type));
	
	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=product&act=man_brand&type=".$type."&p=".$curPage.$strUrl,0);
}

/* Save brand */
function save_brand()
{
	global $d, $curPage, $config, $com, $type;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_brand&type=".$type."&p=".$curPage,0);

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
	if($config['product'][$type]['seo_brand'])
	{
		$dataSeo = $_POST['dataSeo'];
		foreach($dataSeo as $column => $value) $dataSeo[$column] = htmlspecialchars($value);
	}

	if($id)
	{
		$file_name = upload_name($_FILES['file']["name"]);			
		if($photo = uploadImage("file", $config['product'][$type]['img_type_brand'], _upload_product,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['product'][$type]['thumb_width_brand'], $config['product'][$type]['thumb_height_brand'], _upload_product,$file_name,$config['product'][$type]['thumb_ratio_brand']);		
			
			$row = $d->rawQueryOne("select id, photo, thumb from #_product_brand where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_product.$row['photo']);
				delete_file(_upload_product.$row['thumb']);
			}
		}

		$data['ngaysua'] = time();
		
		$d->where('id', $id);
		$d->where('type', $type);
		if($d->update('product_brand',$data))
		{
			/* SEO */
			if($config['product'][$type]['seo_brand'])
			{
				$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_brand',$type));

				$dataSeo['idmuc'] = $id;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_brand';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_brand&type=".$type."&p=".$curPage);
		}
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_brand&type=".$type."&p=".$curPage,0);
	}
	else
	{				
		if($photo = uploadImage("file", $config['product'][$type]['img_type_brand'], _upload_product,$file_name))
		{
			$data['photo'] = $photo;
			$data['thumb'] = createThumb($data['photo'], $config['product'][$type]['thumb_width_brand'], $config['product'][$type]['thumb_height_brand'], _upload_product,$file_name,$config['product'][$type]['thumb_ratio_brand']);				
		}
		
		$data['ngaytao'] = time();
		
		if($d->insert('product_brand',$data))
		{
			$id_insert = $d->getLastInsertId();

			/* SEO */
			if($config['product'][$type]['seo_brand'])
			{
				$dataSeo['idmuc'] = $id_insert;
				$dataSeo['com'] = $com;
				$dataSeo['act'] = 'man_brand';
				$dataSeo['type'] = $type;
				$d->insert('seo',$dataSeo);
			}

			transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_brand&type=".$type."&p=".$curPage);
		}
		else transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_brand&type=".$type."&p=".$curPage,0);
	}
}

/* Delete brand */
function delete_brand()
{
	global $d, $strUrl, $curPage, $com, $type;

	$id = htmlspecialchars($_GET['id']);

	if(isset($_GET['id']))
	{
		/* Xóa SEO */
		$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_brand',$type));

		/* Lấy dữ liệu */
		$row = $d->rawQueryOne("select id, photo, thumb from #_product_brand where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			delete_file(_upload_product.$row['photo']);
			delete_file(_upload_product.$row['thumb']);
			$d->rawQuery("delete from #_product_brand where id = ?",array($id));

			transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_brand&type=".$type."&p=".$curPage.$strUrl);
		}
		else transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_brand&type=".$type."&p=".$curPage.$strUrl,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);

			/* Xóa SEO */
			$d->rawQuery("delete from #_seo where idmuc = ? and com = ? and act = ? and type = ?",array($id,$com,'man_brand',$type));

			/* Lấy dữ liệu */
			$row = $d->rawQueryOne("select id, photo, thumb from #_product_brand where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_product.$row['photo']);
				delete_file(_upload_product.$row['thumb']);
				$d->rawQuery("delete from #_product_brand where id = ?",array($id));
			}
		}

		transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_brand&type=".$type."&p=".$curPage.$strUrl);
	}
	else transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_brand&type=".$type."&p=".$curPage.$strUrl,0);
}
?>