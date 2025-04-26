<?php

require_once __DIR__.'/_baseAPI.php';
require_once __DIR__.'/../database/Model/Product.php';

header('Content-Type: application/json');

if(is_post()){
    // $id = (int)$_POST['id'];
    $name = trim($_POST['name'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $discount = (int)($_POST['discount'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $details = trim($_POST['details'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $sizes = array_filter(array_map('trim', explode(',', $_POST['sizes'] ?? '')));
    $colors = array_filter(array_map('trim', explode(',', $_POST['colors'] ?? '')));

    $pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();
    $productModel = new Product($pdo);

    $data = [
        'name' => $name,
        'price' => $price,
        'discount' => $discount,
        'stock' => $stock,
        'description' => $description,
        'details' => $details,
        'image_url' => $image_url,
        'category' => $category,
    ];
    $success = $productModel->createFullProduct($data, $sizes, $colors);

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to create product']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}