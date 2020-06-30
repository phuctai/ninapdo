<?php
	include "ajax_config.php";
	
	$id = htmlspecialchars($_POST['id']);
	$video = $d->rawQueryOne("SELECT link_video FROM table_photo WHERE id = ?",array($id));
?>
<iframe width="100%" height="100%" src="//www.youtube.com/embed/<?=$func->getYoutube($video['link_video'])?>" frameborder="0" allowfullscreen></iframe>