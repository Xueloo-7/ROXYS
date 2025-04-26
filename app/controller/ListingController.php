<?php

require_once __DIR__.'/../database/Model/Product.php';
require_once __DIR__.'/../database/Model/OrderHistory.php';
require_once __DIR__.'/../database/Model/User.php';
require_once __DIR__.'/../lib/SimplePager.php';

// 获取路由地址，这里是member_listing/order_listing/product_listing
$path = getRouteSegment(0);

// 获取当前分页，默认1
$page = (int)$_ROUTE_PARAMS['page'] ?? 1;

// 获取当前搜索字段
$keyword = $_GET['keyword'] ?? 'all';

// 每页显示多少个物品
$page_limit = 6;

switch($path){
    case 'member_listing':
        // 目的：获取所有用户传给视图
        $userModel = new User($pdo);
        // 获取第一页的数据，共三个
        $filters = [];
        if ($keyword !== 'all') {
            $filters['keyword'] = $keyword;
        }
        $pager = $userModel->findPage($page_limit, $page, $filters);
        $users = $pager->getResult();

        require_once __DIR__.'/../views/admin/member_listing.view.php';
        break;
    case 'order_listing':
        // 目的：获取所有订单记录和它的user_name和product_name传给视图
        $orderModel = new OrderHistory($pdo);
        // 获取第一页的数据，共三个
        $filters = [];
        if ($keyword !== 'all') {
            $filters['keyword'] = $keyword;
        }
        $pager = $orderModel->findPage($page_limit, $page, $filters);
        $orders = $pager->getResult();

        // 附加数据
        foreach ($orders as &$order) {
            $order['user_name'] = $orderModel->getUserById($order['user_id'])['name'];
            $order['product_name'] = $orderModel->getProductById($order['product_id'])['name'];
        }
        $pager->setResult($orders);

        require_once __DIR__.'/../views/admin/order_listing.view.php';
        break;
    case 'product_listing':
        $page_limit = 3;
        // 目的：获取产品数据传给视图显示
        $productModel = new Product($pdo);
        // 获取第一页的数据，共三个
        $filters = [];
        if ($keyword !== 'all') {
            $filters['keyword'] = $keyword;
        }
        $pager = $productModel->findPage($page_limit, $page, $filters);
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

