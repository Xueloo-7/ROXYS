<?php
require_once __DIR__.'/../database/Model/OrderHistory.php';
require_once __DIR__.'/../database/Model/Cart.php';
require_once __DIR__.'/../lib/SimplePager.php';

if (!isLoggedIn()) {
    header("Location: " .BASE_URL. '/login?redirect='.urlencode('payment'));
    exit;
}

$status = $_ROUTE_PARAMS['status'] ?? '';

if($status == ""){
    // Payment 获取当前cart的购物清单，用于显示预览
    // 获取各种价格，例如总价，折扣部分，运费，sst，和最终价格
    $cart = $_SESSION['cart'];
    $original_subtotal = $_SESSION['original_subtotal'] ?? 0.00;
    $subtotal = $_SESSION['subtotal'] ?? 0.00;
    $delivery_fee = $_SESSION['delivery_fee'] ?? 0.00;
    $total_payable = $_SESSION['total_payable'] ?? 0.00;

    // Payment Page
    require_once __DIR__.'/../views/payment/index.view.php';
}
else if ($status == "success") {
    // 初始化计时器
    if (!isset($_SESSION['payment_timestamp'])) {
        $_SESSION['payment_timestamp'] = time();
    }
    $remaining_time = max(0, ($_SESSION['payment_timestamp'] + 600) - time());

    // 统一读取 SESSION 数据
    $cart = $_SESSION['cart'] ?? [];
    $user_id = $_SESSION['user']['id'] ?? 1;
    $payment_method = $_POST['payment_method'] ?? ($_SESSION['payment_method'] ?? 'unknown');
    $delivery_detail = $_POST['delivery_detail'] ?? 'Your package has been delivered![Kuala Lumpur]';
    $place_date = date('Y-m-d H:i:s');
    $order_status = 'pending';
    $total_payable = $_SESSION['total_payable'] ?? 0.00;
    $address = $_SESSION['address'] ?? 'No address provided.';

    // 提交支付方式（只在第一次POST时记录）
    if (is_post()) {
        $_SESSION['payment_method'] = $payment_method;
    }

    // 执行结账逻辑
    if ($user_id && !empty($cart)) {
        $data = [
            'user_id' => $user_id,
            'cart' => $cart,
            'payment_method' => $payment_method,
            'order_status' => $order_status,
            'delivery_detail' => $delivery_detail,
            'place_date' => $place_date,
        ];

        $orderModel = new OrderHistory($pdo);
        if ($orderModel->checkout($data)) {
            // 清空购物车（数据库层面）
            $cartModel = new Cart($pdo);
            foreach ($cart as $item) {
                $cartModel->removeItem($user_id, $item['id']);
            }

            // Store the total payable before clearing session
            $final_total_payable = $_SESSION['total_payable'];

            // 清理 session
            unset($_SESSION['cart'], $_SESSION['original_subtotal'], $_SESSION['subtotal'], $_SESSION['delivery_fee'], $_SESSION['total_payable'], $_SESSION['payment_method']);

            // Set the total payable for the success view
            $_SESSION['total_payable'] = $final_total_payable;

            // 成功后跳转
            header('Location: '.BASE_URL.'payment/success');
            exit;
        } else {
            echo "结账失败，请稍后再试。";
        }
    }

    // 最终页面渲染
    require_once __DIR__.'/../views/payment/success.view.php';
}
