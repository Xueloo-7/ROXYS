<?php
require_once __DIR__ .'/_baseAPI.php';

$user_id = $_SESSION['user']['id'];

// 获取 JSON 数据
$data = json_decode(file_get_contents('php://input'), true);

// 检查数据是否存在
if (empty($data['address_line']) || empty($data['city']) || empty($data['postcode'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

$address_line = $data['address_line'];
$city = $data['city'];
$postcode = $data['postcode'];

// 数据库连接
$dbConfig = DatabaseConfig::getDatabaseConfig();
$db = new Database($dbConfig);
$conn = $db->getConnection();

// 更新地址信息
$stmt = $conn->prepare("UPDATE users SET address_line = ?, city = ?, postcode = ? WHERE id = ?");
$stmt->execute([$address_line, $city, $postcode, $user_id]);

if ($stmt->rowCount() > 0) {
    // 成功更新地址
    flash_msg('Address updated!');
    echo json_encode(['success' => true, 'message' => 'Address updated successfully!']);
} else {
    // 更新失败
    flash_msg('Failed to update Address!' ,'error');
    echo json_encode(['success' => false, 'message' => 'Failed to update address.']);
}