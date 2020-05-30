<?php
	session_start();
	@define('LIBRARIES','./libraries/');

	include_once LIBRARIES."config.php";
	include_once LIBRARIES."PDODb.php";
    $d = new PDODb($config['database']);
    include_once LIBRARIES."functions.php";
	
	/* Kiểm tra có đăng nhập chưa */
	if(check_login()==false && $act!="login")
	{
		redirect("index.php?com=user&act=login");
	}

	/* Kiểm tra active export word */
	if(!$config['order']['wordall']) transfer("Trang không tồn tại", "index.php",0);

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

	/* Khởi tạo PHPWord */
	require_once LIBRARIES.'PHPWord.php';
	$PHPWord = new PHPWord();
	$filemau = LIBRARIES.'sample/orderlist.docx';

	/* Load file Word mẫu */
	$document = $PHPWord->loadTemplate($filemau);

	/* Thông tin công ty */
	$document->setValue('{tencty}', $setting["tenvi"]);
	$document->setValue('{hotlinecty}', $setting["hotline"]);
	$document->setValue('{emailcty}', $setting["email"]);
	$document->setValue('{diachicty}', $setting["diachi"]);

	/* Tạo danh sách đơn hàng */
	$data = array();
	for($i=0;$i<count($donhang);$i++) 
	{
		/* Phí ship */
		if($donhang[$i]['phiship']) $phiship = number_format($donhang[$i]['phiship'], 0, ',', '.')."đ";
		else $phiship = "Không";

		/* Phí coupon */
		if($donhang[$i]['loaicoupon']==1) $phicoupon = "-".number_format($donhang[$i]['phicoupon'], 0, ',', '.')."%";
		else if($donhang[$i]['loaicoupon']==2) $phicoupon = "-".number_format($donhang[$i]['phicoupon'], 0, ',', '.')."đ";
		else $phicoupon = "Không";

		/* Trang thái */
		$trangthai = $d->rawQueryOne("select trangthai from #_status where id = ?",array($donhang[$i]['tinhtrang']));

		/* STT */
		$data["stt"][$i] = $i+1;

		/* Thông tin đơn hàng */
		$data["madonhang"][$i] = $donhang[$i]['madonhang'];
		$data["ngaydat"][$i] = date('H:i A d-m-Y',$donhang[$i]['ngaytao']);
		$data["tinhtrang"][$i] = $trangthai['trangthai'];
		$data["httt"][$i] = get_payments($donhang[$i]['httt']);

		/* Thông tin khách hàng */
		$data["hotenkh"][$i] = $donhang[$i]['hoten'];
		$data["dienthoaikh"][$i] = $donhang[$i]['dienthoai'];
		$data["emailkh"][$i] = $donhang[$i]['email'];
		$data["diachikh"][$i] = $donhang[$i]['diachi'];

		/* Tính thành tiền */
		$data["tamtinh"][$i] = number_format($donhang[$i]['tamtinh'], 0, ',', '.')."đ";
		$data["phiship"][$i] = $phiship;
		$data["phicoupon"][$i] = $phicoupon;
		$data["tonggia"][$i] = number_format($donhang[$i]['tonggia'], 0, ',', '.')."đ";
	}
	
	/* Thiết lập đối tượng dữ liệu từng dòng */
	$document->cloneRow('TB', $data);
	
	/* Lưu file */
	$filename = "orderlist_".$time."_".date('d_m_Y').".docx";
	$document->save($filename);
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$filename);
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: '. filesize($filename));
	flush();
	readfile($filename);
	unlink($filename);
?>