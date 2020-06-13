<?php
    if(!defined('SOURCES')) die("Error");

    /* Query allpage */
    $favicon = $d->rawQueryOne("SELECT photo FROM table_photo WHERE hienthi=1 AND type = ? AND act = ?",array('favicon','photo_static'));
    $logo = $d->rawQueryOne("SELECT photo FROM table_photo WHERE type = ? AND act = ?",array('logo','photo_static'));
    $banner = $d->rawQueryOne("SELECT photo FROM table_photo WHERE type = ? AND act = ?",array('banner','photo_static'));
    $slogan = $d->rawQueryOne("SELECT ten$lang FROM table_static WHERE type = ?",array('slogan'));
    $social1 = $d->rawQuery("SELECT ten$lang, photo, link FROM table_photo WHERE type = ? AND hienthi=1 ORDER BY stt,id DESC",array('mangxahoi1'));
    $social2 = $d->rawQuery("SELECT ten$lang, photo, link FROM table_photo WHERE type = ? AND hienthi=1 ORDER BY stt,id DESC",array('mangxahoi2'));
    $splistmenu = $d->rawQuery("SELECT ten$lang, tenkhongdauvi, tenkhongdauen, id FROM table_product_list WHERE hienthi=1 AND type = ? ORDER BY stt,id DESC",array('san-pham'));
    $ttlistmenu = $d->rawQuery("SELECT ten$lang, tenkhongdauvi, tenkhongdauen id FROM table_news_list WHERE hienthi=1 AND type = ? ORDER BY stt,id DESC",array('tin-tuc'));
    $footer = $d->rawQueryOne("SELECT ten$lang, noidung$lang FROM table_static WHERE type = ?",array('footer'));
    $tagsProduct = $d->rawQuery("SELECT ten$lang, tenkhongdauvi, tenkhongdauen id FROM table_tags WHERE type = ? AND noibat>0 ORDER BY stt,id DESC",array('san-pham'));
    $tagsNews = $d->rawQuery("SELECT ten$lang, tenkhongdauvi, tenkhongdauen id FROM table_tags WHERE type = ? AND noibat>0 ORDER BY stt,id DESC",array('tin-tuc'));
    $cs = $d->rawQuery("SELECT ten$lang, tenkhongdauvi, tenkhongdauen id, photo FROM table_news WHERE hienthi=1 AND type = ? ORDER BY stt,id DESC",array('chinh-sach'));

    /* Get statistic */
    $counter = $statistic->getCounter();
    $online = $statistic->getOnline();

    /* Đăng ký nhận mail */
    if(isset($_POST['submit-newsletter']))
    {
        $response = $_POST['recaptcha_response_newsletter'];
        $scopeRecaptcha = $func->checkRecaptcha($response);

        if($scopeRecaptcha >= 0.5)
        {
            $data['email'] = htmlspecialchars($_REQUEST['email-newsletter']);
            $data['ngaytao'] = time();
            $data['type'] = 'dangkynhantin';

            if($d->insert('newsletter',$data))
            {
                $func->transfer("Đăng ký nhận tin thành công. Chúng tôi sẽ liên hệ với bạn sớm.",$config_base);
            }
            else
            {
                $func->transfer("Đăng ký nhận tin thất bại. Vui lòng thử lại sau.",$config_base,0);
            }
        }
        else
        {
            $func->transfer("Đăng ký nhận tin thất bại. Vui lòng thử lại sau.",$config_base,0);
        }
    }
?>