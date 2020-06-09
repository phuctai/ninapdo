<?php
	session_start();
	@define('LIBRARIES','./libraries/');
	
	include_once LIBRARIES."config.php";
    require_once LIBRARIES.'autoload.php';
    new autoload();
    $injection = new AntiSQLInjection();
    $d = new PDODb($config['database']);
    $func = new functions($d);
	
	/* Kiểm tra có đăng nhập chưa */
	if($func->check_login()==false && $act!="login")
	{
		$func->redirect("index.php?com=user&act=login");
	}

	/* Kiểm tra active export excel */
	if(!$config['order']['excel']) $func->transfer("Trang không tồn tại", "index.php",0);
	
	/* Setting */
	$setting = $d->rawQueryOne("select * from table_setting");
	
	/* Thông tin đơn hàng */
	$iddh = htmlspecialchars($_GET['id']);
	if(!$iddh) $func->transfer("Dữ liệu không có thực", "index.php?com=order&act=man",0);
	$donhang = $d->rawQueryOne("select * from #_order where id = ?",array($iddh));

	/* Gán giá trị đơn hàng */
	$time = time();
	$madonhang = $donhang['madonhang'];
	$tinhtrang = $donhang['tinhtrang'];
	$tamtinh = number_format($donhang['tamtinh'], 0, ',', '.')."đ";
	$tonggia = number_format($donhang['tonggia'], 0, ',', '.')."đ";
	$phiship = $donhang['phiship'];
	if($phiship) $phiship = number_format($phiship, 0, ',', '.')."đ";
	else $phiship = "Không";
	$phicoupon = $donhang['phicoupon'];
	$loaicoupon = $donhang['loaicoupon'];
	if($donhang['loaicoupon']==1) $phicoupon = "-".number_format($phicoupon, 0, ',', '.')."%";
	else if($donhang['loaicoupon']==2) $phicoupon = "-".number_format($phicoupon, 0, ',', '.')."đ";
	else $phicoupon = "Không";

	/* Trang thái */
	$trangthai = $d->rawQueryOne("select trangthai from #_status where id = ?",array($tinhtrang));
	
	/* PHPExcel */
	include LIBRARIES.'PHPExcel.php';
	include LIBRARIES.'PHPExcel/Writer/Excel5.php';
	$PHPExcel = new PHPExcel();

	/* Set properties */
	$PHPExcel->getProperties()->setCreator($setting['tenvi']);
	$PHPExcel->getProperties()->setLastModifiedBy($setting['tenvi']);
	$PHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
	$PHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
	$PHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

	/* Add some data */
	$PHPExcel->setActiveSheetIndex(0);
	$PHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
	$PHPExcel->setActiveSheetIndex(0)->mergeCells('A2:F2');
	$PHPExcel->setActiveSheetIndex(0)->mergeCells('A3:F3');
	$PHPExcel->setActiveSheetIndex(0)->mergeCells('A4:F4');
	$PHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6');
	$PHPExcel->setActiveSheetIndex(0)->mergeCells('A7:C7');
	$PHPExcel->setActiveSheetIndex(0)->mergeCells('A8:C8');
	$PHPExcel->setActiveSheetIndex(0)->mergeCells('D6:F6');
	$PHPExcel->setActiveSheetIndex(0)->mergeCells('D7:F7');
	$PHPExcel->setActiveSheetIndex(0)->mergeCells('D8:F8');

	/* Thông tin chung */
	$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
	$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$setting['tenvi']);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('A2','Hotline: '.$setting['hotline']);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('A3','Email: '.$setting['email']);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('A4','Địa chỉ: '.$setting['diachi']);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('A6','Họ tên: '.$donhang['hoten']);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('A7','Điện thoại: '.$donhang['dienthoai']);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('A8','Địa chỉ: '.$donhang['diachi']);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('D6','Mã đơn hàng: '.$madonhang);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('D7','Ngày đặt: '.date('H:i A d-m-Y',$donhang['ngaytao']));
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('D8','Tình trạng: '.$trangthai['trangthai']);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('A10','STT');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('B10','Sản phẩm');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('C10','Số lượng');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('D10','Giá');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('E10','Giá mới');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('F10','Tạm tính');

	/* Style */
	$PHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(
		array(
			'font'=>array(
				'color'=>array(
					'rgb'=>'000000'
				),
				'name'=>'Arial',
				'bold'=>true,
				'italic'=>false,
				'size' => 14
			),
			'alignment'=>array(
				'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'=>true
			)
		)
	);
	$PHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray(
		array(
			'font'=>array(
				'size'=>11
			),
			'alignment'=>array(
				'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'=>true
			)
		)
	);
	$PHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray(
		array(
			'font'=>array(
				'size'=>11
			),
			'alignment'=>array(
				'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'=>true
			)
		)
	);
	$PHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray(
		array(
			'font'=>array(
				'size'=>11
			),
			'alignment'=>array(
				'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'=>true
			)
		)
	);
	$PHPExcel->getActiveSheet()->getStyle('A10:F10')->applyFromArray(
		array(
			'font'=>array(
				'color'=>array('rgb'=>'000000'),
				'name'=>'Calibri',
				'bold'=>true,
				'italic'=>false,
				'size'=> 10
			),
			'alignment'=>array(
				'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'=>true)
		)
	);
	$PHPExcel->getActiveSheet()->getStyle('A10:F10')->getBorders()->getAllBorders()->setBorderStyle(
		PHPExcel_Style_Border::BORDER_THIN
	);

	/* Thông tin giỏ hàng chi tiết */
	$vitri = 11;
	$items = $d->rawQuery("select * from #_order_detail where id_order = ?",array($iddh));

	for($i=0;$i<count($items);$i++) 
	{
		$gia = number_format($items[$i]['gia'], 0, ',', '.')."đ";
		$giamoi = number_format($items[$i]['giamoi'], 0, ',', '.')."đ";
		$thanhtien = 0;
		if($items[$i]['giamoi']) $thanhtien = number_format($items[$i]['giamoi']*$items[$i]['soluong'], 0, ',', '.')."đ";
		else $thanhtien = number_format($items[$i]['gia']*$items[$i]['soluong'], 0, ',', '.')."đ";

		$PHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$vitri, $i+1)
		->setCellValue('B'.$vitri, $items[$i]['ten'])
		->setCellValue('C'.$vitri, $items[$i]['soluong'])
		->setCellValue('D'.$vitri, $gia)
		->setCellValue('E'.$vitri, $giamoi)
		->setCellValue('F'.$vitri, $thanhtien);

		$PHPExcel->getActiveSheet()->getStyle('A'.$vitri.':F'.$vitri)->applyFromArray(
			array(
				'alignment'=>array(
					'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'=>true
				)
			)
		);
		$PHPExcel->getActiveSheet()->getStyle('A'.$vitri.':F'.$vitri)->getBorders()->getAllBorders()->setBorderStyle(
			PHPExcel_Style_Border::BORDER_THIN
		);
		$vitri++;
	}

	/* Tính thành tiền */
	$vitri++;

	if($config['order']['ship'] || $config['order']['coupon'])
	{
		/* Tạm tính */
		$PHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$vitri.':E'.$vitri);
		$PHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$vitri,'Tạm tính');
		$PHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$vitri,$tamtinh);
		$PHPExcel->getActiveSheet()->getStyle('A'.$vitri.':F'.$vitri)->applyFromArray(
			array(
				'font'=>array(
					'color'=>array('rgb'=>'000000'),
					'name'=>'Calibri',
					'bold'=>true,
					'italic'=>false,
					'size'=>10
				),
				'alignment'=>array(
					'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'=>true
				)
			)
		);
		$vitri++;
	}

	if($config['order']['ship'])
	{
		/* Phí vận chuyển */
		$PHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$vitri.':E'.$vitri);
		$PHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$vitri,'Phí vận chuyển');
		$PHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$vitri,$phiship);
		$PHPExcel->getActiveSheet()->getStyle('A'.$vitri.':F'.$vitri)->applyFromArray(
			array(
				'font'=>array(
					'color'=>array('rgb'=>'000000'),
					'name'=>'Calibri',
					'bold'=>true,
					'italic'=>false,
					'size'=>10
				),
				'alignment'=>array(
					'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'=>true
				)
			)
		);
		$vitri++;
	}

	if($config['order']['coupon'])
	{
		/* Mã ưu đãi */
		$PHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$vitri.':E'.$vitri);
		$PHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$vitri,'Ưu đãi');
		$PHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$vitri,$phicoupon);
		$PHPExcel->getActiveSheet()->getStyle('A'.$vitri.':F'.$vitri)->applyFromArray(
			array(
				'font'=>array(
					'color'=>array('rgb'=>'000000'),
					'name'=>'Calibri',
					'bold'=>true,
					'italic'=>false,
					'size'=>10
				),
				'alignment'=>array(
					'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'=>true
				)
			)
		);
		$vitri++;
	}

	/* Tổng tiền */
	$PHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$vitri.':E'.$vitri);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$vitri,'Tổng giá trị đơn hàng');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$vitri,$tonggia);
	$PHPExcel->getActiveSheet()->getStyle('A'.$vitri.':F'.$vitri)->applyFromArray(
		array(
			'font'=>array(
				'color'=>array('rgb'=>'000000'),
				'name'=>'Calibri',
				'bold'=>true,
				'italic'=>false,
				'size'=>10
			),
			'alignment'=>array(
				'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
				'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'=>true
			)
		)
	);
	$vitri++;

	/* Đổi tiêu đề */
	$PHPExcel->getActiveSheet()->setTitle('ĐƠN HÀNG');

	/* Lưu file */
    header( 'Content-Type: application/vnd.ms-excel' );
    header( 'Content-Disposition: attachment;filename="order_'.$madonhang.'_'.$time.'_'.date('d_m_Y').'.xls"' );
    header( 'Cache-Control: max-age=0' );

    $objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
    $objWriter->save( 'php://output' );	
?>