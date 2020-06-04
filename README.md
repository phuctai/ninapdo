**NOTES**

1/  Database: **libraries > database > sneakerltepdo.sql**

2/  File config-type.php: **libraries > config-type.php**

3/  File lang init: **libraries > langinit.php**

4/  Các config sau mặc định để **FALSE**
    
    // Chỉ bật **TRUE** khi website đó có yêu cầu về link ngôn ngữ **(vi/TENKHONGDAU,en/TENKHONGDAU)**
    // Khi bật lên mà ko có link ngôn ngữ sẽ báo **lỗi code tối ưu link**

    'slug' => array(
    	'lang-active' => false
    ),
    'seo' => array(
    	'lang' => false,
    	'headings' => false,
    ),
    
5/  Config **comlang** dùng để tạo phần ngôn ngữ seo cho t**rang tĩnh và các com trên thanh menu bên ngoài**
    
    // Áp dụng cho menu và phần SEO trong admin
    
    'comlang' => array(
		"gioi-thieu" => array("vi"=>"gioi-thieu","en"=>"about-us"),
		"san-pham" => array("vi"=>"san-pham","en"=>"product"),
		"tin-tuc" => array("vi"=>"tin-tuc","en"=>"news"),
		"tuyen-dung" => array("vi"=>"tuyen-dung","en"=>"recruitment"),
		"thu-vien-anh" => array("vi"=>"thu-vien-anh","en"=>"gallery"),
		"video" => array("vi"=>"video","en"=>"video"),
		"lien-he" => array("vi"=>"lien-he","en"=>"contact")
	)
	
6/  Khi làm ở local, tắt config active của google recaptcha bằng **FALSE** để có thể test được khi ko có mã captcha

    'googleAPI' => array(
		'recaptcha' => array(
			'active' => FALSE,
			'urlapi' => 'https://www.google.com/recaptcha/api/siteverify',
			'sitekey' => '6LezS5kUAAAAAF2A6ICaSvm7R5M-BUAcVOgJT_31',
			'secretkey' => '6LezS5kUAAAAAGCGtfV7C1DyiqlPFFuxvacuJfdq'
		)
	),
	
7/  Các config từ dòng **Error reporting** trở xuống các bạn không cần cấu hình vì đã được đặt mặc định

**CHANGELOG**

**Ngày: 22/05/2020**

1/  Nâng cấp phần tạo file logs PDO (Thay thế dấu ? thành giá trị khi lưu file logs)

2/  Nâng cấp phần breadCrumd

3/  Tích hợp phân trang limit (Cả trong admin và bên ngoài)

4/  Chuyển các config trong config.php sang dạng mảng (Để tiện quản lý về sau)

5/  Tạo function bật tắt việc xử lý Recaptcha Google (Tắt active để test các form post khi ở dưới local)

6/  Chuyển các table sang tiếng anh (Các cột vẫn để Tiếng Việt)

7/  Bỏ table_tags_group. Lưu tags dạng chuỗi id.

8/  Tối ưu và chỉnh một số lỗi ở phiên bản trước.

**Ngày: 24/05/2020**

1/  Chuyển thư mục layout sang dạng define

2/  Chuyển các DEFINE sang in Hoa

3/  Chuyển toàn bộ dạng lưu dữ liệu sang dạng post mảng data[] trong admin

4/  Xóa thêm các trường dư thừa và không cần thiết trong CSDL

5/  Xóa các đoạn code dư thừa

**Ngày: 26/05/2020**

1/  Cập nhật thêm tính năng kéo thả hình ra làm multi

2/  Chỉnh lỗi phần POST mảng listid trong admin/ajax/ajax_filer.php

**Ngày: 29/05/2020**

1/  Chỉnh lại phần gán giá trị SESSION username trong file ajax_login.php

**Ngày: 30/05/2020**

1/  Chỉnh lại các define website, define ngôn ngữ, bỏ các '_' đầu dòng của define

2/  Chỉnh lỗi cập nhật thông tin user khi không nhập password

**Ngày: 02/06/2020**

1/  Chỉnh lại giao diện thêm, sửa, xóa của 3 danh mục cấp 2,3,4 của mục News

2/  Chỉnh lại phần slug không cho preview khi ở trang tĩnh, seopage, setting

**Ngày: 03/06/2020**

1/  Chỉnh lỗi xóa thuộc tính khi xóa sản phẩm, bài viết

2/  Tối ưu chức năng kiểm tra slug và seo