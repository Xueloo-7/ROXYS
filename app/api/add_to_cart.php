<?php

// 定义这是api文件，让base.php里的head.php不要输出html
define('IS_API', true);

require_once __DIR__.'/../../base.php';
require_once __DIR__.'/../database/Model/Cart.php';
require_once __DIR__.'/../config/DatabaseConfig.php';
require_once __DIR__.'/../database/Database.php';

header('Content-Type: application/json');

if(is_post()){
    // 获取产品数据，然后添加到cart数据库里
    $user_id = '';
    $product_id = '';
    $quantity = '';
    $color_code = '';
    $size = '';

    $pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();
    $cartModel = new Cart($pdo);

    // 更新产品
    $data = [
        'user_id' => $user_id,
        'product_id' => $product_id,
        'quantity' => $quantity,
        'color_code' => $color_code,
        'size' => $size,
    ];
    $success = $cartModel->addItem($data);

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to add to cart']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}