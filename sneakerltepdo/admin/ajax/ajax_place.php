<?php
	include "ajax_config.php";

	if(isset($_POST["level"]))
	{
		$level = htmlspecialchars($_POST["level"]);
		$table = htmlspecialchars($_POST["table"]);
		$id = htmlspecialchars($_POST["id"]);

		switch($level)
		{
			case '0':
				$id_temp = "id_city";
				break;

			case '1':
				$id_temp = "id_district";
				break;

			default:
				echo 'error ajax';
				exit();
				break;
		}

		$row = $d->rawQuery("select ten, id from $table where $id_temp = ? order by id asc",array($id));

		$str = '<option value="">Chọn danh mục</option>';
		foreach($row as $v) $str .= '<option value='.$v["id"].'>'.$v["ten"].'</option>';			
		echo  $str;
	}
?>