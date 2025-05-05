<?php

require_once __DIR__.'/_baseAPI.php';
require_once __DIR__.'/../database/Model/User.php';
require_once __DIR__.'/../lib/SimpleImage.php';

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

    // Handle avatar upload if exists
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['avatar'];
        $type = mime_content_type($file['tmp_name']);
        $size = $file['size'];

        if (strpos($type, 'image/') !== 0) {
            echo json_encode(['success' => false, 'message' => 'File must be an image']);
            exit;
        }

        if ($size > 2 * 1024 * 1024) {
            echo json_encode(['success' => false, 'message' => 'Image too large (max 2MB)']);
            exit;
        }

        // Get current user info for old avatar path
        $currentUser = $userModel->findById($id);
        $old_username = $currentUser['name'] ?? '';
        $old_avatar_path = ROOT_PATH . 'image/avatar/' . $old_username . '.jpg';

        // Set new avatar path
        $new_avatar_path = ROOT_PATH . 'image/avatar/' . $name . '.jpg';
        $data['avatar'] = 'image/avatar/' . $name . '.jpg';

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $new_avatar_path)) {
            echo json_encode(['success' => false, 'message' => 'Failed to save avatar']);
            exit;
        }

        // Delete old avatar if username changed
        if ($name !== $old_username && file_exists($old_avatar_path)) {
            unlink($old_avatar_path);
        }
    }

    $success = $userModel->update($id, $data);

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to update user']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
