1/  Database: **libraries > database > sneakerltepdo.sql**

2/  config-type.php: **libraries > config-type.php**

3/  Tạo lang: **libraries > lang > langinit.php**

4/  Các phần nội dung liên quan đến ckeditor. Ra ngoài web lúc gọi mọi người sử dụng thêm hàm htmlspecialchars_decode(string) để bọc lại

5/  Do trên gitlab tự xóa các Folder rỗng trong upload. Tạo lại 1 trong các folder sau nếu bị thiếu:

    ** ckfinder, download, excel, mau, news, photo, product, seopage, sync, tags, temp, user **

6/  Cần lưu ý các config sau:
    
    // 'url' để lại dấu '/' khi up lên host
    
    'database' => array(
		'url' => '/',
	),
	
	// Để FALSE các config sau khi up lên host
	
	'website' => array(
    	'debug-developer' => false,
    	'debug-css' => false,
    	'debug-js' => false,
    ),
    
    // Slug - Seo chỉ nên để Tiếng Việt.
    // Chỉ sử dụng đa ngôn ngữ khi đường dẫn có yêu cầu vi/tenkhongdau hoặc en/tenkhongdau

    'slug' => array(
		'lang' => array(
			"vi"=>"Tiếng Việt",
			// "en"=>"Tiếng Anh"
		)
	),
    'seo' => array(
		'lang' => array(
			"vi"=>"Tiếng Việt",
			// "en"=>"Tiếng Anh"
		)
	)
    
    // Dùng để tạo phần Ngôn Ngữ SEO cho **Trang tĩnh trong admin** . Nếu trang không có ngôn ngữ khác thì chỉ cần thiết lập 'vi'
    
    'comlang' => array(
		"gioi-thieu" => array("vi"=>"gioi-thieu","en"=>"about-us"),
		"san-pham" => array("vi"=>"san-pham","en"=>"product"),
		"tin-tuc" => array("vi"=>"tin-tuc","en"=>"news"),
		"tuyen-dung" => array("vi"=>"tuyen-dung","en"=>"recruitment"),
		"thu-vien-anh" => array("vi"=>"thu-vien-anh","en"=>"gallery"),
		"video" => array("vi"=>"video","en"=>"video"),
		"lien-he" => array("vi"=>"lien-he","en"=>"contact")
	)
	
    // Khi làm ở local, tắt config active của google recaptcha bằng **FALSE** để có thể test được khi ko có mã captcha

    'googleAPI' => array(
		'recaptcha' => array(
			'active' => FALSE,
			'urlapi' => 'https://www.google.com/recaptcha/api/siteverify',
			'sitekey' => '6LezS5kUAAAAAF2A6ICaSvm7R5M-BUAcVOgJT_31',
			'secretkey' => '6LezS5kUAAAAAGCGtfV7C1DyiqlPFFuxvacuJfdq'
		)
	),