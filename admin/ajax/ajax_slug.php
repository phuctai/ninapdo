<?php
	include "ajax_config.php";

	$flag = 1;
	$slug = htmlspecialchars($_POST['slug']);
	$id = htmlspecialchars($_POST['id']);
	$where = ($id) ? "id<>$id AND " : "";

	$table = array(
		"#_product_list",
		"#_product_cat",
		"#_product_item",
		"#_product_sub",
		"#_product_brand",
		"#_product",
		"#_news_list",
		"#_news_cat",
		"#_news_item",
		"#_news_sub",
		"#_news",
		"#_tags"
	);

	foreach($table as $v)
	{
		$check = $d->rawQueryOne("select id from $v where $where (tenkhongdauvi = ? or tenkhongdauen = ?) limit 0,1",array($slug,$slug));
		if($check['id'])
		{
			$flag = 0;
			break;
		}
	}

	echo $flag;
?>