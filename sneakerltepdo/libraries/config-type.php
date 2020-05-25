<?php
	/* Sản phẩm */
	$nametype = "san-pham";
	$config['product'][$nametype]['title_main'] = "Sản Phẩm";
	$config['product'][$nametype]['dropdown'] = true;
	$config['product'][$nametype]['list'] = true;
	$config['product'][$nametype]['cat'] = true;
	$config['product'][$nametype]['item'] = true;
	$config['product'][$nametype]['sub'] = true;
	$config['product'][$nametype]['brand'] = true;
	$config['product'][$nametype]['mau'] = true;
	$config['product'][$nametype]['size'] = true;
	$config['product'][$nametype]['tags'] = true;
	$config['product'][$nametype]['import'] = true;
	$config['product'][$nametype]['export'] = true;
	$config['product'][$nametype]['view'] = true;
	$config['product'][$nametype]['copy'] = true;
	$config['product'][$nametype]['slug'] = true;
	$config['product'][$nametype]['attribute'] = true;
	$config['product'][$nametype]['check'] = array("moi" => "Mới","noibat" => "Nổi bật");
	$config['product'][$nametype]['images'] = true;
	$config['product'][$nametype]['show_images'] = true;
	$config['product'][$nametype]['gallery'] = array
	(
		$nametype => array
		(
			"title_main_photo" => "Hình ảnh sản phẩm",
			"title_sub_photo" => "Hình ảnh",
			"number_photo" => 3,
			"images_photo" => true,
			"cart_photo" => true,
			"avatar_photo" => true,
			"tieude_photo" => true,
			"width_photo" => 135*4,
			"height_photo" => 135*4,
			"thumb_width_photo" => 135,
			"thumb_height_photo" => 135,
			"thumb_ratio_photo" => 1,
			"img_type_photo" => '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF'
		),
		"video" => array
		(
			"title_main_photo" => "Video sản phẩm",
			"title_sub_photo" => "Video",
			"number_photo" => 2,
			"video_photo" => true,
			"link_photo" => true,
			"tieude_photo" => true
		),
		"taptin" => array
		(
			"title_main_photo" => "Tập tin sản phẩm",
			"title_sub_photo" => "Tập tin",
			"number_photo" => 2,
			"file_photo" => true,
			"tieude_photo" => true,
			"file_type_photo" => 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS'
		)
	);
	$config['product'][$nametype]['link'] = true;
	$config['product'][$nametype]['file'] = true;
	$config['product'][$nametype]['ma'] = true;
	$config['product'][$nametype]['tinhtrang'] = true;
	$config['product'][$nametype]['video'] = true;
	$config['product'][$nametype]['gia'] = true;
	$config['product'][$nametype]['giamoi'] = true;
	$config['product'][$nametype]['giakm'] = true;
	$config['product'][$nametype]['mota'] = true;
	$config['product'][$nametype]['noidung'] = true;
	$config['product'][$nametype]['noidung_cke'] = true;
	$config['product'][$nametype]['khuyenmai'] = true;
	$config['product'][$nametype]['seo'] = true;
	$config['product'][$nametype]['width'] = 135*2;
	$config['product'][$nametype]['height'] = 135*2;
	$config['product'][$nametype]['thumb_width'] = 135;
	$config['product'][$nametype]['thumb_height'] = 135;
	$config['product'][$nametype]['thumb_ratio'] = 1;
	$config['product'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
	$config['product'][$nametype]['file_type'] = 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS';

	/* Sản phẩm (Size) */
	$config['product'][$nametype]['size_gia'] = true;

	/* Sản phẩm (Màu) */
	$config['product'][$nametype]['mau_images'] = true;
	$config['product'][$nametype]['mau_gia'] = true;
	$config['product'][$nametype]['mau_mau'] = true;
	$config['product'][$nametype]['mau_loai'] = true;
	$config['product'][$nametype]['width_mau'] = 30;
	$config['product'][$nametype]['height_mau'] = 30;
	$config['product'][$nametype]['thumb_width_mau'] = 30;
	$config['product'][$nametype]['thumb_height_mau'] = 30;
	$config['product'][$nametype]['thumb_ratio_mau'] = 1;
	$config['product'][$nametype]['img_type_mau'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Sản phẩm (List) */
	$config['product'][$nametype]['title_main_list'] = "Sản phẩm cấp 1";
	$config['product'][$nametype]['images_list'] = true;
	$config['product'][$nametype]['show_images_list'] = true;
	$config['product'][$nametype]['slug_list'] = true;
	$config['product'][$nametype]['check_list'] = array("noibat" => "Nổi bật");
	$config['product'][$nametype]['gallery_list'] = array
	(
		$nametype => array
		(
			"title_main_photo" => "Hình ảnh sản phẩm cấp 1",
			"title_sub_photo" => "Hình ảnh",
			"number_photo" => 2,
			"images_photo" => true,
			"avatar_photo" => true,
			"file_photo" => true,
			"avatar_photo" => true,
			"mausac_photo" => true,
			"video_photo" => true,
			"link_photo" => true,
			"mota_photo" => true,
			"mota_cke_photo" => true,
			"tieude_photo" => true,
			"noidung_photo" => true,
			"noidung_cke_photo" => true,
			"width_photo" => 75*4,
			"height_photo" => 50*4,
			"thumb_width_photo" => 75,
			"thumb_height_photo" => 50,
			"thumb_ratio_photo" => 1,
			"img_type_photo" => '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF',
			"file_type_photo" => 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS'
		),
		"video" => array
		(
        	"title_main_photo" => "Video sản phẩm cấp 1",
        	"title_sub_photo" => "Video",
        	"number_photo" => 6,
        	"video_photo" => true,
        	"link_photo" => true,
        	"tieude_photo" => true
     	)
	);
	$config['product'][$nametype]['mota_list'] = true;
	$config['product'][$nametype]['seo_list'] = true;
	$config['product'][$nametype]['width_list'] = 75*4;
	$config['product'][$nametype]['height_list'] = 50*4;
	$config['product'][$nametype]['thumb_width_list'] = 75;
	$config['product'][$nametype]['thumb_height_list'] = 50;
	$config['product'][$nametype]['thumb_ratio_list'] = 1;
	$config['product'][$nametype]['img_type_list'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Sản phẩm (Cat) */
	$config['product'][$nametype]['title_main_cat'] = "Sản phẩm cấp 2";
	$config['product'][$nametype]['images_cat'] = true;
	$config['product'][$nametype]['show_images_cat'] = true;
	$config['product'][$nametype]['slug_cat'] = true;
	$config['product'][$nametype]['check_cat'] = array("noibat" => "Nổi bật");
	$config['product'][$nametype]['mota_cat'] = true;
	$config['product'][$nametype]['seo_cat'] = true;
	$config['product'][$nametype]['width_cat'] = 75*4;
	$config['product'][$nametype]['height_cat'] = 50*4;
	$config['product'][$nametype]['thumb_width_cat'] = 75;
	$config['product'][$nametype]['thumb_height_cat'] = 50;
	$config['product'][$nametype]['thumb_ratio_cat'] = 1;
	$config['product'][$nametype]['img_type_cat'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Sản phẩm (Item) */
	$config['product'][$nametype]['title_main_item'] = "Sản phẩm cấp 3";
	$config['product'][$nametype]['images_item'] = true;
	$config['product'][$nametype]['show_images_item'] = true;
	$config['product'][$nametype]['slug_item'] = true;
	$config['product'][$nametype]['check_item'] = array("noibat" => "Nổi bật");
	$config['product'][$nametype]['mota_item'] = true;
	$config['product'][$nametype]['seo_item'] = true;
	$config['product'][$nametype]['width_item'] = 75*4;
	$config['product'][$nametype]['height_item'] = 50*4;
	$config['product'][$nametype]['thumb_width_item'] = 75;
	$config['product'][$nametype]['thumb_height_item'] = 50;
	$config['product'][$nametype]['thumb_ratio_item'] = 1;
	$config['product'][$nametype]['img_type_item'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Sản phẩm (Sub) */
	$config['product'][$nametype]['title_main_sub'] = "Sản phẩm cấp 4";
	$config['product'][$nametype]['images_sub'] = true;
	$config['product'][$nametype]['show_images_sub'] = true;
	$config['product'][$nametype]['slug_sub'] = true;
	$config['product'][$nametype]['check_sub'] = array("noibat" => "Nổi bật");
	$config['product'][$nametype]['mota_sub'] = true;
	$config['product'][$nametype]['seo_sub'] = true;
	$config['product'][$nametype]['width_sub'] = 75*4;
	$config['product'][$nametype]['height_sub'] = 50*4;
	$config['product'][$nametype]['thumb_width_sub'] = 75;
	$config['product'][$nametype]['thumb_height_sub'] = 50;
	$config['product'][$nametype]['thumb_ratio_sub'] = 3;
	$config['product'][$nametype]['img_type_sub'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Sản phẩm (Hãng) */
	$config['product'][$nametype]['title_main_brand'] = "Hãng sản phẩm";
	$config['product'][$nametype]['images_brand'] = true;
	$config['product'][$nametype]['show_images_brand'] = true;
	$config['product'][$nametype]['slug_brand'] = true;
	$config['product'][$nametype]['check_brand'] = array("noibat" => "Nổi bật");
	$config['product'][$nametype]['seo_brand'] = true;
	$config['product'][$nametype]['width_brand'] = 75*2;
	$config['product'][$nametype]['height_brand'] = 75*2;
	$config['product'][$nametype]['thumb_width_brand'] = 75;
	$config['product'][$nametype]['thumb_height_brand'] = 75;
	$config['product'][$nametype]['thumb_ratio_brand'] = 1;
	$config['product'][$nametype]['img_type_brand'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Thư viện ảnh */
	$nametype = "thu-vien-anh";
	$config['product'][$nametype]['title_main'] = "Thư viện ảnh";
	$config['product'][$nametype]['check'] = array();
	$config['product'][$nametype]['view'] = true;
	$config['product'][$nametype]['slug'] = true;
	$config['product'][$nametype]['images'] = true;
	$config['product'][$nametype]['show_images'] = true;
	$config['product'][$nametype]['gallery'] = array
	(
		$nametype => array
		(
			"title_main_photo" => "Hình ảnh thư viện ảnh",
			"title_sub_photo" => "Hình ảnh",
			"images_photo" => true,
			"avatar_photo" => true,
			"width_photo" => 135*4,
			"height_photo" => 135*4,
			"thumb_width_photo" => 135,
			"thumb_height_photo" => 135,
			"thumb_ratio_photo" => 1,
			"img_type_photo" => '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF'
		)
	);
	$config['product'][$nametype]['seo'] = true;
	$config['product'][$nametype]['width'] = 135*4;
	$config['product'][$nametype]['height'] = 135*4;
	$config['product'][$nametype]['thumb_width'] = 135;
	$config['product'][$nametype]['thumb_height'] = 135;
	$config['product'][$nametype]['thumb_ratio'] = 1;
	$config['product'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Tags Sản phẩm */
	$nametype = "san-pham";
	$config['tags'][$nametype]['title_main'] = "Tags sản phẩm";
	$config['tags'][$nametype]['slug'] = true;
	$config['tags'][$nametype]['images'] = true;
	$config['tags'][$nametype]['show_images'] = true;
	$config['tags'][$nametype]['check'] = array("noibat" => "Nổi bật");
	$config['tags'][$nametype]['seo'] = true;
	$config['tags'][$nametype]['width'] = 75*4;
	$config['tags'][$nametype]['height'] = 50*4;
	$config['tags'][$nametype]['thumb_width'] = 75;
	$config['tags'][$nametype]['thumb_height'] = 50;
	$config['tags'][$nametype]['thumb_ratio'] = 1;
	$config['tags'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Tags tin tức */
	$nametype = "tin-tuc";
	$config['tags'][$nametype]['title_main'] = "Tags tin tức";
	$config['tags'][$nametype]['slug'] = true;
	$config['tags'][$nametype]['images'] = true;
	$config['tags'][$nametype]['show_images'] = true;
	$config['tags'][$nametype]['check'] = array("noibat" => "Nổi bật");
	$config['tags'][$nametype]['seo'] = true;
	$config['tags'][$nametype]['width'] = 75*4;
	$config['tags'][$nametype]['height'] = 50*4;
	$config['tags'][$nametype]['thumb_width'] = 75;
	$config['tags'][$nametype]['thumb_height'] = 50;
	$config['tags'][$nametype]['thumb_ratio'] = 1;
	$config['tags'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Đăng ký nhận tin */
	$nametype = "dangkynhantin";
	$config['newsletter'][$nametype]['title_main'] = "Đăng ký nhận tin";
	$config['newsletter'][$nametype]['email'] = true;
	$config['newsletter'][$nametype]['guiemail'] = true;
	$config['newsletter'][$nametype]['ten'] = true;
	$config['newsletter'][$nametype]['dienthoai'] = true;
	$config['newsletter'][$nametype]['diachi'] = true;
	$config['newsletter'][$nametype]['chude'] = true;
	$config['newsletter'][$nametype]['noidung'] = true;
	$config['newsletter'][$nametype]['ghichu'] = true;
	$config['newsletter'][$nametype]['tinhtrang'] = array("1" => "Đã xem", "2" => "Đã liên hệ", "3" => "Đã thông báo");
	$config['newsletter'][$nametype]['showten'] = true;
	$config['newsletter'][$nametype]['showdienthoai'] = true;
	$config['newsletter'][$nametype]['showngaytao'] = true;
	$config['newsletter'][$nametype]['file_type'] = 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS';

	/* Tin tức */
	$nametype = "tin-tuc";
	$config['news'][$nametype]['title_main'] = "Tin tức";
	$config['news'][$nametype]['dropdown'] = true;
	$config['news'][$nametype]['list'] = true;
	$config['news'][$nametype]['cat'] = true;
	$config['news'][$nametype]['item'] = true;
	$config['news'][$nametype]['sub'] = true;
	$config['news'][$nametype]['tags'] = true;
	$config['news'][$nametype]['view'] = true;
	$config['news'][$nametype]['copy'] = true;
	$config['news'][$nametype]['slug'] = true;
	$config['news'][$nametype]['attribute'] = true;
	$config['news'][$nametype]['check'] = array("moi" => "Mới","noibat" => "Nổi bật");
	$config['news'][$nametype]['images'] = true;
	$config['news'][$nametype]['show_images'] = true;
	$config['news'][$nametype]['gallery'] = array
	(
		$nametype => array
		(
			"title_main_photo" => "Hình ảnh Tin tức",
			"title_sub_photo" => "Hình ảnh",
			"number_photo" => 3,
			"images_photo" => true,
			"avatar_photo" => true,
			"width_photo" => 135*4,
			"height_photo" => 135*4,
			"thumb_width_photo" => 135,
			"thumb_height_photo" => 135,
			"thumb_ratio_photo" => 1,
			"img_type_photo" => '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF'
		),
		"video" => array
		(
			"title_main_photo" => "Video Tin tức",
			"title_sub_photo" => "Video",
			"number_photo" => 2,
			"video_photo" => true,
			"link_photo" => true,
			"tieude_photo" => true
		),
		"taptin" => array
		(
			"title_main_photo" => "Tập tin Tin tức",
			"title_sub_photo" => "Tập tin",
			"number_photo" => 2,
			"file_photo" => true,
			"tieude_photo" => true,
			"file_type_photo" => 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS'
		)
	);
	$config['news'][$nametype]['link'] = true;
	$config['news'][$nametype]['file'] = true;
	$config['news'][$nametype]['video'] = true;
	$config['news'][$nametype]['mota'] = true;
	$config['news'][$nametype]['noidung'] = true;
	$config['news'][$nametype]['noidung_cke'] = true;
	$config['news'][$nametype]['seo'] = true;
	$config['news'][$nametype]['width'] = 135*2;
	$config['news'][$nametype]['height'] = 135*2;
	$config['news'][$nametype]['thumb_width'] = 135;
	$config['news'][$nametype]['thumb_height'] = 135;
	$config['news'][$nametype]['thumb_ratio'] = 1;
	$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
	$config['news'][$nametype]['file_type'] = 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS';

	/* Tin tức (List) */
	$config['news'][$nametype]['title_main_list'] = "Tin tức cấp 1";
	$config['news'][$nametype]['images_list'] = true;
	$config['news'][$nametype]['show_images_list'] = true;
	$config['news'][$nametype]['slug_list'] = true;
	$config['news'][$nametype]['check_list'] = array("noibat" => "Nổi bật");
	$config['news'][$nametype]['gallery_list'] = array
	(
		$nametype => array
		(
			"title_main_photo" => "Hình ảnh Tin tức cấp 1",
			"title_sub_photo" => "Hình ảnh",
			"number_photo" => 2,
			"images_photo" => true,
			"avatar_photo" => true,
			"file_photo" => true,
			"avatar_photo" => true,
			"mausac_photo" => true,
			"video_photo" => true,
			"link_photo" => true,
			"mota_photo" => true,
			"mota_cke_photo" => true,
			"tieude_photo" => true,
			"noidung_photo" => true,
			"noidung_cke_photo" => true,
			"width_photo" => 75*4,
			"height_photo" => 50*4,
			"thumb_width_photo" => 75,
			"thumb_height_photo" => 50,
			"thumb_ratio_photo" => 1,
			"img_type_photo" => '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF',
			"file_type_photo" => 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS'
		),
		"video" => array
		(
			"title_main_photo" => "Video Tin tức cấp 1",
			"title_sub_photo" => "Video",
			"number_photo" => 6,
			"video_photo" => true,
			"link_photo" => true,
			"tieude_photo" => true
		)
	);
	$config['news'][$nametype]['mota_list'] = true;
	$config['news'][$nametype]['mota_cke_list'] = true;
	$config['news'][$nametype]['noidung_list'] = true;
	$config['news'][$nametype]['noidung_cke_list'] = true;
	$config['news'][$nametype]['seo_list'] = true;
	$config['news'][$nametype]['width_list'] = 75*4;
	$config['news'][$nametype]['height_list'] = 50*4;
	$config['news'][$nametype]['thumb_width_list'] = 75;
	$config['news'][$nametype]['thumb_height_list'] = 50;
	$config['news'][$nametype]['thumb_ratio_list'] = 1;
	$config['news'][$nametype]['img_type_list'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Tin tức (Cat) */
	$config['news'][$nametype]['title_main_cat'] = "Tin tức cấp 2";
	$config['news'][$nametype]['images_cat'] = true;
	$config['news'][$nametype]['show_images_cat'] = true;
	$config['news'][$nametype]['slug_cat'] = true;
	$config['news'][$nametype]['check_cat'] = array("noibat" => "Nổi bật");
	$config['news'][$nametype]['mota_cat'] = true;
	$config['news'][$nametype]['mota_cke_cat'] = true;
	$config['news'][$nametype]['noidung_cat'] = true;
	$config['news'][$nametype]['noidung_cke_cat'] = true;
	$config['news'][$nametype]['seo_cat'] = true;
	$config['news'][$nametype]['width_cat'] = 75*4;
	$config['news'][$nametype]['height_cat'] = 50*4;
	$config['news'][$nametype]['thumb_width_cat'] = 75;
	$config['news'][$nametype]['thumb_height_cat'] = 50;
	$config['news'][$nametype]['thumb_ratio_cat'] = 1;
	$config['news'][$nametype]['img_type_cat'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Tin tức (Item) */
	$config['news'][$nametype]['title_main_item'] = "Tin tức cấp 3";
	$config['news'][$nametype]['images_item'] = true;
	$config['news'][$nametype]['show_images_item'] = true;
	$config['news'][$nametype]['slug_item'] = true;
	$config['news'][$nametype]['check_item'] = array("noibat" => "Nổi bật");
	$config['news'][$nametype]['mota_item'] = true;
	$config['news'][$nametype]['mota_cke_item'] = true;
	$config['news'][$nametype]['noidung_item'] = true;
	$config['news'][$nametype]['noidung_cke_item'] = true;
	$config['news'][$nametype]['seo_item'] = true;
	$config['news'][$nametype]['width_item'] = 75*4;
	$config['news'][$nametype]['height_item'] = 50*4;
	$config['news'][$nametype]['thumb_width_item'] = 75;
	$config['news'][$nametype]['thumb_height_item'] = 50;
	$config['news'][$nametype]['thumb_ratio_item'] = 1;
	$config['news'][$nametype]['img_type_item'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Tin tức (Sub) */
	$config['news'][$nametype]['title_main_sub'] = "Tin tức cấp 4";
	$config['news'][$nametype]['images_sub'] = true;
	$config['news'][$nametype]['show_images_sub'] = true;
	$config['news'][$nametype]['slug_sub'] = true;
	$config['news'][$nametype]['check_sub'] = array("noibat" => "Nổi bật");
	$config['news'][$nametype]['mota_sub'] = true;
	$config['news'][$nametype]['mota_cke_sub'] = true;
	$config['news'][$nametype]['noidung_sub'] = true;
	$config['news'][$nametype]['noidung_cke_sub'] = true;
	$config['news'][$nametype]['seo_sub'] = true;
	$config['news'][$nametype]['width_sub'] = 75*4;
	$config['news'][$nametype]['height_sub'] = 50*4;
	$config['news'][$nametype]['thumb_width_sub'] = 75;
	$config['news'][$nametype]['thumb_height_sub'] = 50;
	$config['news'][$nametype]['thumb_ratio_sub'] = 3;
	$config['news'][$nametype]['img_type_sub'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Tuyển dụng */
	$nametype = "tuyen-dung";
	$config['news'][$nametype]['title_main'] = "Tuyển dụng";
	$config['news'][$nametype]['check'] = array();
	$config['news'][$nametype]['view'] = true;
	$config['news'][$nametype]['slug'] = true;
	$config['news'][$nametype]['images'] = true;
	$config['news'][$nametype]['show_images'] = true;
	$config['news'][$nametype]['copy'] = true;
	$config['news'][$nametype]['mota'] = true;
	$config['news'][$nametype]['noidung'] = true;
	$config['news'][$nametype]['noidung_cke'] = true;
	$config['news'][$nametype]['seo'] = true;
	$config['news'][$nametype]['width'] = 20*16;
	$config['news'][$nametype]['height'] = 15*16;
	$config['news'][$nametype]['thumb_width'] = 20;
	$config['news'][$nametype]['thumb_height'] = 15;
	$config['news'][$nametype]['thumb_ratio'] = 1;
	$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Chính sách */
	$nametype = "chinh-sach";
	$config['news'][$nametype]['title_main'] = "Chính sách";
	$config['news'][$nametype]['check'] = array();
	$config['news'][$nametype]['view'] = true;
	$config['news'][$nametype]['slug'] = true;
	$config['news'][$nametype]['images'] = true;
	$config['news'][$nametype]['show_images'] = true;
	$config['news'][$nametype]['copy'] = true;
	$config['news'][$nametype]['noidung'] = true;
	$config['news'][$nametype]['noidung_cke'] = true;
	$config['news'][$nametype]['seo'] = true;
	$config['news'][$nametype]['width'] = 20*16;
	$config['news'][$nametype]['height'] = 15*16;
	$config['news'][$nametype]['thumb_width'] = 20;
	$config['news'][$nametype]['thumb_height'] = 15;
	$config['news'][$nametype]['thumb_ratio'] = 1;
	$config['news'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Hình thức thanh toán */
	$nametype = "hinh-thuc-thanh-toan";
	$config['news']['hinh-thuc-thanh-toan']['title_main'] = "Hình thức thanh toán";
	$config['news']['hinh-thuc-thanh-toan']['check'] = array();
	$config['news']['hinh-thuc-thanh-toan']['mota'] = true;

	/* Giới thiệu */
	$nametype = "gioi-thieu";
	$config['static'][$nametype]['title_main'] = "Giới thiệu";
	$config['static'][$nametype]['images'] = true;
	$config['static'][$nametype]['link'] = true;
	$config['static'][$nametype]['file'] = true;
	$config['static'][$nametype]['video'] = true;
	$config['static'][$nametype]['tieude'] = true;
	$config['static'][$nametype]['mota'] = true;
	$config['static'][$nametype]['mota_cke'] = true;
	$config['static'][$nametype]['noidung'] = true;
	$config['static'][$nametype]['noidung_cke'] = true;
	$config['static'][$nametype]['seo'] = true;
	$config['static'][$nametype]['width'] = 75*4;
	$config['static'][$nametype]['height'] = 50*4;
	$config['static'][$nametype]['thumb_width'] = 75;
	$config['static'][$nametype]['thumb_height'] = 50;
	$config['static'][$nametype]['thumb_ratio'] = 1;
	$config['static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
	$config['static'][$nametype]['file_type'] = 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS';

	/* Slogan */
	$nametype = "slogan";
	$config['static'][$nametype]['title_main'] = "Slogan";
	$config['static'][$nametype]['tieude'] = true;

	/* Liên hệ */
	$nametype = "lienhe";
	$config['static'][$nametype]['title_main'] = "Liên hệ";
	$config['static'][$nametype]['noidung'] = true;
	$config['static'][$nametype]['noidung_cke'] = true;

	/* Footer */
	$nametype = "footer";
	$config['static'][$nametype]['title_main'] = "Footer";
	$config['static'][$nametype]['tieude'] = true;
	$config['static'][$nametype]['noidung'] = true;
	$config['static'][$nametype]['noidung_cke'] = true;

	/* Background */
	$nametype = "background";
	$config['photo']['photo_static'][$nametype]['title_main'] = "Background";
	$config['photo']['photo_static'][$nametype]['images'] = true;
	$config['photo']['photo_static'][$nametype]['background'] = true;
	$config['photo']['photo_static'][$nametype]['width'] = 900;
	$config['photo']['photo_static'][$nametype]['height'] = 300;
	$config['photo']['photo_static'][$nametype]['thumb_width'] = 900;
	$config['photo']['photo_static'][$nametype]['thumb_height'] = 300;
	$config['photo']['photo_static'][$nametype]['thumb_ratio'] = 1;
	$config['photo']['photo_static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Banner */
	$nametype = "banner";
	$config['photo']['photo_static'][$nametype]['title_main'] = "Banner";
	$config['photo']['photo_static'][$nametype]['images'] = true;
	$config['photo']['photo_static'][$nametype]['width'] = 900;
	$config['photo']['photo_static'][$nametype]['height'] = 300;
	$config['photo']['photo_static'][$nametype]['thumb_width'] = 900;
	$config['photo']['photo_static'][$nametype]['thumb_height'] = 300;
	$config['photo']['photo_static'][$nametype]['thumb_ratio'] = 1;
	$config['photo']['photo_static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Logo */
	$nametype = "logo";
	$config['photo']['photo_static'][$nametype]['title_main'] = "Logo";
	$config['photo']['photo_static'][$nametype]['images'] = true;
	$config['photo']['photo_static'][$nametype]['width'] = 30*4;
	$config['photo']['photo_static'][$nametype]['height'] = 25*4;
	$config['photo']['photo_static'][$nametype]['thumb_width'] = 30;
	$config['photo']['photo_static'][$nametype]['thumb_height'] = 25;
	$config['photo']['photo_static'][$nametype]['thumb_ratio'] = 1;
	$config['photo']['photo_static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Favicon */
	$nametype = "favicon";
	$config['photo']['photo_static'][$nametype]['title_main'] = "Favicon";
	$config['photo']['photo_static'][$nametype]['images'] = true;
	$config['photo']['photo_static'][$nametype]['width'] = 25;
	$config['photo']['photo_static'][$nametype]['height'] = 25;
	$config['photo']['photo_static'][$nametype]['thumb_width'] = 25;
	$config['photo']['photo_static'][$nametype]['thumb_height'] = 25;
	$config['photo']['photo_static'][$nametype]['thumb_ratio'] = 1;
	$config['photo']['photo_static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Watermark */
	$nametype = "watermark";
	$config['photo']['photo_static'][$nametype]['title_main'] = "Watermark";
	$config['photo']['photo_static'][$nametype]['images'] = true;
	$config['photo']['photo_static'][$nametype]['removeCacheThumb'] = true;
	$config['photo']['photo_static'][$nametype]['width'] = 135*2;
	$config['photo']['photo_static'][$nametype]['height'] = 135*2;
	$config['photo']['photo_static'][$nametype]['thumb_width'] = 135;
	$config['photo']['photo_static'][$nametype]['thumb_height'] = 135;
	$config['photo']['photo_static'][$nametype]['thumb_ratio'] = 1;
	$config['photo']['photo_static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Watermark chi tiết */
	$nametype = "watermark-chitiet";
	$config['photo']['photo_static'][$nametype]['title_main'] = "Watermark chi tiết";
	$config['photo']['photo_static'][$nametype]['images'] = true;
	$config['photo']['photo_static'][$nametype]['removeCacheThumb'] = true;
	$config['photo']['photo_static'][$nametype]['width'] = 135*4;
	$config['photo']['photo_static'][$nametype]['height'] = 135*4;
	$config['photo']['photo_static'][$nametype]['thumb_width'] = 135;
	$config['photo']['photo_static'][$nametype]['thumb_height'] = 135;
	$config['photo']['photo_static'][$nametype]['thumb_ratio'] = 2;
	$config['photo']['photo_static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Video */
	$nametype = "video";
	$config['photo']['photo_static'][$nametype]['title_main'] = "Video";
	$config['photo']['photo_static'][$nametype]['images'] = true;
	$config['photo']['photo_static'][$nametype]['video'] = true;
	$config['photo']['photo_static'][$nametype]['tieude'] = true;
	$config['photo']['photo_static'][$nametype]['mota'] = true;
	$config['photo']['photo_static'][$nametype]['noidung'] = true;
	$config['photo']['photo_static'][$nametype]['width'] = 250;
	$config['photo']['photo_static'][$nametype]['height'] = 150;
	$config['photo']['photo_static'][$nametype]['thumb_width'] = 250;
	$config['photo']['photo_static'][$nametype]['thumb_height'] = 150;
	$config['photo']['photo_static'][$nametype]['thumb_ratio'] = 1;
	$config['photo']['photo_static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Popup */
	$nametype = "popup";
	$config['photo']['photo_static'][$nametype]['title_main'] = "Popup";
	$config['photo']['photo_static'][$nametype]['images'] = true;
	$config['photo']['photo_static'][$nametype]['tieude'] = true;
	$config['photo']['photo_static'][$nametype]['link'] = true;
	$config['photo']['photo_static'][$nametype]['width'] = 800;
	$config['photo']['photo_static'][$nametype]['height'] = 530;
	$config['photo']['photo_static'][$nametype]['thumb_width'] = 800;
	$config['photo']['photo_static'][$nametype]['thumb_height'] = 530;
	$config['photo']['photo_static'][$nametype]['thumb_ratio'] = 1;
	$config['photo']['photo_static'][$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Slideshow */
	$nametype = "slide";
	$config['photo']['man_photo'][$nametype]['title_main_photo'] = "Slideshow";
	$config['photo']['man_photo'][$nametype]['number_photo'] = 5;
	$config['photo']['man_photo'][$nametype]['images_photo'] = true;
	$config['photo']['man_photo'][$nametype]['avatar_photo'] = true;
	$config['photo']['man_photo'][$nametype]['link_photo'] = true;
	$config['photo']['man_photo'][$nametype]['mausac_photo'] = true;
	$config['photo']['man_photo'][$nametype]['tieude_photo'] = true;
	$config['photo']['man_photo'][$nametype]['width_photo'] = 1366;
	$config['photo']['man_photo'][$nametype]['height_photo'] = 600;
	$config['photo']['man_photo'][$nametype]['thumb_width_photo'] = 1366;
	$config['photo']['man_photo'][$nametype]['thumb_height_photo'] = 600;
	$config['photo']['man_photo'][$nametype]['thumb_ratio_photo'] = 1;
	$config['photo']['man_photo'][$nametype]['img_type_photo'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Mạng xã hội */
	$nametype = "mangxahoi";
	$config['photo']['man_photo'][$nametype]['title_main_photo'] = "Mạng xã hội";
	$config['photo']['man_photo'][$nametype]['number_photo'] = 3;
	$config['photo']['man_photo'][$nametype]['images_photo'] = true;
	$config['photo']['man_photo'][$nametype]['avatar_photo'] = true;
	$config['photo']['man_photo'][$nametype]['link_photo'] = true;
	$config['photo']['man_photo'][$nametype]['width_photo'] = 30;
	$config['photo']['man_photo'][$nametype]['height_photo'] = 30;
	$config['photo']['man_photo'][$nametype]['thumb_width_photo'] = 30;
	$config['photo']['man_photo'][$nametype]['thumb_height_photo'] = 30;
	$config['photo']['man_photo'][$nametype]['thumb_ratio_photo'] = 1;
	$config['photo']['man_photo'][$nametype]['img_type_photo'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Mạng xã hội 1 */
	$nametype = "mangxahoi1";
	$config['photo']['man_photo'][$nametype]['title_main_photo'] = "Mạng xã hội 1";
	$config['photo']['man_photo'][$nametype]['number_photo'] = 3;
	$config['photo']['man_photo'][$nametype]['images_photo'] = true;
	$config['photo']['man_photo'][$nametype]['avatar_photo'] = true;
	$config['photo']['man_photo'][$nametype]['link_photo'] = true;
	$config['photo']['man_photo'][$nametype]['tieude_photo'] = true;
	$config['photo']['man_photo'][$nametype]['width_photo'] = 30;
	$config['photo']['man_photo'][$nametype]['height_photo'] = 30;
	$config['photo']['man_photo'][$nametype]['thumb_width_photo'] = 30;
	$config['photo']['man_photo'][$nametype]['thumb_height_photo'] = 30;
	$config['photo']['man_photo'][$nametype]['thumb_ratio_photo'] = 1;
	$config['photo']['man_photo'][$nametype]['img_type_photo'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Mạng xã hội 2 */
	$nametype = "mangxahoi2";
	$config['photo']['man_photo'][$nametype]['title_main_photo'] = "Mạng xã hội 2";
	$config['photo']['man_photo'][$nametype]['number_photo'] = 3;
	$config['photo']['man_photo'][$nametype]['images_photo'] = true;
	$config['photo']['man_photo'][$nametype]['avatar_photo'] = true;
	$config['photo']['man_photo'][$nametype]['link_photo'] = true;
	$config['photo']['man_photo'][$nametype]['tieude_photo'] = true;
	$config['photo']['man_photo'][$nametype]['width_photo'] = 35;
	$config['photo']['man_photo'][$nametype]['height_photo'] = 35;
	$config['photo']['man_photo'][$nametype]['thumb_width_photo'] = 35;
	$config['photo']['man_photo'][$nametype]['thumb_height_photo'] = 35;
	$config['photo']['man_photo'][$nametype]['thumb_ratio_photo'] = 1;
	$config['photo']['man_photo'][$nametype]['img_type_photo'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Video */
	$nametype = "video";
	$config['photo']['man_photo'][$nametype]['title_main_photo'] = "Video";
	$config['photo']['man_photo'][$nametype]['check_photo'] = array("noibat" => "Nổi bật");
	$config['photo']['man_photo'][$nametype]['number_photo'] = 2;
	$config['photo']['man_photo'][$nametype]['video_photo'] = true;
	$config['photo']['man_photo'][$nametype]['tieude_photo'] = true;

	/* Đối tác */
	$nametype = "doitac";
	$config['photo']['man_photo'][$nametype]['title_main_photo'] = "Đối tác";
	$config['photo']['man_photo'][$nametype]['number_photo'] = 5;
	$config['photo']['man_photo'][$nametype]['images_photo'] = true;
	$config['photo']['man_photo'][$nametype]['avatar_photo'] = true;
	$config['photo']['man_photo'][$nametype]['link_photo'] = true;
	$config['photo']['man_photo'][$nametype]['tieude_photo'] = true;
	$config['photo']['man_photo'][$nametype]['width_photo'] = 175;
	$config['photo']['man_photo'][$nametype]['height_photo'] = 95;
	$config['photo']['man_photo'][$nametype]['thumb_width_photo'] = 175;
	$config['photo']['man_photo'][$nametype]['thumb_height_photo'] = 95;
	$config['photo']['man_photo'][$nametype]['thumb_ratio_photo'] = 1;
	$config['photo']['man_photo'][$nametype]['img_type_photo'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Setting */
	$config['setting']['diachi'] = true;
	$config['setting']['dienthoai'] = true;
	$config['setting']['hotline'] = true;
	$config['setting']['zalo'] = true;
	$config['setting']['oaidzalo'] = true;
	$config['setting']['email'] = true;
	$config['setting']['website'] = true;
	$config['setting']['fanpage'] = true;
	$config['setting']['toado'] = true;
	$config['setting']['toado_iframe'] = true;
	$config['setting']['copyright'] = true;
	$config['setting']['mota'] = true;
	$config['setting']['mota_cke'] = true;
	$config['setting']['noidung'] = true;
	$config['setting']['noidung_cke'] = true;

	/* Seo page */
	$config['seopage']['page']=array(
		"san-pham" => "Sản phẩm",
		"tin-tuc" => "Tin tức",
		"tuyen-dung" => "Tuyển dụng",
		"thu-vien-anh" => "Thư viện ảnh",
		"video" => "Video",
		"lien-he" => "Liên hệ"
	);
	$config['seopage']['width'] = 75*4;
	$config['seopage']['height'] = 50*4;
	$config['seopage']['thumb_width'] = 75;
	$config['seopage']['thumb_height'] = 50;
	$config['seopage']['thumb_ratio'] = 1;
	$config['seopage']['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

	/* Quản lý import */
	$config['import']['images'] = true;
	$config['import']['img_type'] = ".jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF";

	/* Quản lý export */
	$config['export']['category'] = true;

	/* Quản lý tài khoản */
	$config['user']['active'] = true;
	$config['user']['admin'] = true;
	$config['user']['visitor'] = true;

	/* Quản lý phân quyền */
	$config['permission'] = true;

	/* Quản lý địa điểm */
	$config['places']['active'] = true;
	$config['places']['placesship'] = true;

	/* Quản lý giỏ hàng */
	$config['order']['active'] = true;
	$config['order']['ship'] = true;
	$config['order']['coupon'] = true;
	$config['order']['search'] = true;
	$config['order']['excel'] = true;
	$config['order']['word'] = true;
	$config['order']['excelall'] = true;
	$config['order']['wordall'] = true;

	/* Quản lý mã ưu đãi */
	$config['coupon'] = true;

	/* Quản lý thông báo đẩy */
	$config['onesignal'] = true;

	/* Quản lý mục (Không cấp) */
	if(count($config['news']))
	{
		foreach ($config['news'] as $key => $value)
		{
			if($value['dropdown']==false)
			{ 
				$config['shownews'] = 1;
				break;
			}
		}
	}
?>