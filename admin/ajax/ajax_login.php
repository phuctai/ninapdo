<?php
	session_start();
	@define('_LIB','../../libraries/');

    include_once _LIB."config.php";
    include_once _LIB."PDODb.php";
    $d = new PDODb($config['database']);
    include_once _LIB."functions.php";

    $username = strtolower(htmlspecialchars($_POST['username']));
	$password = htmlspecialchars($_POST['password']);
	$error = "";
	$success = "";
	$login_failed = false;
	$login_name = $config_base;

    /* Kiểm tra đăng nhập tài khoản sai theo số lần */
	$ip = getRealIPAddress();
	$row = $d->rawQuery("select id, login_ip, login_attempts, attempt_time, locked_time from #_user_limit WHERE login_ip = ? order by id desc limit 1",array($ip));

	if(count($row)==1)
	{
		$id_login = $row[0]['id'];
		$time_now = time();
		if($row[0]['locked_time']>0)
		{
			$locked_time = $row[0]['locked_time'];
			$delay_time = $config['login']['delay'];
			$interval = $time_now  - $locked_time;

			if($interval <= $delay_time*60)
			{
				$time_remain = $delay_time*60 - $interval;
				$error = "Xin lỗi..! Vui lòng thử lại sau ". round($time_remain/60)." phút..!";
			}
			else
			{
				$d->rawQuery("update #_user_limit set login_attempts = 0, attempt_time = ?, locked_time = 0 where id = ?",array($time_now,$id_login));
			}
		}
	}

	/* Còn số lần đăng nhập */
	if($error=='')
	{
		/* Kiểm tra thông tin đăng nhập */
		if($username == '' && $password == '')
		{
			$error = "Chưa nhập tên đăng nhập và mật khẩu";
		}
		else if($username == '')
		{
			$error = "Chưa nhập tên đăng nhập";
		}
		else if($password == '')
		{
			$error = "Chưa nhập mật khẩu";
		}
		else
		{
			/* Kiểm tra đăng nhập */
			$row = $d->rawQueryOne("select * from #_user where username = ? and hienthi>0",array($username));

			if($row['id'])
			{
				if(($row['password'] == encrypt_password($config['website']['secret'],$password,$config['website']['salt'])) && ($row['role'] == 3))
				{
					$timenow = time();
					$id_user = $row['id'];
					$ip= getRealIPAddress();
					$token = md5(time());
					$user_agent = $_SERVER['HTTP_USER_AGENT'];
					$sessionhash = md5(sha1($row['password'].$row['username']));

					/* Ghi log truy cập thành công */				
					$d->rawQuery("insert into #_user_log (id_user, ip, timelog, user_agent) values (?,?,?,?)",array($id_user,$ip,$timenow,$user_agent));

					/* Tạo log và login session */				
					$d->rawQuery("update #_user set login_session = ?, lastlogin = ?, user_token = ? where id = ?",array($sessionhash,$timenow,$token,$id_user));

					/* Khởi tạo Session để kiểm tra số lần đăng nhập */
					$d->rawQuery("update #_user set login_session = ?, lastlogin = ? where id = ?",array($sessionhash,$timenow,$id_user));

					/* Reset số lần đăng nhập và thời gian đăng nhập */
					$limitlogin = $d->rawQuery("select id, login_ip, login_attempts, attempt_time, locked_time from #_user_limit where login_ip = ? order by id desc",array($ip));

					if(count($limitlogin)==1)
					{
				        $id_login = $limitlogin[0]['id'];
						$d->rawQuery("update #_user_limit set login_attempts = 0, locked_time = 0 where id = ?",array($id_login));
				   	}

				   	/* Tạo Session login */
					$_SESSION[$login_name] = true;
					$_SESSION['login']['username'] = $row['username'];
					$_SESSION['login']['id'] = $row['id'];
					$_SESSION['login']['quyen'] = $row['quyen'];
					$_SESSION['login']['token'] = $sessionhash;
					$_SESSION['login']['password'] = $row['password'];
					$_SESSION['isLoggedIn'] = true;
					$_SESSION['login_session'] = $sessionhash;
					$_SESSION['login_token'] = $token;
					$_SESSION['login']['idUser'] = $row['id'];

					/* Cập nhật quyền của user đăng nhập */
					$quyen = $_SESSION['login']['token'];
					$d->rawQuery("update #_user set quyen = ? where id = ?",array($quyen,$row['id']));
					
					/* Lấy quyền của user đăng nhập */
					$id_nhomquyen = $row['id_nhomquyen'];
					$nhomquyen = $d->rawQueryOne("select id from #_permission_group where id = ? and hienthi>0",array($id_nhomquyen));

					if($nhomquyen['id'])
					{
						$manhomquyen = $nhomquyen['id'];
						$quyenuser = $d->rawQuery("select quyen from #_permission where ma_nhom_quyen = ?",array($manhomquyen));

						if(count($quyenuser))
						{
							foreach ($quyenuser as $value) $_SESSION['list_quyen'][] = $value['quyen'];
						}
						else
						{
							$_SESSION['list_quyen'][]='';
						}
					}
					else
					{
						$_SESSION['list_quyen'][]='';
					}

					$success = "Đăng nhập thành công";
				}
				else
				{
					$login_failed = true;
					$error = "Mật khẩu không chính xác";
				}
			}
			else
			{
				$error = "Tên đăng nhập không tồn tại";
			}

			/* Xử lý khi đăng nhập thất bại */
			if($login_failed)
			{
				$ip = getRealIPAddress();
				$row = $d->rawQuery("select id,login_ip,login_attempts,attempt_time,locked_time from #_user_limit where login_ip = ? order by id desc limit 1",array($ip));

				if(count($row)==1)
				{
					$id_login = $row[0]['id'];
					$attempt = $row[0]['login_attempts'];
					$noofattmpt = $config['login']['attempt'];
					if($attempt<$noofattmpt)
					{
						$attempt = $attempt +1;

						/* Cập nhật số lần đăng nhập sai */
						$d->rawQuery("update #_user_limit set login_attempts = ? where id = ?",array($attempt,$id_login));
						
						$no_ofattmpt = $noofattmpt + 1;
						$remain_attempt = $no_ofattmpt - $attempt;
						$error = 'Sai thông tin. Còn '.$remain_attempt.' lần thử';
					}
					else
					{
						if($row[0]['locked_time']==0)
						{
							$attempt = $attempt + 1;
							$timenow = time();

							/* Cập nhật số lần đăng nhập sai */
							$d->rawQuery("update #_user_limit set login_attempts = ?, locked_time = ? where id = ?",array($attempt,$timenow,$id_login));
						}
						else
						{
							$attempt = $attempt + 1;

							/* Cập nhật số lần đăng nhập sai */
							$d->rawQuery("update #_user_limit set login_attempts = ? where id = ?",array($attempt,$id_login));
						}
						$delay_time = $config['login']['delay'];
						$error = "Bạn đã hết lần thử. Vui lòng thử lại sau ".$delay_time." phút";
					}
				}
				else
				{
					$timenow = time();

					/* Cập nhật thông tin đăng nhập sai */
					$d->rawQuery("insert into #_user_limit (login_ip, login_attempts, attempt_time, locked_time) values (?,?,?,?)",array($ip,1,$timenow,0));

					$remain_attempt = $config['login']['attempt'];
					$error = 'Sai thông tin. Còn '.$remain_attempt.' lần thử';
				}
			}
		}
	}

	$data = array('success' => $success, 'error' => $error);
	echo json_encode($data);
?>