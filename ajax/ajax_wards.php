<?php
	include "ajax_config.php";
	
	$id_district = htmlspecialchars($_POST['id_district']);
	if($id_district) $wards = $d->rawQuery("SELECT ten, id FROM table_wards WHERE id_district = ? ORDER BY id ASC",array($id_district));

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