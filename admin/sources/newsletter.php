<?php
if(!defined('_SOURCE')) die("Error");

$act = htmlspecialchars($_REQUEST['act']);
$type = htmlspecialchars($_REQUEST['type']);
$curPage = (isset($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;

/* Kiểm tra active newsletter */
$arrCheck = array();
foreach($config['newsletter'] as $k => $v) $arrCheck[] = $k;
if(!count($arrCheck) || !in_array($type,$arrCheck)) transfer("Trang không tồn tại", "index.php",0);

/* Send email */
if(isset($_POST["listemail"]))
{
	$file_name = upload_name($_FILES['file-taptin']["name"]);
	if($file = uploadImage("file-taptin", $config['newsletter'][$type]['file_type'], _upload_file,$file_name))
	{
		$data['taptin'] = $file;
	}

	// Gán giá trị cho biến gửi email
    $tieude = htmlspecialchars($_POST['tieude']);
    $noidungthongtin = htmlspecialchars_decode($_POST['noidung']);

	// Cấu hình chung gửi email
	include_once _LIB."mailsetting.php";

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
													<p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">Thông tin của quý khách đã được tiếp nhận. '.$websitecongty.' xin gửi các tin tức và thông báo mới nhất từ chúng tôi.</p>
													<h3 style="font-size:13px;font-weight:bold;color:'.$mauform.';text-transform:uppercase;margin:20px 0 0 0;padding: 0 0 5px;border-bottom:1px solid #ddd">'.$tieude.'</h3>
												</td>
											</tr>
										<tr>
									</tr>
									<tr>
										<td>
										<p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">'.$noidungthongtin.'</p>
										</td>
									</tr>
									<tr>
										<td>
											<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;border:1px '.$mauform.' dashed;padding:10px;margin-top:15px;list-style-type:none">Bạn cần được hỗ trợ ngay? Chỉ cần gửi mail về <a href="mailto:'.$emailcongty.'" style="color:'.$mauform.';text-decoration:none" target="_blank"> <strong>'.$emailcongty.'</strong> </a>, hoặc gọi về hotline <strong style="color:'.$mauform.'">'.$hotlinecongty.'</strong> '.$thoitranglamviec.'. '.$websitecongty.' luôn sẵn sàng hỗ trợ bạn bất kì lúc nào.</p>
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
	
	/* Send email */
	$arrayEmail = array();
	$listemail = explode(",",$_POST['listemail']);
	for($i=0;$i<count($listemail);$i++)
	{
		$id = htmlspecialchars($listemail[$i]);
		$row = $d->rawQueryOne("select id, email, ten from #_newsletter where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			$data = array();
			$data['name'] = $row['ten'];
			$data['email'] = $row['email'];
			$arrayEmail["dataEmail".$i] = $data;
		}
	}
	$subject = "Thư phản hồi từ ".$setting['tenvi'];
	$message = $noidung;
	$file = $data['taptin'];

	if(sendEmail("customer", $arrayEmail, $subject, $message, $file))
	{
		delete_file(_upload_file.$file);
		transfer("Email đã được gửi thành công.", "index.php?com=newsletter&act=man&type=".$type."&p=".$curPage);
	}
	else
	{
		delete_file(_upload_file.$file);
		transfer("Email gửi bị lỗi. Vui lòng thử lại sau", "index.php?com=newsletter&act=man&type=".$type."&p=".$curPage,0);
	}
}

switch($act)
{
	case "man":
		get_items();
		$template = "newsletter/man/items";
		break;

	case "add":
		$template = "newsletter/man/item_add";
		break;

	case "edit":
		get_item();
		$template = "newsletter/man/item_add";
		break;

	case "save":
		save_item();
		break;
		
	case "delete":
		delete_item();
		break;

	default:
		$template = "404";
}

/* Get newsletter */
function get_items()
{
	global $d, $curPage, $items, $paging, $type;

	$where = "";	
	
	if($_REQUEST['keyword'])
	{
		$keyword = htmlspecialchars($_REQUEST['keyword']);
		$where .= " and (ten LIKE '%$keyword%' or email LIKE '%$keyword%')";
	}

	$per_page = 10;
	$startpoint = ($curPage * $per_page) - $per_page;
	$limit = " limit ".$startpoint.",".$per_page;
	$sql = "select * from #_newsletter where type = ? $where order by stt,id desc $limit";
	$items = $d->rawQuery($sql,array($type));
	$sqlNum = "select count(*) as 'num' from #_newsletter where type = ? $where order by stt,id desc";
	$count = $d->rawQueryOne($sqlNum,array($type));
	$total = $count['num'];
	$url = "index.php?com=newsletter&act=man&type=".$type;
	$paging = pagination($total,$per_page,$curPage,$url);
}

/* Edit newsletter */
function get_item()
{
	global $d, $curPage, $item, $type;

	$id = htmlspecialchars($_GET['id']);

	if(!$id) transfer("Không nhận được dữ liệu", "index.php?com=newsletter&act=man&type=".$type."&p=".$curPage,0);
	
	$item = $d->rawQueryOne("select * from #_newsletter where id = ? and type = ?",array($id,$type));

	if(!$item['id']) transfer("Dữ liệu không có thực", "index.php?com=newsletter&act=man&type=".$type."&p=".$curPage,0);
}

/* Save newsletter */
function save_item()
{
	global $d, $curPage, $config, $type;

	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=newsletter&act=man&type=".$type."&p=".$curPage,0);

	$file_name = upload_name($_FILES['file-taptin']["name"]);
	$id = htmlspecialchars($_POST['id']);

	/* Post dữ liệu */
	$data = $_POST['data'];
	foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
	$data['hienthi'] = ($data['tinhtrang']) ? 1 : 0;
	$data['type'] = $type;

	if($id)
	{
		if($taptin = uploadImage("file-taptin", $config['newsletter'][$type]['file_type'],_upload_file,$file_name))
		{
			$data['taptin'] = $taptin;

			$row = $d->rawQueryOne("select id, taptin from #_newsletter where id = ? and type = ?",array($id,$type));

			if($row['id']) delete_file(_upload_file.$row['taptin']);
		}

		$data['ngaysua'] = time();
		
		$d->where('id', $id);
		$d->where('type', $type);
		if($d->update('newsletter',$data)) transfer("Cập nhật dữ liệu thành công", "index.php?com=newsletter&act=man&type=".$type."&p=".$curPage);
		else transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=newsletter&act=man&type=".$type."&p=".$curPage,0);
	}
	else
	{
		if($taptin = uploadImage("file-taptin", $config['newsletter'][$type]['file_type'],_upload_file,$file_name))
		{
			$data['taptin'] = $taptin;			
		}

		$data['ngaytao'] = time();

		if($d->insert('newsletter',$data)) transfer("Lưu dữ liệu thành công", "index.php?com=newsletter&act=man&type=".$type."&p=".$curPage);
		else transfer("Lưu dữ liệu bị lỗi", "index.php?com=newsletter&act=man&type=".$type."&p=".$curPage,0);
	}
}

/* Delete newsletter */
function delete_item()
{
	global $d, $curPage, $type;
	
	$id = htmlspecialchars($_GET['id']);

	if($id)
	{
		$row = $d->rawQueryOne("select id, taptin from #_newsletter where id = ? and type = ?",array($id,$type));

		if($row['id'])
		{
			delete_file(_upload_file.$row['taptin']);
			$d->rawQuery("delete from #_newsletter where id = ? and type = ?",array($id,$type));
			transfer("Xóa dữ liệu thành công", "index.php?com=newsletter&act=man&type=".$type."&p=".$curPage);
		}
		else transfer("Xóa dữ liệu bị lỗi", "index.php?com=newsletter&act=man&type=".$type."&p=".$curPage,0);
	}
	elseif(isset($_GET['listid']))
	{
		$listid = explode(",",$_GET['listid']);

		for($i=0;$i<count($listid);$i++)
		{
			$id = htmlspecialchars($listid[$i]);
			$row = $d->rawQueryOne("select id, taptin from #_newsletter where id = ? and type = ?",array($id,$type));

			if($row['id'])
			{
				delete_file(_upload_file.$row['taptin']);
				$d->rawQuery("delete from #_newsletter where id = ? and type = ?",array($id,$type));
			}
		}
		
		transfer("Xóa dữ liệu thành công", "index.php?com=newsletter&act=man&type=".$type."&p=".$curPage);
	}
	else transfer("Không nhận được dữ liệu", "index.php?com=newsletter&act=man&type=".$type."&p=".$curPage,0);
}
?>