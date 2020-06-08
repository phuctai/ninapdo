<?php
	include "ajax_config.php";

	$id = htmlspecialchars($_POST["id"]);

	if($id) $row = $d->rawQuery("delete from #_attribute where id = ?",array($id));
?>