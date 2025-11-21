<?php
header('Content-Type: application/json');

// include connect để có $baseUrl nếu cần
require_once __DIR__ . '/../../controllers/connect.php';

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'Không nhận được file ảnh']);
    exit;
}

$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
if (!in_array($ext, $allowed)) {
    http_response_code(400);
    echo json_encode(['error' => 'Chỉ cho phép file ảnh jpg, jpeg, png, gif, webp']);
    exit;
}

// Đường dẫn thư mục upload trên filesystem: từ src/views/post -> ../../assets/uploads
$uploadDir = __DIR__ . '/../../assets/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$filename = uniqid('img_', true) . '.' . $ext;
$target = $uploadDir . $filename;
if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
    http_response_code(500);
    echo json_encode(['error' => 'Lỗi khi lưu file ảnh']);
    exit;
}

// Trả về URL ảnh có thể truy cập từ trình duyệt, dùng $baseUrl động
$imageUrl = rtrim($baseUrl, '/') . '/src/assets/uploads/' . $filename;

echo json_encode(['success' => 1, 'url' => $imageUrl]);
