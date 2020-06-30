<?php
	if(!defined('SOURCES')) die("Error");

	/* Kiểm tra active static */
	$arrCheck = array();
	foreach($config['static'] as $k => $v) $arrCheck[] = $k;
	if(!count($arrCheck) || !in_array($type,$arrCheck)) $func->transfer("Trang không tồn tại", "index.php", false);

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
		global $d, $config, $func, $com, $type;
		
		if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=static&act=capnhat&type=".$type, false);

		$static = $d->rawQueryOne("select * from #_static where type = ?",array($type));

		/* Post dữ liệu */
		$data = $_POST['data'];
		foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
		$data['tenkhongdauvi'] = $func->changeTitle($data['tenvi']);
		$data['tenkhongdauen'] = $func->changeTitle($data['tenen']);
		$data['hienthi'] = ($data['hienthi']) ? 1 : 0;
		$data['type'] = $type;

		/* Post Seo */
		if($config['static'][$type]['seo'])
		{
			$dataSeo = $_POST['dataSeo'];
			foreach($dataSeo as $column => $value) $dataSeo[$column] = htmlspecialchars($value);
		}

		$file_name = $func->uploadName($_FILES['file']["name"]);
		if($photo = $func->uploadImage("file", $config['static'][$type]['img_type'],UPLOAD_NEWS,$file_name))
		{
			$data['photo'] = $photo;
			$row = $d->rawQueryOne("select id, photo from #_static where type = ?",array($type));
			if($row['id']) $func->delete_file(UPLOAD_NEWS.$row['photo']);
		}

		$file_name = $func->uploadName($_FILES['file-taptin']["name"]);
		if($taptin = $func->uploadImage("file-taptin", $config['static'][$type]['file_type'],UPLOAD_FILE,$file_name))
		{
			$data['taptin'] = $taptin;			
			
			$row = $d->rawQueryOne("select id, taptin from #_static where type = ?",array($type));

			if($row['id']) $func->delete_file(UPLOAD_FILE.$row['taptin']);
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

				$func->transfer("Cập nhật dữ liệu thành công", "index.php?com=static&act=capnhat&type=".$type);
			}
			else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=static&act=capnhat&type=".$type, false);
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

					$func->transfer("Lưu dữ liệu thành công", "index.php?com=static&act=capnhat&type=".$type);
				}
				else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=static&act=capnhat&type=".$type, false);
			}
			$func->transfer("Dữ liệu rỗng", "index.php?com=static&act=capnhat&type=".$type, false);
		}
	}
?>