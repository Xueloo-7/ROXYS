<?php

require_once __DIR__.'/_baseAPI.php';
require_once __DIR__.'/../database/Model/User.php';

header('Content-Type: application/json');

if(is_post()){
    $id = (int)$_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $address_line = $_POST['address_line'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];

    $pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();
    $userModel = new User($pdo);

    $data = [
        'name' => $name,
        'email' => $email,
        'gender' => $gender,
        'role' => $role,
        'address_line' => $address_line,
        'city' => $city,
        'postcode' => $postcode
    ];
    $success = $userModel->delete($id);

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
