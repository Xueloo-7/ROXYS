<?php

require_once __DIR__.'/../database/Model/Product.php';
require_once __DIR__.'/../database/Model/Review.php';

// 根据参数ID来获取产品然后显示
$id = (int)$_ROUTE_PARAMS['id'];

$productModel = new Product($pdo);
$product = $productModel->findById($id);
// 附加额外信息
$product['sizes'] = $productModel->getSizes($id);
$product['colors'] = $productModel->getColors($id);

$reviewModel = new Review($pdo);
$product['reviews'] = $reviewModel->getByProductId($id);

// Product Page
require_once __DIR__.'/../views/product/info.view.php';