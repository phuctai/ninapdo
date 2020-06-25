<?php  
	if(!defined('SOURCES')) die("Error");

	$popup = $d->rawQueryOne("SELECT ten$lang, photo, link, hienthi from table_photo where type = ? and act = ?",array('popup','photo_static'));
    $slider = $d->rawQuery("SELECT ten$lang, photo, link FROM table_photo WHERE hienthi=1 AND type = ? ORDER BY stt,id DESC",array('slide'));
    $brand = $d->rawQuery("SELECT ten$lang, tenkhongdauvi, tenkhongdauen, id, photo FROM table_product_brand WHERE hienthi=1 AND type = ? ORDER BY stt,id DESC",array('san-pham'));
    $pronb = $d->rawQuery("SELECT id FROM table_product WHERE hienthi=1 AND type = ? AND noibat>0",array('san-pham'));
    $newsnb = $d->rawQuery("SELECT ten$lang, tenkhongdauvi, tenkhongdauen, mota$lang, ngaytao, id, photo FROM table_news WHERE hienthi=1 AND type = ? AND noibat>0 ORDER BY stt,id DESC",array('tin-tuc'));
    $videonb = $d->rawQuery("SELECT id FROM table_photo WHERE hienthi=1 AND noibat>0 AND type = ?",array('video'));
    $partner = $d->rawQuery("SELECT ten$lang, link, photo FROM table_photo WHERE type = ? AND hienthi = 1 ORDER BY stt, id DESC",array('doitac'));

    /* SEO */
    $seo->setSeo('h1',$setting['title'.$seolang]);
    $seo->setSeo('title',$setting['title'.$seolang]);
    $seo->setSeo('keywords',$setting['keywords'.$seolang]);
    $seo->setSeo('description',$setting['description'.$seolang]);
    $seo->setSeo('url',$func->getPageURL());
    $img_json_bar = json_decode($logo['options'],true);
    if($img_json_bar['p'] != $logo['photo'])
    {
        $img_json_bar = $func->getImgSize($logo['photo'],UPLOAD_PHOTO_L.$logo['photo']);
        $seo->updateSeoDB(json_encode($img_json_bar),'photo',$logo['id']);
    }
    $seo->setSeo('photo',$config_base.THUMBS.'/'.$img_json_bar['w'].'x'.$img_json_bar['h'].'x2/'.UPLOAD_PHOTO_L.$logo['photo']);
    $seo->setSeo('photo:width',$img_json_bar['w']);
    $seo->setSeo('photo:height',$img_json_bar['h']);
    $seo->setSeo('photo:type',$img_json_bar['m']);
?>