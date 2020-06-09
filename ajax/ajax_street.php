<?php
	include "ajax_config.php";
	
	$id_wards = htmlspecialchars($_POST['id_wards']);
	if($id_wards) $street = $d->rawQuery("SELECT ten, id FROM table_street WHERE id_wards = ? ORDER BY id ASC",array($id_wards));

	if(count($street)>0)
	{ ?>  
		<option value=""><?=duong?></option>
		<?php for($i=0;$i<count($street);$i++) { ?>
			<option value="<?=$street[$i]['id']?>"><?=$street[$i]['ten']?></option>
		<?php }
	}
	else
	{ ?>
		<option value=""><?=duong?></option>
	<?php }
?>