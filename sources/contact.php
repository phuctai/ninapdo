<?php 
	if(!defined('_SOURCE')) die("Error");

	if(isset($_POST['submit-contact']))
	{
        $response = $_POST['recaptcha_response_contact'];
        $scopeRecaptcha = checkRecaptcha($response);

		if($scopeRecaptcha >= 0.5)
		{
			$file_name = upload_name($_FILES["file"]["name"]);
			if($file = uploadImage("file", 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|xlsx|jpg|png|gif|JPG|PNG|GIF', _upload_file_l,$file_name))
			{
				$data['taptin'] = $file;
			}

		    $data['ten'] = htmlspecialchars($_POST['ten']);
		    $data['diachi'] = htmlspecialchars($_POST['diachi']);
		    $data['dienthoai'] = htmlspecialchars($_POST['dienthoai']);
			$data['email'] = htmlspecialchars($_POST['email']);
		    $data['tieude'] = htmlspecialchars($_POST['tieude']);
		    $data['noidung'] = htmlspecialchars($_POST['noidung']);
		    $data['ngaytao'] = time(); 
		    $data['stt'] = 1;
		    $d->insert('contact',$data);

		    // Cấu hình chung gửi email
			include_once _LIB."mailsetting.php";
			
		    // Gán giá trị cho biến gửi email
		    $tennguoigui = $data['ten'];
		    $emailnguoigui = $data['email'];
		    $dienthoainguoigui = $data['dienthoai'];
		    $diachinguoigui = $data['diachi'];
		    $tieudelienhe = $data['tieude'];
		    $noidunglienhe = $data['noidung'];
		    $thongtin = '';

		    if($tennguoigui)
		    {
		    	$thongtin.='<span style="text-transform:capitalize">'.$tennguoigui.'</span><br>';
		    }

		    if($emailnguoigui)
		    {
		    	$thongtin.='<a href="mailto:'.$emailnguoigui.'" target="_blank">'.$emailnguoigui.'</a><br>';
		    }

		    if($diachinguoigui)
		    {
		    	$thongtin.=''.$diachinguoigui.'<br>';
		    }

		    if($dienthoainguoigui)
		    {
		    	$thongtin.='Tel: '.$dienthoainguoigui.'';
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
															<h1 style="font-size:17px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0">Kính chào</h1>
															<p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">Bạn nhận được thư liên hệ từ khách hàng <span style="text-transform:capitalize">'.$tennguoigui.'</span> tại website '.$websitecongty.'.</p>
															<h3 style="font-size:13px;font-weight:bold;color:'.$mauform.';text-transform:uppercase;margin:20px 0 0 0;padding: 0 0 5px;border-bottom:1px solid #ddd">Thông tin liên hệ <span style="font-size:12px;color:#777;text-transform:none;font-weight:normal">(Ngày '.date('d',$ngaygui).' tháng '.date('m',$ngaygui).' năm '.date('Y H:i:s',$ngaygui).')</span></h3>
														</td>
													</tr>
												<tr>
												<td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
												<table border="0" cellpadding="0" cellspacing="0" width="100%">
													<tbody>
														<tr>
															<td style="padding:3px 0px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">'.$thongtin.'</td>
														</tr>
														<tr>
															<td colspan="2" style="border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444" valign="top">&nbsp;
															<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;margin-top:0"><strong>Tiêu đề: </strong> '.$tieudelienhe.'<br>
															</td>
														</tr>
													</tbody>
												</table>
												</td>
											</tr>
											<tr>
												<td>
												<p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><i>'.$noidunglienhe.'</i></p>
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

			$noidungkh='
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
															<p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">Thông tin liên hệ của quý khách đã được tiếp nhận. '.$websitecongty.' sẽ phản hồi trong thời gian sớm nhất.</p>
															<h3 style="font-size:13px;font-weight:bold;color:'.$mauform.';text-transform:uppercase;margin:20px 0 0 0;padding: 0 0 5px;border-bottom:1px solid #ddd">Thông tin liên hệ <span style="font-size:12px;color:#777;text-transform:none;font-weight:normal">(Ngày '.date('d',$ngaygui).' tháng '.date('m',$ngaygui).' năm '.date('Y H:i:s',$ngaygui).')</span></h3>
														</td>
													</tr>
												<tr>
												<td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
												<table border="0" cellpadding="0" cellspacing="0" width="100%">
													<tbody>
														<tr>
															<td style="padding:3px 0px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">'.$thongtin.'</td>
														</tr>
														<tr>
															<td colspan="2" style="border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444" valign="top">&nbsp;
															<p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;margin-top:0"><strong>Tiêu đề: </strong> '.$tieudelienhe.'<br>
															</td>
														</tr>
													</tbody>
												</table>
												</td>
											</tr>
											<tr>
												<td>
												<p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><i>'.$noidunglienhe.'</i></p>
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
			$arrayEmail = null;
			$subject = "Thư liên hệ từ ".$setting['ten'.$lang];
			$message = $noidung;
			$file = $data['taptin'];

			if(sendEmail("admin", $arrayEmail, $subject, $message, $file))
			{
				/* Send email customer */
				$arrayEmail = array(
					"dataEmail" => array(
						"name" => $tennguoigui,
						"email" => $emailnguoigui
					)
				);
				$subject = "Thư liên hệ từ ".$setting['ten'.$lang];
				$message = $noidungkh;
				$file = $data['taptin'];

				if(sendEmail("customer", $arrayEmail, $subject, $message, $file)) transfer("Gửi liên hệ thành công",$config_base);
			}
			else transfer("Gửi liên hệ thất bại. Vui lòng thử lại sau",$config_base,0);
		}
		else
		{
			transfer("Gửi liên hệ thất bại. Vui lòng thử lại sau",$config_base,0);
		}
	}

	/* SEO */
	$seopage = $d->rawQueryOne("SELECT * FROM table_seopage WHERE type = ?",array('lien-he'));
	if($config['website']['seo']['headings'])
	{
		$seo_h1 = $seopage['seo_h1'.$seolangkey];
		$seo_h2 = $seopage['seo_h2'.$seolangkey];
		$seo_h3 = $seopage['seo_h3'.$seolangkey];
	}
	else
	{
		$seo_h1 = $title_crumb;
	}
	if($seopage['title'.$seolangkey]) $title_bar = $seopage['title'.$seolangkey];
	else $title_bar = $title_crumb;
	$keywords_bar = $seopage['keywords'.$seolangkey];
	$description_bar = $seopage['description'.$seolangkey];
	$img_bar = $config_base._upload_seopage_l."300x200x2/".$seopage['photo'];
	$url_bar = getPageURL();
	
    $lienhe = $d->rawQueryOne("select noidung$lang from #_static where type = ?",array('lienhe'));

	/* breadCrumbs */
	if($title_crumb) $data['breadcrumbs'][] = array('slug'=>get_comlang('lien-he',$lang),'name'=>$title_crumb);
	$breadcrumbs = $bc->getUrl(_trangchu, $data['breadcrumbs']);
?>