<?php  
	if(!defined('SOURCES')) die("Error");

	$popup = $d->rawQueryOne("SELECT ten$lang, photo, link, hienthi from table_photo where type = ? and act = ?",array('popup','photo_static'));
    $slider = $d->rawQuery("SELECT ten$lang, photo, link FROM table_photo WHERE hienthi=1 AND type = ? ORDER BY stt,id DESC",array('slide'));
    $brand = $d->rawQuery("SELECT ten$lang, id, photo FROM table_product_brand WHERE hienthi=1 AND type = ? ORDER BY stt,id DESC",array('san-pham'));
    $pronb = $d->rawQuery("SELECT id FROM table_product WHERE hienthi=1 AND type = ? AND noibat>0",array('san-pham'));
    $newsnb = $d->rawQuery("SELECT ten$lang, mota$lang, ngaytao, id, photo FROM table_news WHERE hienthi=1 AND type = ? AND noibat>0 ORDER BY stt,id DESC",array('tin-tuc'));
    $videonb = $d->rawQuery("SELECT id FROM table_photo WHERE hienthi=1 AND noibat>0 AND type = ?",array('video'));
    $partner = $d->rawQuery("SELECT ten$lang, link, photo FROM table_photo WHERE type = ? AND hienthi = 1 ORDER BY stt, id DESC",array('doitac'));

    /* SEO */
    $seologo = $d->rawQueryOne("SELECT photo FROM table_photo WHERE type = ? AND act = ?",array('logo','photo_static'));
    if($config['website']['seo']['headings'])
    {
		$seo_h1 = $setting['seo_h1'.$seolangkey];
		$seo_h2 = $setting['seo_h2'.$seolangkey];
		$seo_h3 = $setting['seo_h3'.$seolangkey];
    }
    else
    {
        $seo_h1 = $setting['title'.$seolangkey];
    }
	$title_bar = $setting['title'.$seolangkey];
	$keywords_bar = $setting['keywords'.$seolangkey];
	$description_bar = $setting['description'.$seolangkey];
	$img_bar = $config_base.UPLOAD_PHOTO_L.$seologo['photo'];
	$url_bar = getPageURL();
?>