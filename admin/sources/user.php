<?php
if(!defined('SOURCES')) die("Error");

$act = htmlspecialchars($_REQUEST['act']);
$curPage = (isset($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;

switch($act)
{
	/* Login - logout - edit admin */
	case "login":
		if(isset($_SESSION[$login_name]) && ($_SESSION[$login_name] == true))
		{
			$func->transfer("Trang không tồn tại", "index.php",0);
		}
		else
		{
			$template = "user/login";
		}
		break;
	case "logout":
		logout();
		break;
	case "admin_edit":
		edit();
		$template = "user/admin/admin_add";
		break;

	/* Info admin */
	case "man_admin":
		/* Kiểm tra active user admin */
		if(!$config['user']['admin']) $func->transfer("Trang không tồn tại", "index.php",0);
		if($func->check_access3())
		{
			$func->transfer("Bạn không có quyền vào trang này", "index.php",0);
			exit;
		}
		get_items_admin();
		$template = "user/man_admin/items";
		break;
	case "add_admin":
		/* Kiểm tra active user admin */
		if(!$config['user']['admin']) $func->transfer("Trang không tồn tại", "index.php",0);
		if($func->check_access3())
		{
			$func->transfer("Bạn không có quyền vào trang này", "index.php",0);
			exit;
		}
		$template = "user/man_admin/item_add";
		break;
	case "edit_admin":
		/* Kiểm tra active user admin */
		if(!$config['user']['admin']) $func->transfer("Trang không tồn tại", "index.php",0);
		if($func->check_access3())
		{
			$func->transfer("Bạn không có quyền vào trang này", "index.php",0);
			exit;
		}
		get_item_admin();
		$template = "user/man_admin/item_add";
		break;
	case "save_admin":
		/* Kiểm tra active user admin */
		if(!$config['user']['admin']) $func->transfer("Trang không tồn tại", "index.php",0);
		save_item_admin();
		break;
	case "delete_admin":
		/* Kiểm tra active user admin */
		if(!$config['user']['admin']) $func->transfer("Trang không tồn tại", "index.php",0);
		if($func->check_access3())
		{
			$func->transfer("Bạn không có quyền vào trang này", "index.php",0);
			exit;
		}
		delete_item_admin();
		break;

	/* Info visitor */
	case "man":
		/* Kiểm tra active user visitor */
		if(!$config['user']['visitor']) $func->transfer("Trang không tồn tại", "index.php",0);
		if($func->check_access3())
		{
			$func->transfer("Bạn không có quyền vào trang này", "index.php",0);
			exit;
		}
		get_items();
		$template = "user/man/items";
		break;
	case "add":
		/* Kiểm tra active user visitor */
		if(!$config['user']['visitor']) $func->transfer("Trang không tồn tại", "index.php",0);
		if($func->check_access3())
		{
			$func->transfer("Bạn không có quyền vào trang này", "index.php",0);
			exit;
		}
		$template = "user/man/item_add";
		break;
	case "edit":
		/* Kiểm tra active user visitor */
		if(!$config['user']['visitor']) $func->transfer("Trang không tồn tại", "index.php",0);
		if($func->check_access3())
		{
			$func->transfer("Bạn không có quyền vào trang này", "index.php",0);
			exit;
		}
		get_item();
		$template = "user/man/item_add";
		break;
	case "save":
		/* Kiểm tra active user visitor */
		if(!$config['user']['visitor']) $func->transfer("Trang không tồn tại", "index.php",0);
		save_item();
		break;
	case "delete":
		/* Kiểm tra active user visitor */
		if(!$config['user']['visitor']) $func->transfer("Trang không tồn tại", "index.php",0);
		if($func->check_access3())
		{
			$func->transfer("Bạn không có quyền vào trang này", "index.php",0);
			exit;
		}
		delete_item();
		break;
	
	/* Phân quyền */
	case "permission_group":
		/* Kiểm tra active phân quyền */
		if(!$config['permission']) $func->transfer("Trang không tồn tại", "index.php",0);
		if($func->check_access3())
		{
			$func->transfer("Bạn không có quyền vào trang này", "index.php",0);
			exit;
		}
		permission_groups();
		$template = "user/admin/permission_groups";
		break;
	case "add_permission_group":
		/* Kiểm tra active phân quyền */
		if(!$config['permission']) $func->transfer("Trang không tồn tại", "index.php",0);
		if($func->check_access3())
		{
			$func->transfer("Bạn không có quyền vào trang này", "index.php",0);
			exit;
		}
		$template = "user/admin/permission_group";
		break;
	case "edit_permission_group":
		/* Kiểm tra active phân quyền */
		if(!$config['permission']) $func->transfer("Trang không tồn tại", "index.php",0);
		if($func->check_access3())
		{
			$func->transfer("Bạn không có quyền vào trang này", "index.php",0);
			exit;
		}
		permission_group();
		$template = "user/admin/permission_group";
		break;
	case "save_permission_group":
		/* Kiểm tra active phân quyền */
		if(!$config['permission']) $func->transfer("Trang không tồn tại", "index.php",0);
		if($func->check_access3())
		{
			$func->transfer("Bạn không có quyền vào trang này", "index.php",0);
			exit;
		}
		save_permission_group();
		break;
	case "delete_permission_group":
		/* Kiểm tra active phân quyền */
		if(!$config['permission']) $func->transfer("Trang không tồn tại", "index.php",0);
		if($func->check_access3())
		{
			$func->transfer("Bạn không có quyền vào trang này", "index.php",0);
			exit;
		}
		delete_permission_group();
		break;

	default:
		$template = "404";
}

/* Get phân quyền */
function permission_groups()
{
	global $d, $func, $curPage, $items, $paging;

	$where = "";
	
	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and ten LIKE '%$keyword%'";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_permission_group where id<>0 $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql);
	$sqlNum = "select count(*) as 'num' from #_permission_group where id<>0 $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum);
	$total = $count['num'];
	$url = "index.php?com=user&act=permission_group";
	$paging = $func->pagination($total,$per_page,$curPage,$url);
}

/* Edit phân quyền */
function permission_group()
{
	global $d, $func, $curPage, $item, $ds_quyen;

	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		/* Lấy nhóm quyền */
		$item = $d->rawQueryOne("select * from #_permission_group where id = ?",array($id));

		if(!isset($item['id'])) $func->transfer("Nhóm quyền này không tồn tại", "index.php?com=user&act=permission_group&p=".$curPage,0);

		/* Lấy quyền */
		$arr = $d->rawQuery("select ma,quyen from #_permission where ma_nhom_quyen = ?",array($id));

		if(!empty($arr)) foreach($arr as $quyen) $ds_quyen[] = $quyen['quyen'];
		else $ds_quyen[] = '';
	}
	else
	{
		$func->transfer("Nhóm quyền này không tồn tại", "index.php?com=user&act=permission_group&p=".$curPage,0);
	}
}

/* Save phân quyền */
function save_permission_group()
{
	global $d, $func, $curPage;

	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	$dataQuyen = $_POST['dataQuyen'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	$data['hienthi'] = ($data['hienthi']) ? 1 : 0;

	if($id)
	{
		/* Kiểm tra nhóm quyền */
		$row = $d->rawQueryOne("select id from #_permission_group where id = ?",array($id));
		if(!$row['id']) $func->transfer("Nhóm quyền này không tồn tại", "index.php?com=user&act=permission_group&p=".$curPage,0);

		/* Xử lý tham số bắt buộc */
		if(empty($_POST['dataQuyen'])) $func->transfer("Vui lòng chọn quyền cho nhóm này", "index.php?com=user&act=edit_permission_group&id=".$id."&p=".$curPage,0);

		/* Cập nhật thông tin nhóm quyền */
		$data['ngaysua'] = time();
		$d->where('id',$id);
		$d->update('permission_group',$data);

		/* Xóa hết các quyên hiện tại */
		$d->rawQuery("delete from #_permission where ma_nhom_quyen = ?",array($id));

		/* Thêm các quyền mới vào */
		for($i=0;$i<count($dataQuyen);$i++)
		{
			$data_permission['ma_nhom_quyen'] = $id;
			$data_permission['quyen'] = $dataQuyen[$i];
			$d->insert('permission',$data_permission);
		}
		$func->transfer("Cập nhật nhóm quyền thành công", "index.php?com=user&act=permission_group&p=".$curPage);
	}
	else
	{
		/* Xử lý tham số bắt buộc */
		if(empty($_POST['dataQuyen'])) $func->transfer("Vui lòng chọn quyền cho nhóm này", "index.php?com=user&act=add_permission_group&p=".$curPage,0);

		/* Lưu thông tin nhóm quyền */
		$data['ngaytao'] = time();
		$d->insert('permission_group',$data);
		
		/* Lưu quyền cho nhóm quyền */
		$id_nhomquyen = $d->getLastInsertId();
		for($i=0;$i<count($dataQuyen);$i++)
		{
			$data_permission['ma_nhom_quyen'] = $id_nhomquyen;
			$data_permission['quyen'] = $dataQuyen[$i];
			$d->insert('permission',$data_permission);
		}
		$func->transfer("Tạo nhóm quyền thành công", "index.php?com=user&act=permission_group&p=".$curPage);
	}
}

/* Delete phân quyền */
function delete_permission_group()
{
	global $d, $func, $curPage;

	$id = htmlspecialchars($_GET['id']);

	if($id)
	{	
		$row = $d->rawQuery("select * from #_permission_group where id = ?",array($id));

		if(count($row))
		{
			$d->rawQuery("delete from #_permission_group where id = ?",array($id));
			$row = $d->rawQuery("select * from #_permission where ma_nhom_quyen = ?",array($id));
			if(count($row)) $d->rawQuery("delete from #_permission where ma_nhom_quyen = ?",array($id));
			$row = $d->rawQuery("select * from #_user where id_nhomquyen = ?",array($id));

			if(count($row))
			{
				$data_user['id_nhomquyen'] = 0;
				$d->where('id_nhomquyen',$id);
				$d->update('user',$data_user);
			}
			$func->transfer("Xóa dữ liệu thành công", "index.php?com=user&act=permission_group&p=".$curPage);
		}
		else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=user&act=permission_group&p=".$curPage,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);
			$row = $d->rawQuery("select * from #_permission_group where id = ?",array($id));

			if(count($row))
			{
				$d->rawQuery("delete from #_permission_group where id = ?",array($id));
				$row = $d->rawQuery("select * from #_permission where ma_nhom_quyen = ?",array($id));
				if(count($row)) $d->rawQuery("delete from #_permission where ma_nhom_quyen = ?",array($id));
				$row = $d->rawQuery("select * from #_user where id_nhomquyen = ?",array($id));

				if(count($row))
				{
					$data_user['id_nhomquyen'] = 0;
					$d->where('id_nhomquyen',$id);
					$d->update('user',$data_user);
				}
			}
		}

		$func->transfer("Xóa dữ liệu thành công", "index.php?com=user&act=permission_group&p=".$curPage);
	} 
	else $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=permission_group&p=".$curPage,0);
}

/* Get admin */
function get_items_admin()
{
	global $d, $func, $curPage, $items, $paging, $config;

	$where = "";

	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and (username LIKE '%$keyword%' or ten LIKE '%$keyword%')";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_user where id <> 1 and (username <> 'coder') $where order by username desc $limit";
	$items = $d->rawQuery($sql);
	$sqlNum = "select count(*) as 'num' from #_user where id <> 1 and (username <> 'coder') $where order by username desc";
	$count = $d->rawQueryOne($sqlNum);
	$total = $count['num'];
	$url = "index.php?com=user&act=man_admin";
	$paging = $func->pagination($total,$per_page,$curPage,$url);
}

/* Edit admin */
function get_item_admin()
{
	global $d, $func, $curPage, $item;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man_admin&p=".$curPage,0);
	
	$item = $d->rawQueryOne("select * from #_user where id = ?",array($id));

	if(!$item['id']) $func->transfer("Dữ liệu không có thực", "index.php?com=user&act=man_admin&p=".$curPage,0);
}

/* Save admin */
function save_item_admin()
{
	global $d, $func, $curPage, $config;
	
	if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man_admin&p=".$curPage,0);
	
	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	$data['ngaysinh'] = strtotime(str_replace("/","-",$data['ngaysinh']));
	$data['hienthi'] = ($data['hienthi']) ? 1 : 0;

	if($id)
	{
		$row = $d->rawQueryOne("select id from #_user where id = ?",array($id));
		if($row['id']) $func->transfer("Bạn không có quyền trên tài khoản này. Mọi thắc mắc xin liên hệ quản trị website", "index.php?com=user&act=man_admin&p=".$curPage,0);
		
		if($data['password'] != '')
		{
			$password = $data['password'];
			$confirm_password = $_POST['confirm_password'];

			if($confirm_password=='')
			{
				$func->transfer("Chưa xác nhận mật khẩu mới","index.php?com=user&act=edit_admin&id=".$id."&p=".$curPage,0);
			}

			if($password!=$confirm_password)
			{
				$func->transfer("Xác nhận mật khẩu mới không chính xác","index.php?com=user&act=edit_admin&id=".$id."&p=".$curPage,0);
			}

			$data['password'] = md5($config['website']['secret'].$password.$config['website']['salt']);
		}
		else unset($data['password']);
		
		$d->where('id', $id);
		if($d->update('user',$data)) $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=user&act=man_admin&p=".$curPage);
		else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=user&act=man_admin&p=".$curPage,0);
	}
	else
	{
		$username = $data['username'];
		$row = $d->rawQueryOne("select id from #_user where username = ?",array($username));
		if($row['id']) $func->transfer("Tên đăng nhập nay đã tồn tại. Xin chọn tên khác", "index.php?com=user&act=man_admin&p=".$curPage,0);
		
		if($data['password']=="") $func->transfer("Chưa nhập mật khẩu", "index.php?com=user&act=add_admin&p=".$curPage,0);
		$data['password'] = md5($config['website']['secret'].$data['password'].$config['website']['salt']);
		
		if($d->insert('user',$data)) $func->transfer("Lưu dữ liệu thành công", "index.php?com=user&act=man_admin&p=".$curPage);
		else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=user&act=man_admin",0);
	}
}

/* Delete admin */
function delete_item_admin()
{
	global $d, $func, $curPage;
	
	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		$d->rawQuery("delete from #_user where id = ?",array($id));
		$func->transfer("Xóa dữ liệu thành công", "index.php?com=user&act=man_admin&p=".$curPage);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);
			$d->rawQuery("delete from #_user where id = ?",array($id));
		}

		$func->transfer("Xóa dữ liệu thành công","index.php?com=user&act=man_admin&p=".$curPage);
	}
	$func->transfer("Không nhận được dữ liệu","index.php?com=user&act=man_admin&p=".$curPage,0);
}

/* Get visitor */
function get_items()
{
	global $d, $func, $curPage, $items, $paging, $config;

	$where = "";

	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and (username LIKE '%$keyword%' or ten LIKE '%$keyword%')";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_member where id <> 0 $where order by username desc $limit";
	$items = $d->rawQuery($sql);
	$sqlNum = "select count(*) as 'num' from #_member where id <> 0 $where order by username desc";
	$count = $d->rawQueryOne($sqlNum);
	$total = $count['num'];
	$url = "index.php?com=user&act=man";
	$paging = $func->pagination($total,$per_page,$curPage,$url);
}

/* Edit visitor */
function get_item()
{
	global $d, $func, $curPage, $item;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man&p=".$curPage,0);
	
	$item = $d->rawQueryOne("select * from #_member where id = ?",array($id));

	if(!$item['id']) $func->transfer("Dữ liệu không có thực", "index.php?com=user&act=man&p=".$curPage,0);
}

/* Save visitor */
function save_item()
{
	global $d, $func, $curPage;
	
	if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man&p=".$curPage,0);

	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	$data['ngaysinh'] = strtotime(str_replace("/","-",$data['ngaysinh']));
	$data['hienthi'] = ($data['hienthi']) ? 1 : 0;

	if($id)
	{
		$row = $d->rawQueryOne("select id from #_member where id = ?",array($id));
		if($row['id']) $func->transfer("Bạn không có quyền trên tài khoản này. Mọi thắc mắc xin liên hệ quản trị website", "index.php?com=user&act=man&p=".$curPage,0);
		
		if($data['password'] != '')
        {
            $password = $data['password'];
            $confirm_password = $_POST['confirm_password'];

            if($confirm_password == '')
            {
                $func->transfer("Chưa xác nhận mật khẩu mới","index.php?com=user&act=edit&id=".$id."&p=".$curPage,0);
            }

            if($password != $confirm_password)
            {
                $func->transfer("Xác nhận mật khẩu mới không chính xác","index.php?com=user&act=edit&id=".$id."&p=".$curPage,0);
            }

            $data['password'] = md5($password);
        }
        else unset($data['password']);
		
		$d->where('id', $id);
		if($d->update('member',$data)) $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=user&act=man&p=".$curPage);
		else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=user&act=man&p=".$curPage,0);
	}
	else
	{
		$username = $data['username'];
		$row = $d->rawQueryOne("select id from #_user where username = ?",array($username));
		if($row['id']) $func->transfer("Tên đăng nhập nay đã tồn tại. Xin chọn tên khác", "index.php?com=user&act=edit&id=".$id."&p=".$curPage,0);
		
		if($data['password'] == "") $func->transfer("Chưa nhập mật khẩu", "index.php?com=user&act=add&p=".$curPage,0);
		$data['password'] = md5($data['password']);
		
		if($d->insert('member',$data)) $func->transfer("Lưu dữ liệu thành công", "index.php?com=user&act=man&p=".$curPage);
		else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=user&act=man&p=".$curPage,0);
	}
}

/* Delete visitor */
function delete_item()
{
	global $d, $func, $curPage;
	
	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		$d->rawQuery("delete from #_member where id = ?",array($id));
		$func->transfer("Xóa dữ liệu thành công", "index.php?com=user&act=man&p=".$curPage);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);
			$d->rawQuery("delete from #_member where id = ?",array($id));
		}

		$func->transfer("Xóa dữ liệu thành công","index.php?com=user&act=man&p=".$curPage);
	}
	$func->transfer("Không nhận được dữ liệu","index.php?com=user&act=man&p=".$curPage,0);
}

/* Edit admin */
function edit()
{
	global $d, $func, $curPage, $item, $login_name, $config;
	
	if($_GET['changepass'] == 1) $changepass = 1;
	else $changepass = 0;

	if(!empty($_POST))
	{
		/* Post dữ liệu */
		$data = $_POST['data'];
		foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);

		if($changepass)
		{
			$old_pass = htmlspecialchars($_POST['old-password']);
			$new_pass = htmlspecialchars($_POST['new-password']);
			$renew_pass = htmlspecialchars($_POST['renew-password']);

			if($old_pass!='' || $new_pass!='' ||  $renew_pass!='')
			{
				if($old_pass=='') $func->transfer("Mật khẩu cũ chưa nhập","index.php?com=user&act=admin_edit&changepass=1",0);
				if($new_pass=='') $func->transfer("Mật khẩu mới chưa nhập","index.php?com=user&act=admin_edit&changepass=1",0);
				if($renew_pass=='') $func->transfer("Chưa xác nhận mật khẩu mới","index.php?com=user&act=admin_edit&changepass=1",0);

				/* Lấy dữ liệu */
				$row = $d->rawQueryOne("select id, password from #_user where username = ?",array($_SESSION['login']['username']));

				if($row['id'])
				{
					if($row['password'] != md5($config['website']['secret'].$old_pass.$config['website']['salt'])) $func->transfer("Mật khẩu không chính xác","index.php?com=user&act=admin_edit&changepass=1",0);
				}
				else
				{
					$func->transfer("Không nhận được dữ liệu","index.php?com=user&act=admin_edit&changepass=1",0);
				}

				if($new_pass!="")
				{
					if($new_pass=='123qwe' || $new_pass=='123456' || $new_pass=='ninaco') $func->transfer("Mật khẩu bạn đặt quá đơn giãn, xin vui lòng chọn mật khẩu khác","index.php?com=user&act=admin_edit&changepass=1",0);			
					$data['password'] = md5($config['website']['secret'].$new_pass.$config['website']['salt']);
					$flagchangepass = true;
				}
			}
			else
			{
				$func->transfer("Không nhận được dữ liệu","index.php?com=user&act=admin_edit&changepass=1",0);
			}
		}
		else
		{
			$username = $data['username'];
			$row = $d->rawQueryOne("select id from #_user where username <> ? and username = ?",array($_SESSION['login']['username'],$username));
			if($row['id']) $func->transfer("Tên đăng nhập này đã tồn tại","index.php?com=user&act=admin_edit",0);

			$data['ngaysinh'] = strtotime(str_replace("/","-",$data['ngaysinh']));
		}
		
		$d->where('username', $_SESSION['login']['username']);
		if($d->update('user',$data))
		{
			if($flagchangepass)
			{
				session_unset();
				$func->transfer("Cập nhật dữ liệu thành công","index.php");	
			}
			$func->transfer("Cập nhật dữ liệu thành công","index.php?com=user&act=admin_edit");
		}
		else
		{
			$func->transfer("Cập nhật dữ liệu bị lỗi","index.php?com=user&act=admin_edit");
		}
	}
	
	$item = $d->rawQueryOne("select * from #_user where username = ?",array($_SESSION['login']['username']));
}

/* Logout admin */
function logout()
{
	global $d, $func, $login_name;

	/* Hủy bỏ quyền */
	$data_capnhatquyen['quyen'] = '';
	$d->where('id',$_SESSION['login']['id']);
	$d->update('user',$data_capnhatquyen);

	/* Hủy bỏ login */
	$_SESSION[$login_name] = false;
	unset($_SESSION['login']);
	unset($_SESSION['list_quyen']);
	$func->redirect("index.php?com=user&act=login");
}
?>