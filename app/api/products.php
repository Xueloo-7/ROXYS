<?php

require_once __DIR__.'/_baseAPI.php';
require_once __DIR__.'/../database/Model/Product.php';

$pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();
$productModel = new Product($pdo);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;

$pager = $productModel->findPage($limit, $page);
$products = $pager->getResult();
shuffle($products);

// 可选：如果要展示颜色/尺寸，可以批量加载进来拼好

// 在返回前处理原价逻辑
foreach ($products as &$p) {
    $p['show_old_price'] = !empty($p['original_price']) && $p['original_price'] > $p['price'];
    $p['sold'] = formatSoldCount($p['sold']);
}

header('Content-Type: application/json');
echo json_encode($products);