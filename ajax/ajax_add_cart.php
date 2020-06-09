<?php
	include "ajax_config.php";

    $cmd = htmlspecialchars($_POST['cmd']);
    $id = htmlspecialchars($_POST['id']);
    $mau = htmlspecialchars($_POST['mau']);
	$size = htmlspecialchars($_POST['size']);
	$q = htmlspecialchars($_POST['qty']);
	$q = ($q>1)?$q:1;

	if($cmd == 'addcart' && $id)
	{
		$cart->addtocart($q,$id,$mau,$size);
		
		$count_cart = count($_SESSION['cart']);
		$data = array('countcart' => $count_cart);
		
		echo json_encode($data);
	}
?>