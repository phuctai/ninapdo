<?php
	include "ajax_config.php";

	$table = htmlspecialchars($_POST['table']);
	$id = htmlspecialchars($_POST['id']);
	$loai = htmlspecialchars($_POST['loai']);

	$tmp = $d->rawQueryOne("select $loai from #_$table where id = ?",array($id));

	if($tmp[$loai]>0) $data[$loai] = 0;
	else $data[$loai] = 1;

	$d->where('id',$id);
	$d->update($table,$data);
?>