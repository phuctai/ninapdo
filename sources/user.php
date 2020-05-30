<?php
	if(!defined('SOURCES')) die("Error");

	$kind = htmlspecialchars($_GET['kind']);

	switch($kind)
	{
		case 'dang-nhap':
			$title_crumb="Đăng nhập";
			$template = "account/dangnhap";
			if(isset($_SESSION[$login_name][$login_name])){transfer("Trang không tồn tại",$config_base,0);}
			if(isset($_POST['dangnhap'])){login();}
			break;

		case 'dang-ky':
			$title_crumb="Đăng ký thành viên";
			$template = "account/dangky";
			if(isset($_SESSION[$login_name][$login_name])){transfer("Trang không tồn tại",$config_base,0);}
			if(isset($_POST['dangky'])){signup();}
			break;

		case 'quen-mat-khau':
			$title_crumb="Quên mật khẩu";
			$template = "account/quenmatkhau";
			if(isset($_SESSION[$login_name][$login_name])){transfer("Trang không tồn tại",$config_base,0);}
			if(isset($_POST['quenmatkhau'])){doimatkhau_user();}
			break;

		case 'kich-hoat':
			$title_crumb="Kích hoạt thành viên";
			$template = "account/kichhoat";
			if(isset($_SESSION[$login_name][$login_name])){transfer("Trang không tồn tại",$config_base,0);}
			if(isset($_POST['kichhoat'])){active_user();}
			break;

		case 'thong-tin':
			if(!isset($_SESSION[$login_name][$login_name])){transfer("Trang không tồn tại",$config_base,0);}
			$template = "account/thongtin";
			$title_crumb="Cập nhật thông tin cá nhân";
			info_user();
			break;

		case 'dang-xuat':
			if(!isset($_SESSION[$login_name][$login_name])){transfer("Trang không tồn tại",$config_base,0);}
			logout();
		
		default:
			$template = "404";
			break;
	}

	$title_bar=$title_crumb;

	/* breadCrumbs */
	if($title_crumb) $data['breadcrumbs'][] = array('slug'=>"",'name'=>$title_crumb);
	$breadcrumbs = $bc->getUrl(trangchu, $data['breadcrumbs']);

	function info_user()
	{
		global $d, $row_detail, $config_base, $login_name;

		$iduser = $_SESSION[$login_name]['id'];

		if($iduser)
		{
			$row_detail = $d->rawQueryOne("select ten, username, gioitinh, ngaysinh, email, dienthoai, diachi from #_user where id = ?",array($iduser));

		    if(isset($_POST['capnhatthongtin']))
		    {
		    	$password = htmlspecialchars($_POST['password']);
		    	$passwordMD5 = md5($password);
	            $new_password = htmlspecialchars($_POST['new-password']);
	            $new_passwordMD5 = md5($new_password);
	            $new_password_confirm = htmlspecialchars($_POST['new-password-confirm']);

		        if($password)
		        {
		            $row = $d->rawQueryOne("select id from #_user where id = ? and password = ?",array($iduser,$passwordMD5));

		            if(!$row['id']) transfer("Mật khẩu cũ không chính xác","",0);
		            if(!$new_password || ($new_password != $new_password_confirm)) transfer("Thông tin mật khẩu mới không chính xác","",0);

		            $data['password'] = $new_passwordMD5;
		        }

		        $data['ten'] = htmlspecialchars($_POST['ten']);
		        $data['diachi'] = htmlspecialchars($_POST['diachi']);
		        $data['dienthoai'] = htmlspecialchars($_POST['dienthoai']);
		        $data['email'] = htmlspecialchars($_POST['email']);
		        $data['ngaysinh'] = strtotime(str_replace("/","-",htmlspecialchars($_POST['ngaysinh'])));
		        $data['gioitinh'] = htmlspecialchars($_POST['gioitinh']);

		        $d->where('id', $iduser);
		        if($d->update('user',$data))
		        {
		        	if($password)
		        	{
			            if(isset($_SESSION[$login_name]) and isset($_SESSION[$login_name][$login_name]))
			            {
			                $_SESSION[$login_name][$login_name] = false;
			                unset($_SESSION[$login_name]);
			            }
			            if(isset($_COOKIE['iduser']))
			            {
			                setcookie('iduser',"",-1,'/');
			            }
		            	transfer("Cập nhật thông tin thành công",$config_base."account/dang-nhap");
		        	}
		        	transfer("Cập nhật thông tin thành công",$config_base."account/thong-tin");	            
		        }
		    }
		}
		else
		{
			transfer("Trang không tồn tại",$config_base,0);
		}
	}

	function active_user()
	{
		global $d, $row_detail, $config_base;

		$id = htmlspecialchars($_GET['id']);
		$maxacnhan = htmlspecialchars($_POST['maxacnhan']);

		/* Kiểm tra thông tin */
        $row_detail = $d->rawQueryOne("select hienthi, maxacnhan, id from #_user where id = ?",array($id));

        if(!$row_detail['id']) transfer("Tài khoản của bạn chưa được kích hoạt",$config_base,0);
        else if($row_detail['hienthi']) transfer("Tài khoản của bạn đã được kích hoạt",$config_base);
        else
        {
    		if($row_detail['maxacnhan'] == $maxacnhan)
        	{
        		$data['hienthi'] = 1;
        		$data['maxacnhan'] = '';
				$d->where('id', $id);
				if($d->update('user',$data)) transfer("Kích hoạt tài khoản thành công.",$config_base."account/dang-nhap");
        	}
        	else
        	{
        		transfer("Mã xác nhận không đúng. Vui lòng nhập lại mã xác nhận.",$config_base."account/kich-hoat/id=".$id,0);
        	}
        }
	}

	function login()
	{
		global $d, $login_name, $config_base;

		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		$passwordMD5 = md5($password);
		$remember = htmlspecialchars($_POST['remember-user']);

		if(!$username) transfer("Chưa nhập tên tài khoản",'account/dang-nhap',0);
		if(!$password) transfer("Chưa nhập mật khẩu",'account/dang-nhap',0);
		
		$row = $d->rawQueryOne("select id, password, username, dienthoai, diachi, email, ten, role from #_user where username = ? and hienthi = 1",array($username));

		if($row['id'])
		{
			if($row['password'] == $passwordMD5 && $row['role'] == 1)
			{
				$_SESSION[$login_name][$login_name] = true;
				$_SESSION[$login_name]['id'] = $row['id'];
				$_SESSION[$login_name]['username'] = $row['username'];
				$_SESSION[$login_name]['dienthoai'] = $row['dienthoai'];
				$_SESSION[$login_name]['diachi'] = $row['diachi'];
				$_SESSION[$login_name]['email'] = $row['email'];
				$_SESSION[$login_name]['ten'] = $row['ten'];

				if($remember)
				{
					$time_expiry = time()+3600*24;
					$iduser = $row['id'];
					setcookie('iduser',$iduser,$time_expiry,'/');
				}

				transfer("Đăng nhập thành công", $config_base);
			}
			else
			{
				transfer("Tên đăng nhập hoặc mật khẩu không chính xác. Hoặc tài khoản của bạn chưa được xác nhận từ Quản trị website", $config_base."account/dang-nhap",0);
			}
		}
		else
		{
			transfer("Tên đăng nhập hoặc mật khẩu không chính xác. Hoặc tài khoản của bạn chưa được xác nhận từ Quản trị website", $config_base."account/dang-nhap",0);
		}
	}

	function signup()
	{
		global $d, $login_name, $config_base;

		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
		$passwordMD5 = md5($password);
		$repassword = htmlspecialchars($_POST['repassword']);
		$email = htmlspecialchars($_POST['email']);
		$maxacnhan = digitalRandom(0,3,6);

		if($password != $repassword) transfer("Xác nhận mật khẩu không trùng khớp", $config_base."account/dang-ky",0);

		/* Kiểm tra tên đăng ký */
		$row = $d->rawQueryOne("select id from #_user where username = ?",array($username));
		if($row['id']) transfer("Tên đăng nhập đã tồn tại", $config_base."account/dang-ky",0);

		/* Kiểm tra email đăng ký */
		$row = $d->rawQueryOne("select id from #_user where email = ?",array($email));
		if($row['id']) transfer("Địa chỉ email đã tồn tại", $config_base."account/dang-ky",0);

		$data['ten'] = htmlspecialchars($_POST['ten']);
		$data['username'] = $username;
		$data['password'] = md5($password);
		$data['email'] = $email;
		$data['dienthoai'] = htmlspecialchars($_POST['dienthoai']);
		$data['diachi'] = htmlspecialchars($_POST['diachi']);
		$data['gioitinh'] = htmlspecialchars($_POST['gioitinh']);
		$data['ngaysinh'] = strtotime(str_replace("/","-",$_POST['ngaysinh']));
		$data['maxacnhan'] = $maxacnhan;
		$data['com'] = 'visitor';
		$data['hienthi'] = 0;
		$data['role'] = 1;
		
		if($d->insert('user',$data))
		{
			send_active_user($username);
			transfer("Đăng ký thành viên thành công. Vui lòng kiểm tra email: ".$data['email']." để kích hoạt tài khoản", $config_base."account/dang-nhap");
		}
		else
		{
			transfer("Đăng ký thành viên thất bại. Vui lòng thử lại sau.", $config_base,0);
		}
	}

	function send_active_user($username)
	{
		global $d, $setting, $config_base, $lang;

		/* Lấy thông tin người dùng */
		$row = $d->rawQueryOne("select id, maxacnhan, username, password, ten, email, dienthoai, diachi from #_user where username = ?",array($username));

		// Cấu hình chung gửi email
		include_once LIBRARIES."mailsetting.php";

		// Gán giá trị cho biến gửi email
		$iduser = $row['id'];
		$maxacnhan = $row['maxacnhan'];
		$tendangnhap = $row['username'];
		$matkhau = $row['password'];
		$tennguoidung = $row['ten'];
		$emailnguoidung = $row['email'];
		$dienthoainguoidung = $row['dienthoai'];
		$diachinguoidung = $row['diachi'];
		$linkkichhoat = $config_base."account/kich-hoat/id=".$iduser;

		// Thông tin đăng ký
		$thongtindangky='<td style="padding:3px 9px 9px 0px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top"><span style="text-transform:normal">Username: '.$tendangnhap.'</span><br>Mật khẩu: *******'.substr($matkhau,-3).'<br>Mã kích hoạt: '.$maxacnhan.'</td><td style="padding:3px 0px 9px 9px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">';
		if($tennguoidung)
		{
			$thongtindangky.='<span style="text-transform:capitalize">'.$tennguoidung.'</span><br>';
		}

		if($emailnguoidung)
		{
			$thongtindangky.='<a href="mailto:'.$emailnguoidung.'" target="_blank">'.$emailnguoidung.'</a><br>';
		}

		if($diachinguoidung)
		{
			$thongtindangky.=$diachinguoidung.'<br>';
		}

		if($dienthoainguoidung)
		{
			$thongtindangky.='Tel: '.$dienthoainguoidung.'</td>';
		}

		$noidung='
		<table align="center" bgcolor="#dcf0f8" border="0" cellpadding="0" cellspacing="0" style="margin:0;padding:0;background-color:#f2f2f2;width:100%!important;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px" width="100%">
			<tbody>
				<tr>
					<td align="center" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">
						<table border="0" cellpadding="0" cellspacing="0" style="margin-top:15px" width="600">
							<tbody>
								<tr>
									<td align="center" id="m_-6357629121201466163headerImage" valign="bottom">
										<table cellpadding="0" cellspacing="0" style="border-bottom:3px solid '.$mauform.';padding-bottom:10px;background-color:#fff" width="100%">
											<tbody>
												<tr>
													<td bgcolor="#FFFFFF" style="padding:0" valign="top" width="100%">
														<div style="color:#fff;background-color:f2f2f2;font-size:11px">&nbsp;</div>
														<div style="display:flex;justify-content:space-between;align-items:center;">
															<table style="width:100%;">
																<tbody>
																	<tr>
																		<td>
																			<a href="'.$trangchu.'" style="border:medium none;text-decoration:none;color:#007ed3;margin:0px 0px 0px 20px" target="_blank">'.$logo.'</a>
																		</td>
																		<td style="padding:15px 20px 0 0;text-align:right">'.$mangxahoi.'</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr style="background:#fff">
									<td align="left" height="auto" style="padding:15px" width="600">
										<table>
											<tbody>
												<tr>
													<td>
														<h1 style="font-size:17px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0">Cảm ơn quý khách đã đăng ký tại '.$websitecongty.'</h1>
														<p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">Thông tin tài khoản của quý khách đã được '.$websitecongty.' cập nhật. Quý khách vui lòng kích hoạt tài khoản bằng cách truy cập vào đường link phía dưới.</p>
														<h3 style="font-size:13px;font-weight:bold;color:'.$mauform.';text-transform:uppercase;margin:20px 0 0 0;padding: 0 0 5px;border-bottom:1px solid #ddd">Thông tin tài khoản <span style="font-size:12px;color:#777;text-transform:none;font-weight:normal">(Ngày '.date('d',$ngaygui).' tháng '.date('m',$ngaygui).' năm '.date('Y H:i:s',$ngaygui).')</span></h3>
													</td>
												</tr>
											<tr>
											<td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
											<table border="0" cellpadding="0" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th align="left" style="padding:6px 9px 0px 0px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold" width="50%">Thông tin tài khoản</th>
														<th align="left" style="padding:6px 0px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold" width="50%">Thông tin người dùng</th>
													</tr>
												</thead>
												<tbody>
													<tr>'.$thongtindangky.'</tr>
												</tbody>
											</table>
											</td>
										</tr>
										<tr>
											<td>
											<p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><i>Lưu ý: Quý khách vui lòng truy cập vào đường link phía dưới để hoàn tất quá trình đăng ký tài khoản.</i>
											<div style="margin:auto"><a href="'.$linkkichhoat.'" style="display:inline-block;text-decoration:none;background-color:'.$mauform.'!important;margin-right:30px;text-align:center;border-radius:3px;color:#fff;padding:5px 10px;font-size:12px;font-weight:bold;margin-left:38%;margin-top:5px" target="_blank">Kích hoạt tài khoản</a></div>
											</p>
											</td>
										</tr>
										<tr>
											<td>&nbsp;
												<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;border:1px '.$mauform.' dashed;padding:10px;list-style-type:none">Bạn cần được hỗ trợ ngay? Chỉ cần gửi mail về <a href="mailto:'.$emailcongty.'" style="color:'.$mauform.';text-decoration:none" target="_blank"> <strong>'.$emailcongty.'</strong> </a>, hoặc gọi về hotline <strong style="color:'.$mauform.'">'.$hotlinecongty.'</strong> '.$thoitranglamviec.'. '.$websitecongty.' luôn sẵn sàng hỗ trợ bạn bất kì lúc nào.</p>
											</td>
										</tr>
										<tr>
											<td>&nbsp;
											<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;line-height:18px;color:#444;font-weight:bold">Một lần nữa '.$websitecongty.' cảm ơn quý khách.</p>
											<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;text-align:right"><strong><a href="'.$trangchu.'" style="color:'.$mauform.';text-decoration:none;font-size:14px" target="_blank">'.$tencongty.'</a> </strong></p>
											</td>
										</tr>
									</tbody>
								</table>
								</td>
							</tr>
						</tbody>
					</table>
					</td>
				</tr>
				<tr>
					<td align="center">
					<table width="600">
						<tbody>
							<tr>
								<td>
								<p align="left" style="font-family:Arial,Helvetica,sans-serif;font-size:11px;line-height:18px;color:#4b8da5;padding:10px 0;margin:0px;font-weight:normal">Quý khách nhận được email này vì đã đăng ký tại '.$websitecongty.'.<br>
								Để chắc chắn luôn nhận được email thông báo, phản hồi từ '.$websitecongty.', quý khách vui lòng thêm địa chỉ <strong><a href="mailto:'.$emailhosting.'" target="_blank">'.$emailhosting.'</a></strong> vào số địa chỉ (Address Book, Contacts) của hộp email.<br>
								<b>Địa chỉ:</b> '.$diachicongty.'</p>
								</td>
							</tr>
						</tbody>
					</table>
					</td>
				</tr>
			</tbody>
		</table>';

		/* Send email admin */
		$arrayEmail = array(
			"dataEmail" => array(
				"name" => $row['username'],
				"email" => $row['email']
			)
		);
		$subject = "Thư kích hoạt tài khoản thành viên từ ".$setting['ten'.$lang];
		$message = $noidung;

		if(!sendEmail("customer", $arrayEmail, $subject, $message, $file)) transfer("Có lỗi xảy ra trong quá trình kích hoạt tài khoản. Vui lòng liên hệ với chúng tôi.",$config_base."lien-he",0);
	}

	function doimatkhau_user()
	{
		global $d, $setting, $login_name, $config_base, $lang;

		$username = htmlspecialchars($_POST['username']);
		$email = htmlspecialchars($_POST['email']);
		$newpass = substr(md5(rand(0,999)*time()), 15, 6);
		$newpassMD5 = md5($newpass);

		if(!$username) transfer("Chưa nhập tên tài khoản", $config_base."account/quen-mat-khau",0);
		if(!$email) transfer("Chưa nhập email đăng ký tài khoản", $config_base."account/quen-mat-khau",0);

		/* Kiểm tra username và email */
		$row = $d->rawQueryOne("select id from #_user where username = ? and email = ?",array($username,$email));
		if(!$row['id']) transfer("Tên đăng nhập và email không tồn tại", $config_base."account/quen-mat-khau",0);

		/* Cập nhật mật khẩu mới */
		$data['password'] = $newpassMD5;
		$d->where('username', $username);
		$d->where('email', $email);
		$d->update('user',$data);

		/* Lấy thông tin người dùng */
		$row = $d->rawQueryOne("select id, username, password, ten, email, dienthoai, diachi from #_user where username = ?",array($username));

		// Cấu hình chung gửi email
		include_once LIBRARIES."mailsetting.php";

		// Gán giá trị cho biến gửi email
		$iduser = $row['id'];
		$tendangnhap = $row['username'];
		$matkhau = $row['password'];
		$tennguoidung = $row['ten'];
		$emailnguoidung = $row['email'];
		$dienthoainguoidung = $row['dienthoai'];
		$diachinguoidung = $row['diachi'];

	    // Thông tin đăng ký
	    $thongtindangky='<td style="padding:3px 9px 9px 0px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top"><span style="text-transform:normal">Username: '.$tendangnhap.'</span><br>Mật khẩu: *******'.substr($matkhau,-3).'</td><td style="padding:3px 0px 9px 9px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">';
	    if($tennguoidung)
	    {
	    	$thongtindangky.='<span style="text-transform:capitalize">'.$tennguoidung.'</span><br>';
	    }

	    if($emailnguoidung)
	    {
	    	$thongtindangky.='<a href="mailto:'.$emailnguoidung.'" target="_blank">'.$emailnguoidung.'</a><br>';
	    }

	    if($diachinguoidung)
	    {
	    	$thongtindangky.=$diachinguoidung.'<br>';
	    }

	    if($dienthoainguoidung)
	    {
	    	$thongtindangky.='Tel: '.$dienthoainguoidung.'</td>';
	    }

	    $noidung='
		<table align="center" bgcolor="#dcf0f8" border="0" cellpadding="0" cellspacing="0" style="margin:0;padding:0;background-color:#f2f2f2;width:100%!important;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px" width="100%">
			<tbody>
				<tr>
					<td align="center" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">
						<table border="0" cellpadding="0" cellspacing="0" style="margin-top:15px" width="600">
							<tbody>
								<tr>
									<td align="center" id="m_-6357629121201466163headerImage" valign="bottom">
										<table cellpadding="0" cellspacing="0" style="border-bottom:3px solid '.$mauform.';padding-bottom:10px;background-color:#fff" width="100%">
											<tbody>
												<tr>
													<td bgcolor="#FFFFFF" style="padding:0" valign="top" width="100%">
														<div style="color:#fff;background-color:f2f2f2;font-size:11px">&nbsp;</div>
														<table style="width:100%;">
															<tbody>
																<tr>
																	<td>
																		<a href="'.$trangchu.'" style="border:medium none;text-decoration:none;color:#007ed3;margin:0px 0px 0px 20px" target="_blank">'.$logo.'</a>
																	</td>
																	<td style="padding:15px 20px 0 0;text-align:right">'.$mangxahoi.'</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr style="background:#fff">
									<td align="left" height="auto" style="padding:15px" width="600">
										<table>
											<tbody>
												<tr>
													<td>
														<h1 style="font-size:17px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0">Kính chào Quý khách</h1>
														<p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">Yêu cầu cung cấp lại mật khẩu của quý khách đã được tiếp nhận và đang trong quá trình xử lý. Quý khách vui lòng xác nhận vào đường dẫn phía dưới để được cấp mấtu khẩu mới.</p>
														<h3 style="font-size:13px;font-weight:bold;color:'.$mauform.';text-transform:uppercase;margin:20px 0 0 0;padding: 0 0 5px;border-bottom:1px solid #ddd">Thông tin tài khoản <span style="font-size:12px;color:#777;text-transform:none;font-weight:normal">(Ngày '.date('d',$ngaygui).' tháng '.date('m',$ngaygui).' năm '.date('Y H:i:s',$ngaygui).')</span></h3>
													</td>
												</tr>
											<tr>
											<td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
											<table border="0" cellpadding="0" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th align="left" style="padding:6px 9px 0px 0px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold" width="50%">Thông tin tài khoản</th>
														<th align="left" style="padding:6px 0px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold" width="50%">Thông tin người dùng</th>
													</tr>
												</thead>
												<tbody>
													<tr>'.$thongtindangky.'</tr>
												</tbody>
											</table>
											</td>
										</tr>
										<tr>
											<td>
											<p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><i>Lưu ý: Quý khách vui lòng thay đổi mật khẩu ngay khi đăng nhập bằng mật khẩu mới bên dưới.</i>
											<div style="margin:auto"><p style="display:inline-block;text-decoration:none;background-color:'.$mauform.'!important;margin-right:30px;text-align:center;border-radius:3px;color:#fff;padding:5px 10px;font-size:12px;font-weight:bold;margin-left:33%;margin-top:5px" target="_blank">Mật khẩu mới: '.$newpass.'</p></div>
											</p>
											</td>
										</tr>
										<tr>
											<td>&nbsp;
												<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;border:1px '.$mauform.' dashed;padding:10px;list-style-type:none">Bạn cần được hỗ trợ ngay? Chỉ cần gửi mail về <a href="mailto:'.$emailcongty.'" style="color:'.$mauform.';text-decoration:none" target="_blank"> <strong>'.$emailcongty.'</strong> </a>, hoặc gọi về hotline <strong style="color:'.$mauform.'">'.$hotlinecongty.'</strong> '.$thoitranglamviec.'. '.$websitecongty.' luôn sẵn sàng hỗ trợ bạn bất kì lúc nào.</p>
											</td>
										</tr>
										<tr>
											<td>&nbsp;
											<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;line-height:18px;color:#444;font-weight:bold">Một lần nữa '.$websitecongty.' cảm ơn quý khách.</p>
											<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;text-align:right"><strong><a href="'.$trangchu.'" style="color:'.$mauform.';text-decoration:none;font-size:14px" target="_blank">'.$tencongty.'</a> </strong></p>
											</td>
										</tr>
									</tbody>
								</table>
								</td>
							</tr>
						</tbody>
					</table>
					</td>
				</tr>
				<tr>
					<td align="center">
					<table width="600">
						<tbody>
							<tr>
								<td>
								<p align="left" style="font-family:Arial,Helvetica,sans-serif;font-size:11px;line-height:18px;color:#4b8da5;padding:10px 0;margin:0px;font-weight:normal">Quý khách nhận được email này vì đã liên hệ tại '.$websitecongty.'.<br>
								Để chắc chắn luôn nhận được email thông báo, phản hồi từ '.$websitecongty.', quý khách vui lòng thêm địa chỉ <strong><a href="mailto:'.$emailhosting.'" target="_blank">'.$emailhosting.'</a></strong> vào số địa chỉ (Address Book, Contacts) của hộp email.<br>
								<b>Địa chỉ:</b> '.$diachicongty.'</p>
								</td>
							</tr>
						</tbody>
					</table>
					</td>
				</tr>
			</tbody>
		</table>';

		/* Send email admin */
		$arrayEmail = array(
			"dataEmail" => array(
				"name" => $tennguoidung,
				"email" => $email
			)
		);
		$subject = "Thư cấp lại mật khẩu từ ".$setting['ten'.$lang];
		$message = $noidung;
		
		if(sendEmail("customer", $arrayEmail, $subject, $message, $file))
		{
			if(isset($_SESSION[$login_name]) and isset($_SESSION[$login_name][$login_name]))
			{
				$_SESSION[$login_name][$login_name] = false;
				unset($_SESSION[$login_name]);
			}
			if(isset($_COOKIE['iduser']))
			{
				setcookie('iduser',"",-1,'/');
			}
			transfer("Cấp lại mật khẩu thành công. Vui lòng kiểm tra email: ".$email, $config_base);
		}
		else
		{
			transfer("Có lỗi xảy ra trong quá trình cấp lại mật khẩu. Vui lòng liện hệ với chúng tôi.", $config_base."account/quen-mat-khau",0);
		}
	}

	function logout()
	{
		global $d, $login_name, $config_base;

		if(isset($_SESSION[$login_name]))
		{
			$_SESSION[$login_name][$login_name] = false;
			unset($_SESSION[$login_name]);
		}
		
		if(isset($_COOKIE['iduser']))
		{
			setcookie('iduser',"",-1,'/');
		}

		redirect($config_base);
	}
?>