<?php
	include "ajax_config.php";

	$flag = 1;
	$slug = htmlspecialchars($_POST['slug']);
	$id = htmlspecialchars($_POST['id']);
	$where = ($id) ? "id<>$id AND " : "";

	$table = array(
		"table_product_list",
		"table_product_cat",
		"table_product_item",
		"table_product_sub",
		"table_product_brand",
		"table_product",
		"table_news_list",
		"table_news_cat",
		"table_news_item",
		"table_news_sub",
		"table_news"
	);

	foreach($table as $v)
	{
		$check = $d->rawQueryOne("SELECT id FROM $v WHERE $where (tenkhongdauvi = ? OR tenkhongdauen = ?)",array($slug,$slug));
		if($check['id'])
		{
			$flag = 0;
			break;
		}
	}

	echo $flag;
?>