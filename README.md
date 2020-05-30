**I. LƯU Ý:**
1/ Database: libraries > database > sneakerltepdo.sql
2/ File config-type.php: libraries > config-type.php
3/ File lang init: libraries > langinit.php

**II. Changelog**
+ Ngày: 22/05/2020
1/ Nâng cấp phần tạo file logs PDO (Thay thế dấu ? thành giá trị khi lưu file logs)
2/ Nâng cấp phần breadCrumd
3/ Tích hợp phân trang limit (Cả trong admin và bên ngoài)
4/ Chuyển các config trong config.php sang dạng mảng (Để tiện quản lý về sau)
5/ Tạo function bật tắt việc xử lý Recaptcha Google (Tắt active để test các form post khi ở dưới local)
6/ Chuyển các table sang tiếng anh (Các cột vẫn để Tiếng Việt)
7/ Bỏ table_tags_group. Lưu tags dạng chuỗi id.
8/ Tối ưu và chỉnh một số lỗi ở phiên bản trước.

+ Ngày: 22/05/2020
1/ Chuyển thư mục layout sang dạng define
2/ Chuyển các DEFINE sang in Hoa
3/ Chuyển toàn bộ dạng lưu dữ liệu sang dạng post mảng data[] trong admin
4/ Xóa thêm các trường dư thừa và không cần thiết trong CSDL
5/ Xóa các đoạn code dư thừa

+ Ngày: 26/05/2020
1/ Cập nhật thêm tính năng kéo thả hình ra làm multi
2/ Chỉnh lỗi phần POST mảng listid trong admin/ajax/ajax_filer.php

+ Ngày: 29/05/2020
1/ Chỉnh lại phần gán giá trị SESSION username trong file ajax_login.php