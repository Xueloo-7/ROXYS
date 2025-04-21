<?php

// 定义这是api文件，让base.php里的head.php不要输出html
define('IS_API', true);

require_once __DIR__.'/../../base.php';
require_once __DIR__.'/../database/Model/Product.php';
require_once __DIR__.'/../config/DatabaseConfig.php';
require_once __DIR__.'/../database/Database.php';

$pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();
$productModel = new Product($pdo);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 3;

$pager = $productModel->findAll($limit, $page);
$products = $pager->getResult();

// 可选：如果要展示颜色/尺寸，可以批量加载进来拼好

// 在返回前处理原价逻辑
foreach ($products as &$p) {
    $p['show_old_price'] = !empty($p['original_price']) && $p['original_price'] > $p['price'];
    $p['sold'] = formatSoldCount($p['sold']);
}

header('Content-Type: application/json');
echo json_encode($products);