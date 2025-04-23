<?php

require_once __DIR__.'/../database/Model/Product.php';
require_once __DIR__.'/../lib/SimplePager.php';

// 获取路由地址，这里是member_listing, order_listing，product_listing
$path = getRouteSegment(0);

// 获取当前分页，默认1
$page = (int)$_ROUTE_PARAMS['page'] ?? 1;

// 获取当前搜索字段
$keyword = $_GET['keyword'] ?? 'all';

switch($path){
    case 'member_listing':

        break;
    case 'order_listing':

        break;
    case 'product_listing':
        // 获取产品数据传给视图显示
        $productModel = new Product($pdo);
        // 获取第一页的数据，共三个产品
        $limit = 3;
        $filters = [];
        if ($keyword !== 'all') {
            $filters['keyword'] = $keyword;
        }
        $pager = $productModel->findPage($limit, $page, $filters);
        $products = $pager->getResult();
        // 附加数据
        foreach ($products as &$product) {
            $id = $product['id'];
            $product['sizes'] = $productModel->getSizes($id);
            $product['colors'] = $productModel->getColors($id);
            $product['reviews'] = $productModel->getReviews($id);
        }
        $pager->setResult($products);

        require_once __DIR__.'/../views/admin/product_listing.view.php';
        break;
}

