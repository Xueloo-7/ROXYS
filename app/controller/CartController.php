<?php
require_once __DIR__.'/../../base.php';
require_once __DIR__.'/../database/Model/Product.php';
require_once __DIR__.'/../database/Model/Cart.php';
require_once __DIR__.'/../lib/SimplePager.php';

if (!isset($_COOKIE['loggedin']) || $_COOKIE['loggedin'] === 'false') {
    header("Location: " . SCRIPT_URL . 'login?redirect='.urlencode(SCRIPT_URL.'cart'));
    exit;
}

try {
    $userId = $_SESSION['user']['id'] ?? null;

    if ($userId) {
        $cartModel = new Cart($pdo);
        
        // 初始化购物车（首次进入或 reload 参数）
        if (is_get('reload') || !isset($_SESSION['cart'], $_SESSION['order_value'])) {
            $cart = $cartModel->getCartItemsByUserId($userId);
            $totals = $cartModel->calculateTotals($cart);

            $_SESSION['cart'] = $cart;
            $_SESSION['original_subtotal'] = $totals['original_subtotal'];
            $_SESSION['subtotal'] = $totals['subtotal'];
            $_SESSION['delivery_fee'] = $totals['delivery_fee'];
            $_SESSION['total_payable'] = $totals['total_payable'];
        }
    } else {
        $_SESSION['cart'] = ['error' => '用户未登录，无法加载购物车'];
    }
} catch (Exception $e) {
    $_SESSION['cart'] = ['error' => $e->getMessage()];
}

// 删除购物车商品
if (isset($_POST['remove_item'])) {
    $cartId = $_POST['cart_id'] ?? null;
    $userId = $_SESSION['user_id'] ?? null;

    if ($cartId && $userId) {
        try {
            $cartModel->removeItem($userId, $cartId);
            header("Location: " . SCRIPT_URL . 'cart?reload');
            exit;
        } catch (Exception $e) {
            $_SESSION['cart'] = ['error' => 'Error removing item: ' . $e->getMessage()];
        }
    }
}

// 从 SESSION 获取数据渲染页面
$cart = $_SESSION['cart'] ?? [];
$original_subtotal = $_SESSION['original_subtotal'] ?? 0.00;
$subtotal = $_SESSION['subtotal'] ?? 0.00;
$delivery_fee = $_SESSION['delivery_fee'] ?? 0.00;
$total_payable = $_SESSION['total_payable'] ?? 0.00;

// 加载页面视图
require_once __DIR__.'/../views/cart/index.view.php';