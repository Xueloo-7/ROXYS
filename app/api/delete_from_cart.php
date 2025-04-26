<?php

require_once __DIR__.'/_baseAPI.php';
require_once __DIR__.'/../database/Model/Cart.php';

header('Content-Type: application/json');

if(is_post()){
    $user_id = (int)$_SESSION['user']['id'];
    $cart_id = (int)$_POST['cart_id'];

    $pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();
    $cartModel = new Cart($pdo);

    $success = $cartModel->removeItem($user_id, $cart_id);

    if ($success) {
        flash_msg("Delete From Cart");
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        flash_msg("Failed to delete order");
        echo json_encode(['success' => false, 'message' => 'Failed to delete order']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
