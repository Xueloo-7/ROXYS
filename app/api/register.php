<?php

// 定义这是api文件，让base.php里的head.php不要输出html
define('IS_API', true);

require_once __DIR__.'/../database/Model/User.php';
require_once __DIR__.'/../config/DatabaseConfig.php';
require_once __DIR__.'/../database/Database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_UNSAFE_RAW);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();
    $user = new User($pdo);

    // Check if the email already exists
    if ($user->findByEmail($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Email already exists']);
        exit;
    }

    // Create the user
    $userData = [
        'name' => $name,
        'email' => $email,
        'password' => $hashed_password
    ];

    if ($user->create($userData)) {
        echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Registration failed']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}