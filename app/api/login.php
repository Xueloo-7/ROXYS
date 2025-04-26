<?php

require_once __DIR__.'/../config/DatabaseConfig.php';
require_once __DIR__.'/../database/Database.php';
require_once __DIR__.'/../database/Model/User.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

    $pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();
    $user = new User($pdo);
    $userData = $user->findByEmail($email);

    if ($userData && password_verify($password, $userData['password'])) {
        // Generate access_token
        try {
            $access_token = bin2hex(random_bytes(16));
        } catch (Random\RandomException) {
        }
        $user->updateRememberToken($userData['id'], $access_token);

        // 将所有用户数据传给控制器，由控制器存入SESSION
        echo json_encode(['status' => 'success', 'message' => 'Login successful', 'access_token'=>  $access_token,'user_data' => $userData]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}