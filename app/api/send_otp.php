<?php

require_once __DIR__.'/_baseAPI.php';
require_once __DIR__.'/../lib/PHPMailer.php';
require_once __DIR__.'/../lib/SMTP.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['email'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email.']);
    exit;
}

// 生成6位数字验证码
$otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

// 发送邮件
$mail = get_mail();

if (!$mail) {
    echo json_encode(['success' => false, 'message' => 'Mail setup failed.']);
    exit;
}

$mail->addAddress($email);
$mail->Subject = 'Your Verification Code';
$mail->Body = "Your verification code is: $otp";

if (!$mail->send()) {
    echo json_encode(['success' => false, 'message' => 'Failed to send email.']);
    exit;
}

// 存入 session（有效期 5 分钟）
$_SESSION['otp_email'] = $email;
$_SESSION['otp_code'] = $otp;
$_SESSION['otp_time'] = time();

echo json_encode(['success' => true, 'message' => 'OTP sent successfully.']);