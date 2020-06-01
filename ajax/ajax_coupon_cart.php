<?php
	include "ajax_config.php";

	$coupon = htmlspecialchars($_POST['coupon']);
	$ship = htmlspecialchars($_POST['ship']);
	$flag = 1;
	$error = "";

	$coupon = $d->rawQueryOne("SELECT * FROM table_coupon where ma = ?",array($coupon));

	if($coupon['ngayketthuc']<time())
	{
		$flag = 0;
		$error = mauudaidahethan;
	}

	if(!$coupon['id'] || $coupon['tinhtrang']!=0)
	{
		$flag = 0;
		$error = mauudaidaduocsudunghoackhongtontai;
	}

	if($flag)
	{
		$total = get_order_total() + $ship;
		$endow = $coupon['chietkhau'];
		$endowID = $coupon['id'];
		$endowType = $coupon['loai'];
		if($endowType==1)
		{
			$total = $total - (($total * $coupon['chietkhau']) / 100);
			$endowText = "-".$coupon['chietkhau']."%";
		}
		if($endowType==2)
		{
			$total = $total - $coupon['chietkhau'];
			$endowText = "-".number_format($coupon['chietkhau'],0, ',', '.')."đ";
		}
		$totalText = number_format($total,0, ',', '.')."đ";
	}
	else
	{
		$total = get_order_total() + $ship;
		$totalText = number_format($total,0, ',', '.')."đ";
		$endow = 0;
		$endowType = 0;
		$endowText = chuacouudai;
	}

	$data = array('error' => $error, 'endow' => $endow, 'endowID' => $endowID, 'endowType' => $endowType, 'endowText' => $endowText, 'total' => $total, 'totalText' => $totalText);
	echo json_encode($data);
?>