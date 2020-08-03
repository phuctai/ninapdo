<?php
	include "ajax_config.php";
	
	$id = htmlspecialchars($_POST['id']);
	$video = $d->rawQueryOne("select link_video from #_photo where id = ? limit 0,1",array($id));
?>
<iframe width="100%" height="100%" src="//www.youtube.com/embed/<?=$func->getYoutube($video['link_video'])?>" frameborder="0" allowfullscreen></iframe>