<?php

require_once __DIR__.'/_baseAPI.php';
require_once __DIR__.'/../database/Model/Product.php';

header('Content-Type: application/json');

if(is_post()){

    $id = (int)$_POST['id'];

    $pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();
    $productModel = new Product($pdo);

    $success = $productModel->delete($id);

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to delete product']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
