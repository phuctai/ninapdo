<?php
	include "ajax_config.php";

	$pid = htmlspecialchars($_POST['pid']);
	$q = htmlspecialchars($_POST['q']);
	$code = htmlspecialchars($_POST['code']);
	$ship = htmlspecialchars($_POST['ship']);
	$endow = htmlspecialchars($_POST['endow']);
	$max = count($_SESSION['cart']);

	for($i=0;$i<$max;$i++)
	{
		if($code == $_SESSION['cart'][$i]['code'])
		{
			if($q) $_SESSION['cart'][$i]['qty'] = $q;
			break;
		}
	}
	
	$gia = number_format($cart->get_price($pid)*$q,0, ',', '.')."đ";
	$giamoi = number_format($cart->get_price_new($pid)*$q,0, ',', '.')."đ";
	$temp = $cart->get_order_total();
	$tempText = number_format($temp,0, ',', '.')."đ";
	$total = $cart->get_order_total() + $ship - $endow;
	$totalText = number_format($total,0, ',', '.')."đ";

	$data = array('gia' => $gia, 'giamoi' => $giamoi, 'temp' => $temp, 'tempText' => $tempText, 'total' => $total, 'totalText' => $totalText);
	echo json_encode($data);
?>