<?php
	include "ajax_config.php";
	
	$id_district = htmlspecialchars($_POST['id_district']);
	if($id_district) $wards = $d->rawQuery("select ten, id from #_wards where id_district = ? order by id asc",array($id_district));

	if(count($wards)>0)
	{ ?>  
		<option value=""><?=phuongxa?></option>
		<?php for($i=0;$i<count($wards);$i++) { ?>
			<option value="<?=$wards[$i]['id']?>"><?=$wards[$i]['ten']?></option>
		<?php }
	}
	else
	{ ?>
		<option value=""><?=phuongxa?></option>
	<?php }
?>