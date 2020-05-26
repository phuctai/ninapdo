<?php
	session_start();
	@define('_LIB','./libraries/');
	
	include_once _LIB."config.php";
	include_once _LIB."PDODb.php";
    $d = new PDODb($config['database']);
    include_once _LIB."functions.php";
	
	/* Kiểm tra có đăng nhập chưa */
	if(check_login()==false && $act!="login")
	{
		redirect("index.php?com=user&act=login");
	}

	/* Kiểm tra active export excel */
	if(!$config['order']['excelall']) transfer("Trang không tồn tại", "index.php",0);
	
	/* Setting */
	$setting = $d->rawQueryOne("select * from table_setting");
	
	/* Thông tin đơn hàng */
	$time = time();
	$sql = "select * from #_order where id<>0";

	$listid = htmlspecialchars($_REQUEST['listid']);
	$tinhtrang = htmlspecialchars($_REQUEST['tinhtrang']);
	$httt = htmlspecialchars($_REQUEST['httt']);
	$ngaydat = htmlspecialchars($_REQUEST['ngaydat']);
	$khoanggia = htmlspecialchars($_REQUEST['khoanggia']);
	$city = htmlspecialchars($_REQUEST['city']);
	$district = htmlspecialchars($_REQUEST['district']);
	$wards = htmlspecialchars($_REQUEST['wards']);

	if($listid) $sql .= " and id IN ($listid)";
	if($tinhtrang) $sql .= " and tinhtrang=$tinhtrang";
	if($httt) $sql .= " and httt=$httt";
	if($ngaydat)
	{
		$ngaydat = explode("-",$ngaydat);
		$ngaytu = trim($ngaydat[0]);
		$ngayden = trim($ngaydat[1]);
		$ngaytu = strtotime(str_replace("/","-",$ngaytu));
		$ngayden = strtotime(str_replace("/","-",$ngayden));
		$sql .= " and ngaytao<=$ngayden and ngaytao>=$ngaytu";
	}
	if($khoanggia)
	{
		$khoanggia = explode(";",$khoanggia);
		$giatu = trim($khoanggia[0]);
		$giaden = trim($khoanggia[1]);
		$sql .= " and tonggia<=$giaden and tonggia>=$giatu";
	}
	if($city) $sql .= " and city=$city";
	if($district) $sql .= " and district=$district";
	if($wards) $sql .= " and wards=$wards";
	if($_REQUEST['keyword']!='')
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$sql .= " and (hoten LIKE '%$keyword%' or email LIKE '%$keyword%' or dienthoai LIKE '%$keyword%' or madonhang LIKE '%$keyword%')";
	}

	$sql .= " order by ngaytao desc";
	$donhang = $d->rawQuery($sql);
	
	/* PHPExcel */
	include _LIB.'PHPExcel.php';
	include _LIB.'PHPExcel/Writer/Excel5.php';
	$PHPExcel = new PHPExcel();

	/* Set properties */
	$PHPExcel->getProperties()->setCreator($setting['tenvi']);
	$PHPExcel->getProperties()->setLastModifiedBy($setting['tenvi']);
	$PHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
	$PHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
	$PHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

	/* Add some data */
	$PHPExcel->setActiveSheetIndex(0);
	$PHPExcel->setActiveSheetIndex(0)->mergeCells('A1:M1');
	$PHPExcel->setActiveSheetIndex(0)->mergeCells('A2:M2');
	$PHPExcel->setActiveSheetIndex(0)->mergeCells('A3:M3');
	$PHPExcel->setActiveSheetIndex(0)->mergeCells('A4:M4');

	/* Thông tin chung */
	$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
	$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
	$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
	$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
	$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('A1',$setting['tenvi']);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('A2','Hotline: '.$setting['hotline']);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('A3','Email: '.$setting['email']);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('A4','Địa chỉ: '.$setting['diachi']);
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('A6','STT');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('B6','Mã đơn hàng');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('C6','Ngày đặt');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('D6','Tình trạng');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('E6','Hình thức thanh toán');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('F6','Họ tên');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('G6','Điện thoại');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('H6','Email');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('I6','Địa chỉ');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('J6','Tạm tính');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('K6','Phí vận chuyển');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('L6','Ưu đãi');
	$PHPExcel->setActiveSheetIndex(0)->setCellValue('M6','Tổng giá trị đơn hàng');

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
	$PHPExcel->getActiveSheet()->getStyle('A6:M6')->applyFromArray(
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
	$PHPExcel->getActiveSheet()->getStyle('A6:M6')->getBorders()->getAllBorders()->setBorderStyle(
		PHPExcel_Style_Border::BORDER_THIN
	);

	/* Thông tin tổng đơn hàng */
	$vitri = 7;
	for($i=0;$i<count($donhang);$i++) 
	{
		/* Phí ship */
		if($donhang[$i]['phiship']) $phiship = number_format($donhang[$i]['phiship'], 0, ',', '.')."đ";
		else $phiship = "Không";

		/* Phí coupon */
		if($donhang['loaicoupon']==1) $phicoupon = "-".number_format($donhang[$i]['phicoupon'], 0, ',', '.')."%";
		else if($donhang['loaicoupon']==2) $phicoupon = "-".number_format($donhang[$i]['phicoupon'], 0, ',', '.')."đ";
		else $phicoupon = "Không";
	
		/* Trang thái */
		$trangthai = $d->rawQueryOne("select trangthai from #_status where id = ?",array($donhang[$i]['tinhtrang']));

		/* Gán giá trị */
		$PHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$vitri, $i+1)
		->setCellValue('B'.$vitri, $donhang[$i]['madonhang'])
		->setCellValue('C'.$vitri, date('H:i A d-m-Y',$donhang['ngaytao']))
		->setCellValue('D'.$vitri, $trangthai['trangthai'])
		->setCellValue('E'.$vitri, get_payments($donhang[$i]['httt']))
		->setCellValue('F'.$vitri, $donhang[$i]['hoten'])
		->setCellValue('G'.$vitri, $donhang[$i]['dienthoai'])
		->setCellValue('H'.$vitri, $donhang[$i]['email'])
		->setCellValue('I'.$vitri, $donhang[$i]['diachi'])
		->setCellValue('J'.$vitri, number_format($donhang[$i]['tamtinh'], 0, ',', '.')."đ")
		->setCellValue('K'.$vitri, $phiship)
		->setCellValue('L'.$vitri, $phicoupon)
		->setCellValue('M'.$vitri, number_format($donhang[$i]['tonggia'], 0, ',', '.')."đ");

		$PHPExcel->getActiveSheet()->getStyle('A'.$vitri.':M'.$vitri)->applyFromArray(
			array(
				'alignment'=>array(
					'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'wrap'=>true
				)
			)
		);
		$PHPExcel->getActiveSheet()->getStyle('A'.$vitri.':M'.$vitri)->getBorders()->getAllBorders()->setBorderStyle(
			PHPExcel_Style_Border::BORDER_THIN
		);
		$vitri++;
	}

	/* Đổi tiêu đề */
	$PHPExcel->getActiveSheet()->setTitle('DANH SÁCH ĐƠN HÀNG');

	/* Lưu file */
    header( 'Content-Type: application/vnd.ms-excel' );
    header( 'Content-Disposition: attachment;filename="orderlist_'.$time.'_'.date('d_m_Y').'.xls"' );
    header( 'Cache-Control: max-age=0' );

    $objWriter = new PHPExcel_Writer_Excel5($PHPExcel);
    $objWriter->save( 'php://output' );	
?>