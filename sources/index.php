<?php  
	if(!defined('SOURCES')) die("Error");

	$popup = $d->rawQueryOne("select ten$lang, photo, link, hienthi from #_photo where type = ? and act = ? limit 0,1",array('popup','photo_static'));
    $slider = $d->rawQuery("select ten$lang, photo, link from #_photo where type = ? and hienthi > 0 order by stt,id desc",array('slide'));
    $brand = $d->rawQuery("select ten$lang, tenkhongdauvi, tenkhongdauen, id, photo from #_product_brand where type = ? and hienthi > 0 order by stt,id desc",array('san-pham'));
    $pronb = $d->rawQuery("select id from #_product where type = ? and noibat > 0 and hienthi > 0",array('san-pham'));
    $splistnb = $d->rawQuery("select ten$lang, tenkhongdauvi, tenkhongdauen, id from #_product_list where type = ? and noibat > 0 and hienthi > 0 order by stt,id desc",array('san-pham'));
    $newsnb = $d->rawQuery("select ten$lang, tenkhongdauvi, tenkhongdauen, mota$lang, ngaytao, id, photo from #_news where type = ? and noibat > 0 and hienthi > 0 order by stt,id desc",array('tin-tuc'));
    $videonb = $d->rawQuery("select id from #_photo where noibat > 0 and type = ? and hienthi > 0",array('video'));
    $partner = $d->rawQuery("select ten$lang, link, photo from #_photo where type = ? and hienthi > 0 order by stt, id desc",array('doitac'));

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