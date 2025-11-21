<?php
// Thiết lập đường dẫn cơ sở động cho các liên kết trong giao diện.
// Hàm `getBaseUrl()` cố gắng suy ra thư mục gốc dự án (ví dụ '/post_web').
require_once __DIR__ . '/../config/base.php';
$baseUrl = getBaseUrl();

require_once __DIR__ . '/../config/database.php'; // Kết nối CSDL
require_once __DIR__ . '/../middleware/AuthMiddleware.php'; // Kiểm tra đăng nhập, xác thực người dùng
