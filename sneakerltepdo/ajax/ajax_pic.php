<?php  
	include "ajax_config.php";

	$id = htmlspecialchars($_GET['id']);
	$product = $d->rawQueryOne("SELECT photo, ten$lang FROM table_product WHERE hienthi>0 AND id = ? AND type = ?",array($id,'san-pham'));
?>
<img onerror="this.src='//placehold.it/300x200';" src="<?=_upload_product_l.$product['photo']?>" alt="<?=$product['ten'.$lang]?>">