<?php
	/* Kiểm tra 2 máy đăng nhập cùng 1 tài khoản */
	if(isset($_SESSION[$login_name]) || $_SESSION[$login_name]==true)
	{
		$id_user = (int)$_SESSION['login']['id'];
		$timenow = time();

		$row = $d->rawQueryOne("select username, password, lastlogin, user_token from #_user WHERE id = ?",array($id_user));

		$sessionhash = md5(sha1($row['password'].$row['username']));
		
		if($_SESSION['login_session']!=$sessionhash || ($timenow - $row['lastlogin'])>3600)
		{
			session_destroy();
			redirect("index.php?com=user&act=login");
		}

		if($_SESSION['login_token']!==$row['user_token']) $alertlogin = 'Có người đang đăng nhập tài khoản của bạn.';
		else $alertlogin ='';

		$token = md5(time());
		$_SESSION['login_token'] = $token;

		/* Cập nhật lại thời gian hoạt động và token */
		$d->rawQuery("update #_user set lastlogin = ?, user_token = ? where id = ?",array($timenow,$token,$id_user));
	}

	if($config['permission'] && isset($_SESSION[$login_name])) 
	{
		/* Kiểm tra phân quyền */
		if(check_access3())
		{
			$kiemtra = 1;
			if( $act != 'save' && 
				$act != 'save_list' && 
				$act != 'save_cat' && 
				$act != 'save_item' && 
				$act != 'save_sub' &&
				$act != 'save_brand' &&
				$act != 'save_mau' &&
				$act != 'save_size' &&
				$act != 'saveImages' &&
				$act != 'uploadExcel' &&
				$act != 'save_static' &&
				$act != 'save_photo')
			{
				if($com != 'user') 
				{
					if($com != '' && $com != 'index')
					{
						if($type != '')
							$quyen_user = $com.'_'.$act.'_'.$type;
						else
							$quyen_user = $com.'_'.$act;

						if($quyen_user == '_'){
							$quyen_user=='';
						}
						if(!in_array($quyen_user, $_SESSION['list_quyen']))
						{
							transfer("Bạn không có quyền vào khu vực này","index.php",0);
							exit;
						}
					}
				}
			}
		}
	}

	/* Kiểm tra có đăng nhập chưa */
	if(check_login()==false && $act!="login")
	{
		redirect("index.php?com=user&act=login");
	}

	switch($com)
	{
		case 'pushOnesignal':
			$source = "pushOnesignal";
			break;

		case 'product':
			$source = "product";
			break;

		case 'contact':
			$source = "contact";
			break;

		case 'coupon':
			$source = "coupon";
			break;

		case 'places':
			$source = "places";
			break;

		case 'tags':
			$source = "tags";
			break;

		case 'order':
			$source = "order";
			break;

		case 'excelAll':
			$source = "excelAll";
			break;

		case 'wordAll':
			$source = "wordAll";
			break;

		case 'excel':
			$source = "excel";
			break;

		case 'word':
			$source = "word";
			break;

		case 'import':
			$source = "import";
			break;

		case 'export':
			$source = "export";
			break;

		case 'tags':
			$source = "tags";
			break;

		case 'news':
			$source = "news";
			break;

		case 'static':
			$source = "static";
			break;

		case 'seopage':
			$source = "seopage";
			break;

		case 'newsletter':
			$source = "newsletter";
			break;

		case 'photo':
			$source = "photo";
			break;

		case 'setting':
			$source = "setting";
			break;

		case 'lang':
			$source = "lang";
			break;

		case 'user':
			$source = "user";
			break;

		case 'map':
			$source = "map";
			break;

		default:
			$source = "";
			$template = "index";
			break;
	}
	
	if((!isset($_SESSION[$login_name]) || $_SESSION[$login_name]==false) && $act!="login")
	{
		redirect("index.php?com=user&act=login");
	}
	
	if($source!="") include _SOURCE.$source.".php";
?>