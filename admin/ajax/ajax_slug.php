<?php
	include "ajax_config.php";

	$error = "";
	$status = htmlspecialchars($_POST['status']);
	$title = htmlspecialchars($_POST['title']);
	$lang = htmlspecialchars($_POST['lang']);
	$com = htmlspecialchars($_POST['com']);
	$act = htmlspecialchars($_POST['act']);
	$id = htmlspecialchars($_POST['id']);
	$slug = changeTitle($title);
	$prefix = '';
	$where = ($id) ? "id<>$id AND" : "";

	if($status == 'old')
	{
		if($act != 'edit')
		{
			$prefix = explode("edit",$act);
			$prefix = $prefix[1];
		}
		
		$oldSlug = $d->rawQueryOne("SELECT tenkhongdau$lang FROM table_".$com.$prefix." WHERE id = ?",array($id));
		$slug = $oldSlug['tenkhongdau'.$lang];
		$error = 3;
	}
	else
	{
		if($com == 'product' || $com == 'news')
		{
			$listSlug = $d->rawQueryOne("SELECT id FROM table_".$com."_list WHERE $where (tenkhongdauvi = ? OR tenkhongdauen = ?)",array($slug,$slug));
			$catSlug = $d->rawQueryOne("SELECT id FROM table_".$com."_cat WHERE $where (tenkhongdauvi = ? OR tenkhongdauen = ?)",array($slug,$slug));
			$itemSlug = $d->rawQueryOne("SELECT id FROM table_".$com."_item WHERE $where (tenkhongdauvi = ? OR tenkhongdauen = ?)",array($slug,$slug));
			$subSlug = $d->rawQueryOne("SELECT id FROM table_".$com."_sub WHERE $where (tenkhongdauvi = ? OR tenkhongdauen = ?)",array($slug,$slug));
		}

		if($com == 'product') $brandSlug = $d->rawQueryOne("SELECT id FROM table_".$com."_brand WHERE $where (tenkhongdauvi = ? OR tenkhongdauen = ?)",array($slug,$slug));
		
		$manSlug = $d->rawQueryOne("SELECT id FROM table_$com WHERE $where (tenkhongdauvi = ? OR tenkhongdauen = ?)",array($slug,$slug));

		if($listSlug['id'] || $catSlug['id'] || $itemSlug['id'] || $subSlug['id'] || $brandSlug['id'] || $manSlug['id']) $error = 1;
		else $error = 2;
	}
	
	$data = array('slug' => $slug, 'error' => $error);
	echo json_encode($data);
?>