<?php

// 获取当前网址
$uri = $_SERVER['REQUEST_URI'];

// 移除开头的/ROXYS/方便后续写
$uri = str_replace(BASE_URI, "", $uri);;

// 分割网址和参数
$uri = parse_url($uri);
$path = $uri['path'];
$query = $uri['query'] ?? '';

// 定义routes，维护所有网址的跳转
$routes = [
    '' => 'controller/HomeController.php',
    'about' => 'service/about.php',
    'contact' => 'service/contact.php',
    'help' => 'service/help.php',
    'login' => 'controller/LoginController.php',
    'logout' => 'controller/LoginController.php',
    'register' => 'controller/LoginController.php',
    'account' => 'controller/AccountController.php',
    'product/{id}' => 'controller/ProductController.php',
    'member_listing/{page}'=> 'controller/ListingController.php',
    'order_listing/{page}'=> 'controller/ListingController.php',
    'product_listing/{page}'=> 'controller/ListingController.php',
    'cart' => 'controller/CartController.php',
    'payment' => 'controller/PaymentController.php',
    'payment/{status}' => 'controller/PaymentController.php',
    'order' => 'controller/OrderController.php',
    'search/{keyword}' => 'controller/HomeController.php',
    'account' => 'controller/AccountController.php',
    'account/{tab}' => 'controller/AccountController.php',

    // 更多写法 example
    // 'product/id/{id}' => 'controllers/product.php',
    // 'product/category/{category}' => 'controllers/product.php',
    // 'product/id/{id}/category/{category}' => 'controllers/product.php',
];

// === 核心路由器（有点复杂所以写了注释） ===
function matchRoute($path, $routes, &$params = []) {
    // 遍历所有定义的路由
    foreach ($routes as $route => $file) {

        // 把 {xxx} 替换成正则表达式，用于匹配实际路径的参数
        // 例：'product/{category}/{id}' => 'product/([^/]+)/([^/]+)'
        $pattern = preg_replace('#\{[^}]+\}#', '([^/]+)', $route);

        // 加上正则开头结尾限制，确保完整匹配路径
        // 最终变成：#^product/([^/]+)/([^/]+)$#
        $pattern = "#^{$pattern}$#";

        // 用正则检查请求路径是否匹配这个路由模式
        // 例：$path = 'product/laptop/123'
        if (preg_match($pattern, $path, $matches)) {

            // 提取出路由中的参数名
            // 例：paramNames[1] = ['category', 'id']
            preg_match_all('#\{([^}]+)\}#', $route, $paramNames);

            // 去除 $matches 第一个元素（完整匹配的路径），只保留参数值部分
            // 例：['laptop', '123']
            array_shift($matches);

            // 将参数名和对应值组合成关联数组
            // 例：['category' => 'laptop', 'id' => '123']
            $params = array_combine($paramNames[1], $matches);

            // 返回匹配到的控制器路径
            return $file;
        }
    }

    // 如果所有路由都不匹配，返回 null
    return null;
}


$params = [];
$controller = matchRoute($path, $routes, $params);

if ($controller && file_exists(__DIR__.'/app/'.$controller)) {
    $_ROUTE_PARAMS = $params; // 全局传值
    require __DIR__.'/app/'.$controller;
} else {
    abort();
}