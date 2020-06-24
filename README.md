**NOTES**

1/  Database: **libraries > database > sneakerltepdo.sql**

2/  config-type.php: **libraries > config-type.php**

3/  Lang Init: **libraries > lang > langinit.php**

4/  **Sitemap** cấu hình trong config-type.php

5/  Các phần nội dung liên quan đến ckeditor. Ra ngoài web lúc gọi mọi người sử dụng thêm hàm tmlspecialchars_decode(string) để bọc lại .

6/  Các config sau cần lưu ý
    
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
    
7/  Config **comlang** dùng để tạo phần Ngôn Ngữ SEO cho **Trang tĩnh trong admin**
    
    'comlang' => array(
		"gioi-thieu" => array("vi"=>"gioi-thieu","en"=>"about-us"),
		"san-pham" => array("vi"=>"san-pham","en"=>"product"),
		"tin-tuc" => array("vi"=>"tin-tuc","en"=>"news"),
		"tuyen-dung" => array("vi"=>"tuyen-dung","en"=>"recruitment"),
		"thu-vien-anh" => array("vi"=>"thu-vien-anh","en"=>"gallery"),
		"video" => array("vi"=>"video","en"=>"video"),
		"lien-he" => array("vi"=>"lien-he","en"=>"contact")
	)
	
8/  Khi làm ở local, tắt config active của google recaptcha bằng **FALSE** để có thể test được khi ko có mã captcha

    'googleAPI' => array(
		'recaptcha' => array(
			'active' => FALSE,
			'urlapi' => 'https://www.google.com/recaptcha/api/siteverify',
			'sitekey' => '6LezS5kUAAAAAF2A6ICaSvm7R5M-BUAcVOgJT_31',
			'secretkey' => '6LezS5kUAAAAAGCGtfV7C1DyiqlPFFuxvacuJfdq'
		)
	),
	
9/  Các config từ dòng **Error reporting** trở xuống các bạn không cần cấu hình vì đã được đặt mặc định

**CHANGELOG**

**Ngày: 22/06/2020**

1/ Viết lại phần Seo, Breadcrumd, Watermark (Cơ bản - Nâng cao), Thumbs.

2/ Tích hợp PHPMailer mới.

3/ Chuyển các cột của setting sang dạng json.

**Ngày: 16/06/2020**

1/ Lưu cache file js bằng LocalStorage.

2/ Tạo watermark bằng Router. Cho thay đổi vị trí trong admin.

3/ Xóa toàn bộ các code kiểm tra Slug - Seo đa ngôn ngữ. Mặc định chạy Tiếng Việt. Sau này lập trình sẽ tự làm phần này.

4/ Xóa chức năng tạo thuộc tính động trong phần sản phẩm.

5/ Chuyển nút xóa bộ file tạm lên phần tool header của admin (Bản trước để trong phần Thông Tin Công Ty)

6/ Xóa các đoạn code dư thừa

**Ngày: 13/06/2020**

1/ Slug: Kiểm tra slug không cho get_slug từ csdl tránh tốn tài nguyên.

2/ AntiSQLInjection: Chỉ gọi và sử dụng bên ngoài web. Không dùng trong admin

3/ Sắp xếp các thư mục index.php, class, css, ... gọn gàng hơn

4/ Sitemap: Em tạo config type sitemap. Do Router xử lý nhiều nên e ko cho đồng bộ với router.

5/ Timthumb: Bỏ cột thumb trong csdl. Xử lý dựa trên link thumbs của router (Toàn bộ website)

6/ Set dung lượng upload hình < 4mb

7/ Xử lý lưu cache SQL, xóa cache trong admin khi người dùng thao tác trong admin

8/ Viết thêm Class Css Minify (Debug: True/Flase ko bị lỗi url trong các file css - Quy định đặt images và fonts e sẽ báo cáo sau)

9/ Đổi tên Class in hoa chữ cái đầu cho đồng bộ.

10/ Bỏ '&' trên router. Đổi thành '?'. Em viết thêm điều kiện kiểm tra trong hàm Pagination.

11/ Viết phần 'Nhớ mật khẩu' cho đăng nhập bên ngoài. Tự logout khi user đăng nhập ở thiết bị khác.

12/ Tách user thành 2 table: table_member - table_user

**Ngày: 09/06/2020**

1/ Tích hợp Router thay thế cho Htaccess

**Ngày: 08/06/2020**

1/ Chuyển các thư viện sang dạng hướng đối tượng

**Ngày: 03/06/2020**

1/  Chỉnh lỗi xóa thuộc tính khi xóa sản phẩm, bài viết

2/  Tối ưu chức năng kiểm tra slug và seo

**Ngày: 02/06/2020**

1/  Chỉnh lại giao diện thêm, sửa, xóa của 3 danh mục cấp 2,3,4 của mục News

2/  Chỉnh lại phần slug không cho preview khi ở trang tĩnh, seopage, setting

**Ngày: 30/05/2020**

1/  Chỉnh lại các define website, define ngôn ngữ, bỏ các '_' đầu dòng của define

2/  Chỉnh lỗi cập nhật thông tin user khi không nhập password

**Ngày: 29/05/2020**

1/  Chỉnh lại phần gán giá trị SESSION username trong file ajax_login.php

**Ngày: 26/05/2020**

1/  Cập nhật thêm tính năng kéo thả hình ra làm multi

2/  Chỉnh lỗi phần POST mảng listid trong admin/ajax/ajax_filer.php

**Ngày: 24/05/2020**

1/  Chuyển thư mục layout sang dạng define

2/  Chuyển các DEFINE sang in Hoa

3/  Chuyển toàn bộ dạng lưu dữ liệu sang dạng post mảng data[] trong admin

4/  Xóa thêm các trường dư thừa và không cần thiết trong CSDL

5/  Xóa các đoạn code dư thừa

**Ngày: 22/05/2020**

1/  Nâng cấp phần tạo file logs PDO (Thay thế dấu ? thành giá trị khi lưu file logs)

2/  Nâng cấp phần breadCrumd

3/  Tích hợp phân trang limit (Cả trong admin và bên ngoài)

4/  Chuyển các config trong config.php sang dạng mảng (Để tiện quản lý về sau)

5/  Tạo function bật tắt việc xử lý Recaptcha Google (Tắt active để test các form post khi ở dưới local)

6/  Chuyển các table sang tiếng anh (Các cột vẫn để Tiếng Việt)

7/  Bỏ table_tags_group. Lưu tags dạng chuỗi id.

8/  Tối ưu và chỉnh một số lỗi ở phiên bản trước.