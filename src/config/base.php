<?php

/**
 * Trả về BASE URL dạng '/project_folder' hoặc '' nếu chạy ở root
 * Có thể ghi đè bằng cách define('BASE_URL_OVERRIDE', '/myfolder') trước khi include
 */
if (!function_exists('getBaseUrl')) {
    function getBaseUrl(): string
    {
        // Nếu có override thì dùng ngay
        if (defined('BASE_URL_OVERRIDE') && BASE_URL_OVERRIDE !== '') {
            return BASE_URL_OVERRIDE;
        }

        // Thử lấy từ SCRIPT_NAME (ví dụ: /post_web/index.php)
        if (!empty($_SERVER['SCRIPT_NAME'])) {
            $segments = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
            if (!empty($segments[0])) {
                return '/' . $segments[0];
            }
        }

        // Thử lấy từ REQUEST_URI làm fallback
        if (!empty($_SERVER['REQUEST_URI'])) {
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $segments = explode('/', trim($path, '/'));
            if (!empty($segments[0])) {
                return '/' . $segments[0];
            }
        }

        // Nếu không xác định được, trả về rỗng (tức root)
        return '';
    }
}
