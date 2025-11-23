# Tài liệu hướng dẫn sử dụng Website chia sẻ kiến thức

## 1. Giới thiệu  
Phần mềm là nền tảng chia sẻ kiến thức kiểm thử phần mềm, giúp người học dễ dàng tiếp cận tài liệu, đăng bài viết, trao đổi kinh nghiệm và cập nhật xu hướng Testing mới nhất. Hệ thống giải quyết tình trạng kiến thức kiểm thử hiện nay đang phân tán, khó tìm và nhiều tài liệu tiếng Anh.
Phần mềm hỗ trợ người dùng đăng bài, tìm kiếm, bình luận; và admin quản lý bài đăng, chủ đề và người dùng. Đây là môi trường học tập trực quan, dễ hiểu và có lộ trình rõ ràng cho người mới bắt đầu.

## 2. Chức năng theo vai trò

### 2.1 Người dùng ( User)

#### Quản lý xác thực 
##### Đăng nhập
        - Truy cập đường dẫn : ' /post_web/src/views/auth/login.php ' 
        - Chức năng: 
          - Hiển thị form đăng nhập chung cho cả user thường và admin
          - Nhận username + password, xử lý đăng nhập qua LoginController.php
          - Hiển thị thông báo lỗi nếu đăng nhập thất bại
          - Tạo session và tự động chuyển hướng sau khi đăng nhập thành công
          → Admin → vào Admin Panel
          → User → về trang chủ
          - Cung cấp link chuyển sang trang đăng ký
          - Là trang đăng nhập DUY NHẤT của toàn bộ website
##### Đăng ký 
        - Truy cập đường dẫn : ' /post_web/src/views/auth/register.php '
        - Chức năng: 
          - Hiển thị form đăng ký tài khoản mới cho người dùng
          - Yêu cầu nhập: Username + Email + Password + Confirm Password
          - Kiểm tra và hiển thị thông báo lỗi (nếu username/email đã tồn tại, mật khẩu không khớp, mật khẩu < 6 ký tự, …)
          - Hiển thị thông báo thành công khi đăng ký xong
          - Tự động lưu tài khoản mới vào CSDL (xử lý bởi RegisterController.php)
          - Mật khẩu được yêu cầu ít nhất 6 ký tự (hiển thị cảnh báo màu đỏ)
          - Có link quay lại trang đăng nhập
          - Là trang đăng ký duy nhất của toàn hệ thống (dùng chung cho cả user và admin)
##### Đăng xuất
        - Truy cập đường dẫn : ' /post_web/src/views/auth/logout.php '
        - Chức năng: 
          - Kiểm tra trạng thái đăng nhập (qua AuthMiddleware.php)
          - Thực hiện đăng xuất hoàn toàn: xóa toàn bộ session (user_id, username, role, …)
          - Hủy phiên làm việc hiện tại của người dùng
          - Tự động chuyển hướng về trang chủ hoặc trang login sau khi đăng xuất xong
          - Dùng chung cho cả user thường và admin (ai bấm “Đăng xuất” đều đi qua file này)
#### Tìm kiếm và xem bài viết 
        - Truy cập đường dẫn: '  /post_web/index.php '
        - Chức năng:
          - Hiển thị danh sách bài viết mới nhất
          - Có thanh tìm kiếm thông minh (tìm theo từ khóa + lọc theo chủ đề)
          - Hiển thị thông tin tác giả (avatar + tên), lượt like/dislike, ngày đăng
          - Tự động cuộn xuống phần kết quả khi tìm kiếm

#### Quản lý bài đăng cá nhân
        - Truy cập đường dẫn: ' /post_web/src/views/post/my_posts.php ' 
        - Chức năng:
          - Hiển thị toàn bộ bài viết do chính bạn tạo
          - Cho phép tìm kiếm bài viết của mình theo từ khóa
          - Hiển thị: tiêu đề, tóm tắt, lượt like/dislike, ngày đăng, avatar tác giả
          - Cho phép xóa bài viết (có xác nhận)
          - Khi xóa bài: tự động xóa luôn tất cả ảnh đã upload trong bài viết → cực kỳ sạch sẽ và chuyên nghiệp
#### Lưu bài viết & xem lại bài viết đã lưu
        - Truy cập đường dẫn : '/post_web/src/views/bookmarks.php'
        - Chức năng: 
          - Hiển thị danh sách tất cả bài viết mà người dùng hiện tại đã lưu (bookmark)
          - Mỗi bài hiển thị: tiêu đề, tóm tắt nội dung, lượt like/dislike, ngày lưu
          - Cho phép người dùng đọc tiếp bài viết
          - Cho phép người dùng hủy lưu (xóa khỏi danh sách đã lưu) với xác nhận
          - Nếu chưa lưu bài nào → hiện thông báo “Bạn chưa có bài viết đã lưu nào.”
#### Xem lịch sử bài viết đã đọc
        - Truy cập đường dẫn : ' /post_web/src/views/history.php ' 
        - Chức năng: 
          - Hiển thị danh sách tất cả bài viết mà bạn từng đọc
          - Mỗi bài hiển thị: → Tiêu đề bài viết → Thời gian đọc lần cuối (ngày giờ chính xác)
          - Click vào tiêu đề → quay lại đọc tiếp bài đó
          - Nếu chưa đọc bài nào → hiện thông báo thân thiện: “Bạn chưa đọc bài viết nào.”
#### Bình luận & đánh giá bài viết
        - Truy cập đường dẫn: '  /post_web/src/views/post/post.php '
        - Chức năng:
          - Hiển thị toàn bộ nội dung bài viết với định dạng đẹp (rich text + ảnh)
          - Hiển thị tác giả (avatar + tên thật/username), ngày đăng
          - Cho phép thích / không thích / lưu bài viết / chia sẻ (Web Share API + fallback copy link)
          - Cho phép bình luận + trả lời bình luận (reply) đầy đủ, có phân cấp
          - Hỗ trợ sửa / xóa bình luận (chỉ chủ bình luận hoặc admin)
          - Hiển thị tất cả trả lời bình luận, có nút “Xem thêm”
#### Nhận thông báo khi có người bình luận và phản hồi 
        - Truy cập đường dẫn : src/views/notification/notifications.php
        - Chức năng:
          - Hiển thị toàn bộ thông báo của người dùng hiện tại
          - Phân biệt thông báo đã đọc / chưa đọc
          - Hiển thị nội dung thông báo rõ ràng
          - Tự động lấy tiêu đề bài viết bị bình luận/trả lời
          - Hiển thị thời gian nhận thông báo
          - Thông báo trống → hiện thông báo thân thiện 

### 2.2 Quản trị viên ( Admin)
        Ngoài tất cả quyền của User , Admin có thể : 
#### Quản lý người dùng
        - Truy cập đường dẫn  : '  /post_web/src/views/admin/users.php ' 
        - Chức năng:
          - Hiển thị danh sách tất cả người dùng trong hệ thống
          - Cho phép admin tìm kiếm người dùng theo từ khóa
          - Cho phép admin đổi vai trò (User ↔ Admin) ngay lập tức
          - Cho phép admin xóa người dùng (có xác nhận, không cho xóa chính mình)
          - Hiển thị thông tin: ID, Username/Họ tên, Email, Role, Avatar, Ngày tạo
          - Không cho phép thay đổi role của chính admin đang đăng nhập (bảo vệ tài khoản)
          - Hỗ trợ phân trang khi có nhiều người dùng
#### Quản lý chủ đề 
        - Truy cập đường dẫn  : ' /post_web/src/views/admin/topics.php ' 
        - Chức năng:
          - Hiển thị danh sách tất cả các chủ đề hiện có trên website
          - Cho phép admin thêm chủ đề mới (qua modal)
          - Cho phép admin sửa tên chủ đề (modal chỉnh sửa + JavaScript tự động điền dữ liệu)
          - Cho phép admin xóa chủ đề (có xác nhận cảnh báo trước khi xóa)
          - Hiển thị thông tin: ID, tên chủ đề, ngày tạo
          - Hiển thị thông báo lỗi/thành công khi thực hiện thao tác
#### Quản lý bài đăng của người dùng
        - Truy cập đường dẫn  : ' /post_web/src/views/admin/topics.php ' 
        - Chức năng:
          - Hiển thị danh sách toàn bộ bài đăng trên website
          - Cho phép admin tìm kiếm bài viết theo từ khóa
          - Hiển thị thông tin chi tiết: ID, tiêu đề, chủ đề, tác giả, ngày đăng, lượt like/dislike/bình luận
          - Cho phép admin xem chi tiết bài viết (nút Xem)
          - Cho phép admin xóa bài viết bất kỳ (có xác nhận trước khi xóa)
          - Hỗ trợ phân trang (có nút chuyển trang)
          - Hiển thị thông báo lỗi/thành công khi thao tác
          - Giao diện admin đầy đủ với sidebar điều hướng (Dashboard, Quản lý người dùng, Quản lý chủ đề, Đăng xuất…)

## 3. Hướng dẫn tìm kiếm bài viết
### 3.1 Tìm kiếm cơ bản
        1. Truy cập vào trang chủ của blog:  ' /post_web/index.php '
        2. Tại trang chủ, bạn sẽ thấy ngay thanh tìm kiếm lớn ở giữa màn hình
        3. Điền các tiêu chí tìm kiếm:
          - Từ khóa: nhập từ cần tìm (ví dụ: Laravel, Quill, upload ảnh…)
          - Chủ đề (tùy chọn): chọn từ dropdown “Chọn chủ đề”
        4. Nhấn nút “Tìm kiếm” hoặc nhấn Enter
        5. Kết quả sẽ hiển thị ngay bên dưới dạng card bài viết, có phân trang nếu nhiều kết quả
### 3.2 Tìm kiếm và xem bài viết nâng cao (dành cho thành viên đã đăng nhập)
        1. Truy cập : ' /post_web/src/views/post/my_posts.php '
        2.  Thông tin chi tiết bài viết sẽ hiển thị:
          - Thông tin cơ bản: tên, chủ đề, trạng thái, thời gian đăng
          - Danh sách bài viết đã tìm kiếm ( nếu có )
          - Sắp xếp theo : Mới nhất, Cũ nhất, Nhiều lượt thích nhất, Nhiều bình luận nhất
        3. Chọn thêm bộ lọc tùy chọn (nếu cần):
          - Chỉ hiển thị bài có hình ảnh
          - Chỉ hiển thị bài đã được lưu (Bookmark) bởi người khác
          - Chỉ hiển thị bài có từ 5 bình luận trở lên
        4. Nhấn nút “Tìm kiếm nâng cao” hoặc “Lọc” để xem kết quả

## 4. Hướng dẫn đăng bài chia sẻ
        1. Truy cập : ' /post_web/src/views/post/create.php ' 
        2. Điền đầy đủ thông tin bài viết: 
          - Tiêu đề bài viết  (bắt buộc )
          - Chủ đề → chọn 1 trong các chủ đề có sẵn, hoặc nhập chủ đề
          - Nội dung phù hợp
        3. Xem trước bài viết (tùy chọn) : Nội dung sẽ hiển thị realtime giống hệt khi đăng
        4. Nhấn nút ' Đăng bài ' 
        5. Kết quả: Bài viết được đăng thành công → chuyển ngay đến trang chi tiết bài viết

## 5. Các trang báo lỗi 
### 5.1 Trang lỗi 403 - Truy cập bị từ chối
        1. Truy cập đường dẫn: ' /post_web/src/views/errors/403.php '
        2. Chức năng
          - Hiển thị khi người dùng cố tình truy cập vào trang không có quyền (ví dụ: user thường vào trang admin, hoặc khách vào trang cần đăng nhập)
          - Thông báo rõ ràng: “Bạn không có quyền truy cập vào nội dung này.”
          - Có nút Quay về trang chủ
### 5.2 Trang lỗi 404 - Không tìm thấy trang 
        1. Truy cập đường dẫn: ' /post_web/src/views/errors/404.php ' 
        2. Chức năng:
          - Hiển thị khi người dùng truy cập vào URL không tồn tại hoặc đã bị xóa
          - Thông báo rõ ràng: “Trang bạn yêu cầu không tồn tại.”
          - Có nút Quay về trang chủ
### 5.3 Trang lỗi 500 - Lỗi máy chủ nội bộ
        1. Truy cập đường dẫn : ' /post_web/src/views/errors/500.php ' 
        2. Chức năng:
          - Hiển thị khi có lỗi nghiêm trọng trong code PHP (lỗi cú pháp, lỗi database, exception chưa bắt, v.v.)
          - Thông báo an toàn, thân thiện: “Đã xảy ra lỗi trên máy chủ. Vui lòng thử lại sau.”
          - Có nút Quay về trang chủ

## 6. Lưu ý quan trọng 
        - Phải đăng nhập mới được đăng bài, sửa bài, xóa bài, bình luận, lưu bài, xem lịch sử đọc, xem thông báo
        - Chỉ chủ bài viết hoặc Admin mới được sửa/xóa bài viết
        - Khi xóa bài viết → tất cả ảnh trong bài sẽ tự động bị xóa khỏi thư mục uploads
        - Thông báo bình luận & trả lời bình luận chỉ hiển thị cho người đã đăng nhập
        









   


