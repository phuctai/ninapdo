<?php
	include "ajax_config.php";

	$gg_id = htmlspecialchars($_POST['id']);
	$gg_name = htmlspecialchars($_POST['name']);
	$gg_img = htmlspecialchars($_POST['img']);
	$gg_email = htmlspecialchars($_POST['email']);
	$str_return = "";
	$error_return = 0;

	$user_gg = $d->rawQueryOne("SELECT id FROM table_user WHERE role = ? AND email = ?",array(1,$gg_email));

	if($user_gg['id'])
	{
		$row_user = $d->rawQueryOne("SELECT * FROM table_user WHERE role = ? AND hienthi>0 AND email = ?",array(1,$gg_email));

		if($row_user['id']=='')
		{
			$str_return="Tài khoản của bạn đã bị đình chỉ hoặc bị vô hiệu. Vui lòng liên hệ với chúng tôi.";
			$error_return=1;
		}
		else
		{
			$_SESSION[$login_name][$login_name] = true;
			$_SESSION[$login_name]['id'] = $row_user['id'];
			$_SESSION[$login_name]['dienthoai'] = $row_user['dienthoai'];
			$_SESSION[$login_name]['diachi'] = $row_user['diachi'];
			$_SESSION[$login_name]['email'] = $row_user['email'];
			$_SESSION[$login_name]['ten'] = $row_user['ten'];
			$_SESSION[$login_name]['id_social'] = $row_user['id_social'];

			$str_return="Đăng nhập thành công";
		}
	}
	else
	{
		$row_user = $d->rawQueryOne("SELECT * FROM table_user WHERE role = ? AND hienthi>0 AND email = ?",array(1,$gg_email));

		$data['ten']=$gg_name;
		$data['username']='Login by Google';
		$data['email']=$gg_email;
		$data['avatar']=uploadUrl($gg_img,_upload_user,"jpg,bmp,jpeg,png,gif","20000000");
		$data['role']=1;
		$data['hienthi']=1;
		$data['id_social']=1;
		$d->insert('user',$data);
		
		$_SESSION[$login_name][$login_name] = true;
		$_SESSION[$login_name]['id'] = $row_user['id'];
		$_SESSION[$login_name]['dienthoai'] = $row_user['dienthoai'];
		$_SESSION[$login_name]['diachi'] = $row_user['diachi'];
		$_SESSION[$login_name]['email'] = $row_user['email'];
		$_SESSION[$login_name]['ten'] = $row_user['ten'];
		$_SESSION[$login_name]['id_social'] = $row_user['id_social'];

		$str_return="Đăng ký thành viên thành công";
	}

	$data = array('str_return' => $str_return, 'error_return' => $error_return);
	echo json_encode($data);
?>