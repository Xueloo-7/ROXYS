<?php

require_once __DIR__.'/_baseAPI.php';
require_once __DIR__.'/../database/Model/OrderHistory.php';

header('Content-Type: application/json');

if(is_post()){
    $id = (int)$_POST['id'];
    $quantity = (int)$_POST['quantity'];
    $payment_method = $_POST['payment_method'] ?? '';
    $order_status = $_POST['order_status'] ?? '';
    $delivery_detail = $_POST['delivery_detail'] ?? '';
    $paid_date = $_POST['paid_date'] ?? null;
    $shipped_date = $_POST['shipped_date'] ?? null;
    $delivered_date = $_POST['delivered_date'] ?? null;
    $completed_date = $_POST['completed_date'] ?? null;
    
    $pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();
    $orderModel = new OrderHistory($pdo);

    $data = [
        'quantity' => $quantity,
        'payment_method' => $payment_method,
        'order_status' => $order_status,
        'delivery_detail' => $delivery_detail,
        'paid_date' => $paid_date,
        'shipped_date' => $shipped_date,
        'delivered_date' => $delivered_date,
        'completed_date' => $completed_date,
    ];
    $success = $orderModel->update($id, $data);

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to update product']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
