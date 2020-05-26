<?php
    $maillogo = $d->rawQueryOne("SELECT photo FROM table_photo WHERE type = ? AND act = ?",array('logo','photo_static'));
	$mailmxh = $d->rawQuery("SELECT photo, link FROM table_photo WHERE type = ? AND hienthi=1 ORDER BY stt,id DESC",array('mangxahoi'));

    $emailhosting = ($setting['mailertype']==1) ? $setting['email_host'] : $setting['email_gmail'];
    $mauform = '#94130F';
    $trangchu = $config_base;
    $logo = '<img src="'.$trangchu._upload_photo_l.$maillogo['photo'].'" style="max-height:70px;" >';
    $tencongty = $setting['ten'.$lang];
    $diachicongty = $setting['diachi'];
    $emailcongty = $setting['email'];
    $hotlinecongty = $setting['hotline'];
    $websitecongty = $setting['website'];
    $thoitranglamviec = '(8-21h cả T7,CN)';
    $mangxahoi = '';
    for($i=0,$count=count($mailmxh);$i<$count;$i++)
    {
        $mangxahoi .= '<a href="'.$mailmxh[$i]['link'].'" target="_blank"><img src="'.$trangchu._upload_photo_l.$mailmxh[$i]['photo'].'" style="max-height:30px;margin:0 0 0 5px" /></a>';
    }
    $ngaygui = time();
    $notethanhtoan = "Lưu ý: Đối với đơn hàng đã được thanh toán trước, nhân viên giao nhận có thể yêu cầu người nhận hàng cung cấp CMND / giấy phép lái xe để chụp ảnh hoặc ghi lại thông tin.";
?>