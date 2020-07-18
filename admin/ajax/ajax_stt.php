<?php
	include "ajax_config.php";

	$table = htmlspecialchars($_POST['table']);
	$id = htmlspecialchars($_POST['id']);
	$value = htmlspecialchars($_POST['value']);

	$data['stt'] = $value;
	
	$d->where('id',$id);
	$d->update($table,$data);
	$cache->DeleteCache();
?>