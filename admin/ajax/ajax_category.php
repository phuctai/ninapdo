<?php
	include "ajax_config.php";

	if(isset($_POST["level"]))
	{
		$level = htmlspecialchars($_POST["level"]);
		$table = htmlspecialchars($_POST["table"]);
		$id = htmlspecialchars($_POST["id"]);
		$type = htmlspecialchars($_POST["type"]);

		switch($level)
		{
			case '0':
				$id_temp = "id_list";
				break;

			case '1':
				$id_temp = "id_cat";
				break;

			case '2':
				$id_temp = "id_item";
				break;

			default:
				echo 'error ajax';
				exit();
				break;
		}

		$row = $d->rawQuery("select tenvi, id from $table where $id_temp = ? and type = ? order by stt,id desc",array($id,$type));

		$str = '<option value="">Chọn danh mục</option>';
		foreach($row as $v) $str .= '<option value='.$v["id"].'>'.$v["tenvi"].'</option>';			
		echo $str;
	}
?>