<?php
require_once __DIR__.'/../../base.php';
require_once __DIR__.'/../database/Model/User.php';
require_once __DIR__.'/../lib/SimpleImage.php';

if (!isLoggedIn()) {
    header("Location: " . BASE_URL. 'login?redirect='.urlencode('account'));
    exit;
}

if(!isset($_ROUTE_PARAMS['tab'])){
    $_ROUTE_PARAMS['tab'] = "profile"; // 默认profile界面
}

// 获取用户最新资料
$userModel = new User($pdo);
$user = $userModel->findByEmail($_SESSION['user']['email']);
$address = [
    'address_line' => $user['address_line'] ?? '',
    'city' => $user['city'] ?? '',
    'postcode' => $user['postcode'] ?? '',
];

if (!$user) {
    echo "<p>User not found.</p>";
    exit;
}

if (!$address) {
    echo "<p>Address not found.</p>";
    exit;
}

// 头像路径setup
$avatar_path = ROOT_PATH. 'image/avatar/' . $user['name'] . '.jpg';
$avatar_url = file_exists($avatar_path)
    ? BASE_URL . 'image/avatar/' . $user['name'] . '.jpg?v=' . time()
    : BASE_URL . 'image/avatar/account.png'; // 默认icon路径

// 默认profile界面
require_once __DIR__.'/../views/account/index.view.php';