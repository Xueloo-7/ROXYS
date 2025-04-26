<?php
require_once __DIR__.'/_baseAPI.php';

$user_id = $_SESSION['user']['id'];
$dbConfig = DatabaseConfig::getDatabaseConfig();
$db = new Database($dbConfig);
$conn = $db->getConnection();

// 接收 POST 数据
$name = trim($_POST['username'] ?? '');
$gender = $_POST['gender'] ?? '';
$valid_genders = ['male', 'female', 'other'];

if ($name === '' || !in_array($gender, $valid_genders)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// 获取当前用户名（用于头像路径）
$stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$current = $stmt->fetch(PDO::FETCH_ASSOC);
$old_username = $current['name'] ?? '';
$avatar_path = ROOT_PATH . 'image/avatar/' . $old_username . '.jpg';

// 更新用户信息
$stmt = $conn->prepare("UPDATE users SET name = ?, gender = ?, avatar = ? WHERE id = ?");
$stmt->execute([$name, $gender,'image/avatar/' . $name . '.jpg', $user_id]);

// 头像上传（如果有）
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

    // 重命名头像（如用户名改了，覆盖为新用户名）
    $new_avatar_path = ROOT_PATH . 'image/avatar/' . $name . '.jpg';

    // move_uploaded_file 会覆盖旧图
    if (!move_uploaded_file($file['tmp_name'], $new_avatar_path)) {
        echo json_encode(['success' => false, 'message' => 'Failed to save avatar']);
        exit;
    }

    // 如果用户名改了，旧头像文件需要删除
    if ($name !== $old_username && file_exists($avatar_path)) {
        unlink($avatar_path);
    }
}

// update user session
$_SESSION['user'] = [
    'id' => $_SESSION['user']['id'],
    'email' =>  $_SESSION['user']['email'],
    'username' => $name,
    'avatar' => 'image/avatar/' . $name . '.jpg',
    'role' => $_SESSION['user']['role'],
];

// 成功返回
flash_msg('Profile updated!');
echo json_encode(['success' => true, 'message' => 'Profile updated']);

