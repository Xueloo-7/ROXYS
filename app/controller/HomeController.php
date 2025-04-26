<?php
require_once __DIR__.'/../database/Model/Product.php';
require_once __DIR__.'/../lib/SimplePager.php';

// 获取单个产品 example
// $id=1;
// $productModel = new Product($pdo);
// $product = $productModel->findById($id);
// $product['sizes'] = $productModel->getSizes($id);
// $product['colors'] = $productModel->getColors($id);
// $product['reviews'] = $productModel->getReviews($id);

// 分页查询
$productModel = new Product($pdo);
// 获取第一页的数据，共三个产品
$page = 1;
$limit = 10;
$filters=[];
$pager = $productModel->findPage($limit, $page, $filters);
$products = $pager->getResult();
shuffle($products);

// 更新产品，将额外信息附加进去products
// foreach ($products as &$product) {
//     $id = $product['id'];
//     $product['sizes'] = $productModel->getSizes($id);
//     $product['colors'] = $productModel->getColors($id);
//     $product['reviews'] = $productModel->getReviews($id);
// }

// 如果产品很多很多，建议使用这种写法来优化数据库查询次数
// $productIds = array_column($products, 'id');
// $sizesMap = $productModel->getAllSizes($productIds);
// $colorsMap = $productModel->getAllColors($productIds);
// $reviewsMap = $productModel->getAllReviews($productIds);

// foreach ($products as &$product) {
//     $id = $product['id'];
//     $product['sizes'] = $sizesMap[$id] ?? [];
//     $product['colors'] = $colorsMap[$id] ?? [];
//     $product['reviews'] = $reviewsMap[$id] ?? [];
// }

// 将更新后的数据更新进result（不过这里没有更新所以不需要）
// $pager->setResult($products);

// 获取路由地址，这里是 / 和 search
$path = getRouteSegment(0);

// 如果是搜索界面，获取搜索keyword
if($path == "search"){
    $keyword = $_ROUTE_PARAMS['keyword'] ?? "all";

    // 筛选
    $result = [];

    if ($keyword !== 'all') {
        foreach ($products as $product) {
            $nameMatch = stripos($product['name'], $keyword) !== false;
            $categoryMatch = strtolower($product['category']) === strtolower($keyword);

            if ($nameMatch || $categoryMatch) {
                $result[] = $product;
            }
        }
    }
    else{
        $result = $products;
    }

    // 搜索页面
    require_once __DIR__.'/../views/search/index.view.php';
}
else{
    // 否则显示正常页面
    // 获取前五销量的产品
    $top5sales = $productModel->getTop5BySold();

    // Home Page
    require_once __DIR__.'/../views/home/index.view.php';
}
