<?php	
if(!defined('SOURCES')) die("Error");

$act = htmlspecialchars($_REQUEST['act']);
$type = htmlspecialchars($_REQUEST['type']);
$curPage = (isset($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;

/* Kiểm tra active import */
$arrCheck = array();
foreach($config['product'] as $k => $v) if($v['import']) $arrCheck[] = $k;
if(!count($arrCheck) || !in_array($type,$arrCheck)) transfer("Trang không tồn tại", "index.php",0);

switch($act)
{
	case "man":
		getImages();
		$template = "import/man/items";
		break;

	case "uploadImages":
		uploadImages();
		break;

	case "editImages":
		editImages();
		$template = "import/man/item_edit";
		break;

	case "saveImages":
		saveImages();
		break;

	case "deleteImages":
		deleteImages();
		break;

	case "uploadExcel":
		uploadExcel();
		break;

	default:
		$template = "404";
}

/* Get image */
function getImages()
{
	global $d, $type, $curPage, $items, $paging;

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_excel where type = ? order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_excel where type = ? order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=import&act=man&type=".$type;
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Edit image */
function editImages()
{
	global $d, $item, $type, $curPage;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=import&act=man&type=".$type."&p=".$curPage,0);

	$item = $d->rawQueryOne("select * from #_excel where id = ? and type = ?",array($id,$type));

	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=import&act=man&type=".$type."&p=".$curPage,0);
}

/* Save image */
function saveImages()
{
	global $d, $item, $type, $curPage, $config;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=import&act=man&type=".$type."&p=".$curPage,0);

	$id = htmlspecialchars($_POST['id']);

	if($id)
	{
		$file_name = upload_name($_FILES['file']["name"]);
		if($photo = uploadImage("file", $config['import']['img_type'], UPLOAD_EXCEL, $file_name))
		{
			$data['photo'] = $photo;

			$row = $d->rawQueryOne("select id, photo from #_excel where id = ? and type = ?",array($id,$type));

			if($row['id']) delete_file(UPLOAD_EXCEL.$row['photo']);
			
			$d->where('id', $id);
			$d->where('type', $type);
			if($d->update('excel',$data)) transfer("Cập nhật dữ liệu thành công", "index.php?com=import&act=man&type=".$type."&p=".$curPage);
			else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=import&act=man&type=".$type."&p=".$curPage,0);
		}
		else
		{
			transfer("Không nhận được hình ảnh mới", "index.php?com=import&act=editImages&id=".$id."&type=".$type."&p=".$curPage,0);
		}
	}
	else
	{
		transfer("Không nhận được dữ liệu", "index.php?com=import&act=man&type=".$type."&p=".$curPage,0);
	}
}

/* Upload image */
function uploadImages()
{
	global $d, $type, $config;

	if(isset($_POST['uploadImg']) && isset($_FILES['files']) && $_FILES['files']["name"][0]!='') 
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
					$random = digitalRandom(0,9,6);
					$file_name = explode(".",$myFile["name"][$i]);

					if($_POST['ten-filer'][$dem]) $photo = $random."_".$_POST['ten-filer'][$dem].".".$file_name[1];
					else $photo = $random."_".$file_name[0].".".$file_name[1];

					if(move_uploaded_file($myFile["tmp_name"][$i], UPLOAD_EXCEL."/".$photo))
		            {
		            	$data['photo'] = $photo;
						$data['stt'] = (int)$_POST['stt-filer'][$dem];
						$data['type'] = $type;
						$d->insert('excel',$data);
		            }
		            $dem++;
				}
            }
        }
        transfer("Lưu hình ảnh thành công", "index.php?com=import&act=man&type=".$type);
    }
    else
    {
    	transfer("Dữ liệu rỗng", "index.php?com=import&act=man&type=".$type,0);
    }
}

/* Delete image */
function deleteImages()
{
	global $d, $type, $curPage;

	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		$row = $d->rawQueryOne("select id, photo from #_excel where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			delete_file(UPLOAD_EXCEL.$row['photo']);
			$d->rawQuery("delete from #_excel where id = ? and type = ?",array($id,$type));
			transfer("Xóa dữ liệu thành công", "index.php?com=import&act=man&type=".$type."&p=".$curPage);
		}
		else transfer("Xóa dữ liệu bị lỗi", "index.php?com=import&act=man&type=".$type."&p=".$curPage,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);
			$row = $d->rawQueryOne("select id, photo from #_excel where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(UPLOAD_EXCEL.$row['photo']);
				$d->rawQuery("delete from #_excel where id = ? and type = ?",array($id,$type));
			}
		}
		
		transfer("Xóa dữ liệu thành công", "index.php?com=import&act=man&type=".$type."&p=".$curPage);
	} 
	else transfer("Không nhận được dữ liệu", "index.php?com=import&act=man&type=".$type."&p=".$curPage,0);
}

/* Transfer image */
function transferphoto($photo)
{
	global $d;

	$oldpath = UPLOAD_EXCEL.$photo;
	$newpath = UPLOAD_PRODUCT.$photo;

	if(rename($oldpath,$newpath)) $d->rawQuery("delete from #_excel where photo = ?",array($photo));
}

/* Upload excel */
function uploadExcel()
{
	global $d, $type, $config;

	if(isset($_POST['importExcel']))
	{
		$file_type = $_FILES['file-excel']['type'];

		if($file_type == "application/vnd.ms-excel" || $file_type == "application/x-ms-excel")
		{
			$mess = '';
			$filename = changeTitle($_FILES["file-excel"]["name"]);
			move_uploaded_file($_FILES["file-excel"]["tmp_name"],$filename);			
			
			require LIBRARIES.'PHPExcel.php';
			require_once LIBRARIES.'PHPExcel/IOFactory.php';

			$objPHPExcel = PHPExcel_IOFactory::load($filename);

			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) 
			{
				$worksheetTitle = $worksheet->getTitle();
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

				$nrColumns = ord($highestColumn) - 64;

				for($row=2;$row<=$highestRow;++$row)
				{
					$cell = $worksheet->getCellByColumnAndRow(3, $row);
					$masp = $cell->getValue();

					if($masp!="")
					{
						$cell = $worksheet->getCellByColumnAndRow(0, $row);
						$stt = $cell->getValue();

						$cell = $worksheet->getCellByColumnAndRow(1, $row);
						$cap1 = $cell->getValue();

						$cell = $worksheet->getCellByColumnAndRow(2, $row);
						$cap2 = $cell->getValue();

						$cell = $worksheet->getCellByColumnAndRow(3, $row);
						$masp = $cell->getValue();

						$cell = $worksheet->getCellByColumnAndRow(4, $row);
						$tenvi = $cell->getValue();

						$cell = $worksheet->getCellByColumnAndRow(5, $row);
						$gia = $cell->getValue();

						$cell = $worksheet->getCellByColumnAndRow(6, $row);
						$giamoi = $cell->getValue();

						$cell = $worksheet->getCellByColumnAndRow(7, $row);
						$giakm = $cell->getValue();

						$cell = $worksheet->getCellByColumnAndRow(8, $row);
						$motavi = $cell->getValue();
						
						$cell = $worksheet->getCellByColumnAndRow(9, $row);
						$noidungvi = $cell->getValue();

						$cell = $worksheet->getCellByColumnAndRow(10, $row);
						$photo = $cell->getValue();

						/* Lấy sản phẩm theo mã */
						$proimport = $d->rawQueryOne("SELECT id, photo FROM table_product WHERE masp = ?",array($masp));

						/* Lấy danh mục cấp 1 */
						$tkdcap1 = changeTitle($cap1);
						$idlist = $d->rawQueryOne("SELECT id FROM table_product_list WHERE tenkhongdau = ?",array($tkdcap1));

						/* Lấy danh mục cấp 2 */
						$tkdcap2 = changeTitle($cap2);
						$idcat = $d->rawQueryOne("SELECT id FROM table_product_cat WHERE tenkhongdau = ?",array($tkdcap2));

						/* Gán dữ liệu */
						$data = array();
						$data['stt'] = (int)$stt;
						$data['id_list'] = (int)$idlist['id'];
						$data['id_cat'] = (int)$idcat['id'];
						$data['masp'] = htmlspecialchars($masp);
						$data['tenvi'] = htmlspecialchars($tenvi);
						$data['tenkhongdau'] = changeTitle($data['tenvi']);
						$data['gia'] = $gia;
						$data['giamoi'] = $giamoi;
						$data['giakm'] = $giakm;
						$data['motavi'] = htmlspecialchars($motavi);
						$data['noidungvi'] = htmlspecialchars($noidungvi);

						if($config['import']['images'])
						{
							if($photo!="")
							{
								if(filter_var($photo,FILTER_VALIDATE_URL))
								{ 
									/* Get Images Online */
									$random = digitalRandom(0,9,12);
									$ext = substr(basename($photo),strrpos(basename($photo),".")+1);
									$tmp = explode('?',$ext);
									$ext = $tmp[0];
									$name = $random."_online_img.".$ext;

									$pathOnlineImg = $photo;
									$pathSaveImg = UPLOAD_EXCEL.$name;
									$ch = curl_init($pathOnlineImg);
									$fp = fopen($pathSaveImg, 'wb');
									curl_setopt($ch, CURLOPT_FILE, $fp);
									curl_setopt($ch, CURLOPT_HEADER, 0);
									curl_exec($ch);
									curl_close($ch);
									fclose($fp);

									$data['photo'] = $name;
									$photo = $name;
								}
								else
								{
									/* Get Images Local */
									$data['photo'] = $photo;
								}
							}
							else $data['photo'] = '';
						}
						else
						{
							$data['photo'] = '';
						}
						$data['type'] = $type;
						$data['hienthi'] = 1;

						if($proimport['id'])
						{
							$d->where('type', $type);
							$d->where('masp', $masp);
							if($d->update('product',$data))
							{
								if($config['import']['images'])
								{
									/* Cập nhật hình */
									/* Nếu tồn tại hình mới thì xóa hình cũ và cập nhật hình mới */
									$oldphoto = $proimport['photo'];
									if(($photo!="") && ($photo!=$oldphoto))
									{
										/* Xóa hình cũ */
										$oldpathphoto = UPLOAD_PRODUCT.$oldphoto;
										if(file_exists($oldpathphoto)) unlink($oldpathphoto);

										/* Chuyển hình mới từ thư mục excel sang thư mục cần chuyển */
										transferphoto($photo);
									}
								}
							}
							else
							{
								$mess.='Lỗi tại dòng: '.$row."<br>";
							}
						}
						else
						{
							if($d->insert('product',$data))
							{
								if($config['import']['images'])
								{
									/* Chuyển hình trong thư mục excel sang thư mục cần chuyển */
									if($photo!="") transferphoto($photo);
								}
							}
							else
							{
								$mess.='Lỗi tại dòng: '.$row."<br>";
							}
						}
					}
				}
			}

			/* Xóa tập tin sau khi đã import xong */
			unlink($filename);

			/* Kiểm tra kết quả import */
			if($mess == '')
			{
				$mess = "Import danh sách thành công";
				transfer($mess, "index.php?com=import&act=man&type=".$type);
			}
			else
			{
				transfer($mess, "index.php?com=import&act=man&type=".$type,0);
			}
		}
		else
		{
			$mess = "Không hỗ trợ kiểu tập tin này";
			transfer($mess, "index.php?com=import&act=man&type=".$type,0);
		}
	}
	else
	{
		transfer("Dữ liệu rỗng", "index.php?com=import&act=man&type=".$type,0);
	}
}
?>