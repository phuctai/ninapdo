<?php
	include "ajax_config.php";

	$code = htmlspecialchars($_POST['code']);
	$ship = htmlspecialchars($_POST['ship']);
	$endow = htmlspecialchars($_POST['endow']);
	remove_product($code);
	
	$max = count($_SESSION['cart']);
	$temp = get_order_total();
	$tempText = number_format($temp,0, ',', '.')."đ";
	$total = get_order_total() + $ship - $endow;
	$totalText = number_format($total,0, ',', '.')."đ";

	$data = array('max' => $max, 'temp' => $temp, 'tempText' => $tempText, 'total' => $total, 'totalText' => $totalText);
	echo json_encode($data);
?>