# 📚 Hệ Thống Chia Sẻ Kiến Thức – Knowledge Sharing Platform

---

## 🧩 Tổng Quan

Hệ thống Chia Sẻ Kiến Thức là nền tảng cho phép người dùng đăng bài, tìm kiếm bài viết, lưu bài viết, xem danh sách bài viết đã lưu, xem lịch sử đọc, tương tác bằng bình luận, nhận thông báo khi có bình luận vào bài viết hay là phản hồi bình luận.  
Ngoài ra hệ thống tích hợp chat trực tuyến Messenger để trao đổi nhanh và hỗ trợ kịp thời.  
Ngoài tất cả chức năng giống người dùng, Admin có quyền quản lý toàn bộ bài đăng, chủ đề và tài khoản người dùng.

---

## ⚙️ Yêu Cầu Hệ Thống

### 🔧 Yêu Cầu Kỹ Thuật

- PHP 7.4 hoặc cao hơn  
- MySQL 5.7 hoặc cao hơn  
- Máy chủ web (Apache/Nginx)  
- PDO PHP Extension  
- Trình duyệt web hiện đại có hỗ trợ JavaScript  

### 🗄️ Cấu Hình Cơ Sở Dữ Liệu

- Host: `localhost`  
- Database: `cskt`  
- Username: `root`  
- Password: `""`  
- Cấu hình mật khẩu mặc định (có thể được sửa đổi trong `Config/Database.php`)

---

## 👥 Vai Trò Người Dùng và Quyền Truy Cập

### 👤 Người Dùng (User)

- Quản lý xác thực (Đăng ký/ đăng nhập/ đăng xuất/ cập nhật thông tin)  
- Tìm kiếm và xem bài viết  
- Quản lý bài đăng cá nhân (đăng, sửa, xóa)  
- Lưu bài viết & xem lại danh sách đã lưu  
- Xem lịch sử bài viết đã đọc  
- Bình luận bài viết  
- Nhận thông báo khi có người bình luận và phản hồi bình luận  
- Chat trực tuyến qua Messenger  

### 🛠️ Quản Trị Viên (Admin)

Ngoài tất cả quyền của User, Admin có thể:

- Quản lý bài đăng của người dùng (tìm kiếm, xem, xóa)  
- Quản lý chủ đề (Thêm, sửa, xóa)  
- Quản lý người dùng (tìm kiếm, phân quyền, xóa)  

---

## 🧾 Use Cases (Trường Hợp Sử Dụng)

### 🔐 Use Cases Quản Lý Xác Thực

#### 1.Đăng Nhập

- **Tác nhân:** User, Admin  
- **Mô tả:** Người dùng đăng nhập vào hệ thống bằng tên đăng nhập và mật khẩu  
- **Luồng chính:**  
  1. Truy cập trang đăng nhập  
  2. Nhập tài khoản và mật khẩu  
  3. Hệ thống kiểm tra thông tin  
  4. Điều hướng đến trang chính theo vai trò  

#### 2. Đăng Ký

- **Tác nhân:** Người dùng mới  
- **Mô tả:** Người dùng tạo tài khoản mới trong hệ thống  
- **Luồng chính:**  
  1. Vào trang đăng ký  
  2. Điền thông tin email, tên đăng nhập, mật khẩu  
  3. Hệ thống xác thực và lưu thông tin  
  4. Chuyển sang trang đăng nhập  

#### 3. Đăng Xuất

- **Tác nhân:** Người dùng đã đăng nhập  
- **Mô tả:** Người dùng đăng xuất khỏi hệ thống  
- **Luồng chính:**  
  1. Nhấn nút đăng xuất  
  2. Hệ thống xoá session  
  3. Chuyển hướng đến trang đăng nhập  

#### 4.Cập nhật thông tin

- **Tác nhân:** Người dùng đã đăng nhập  
- **Mô tả:** Người dùng thay đổi thông tin tài khoản  
- **Luồng chính:**  
  1. Nhấn vào thông tin tài khoản  
  2. Nhập thông tin cần thay đổi  
  3. Hệ thống lưu thông tin và hiển thị cập nhật thành công  

---

### 👤 Use Cases Người Dùng

#### 1. Tìm Kiếm Bài Viết và Xem Bài Viết

- **Tác nhân:** Người dùng đã đăng nhập  
- **Mô tả:** Người dùng tìm bài viết theo từ khóa và xem bài viết  
- **Luồng chính:**  
  1. Nhập từ khóa vào thanh tìm kiếm  
  2. Hệ thống thực hiện truy xuất từ CSDL và trả về danh sách bài viết  
  3. Chọn bài viết xem chi tiết  

#### 2. Quản Lý Bài Viết Cá Nhân

- **Tác nhân:** Người dùng đã đăng nhập  
- **Mô tả:** Người dùng có thể tự đăng bài viết mới, chỉnh sửa nội dung bài đã đăng và xóa các bài không còn muốn hiển thị.  
- **Luồng chính:**  
  1. Người dùng truy cập “Bài viết”.  
  2. Đăng bài mới  
  3. Xem danh sách bài đăng cá nhân  
  4. Chỉnh sửa bài đăng  
  5. Xóa bài đăng khỏi hệ thống  

#### 3. Lưu Bài Viết & Xem Danh Sách Bài Đã Lưu

- **Tác nhân:** Người dùng đã đăng nhập  
- **Mô tả:** Người dùng có thể lưu lại các bài viết yêu thích và xem lại.  
- **Luồng chính:**  
  1. Người dùng chọn một bài viết.  
  2. Nhấn nút “Lưu bài viết”.  
  3. Hệ thống kiểm tra xem bài đã được lưu trước đó hay chưa.  
  4. Nếu chưa lưu → hệ thống tạo bản ghi mới vào CSDL.  
  5. Người dùng truy cập “Bài viết”,chọn xem bài viết đã lưu  

#### 4. Xem lịch sử bài viết đã đọc

- **Tác nhân:** Người dùng đã đăng nhập  
- **Mô tả:** Hệ thống tự động ghi nhận các bài viết mà người dùng đã xem và cho phép xem lại danh sách này.  
- **Luồng chính:**  
  1. Người dùng mở một bài viết bất kỳ.  
  2. Hệ thống tự động ghi nhận bài viết đã đọc.  
  3. Người dùng truy cập mục “Lịch sử đọc bài viết”.  
  4. Hệ thống hiển thị danh sách các bài đã xem gần đây.  

#### 5. Bình Luận Bài Viết

- **Tác nhân:** Người dùng đã đăng nhập  
- **Mô tả:** Người dùng có thể bình luận vào bài viết hoặc trả lời bình luận của người khác.  
- **Luồng chính:**  
  1. Người dùng mở bài viết.  
  2. Nhập nội dung bình luận.  
  3. Hệ thống lưu bình luận .  
  4. Chỉnh sửa bình luận  
  5. Xóa bình luận  

#### 6. Nhận Thông Báo

- **Tác nhân:** Người dùng đã đăng nhập  
- **Mô tả:** Khi có người bình luận, like bài viết hay phản hồi bình luận của người dùng, họ sẽ nhận được thông báo.  
- **Luồng chính:**  
  1. Người dùng khác like hoặc bình luận bài viết.  
  2. Hệ thống cập nhật dữ liệu vào phần thông báo của chủ sở hữu.  

#### 7. Chat Messenger

- **Tác nhân:** Người dùng đã đăng nhập  
- **Mô tả:** Người dùng có thể tương tác nhanh với quản trị viên thông qua Messenger.  
- **Luồng chính:**  
  1. Người dùng nhấn vào biểu tượng chat Messenger.  
  2. Hệ thống mở cửa sổ chat Messenger .  
  3. Người dùng gửi tin nhắn trực tiếp.  

---

### 🛠️ Use Cases Admin

#### 1. Quản Lý Bài Đăng Người Dùng

- **Tác nhân:** Quản trị viên  
- **Mô tả:** Admin có thể tìm kiếm, xem hoặc xóa bài đăng của người dùng trong trường hợp vi phạm quy định.  
- **Luồng chính:**  
  1. Admin truy cập trang quản lý bài đăng.  
  2. Hệ thống hiển thị danh sách tất cả bài viết.  
  3. Tìm kiếm bài viết.  
  4. Xóa bài viết.  

#### 2. Quản Lý Chủ Đề

- **Tác nhân:** Quản trị viên  
- **Mô tả:** Admin tạo, cập nhật hoặc xóa các chủ đề bài viết.  
- **Luồng chính:**  
  1. Admin truy cập trang quản lý chủ đề.  
  2. Hệ thống hiển thị danh sách chủ đề hiện có.  
  3. Thêm chủ đề.  
  4. Sửa chủ đề.  
  5. Xóa chủ đề.  

#### 3. Quản Lý Người Dùng

- **Tác nhân:** Quản trị viên  
- **Mô tả:** Admin có thể xem danh sách người dùng, phân quyền Admin, khóa tài khoản hoặc xóa người dùng khỏi hệ thống.  
- **Luồng chính:**  
  1. Admin truy cập trang quản lý người dùng.  
  2. Hệ thống hiển thị danh sách người dùng.  
  3. Tìm kiếm người dùng.  
  4. Phân quyền người dùng.  
  5. Xóa người dùng.  

---

## ⭐ Tính Năng Chính

### 🔐 Hệ Thống Xác Thực

- Đăng nhập người dùng với tên đăng nhập và mật khẩu  
- Đăng ký người dùng  
- Mã hóa mật khẩu bằng `password_hash`  

### 📝 Quản Lý Bài Viết 

- Đăng bài viết mới  
- Chỉnh sửa bài viết  
- Xóa bài viết  
- Tìm kiếm và xem bài viết  
- Lưu bài viết và xem danh sách đã lưu  
- Xem lịch sử bài viết đã đọc  
- Bình luận bài viết  
- Nhận thông báo  
- Đề xuất các bài viết mới nhất  

### 💬 Chat Messenger

### 📄 Quản Lý Bài Đăng Người Dùng

- Tìm kiếm bài đăng  
- Xem bài viết  
- Xóa bài viết  

### 🏷️ Quản Lý Chủ Đề

- Thêm chủ đề  
- Chỉnh sửa chủ đề  
- Xóa chủ đề  

### 👥 Quản Lý Người Dùng

- Tìm kiếm người dùng  
- Phân quyền người dùng  
- Xóa người dùng  

---

## 🗂️ Mô Hình Dữ Liệu

Hệ thống sử dụng cơ sở dữ liệu MySQL gồm 7 bảng: `users`, `posts`, `comments`, `likes`, `bookmarks`, `read_history` và `notifications`.

---

### 1. Bảng **users** (Người dùng)

- **id** (INT, PK, AI): Mã người dùng  
- **username** (VARCHAR(50), UNIQUE): Tên đăng nhập  
- **password** (VARCHAR(255)): Mật khẩu đã mã hóa  
- **email** (VARCHAR(100), UNIQUE): Email người dùng  
- **role** (ENUM('admin','user')): Vai trò  
- **created_at** (TIMESTAMP): Ngày tạo tài khoản  

---

### 2. Bảng **posts** (Bài viết)

- **id** (INT, PK, AI): Mã bài viết  
- **user_id** (INT, FK → users.id): Người đăng bài  
- **title** (VARCHAR(255)): Tiêu đề bài viết  
- **content** (TEXT): Nội dung bài viết  
- **created_at** (TIMESTAMP): Thời gian đăng  
- **updated_at** (TIMESTAMP): Thời gian cập nhật gần nhất  

---

### 3. Bảng **comments** (Bình luận)

- **id** (INT, PK, AI): Mã bình luận  
- **post_id** (INT, FK → posts.id): Thuộc bài viết nào  
- **user_id** (INT, FK → users.id): Người bình luận  
- **parent_id** (INT, FK → comments.id, NULLABLE): Mã bình luận cha (hỗ trợ trả lời dạng thread)  
- **content** (TEXT): Nội dung bình luận  
- **created_at** (TIMESTAMP): Thời gian tạo  
- **updated_at** (TIMESTAMP): Thời gian cập nhật  

---

### 4. Bảng **likes** (Thích / Không thích)

- **id** (INT, PK, AI): Mã like  
- **post_id** (INT, FK → posts.id): Thuộc bài viết nào  
- **user_id** (INT, FK → users.id): Ai đã like  
- **type** (ENUM('like', 'dislike')): Loại tương tác  
- **created_at** (TIMESTAMP): Thời gian tạo  
- **unique_like** (post_id, user_id): Mỗi người chỉ được like/dislike bài 1 lần  

---

### 5. Bảng **bookmarks** (Bài viết đã lưu)

- **id** (INT, PK, AI): Mã lưu bài  
- **user_id** (INT, FK → users.id): Người lưu  
- **post_id** (INT, FK → posts.id): Bài được lưu  
- **created_at** (DATETIME): Thời gian lưu  
- **unique_bookmark** (user_id, post_id): Mỗi bài chỉ được lưu 1 lần cho mỗi user  

---

### 6. Bảng **read_history** (Lịch sử đọc bài viết)

- **id** (INT, PK, AI): Mã lịch sử  
- **user_id** (INT, FK → users.id): Người đọc  
- **post_id** (INT, FK → posts.id): Bài viết đã đọc  
- **last_read_at** (DATETIME): Lần đọc gần nhất  
- **unique_read** (user_id, post_id): Không tạo trùng lịch sử  

---

### 7. Bảng **notifications** (Thông báo)

- **id** (INT, PK, AI): Mã thông báo  
- **receiver_id** (INT, FK → users.id): Người nhận thông báo  
- **sender_id** (INT, FK → users.id): Người thực hiện hành động (like/comment)  
- **post_id** (INT, FK → posts.id): Bài viết liên quan  
- **comment_id** (INT, FK → comments.id, NULLABLE): Bình luận liên quan (nếu có)  
- **type** (ENUM('like','comment')): Loại thông báo  
- **created_at** (DATETIME): Thời gian tạo  
- **seen** (TINYINT(1)): Trạng thái (0 = chưa xem, 1 = đã xem)  
- **Chỉ mục hỗ trợ:**  
  - idx_receiver_id  
  - idx_sender_id  
  - idx_post_id  
  - idx_comment_id  

---

## 🖥️ Yêu Cầu Giao Diện Người Dùng

- Thiết kế giao diện responsive, hiển thị tốt trên cả máy tính và thiết bị di động.  
- Giao diện tối giản, dễ nhìn, phù hợp cho việc đọc bài viết dài.  
- Thanh điều hướng rõ ràng.  
- Màu sắc hài hòa, ưu tiên trải nghiệm đọc và tương tác.  
- Tối ưu tốc độ tải trang và thời gian phản hồi của giao diện.  
- Hỗ trợ đầy đủ tiếng Việt (Unicode UTF-8).  

---

## 📊 Yêu Cầu Báo Cáo

- Thống kê tổng số bài viết.  
- Thống kê tổng số người dùng.  

---

## 🔒 Yêu Cầu Bảo Mật

- Mã hóa mật khẩu người dùng bằng `password_hash()` trước khi lưu vào cơ sở dữ liệu.  
- Quản lý phiên làm việc  
- Xác thực đầu vào  
- Kiểm soát truy cập dựa trên vai trò  

---

## 🏗️ Cấu Trúc Dự Án

- `/src/assets` – Các file ảnh  
- `/src/config` - Các file cấu hình cho cơ sở dữ liệu và cài đặt hệ thống  
- `/src/controllers` - Các bộ điều khiển ứng dụng để xử lý yêu cầu  
- `/src/database` - Cơ sở dữ liệu  
- `/src/layout` - Giao diện khung  
- `/src/middleware` - Bộ lọc request (kiểm tra đăng nhập, phân quyền)  
- `/src/models` – Các mô hình dữ liệu cho tương tác cơ sở dữ liệu  
- `/src/styles` – Các file css  
- `/src/views` – Các file giao diện trả về cho người dùng  
- `/index.php` – File khởi động ứng dụng  

---

## ⚙️ Chi Tiết Triển Khai

- Kiến trúc MVC (Model-View-Controller)  
- PDO cho tương tác cơ sở dữ liệu  
- Phân quyền dựa vào session  
- Tách biệt logic nghiệp vụ khỏi giao diện  

---

## 🛣️ Các Tuyến Đường (Routes) Chính

### User

### Admin

---

## 📖 Hướng Dẫn Sử Dụng

Tài liệu hướng dẫn chi tiết cách sử dụng hệ thống có thể được tìm thấy trong thư mục `/docs`.
