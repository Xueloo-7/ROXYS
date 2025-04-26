<?php

require_once __DIR__.'/_baseAPI.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['email'] ?? '');
$otp = trim($data['otp'] ?? '');

// 校验 session 中的验证码
if (
    !isset($_SESSION['otp_code'], $_SESSION['otp_email'], $_SESSION['otp_time']) ||
    $_SESSION['otp_email'] !== $email ||
    $_SESSION['otp_code'] !== $otp ||
    time() - $_SESSION['otp_time'] > 300 // 超过5分钟
) {
    echo json_encode(['success' => false, 'message' => 'Invalid or expired OTP.']);
    exit;
}

// 更新用户邮箱
$user_id = $_SESSION['user']['id'];

$dbConfig = DatabaseConfig::getDatabaseConfig();
$db = new Database($dbConfig);
$conn = $db->getConnection();

$stmt = $conn->prepare("UPDATE users SET email = ?, updated_at = NOW() WHERE id = ?");
$stmt->execute([$email, $user_id]);

// 清除验证码
unset($_SESSION['otp_code'], $_SESSION['otp_email'], $_SESSION['otp_time']);

// update session
$_SESSION['user']['email'] = $email;

echo json_encode(['success' => true]);