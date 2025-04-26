<?php

require_once __DIR__.'/_baseAPI.php';
require_once __DIR__.'/../database/Model/Cart.php';

header('Content-Type: application/json');

// 检查登录
if (!isLoggedIn()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    error_log("s");
    header("Location: " . BASE_URL . 'login?redirect='.urlencode('cart'));
    exit;
}

if(is_post()){
    // 获取产品数据，然后添加到cart数据库里
    $user_id = $_SESSION['user']['id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $color_code = $_POST['color_code'];
    $size = $_POST['size'];

    $pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();
    $cartModel = new Cart($pdo);

    $data = [
        'user_id' => $user_id,
        'product_id' => $product_id,
        'quantity' => $quantity,
        'color_code' => $color_code,
        'size' => $size,
    ];
    $success = $cartModel->addItem($data);

    if ($success) {
        flash_msg('Your item has been added to cart!');
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        flash_msg("Error adding to cart.", "error");
        echo json_encode(['success' => false, 'message' => 'Failed to add to cart']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}