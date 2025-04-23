<?php

require_once __DIR__.'/_baseAPI.php';
require_once __DIR__.'/../database/Model/User.php';

header('Content-Type: application/json');

if(is_post()){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();
    $userModel = new User($pdo);

    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $password
    ];
    $success = $userModel->create($data);

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