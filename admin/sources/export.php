<?php	
	if(!defined('SOURCES')) die("Error");

	$act = htmlspecialchars($_REQUEST['act']);
	$type = htmlspecialchars($_REQUEST['type']);

	/* Kiểm tra active export */
	$arrCheck = array();
	foreach($config['product'] as $k => $v) if($v['export']) $arrCheck[] = $k;
	if(!count($arrCheck) || !in_array($type,$arrCheck)) $func->transfer("Trang không tồn tại", "index.php", false);

	switch($act)
	{
		case "man":
			$template = "export/man/items";
			break;

		case "exportExcel":
			exportExcel();
			break;

		default:
			$template = "404";
	}

	function exportExcel()
	{
		global $d, $func, $type;

		if(isset($_POST['exportExcel']))
		{
			/** PHPExcel */
			include LIBRARIES.'PHPExcel.php';

			/** PHPExcel_Writer_Excel */
			include LIBRARIES.'PHPExcel/Writer/Excel5.php';
			
			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();
			
			// Set properties
			$objPHPExcel->getProperties()->setCreator("Diệp Phúc Tài");
			$objPHPExcel->getProperties()->setLastModifiedBy("Diệp Phúc Tài");
			$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
			$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
			$objPHPExcel->getProperties()->setDescription("Document for Office 2007 XLSX, generated using PHP classes.");

			// Set AutoFilter
			$objPHPExcel->getActiveSheet()->setAutoFilter('A1:B1');

			/* Identify */
			$alphas = range('A','Z');
			$array_file = array(
				'stt'=>'STT',
				'id_list'=>'Danh Mục Cấp 1',
				'id_cat'=>'Danh mục 2',
				'masp'=>'Mã sản phẩm',
				'tenvi'=>'Tên Sản phẩm',
				'gia'=>'Giá bán',
				'giamoi'=>'Giá mới',
				'giakm'=>'Chiết khấu',
				'motavi'=>'Mô tả',
				'noidungvi'=>'Nội dung',
				'photo'=>'Hình đại diện'
			);

			$i=0;
			foreach($array_file as $k=>$v)
			{
				if($k=='stt')
				{
					$objPHPExcel->getActiveSheet()->getColumnDimension( $alphas[$i] )->setWidth(5);
				}
				else if($k=='id_list' || $k=='id_cat')
				{
					$objPHPExcel->getActiveSheet()->getColumnDimension( $alphas[$i] )->setWidth(20);
				}
				else if($k=='masp')
				{
					$objPHPExcel->getActiveSheet()->getColumnDimension( $alphas[$i] )->setWidth(15);
				}
				else if($k=='tenvi')
				{
					$objPHPExcel->getActiveSheet()->getColumnDimension( $alphas[$i] )->setWidth(40);
				}
				else if($k=='gia' || $k=='giamoi' || $k=='giakm')
				{
					$objPHPExcel->getActiveSheet()->getColumnDimension( $alphas[$i] )->setWidth(10);
				}
				else if($k=='motavi' || $k=='noidungvi' || $k=='photo')
				{
					$objPHPExcel->getActiveSheet()->getColumnDimension( $alphas[$i] )->setWidth(35);
				}
				
				$objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( $alphas[$i].'1', $v );
				$objPHPExcel->getActiveSheet()->getStyle( $alphas[$i].'1' )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ), 'name' => 'Calibri', 'bold' => true, 'italic' => false, 'size' => 10 ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ),'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'4f81bd'))));
				$i++; 
			}

			/* Lấy dữ liệu */
			$whereCategory = "";
			$idlist = htmlspecialchars($_POST['id_list']);
			$idcat = htmlspecialchars($_POST['id_cat']);
			$iditem = htmlspecialchars($_POST['id_item']);
			$idsub = htmlspecialchars($_POST['id_sub']);
			if($idlist) $whereCategory .= " and id_list=$idlist";
			if($idcat) $whereCategory .= " and id_cat=$idcat";
			if($iditem) $whereCategory .= " and id_item=$iditem";
			if($idsub) $whereCategory .= " and id_sub=$idsub";

			$product = $d->rawQuery("SELECT * FROM table_product WHERE type = ? $whereCategory ORDER BY stt,id DESC",array($type));

			$vitri=2;
			for($i=0;$i<count($product);$i++)
			{
				$j=0;
				foreach($array_file as $k=>$v)
				{
					if($k=='id_list')
					{
						$tenlist = $d->rawQueryOne("SELECT tenvi FROM table_product_list WHERE id = ?",array($product[$i][$k]));
						$datacell = $tenlist['tenvi'];
					}
					else if($k=='id_cat')
					{
						$tencat = $d->rawQueryOne("SELECT tenvi FROM table_product_cat WHERE id = ?",array($product[$i][$k]));
						$datacell = $tencat['tenvi'];
					}
					else
					{
						$datacell = $product[$i][$k];
					}

					if($k=='masp')
					{
						$objPHPExcel->getActiveSheet()->setCellValueExplicit($alphas[$j].$vitri, $datacell,  PHPExcel_Cell_DataType::TYPE_STRING);
					}
					else
					{
						$objPHPExcel->setActiveSheetIndex( 0 )->setCellValue($alphas[$j].$vitri,$datacell);
					}
					$j++;
				}
				$vitri++;
			}

			$vitri=2;
			for($i=0;$i<count($product);$i++)
			{
				$j=0;
				foreach($array_file as $k=>$v)
				{
					$objPHPExcel->getActiveSheet()->getStyle( $alphas[$j].$vitri )->applyFromArray(
						array( 
							'font' => array( 
								'color' => array( 'rgb' => '000000' ), 
								'name' => 'Calibri', 
								'bold' => false, 
								'italic' => false, 
								'size' => 10 
							), 
							'alignment' => array( 
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 
								'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 
								'wrap' => true 
							)
						)
					);
					$j++;
				}
				$vitri++;
			}

			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle('DANH SÁCH SẢN PHẨM');

			// Redirect output to a client’s web browser (Excel5)
			$time = time();
			header( 'Content-Type: application/vnd.ms-excel' );
			header( 'Content-Disposition: attachment;filename="danhsachsanpham_'.$time.'_'.date('d_m_Y').'.xls"' );
			header( 'Cache-Control: max-age=0' );

			$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
			$objWriter->save( 'php://output' );
		}
		else
		{
			$func->transfer("Dữ liệu rỗng", "index.php?com=export&act=man&type=".$type, false);
		}
	}
?>