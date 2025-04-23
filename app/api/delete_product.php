<?php

// 定义这是api文件，让base.php里的head.php不要输出html
define('IS_API', true);

require_once __DIR__.'/../../base.php';
require_once __DIR__.'/../database/Model/Product.php';
require_once __DIR__.'/../config/DatabaseConfig.php';
require_once __DIR__.'/../database/Database.php';

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
