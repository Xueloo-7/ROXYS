<?php

require_once __DIR__.'/_baseAPI.php';
require_once __DIR__.'/../database/Model/Review.php';

header('Content-Type: application/json');

// 检查登录
if (!isLoggedIn()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();
$reviewModel = new Review($pdo);
$user_id = $_SESSION['user']['id'];

if (is_post()) {
    $product_id = $_POST['product_id'] ?? null;
    $rating = $_POST['rating'] ?? null;
    $review_text = $_POST['review_text'] ?? '';

    // 简单验证
    if (!$product_id || !$rating) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    // 插入评论
    $success = $reviewModel->create([
        'product_id' => $product_id,
        'user_id' => $user_id,
        'rating' => $rating,
        'review_text' => $review_text
    ]);

    if ($success) {
        flash_msg("Success to submit review!");
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to insert review']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
