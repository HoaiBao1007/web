<?php
session_start();
require_once 'app/models/ProductModel.php';
require_once 'app/helpers/SessionHelper.php';

// Lấy URL và xử lý dữ liệu đầu vào
$url = $_GET['url'] ?? ''; 
$url = trim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$urlParts = explode('/', $url);

// Xác định controller và action mặc định
$controllerName = !empty($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : 'ProductController';
$action = $urlParts[1] ?? 'index';

// Đường dẫn file controller
$controllerPath = 'app/controllers/' . $controllerName . '.php';

// Kiểm tra file controller tồn tại
if (!file_exists($controllerPath)) {
    http_response_code(404);
    die('❌ Controller not found!');
}

// Nhúng file controller
require_once $controllerPath;

// Kiểm tra class có tồn tại không
if (!class_exists($controllerName)) {
    http_response_code(500);
    die('❌ Controller class does not exist!');
}

// Khởi tạo controller
$controller = new $controllerName();

// Kiểm tra method (action) có tồn tại không
if (!method_exists($controller, $action)) {
    http_response_code(404);
    die('❌ Action not found!');
}

// Gọi action với các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($urlParts, 2));
?>
