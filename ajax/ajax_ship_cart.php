<?php  
	include "ajax_config.php";

	$id = htmlspecialchars($_POST['id']);
	$endow = htmlspecialchars($_POST['endow']);

	if($id) $ship = $d->rawQueryOne("SELECT gia FROM table_wards WHERE id = ?",array($id));

	$shipText = number_format($ship['gia'],0, ',', '.')."đ";
	$total = get_order_total() + $ship['gia'] - $endow;
	$totalText = number_format($total,0, ',', '.')."đ";

	$data = array('shipText' => $shipText, 'ship' => $ship['gia'], 'totalText' => $totalText, 'total' => $total);
	echo json_encode($data);
?>