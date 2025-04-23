<?php

require_once __DIR__.'/_baseAPI.php';
require_once __DIR__.'/../database/Model/OrderHistory.php';
header('Content-Type: application/json');

if(is_post()){

    $id = (int)$_POST['id'];

    $pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();
    $orderModel = new OrderHistory($pdo);

    $success = $orderModel->delete($id);

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to delete order']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
