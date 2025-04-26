<?php

require_once __DIR__.'/_baseAPI.php';
require_once __DIR__.'/../database/Model/OrderHistory.php';

// get orders$orders
$pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();
$orderModel = new OrderHistory($pdo);
$user_id = $_SESSION['user']['id'];
$orders = $orderModel->getOrdersByUserId($user_id);

// 附加信息
foreach($orders as &$order){
    $product = $orderModel->getProductById($order['product_id']);
    $order['product'] = $product;
}
// foreach ($products as &$product) {
//     $id = $product['id'];
//     $product['sizes'] = $sizesMap[$id] ?? [];
//     $product['colors'] = $colorsMap[$id] ?? [];
//     $product['reviews'] = $reviewsMap[$id] ?? [];
// }




$status = $_GET['status'] ?? 'all';
$search = $_GET['search'] ?? '';
$filteredData = array_filter($orders, function($order) use ($status, $search) {
    // 筛选状态
    if ($status !== 'all' && $order['order_status'] !== $status) {
        return false;
    }
    // 筛选关键词
    if (!empty($search) && stripos($order['product']['name'], $search) === false) {
        return false;
    }

    return true;
});

// 3. 返回筛选后的数据
$orders = $filteredData;
// dd($orders);

// 填充数据
if (!empty($orders)):
    foreach ($orders as &$order): ?>    
        <div class="order-card">
            <!-- 左边部分 -->
            <div class="left-part">
                <div class="above-part">
                    <div class="img-part">
                        <!-- 照片 -->
                        <img src="<?= BASE_URL. $order['product']['image_url'] ?>" alt="Product Image"
                                            class="product-image">
                    </div>
                    <div class="info-part">
                        <!-- 名字，价格，数量 -->
                        <p class="product-name"><?= encode($order['product']['name']); ?></p>
                        <p class="product-price">RM <?= encode(number_format($order['product']['price'], 2)) ?></p>
                        <p class="product-quantity">Qty: <?= encode($order['quantity']) ?></p>
                    </div>
                </div>
                <div class="below-part">
                    <!-- 总价格，计算和显示 -->
                    <?php
                        $qty = $order['quantity'];
                        $price = $order['product']['price'];
                        $total_price = $qty * $price;
                    ?>
                    <p class="product-total-price">Total Price: RM <?= encode(number_format($total_price)) ?></p>
                </div>
                <div class="fill"></div>
                <!-- 两个按钮 -->
                <div class="order-action-button">
                    <form action="<?= API_URL ?>buy_again.php" method="POST">
                        <!-- 传输该商品的地址 -->
                        <input type="hidden" name="product_id" value="<?= encode($order['product']['id']) ?>">
                        <button id="buy-again" type="submit">Buy Again</button>
                    </form>
                </div>
            </div>
            <!-- 右边部分 -->
            <div class="right-part">
                <!-- 资讯盒子 -->
                <div class="info-box">
                    <div class="status-ui">
                        <i class="fa-solid fa-truck"></i>
                        <p><?= formatStatus(encode($order['order_status'])); ?></p>
                    </div>
                    <p><?= encode($order['delivery_detail']); ?></p>
                </div>
                <!-- 订单信息 -->
                <div class="order-info">
                    <!-- 左对齐 -->
                    <div class="left">
                        <p>Order No.</p>
                        <p>Place On</p>
                        <p>Paid On</p>
                        <p>Shipped On</p>
                        <p>Delivered On</p>
                        <p>Completed On</p>
                        <p>Paid By</p>
                    </div>
                    <!-- 右对齐 -->
                    <div class="right">
                        <p>#<?= $order['id']; ?></p>
                        <p><?= formatDate($order['place_date']); ?></p>
                        <p><?= formatDate($order['paid_date']); ?></p>
                        <p><?= formatDate($order['shipped_date']); ?></p>
                        <p><?= formatDate($order['delivered_date']); ?></p>
                        <p><?= formatDate($order['completed_date']); ?></p>
                        <p><?= $order['payment_method']; ?></p>
                    </div>
                </div>
                <div class="fill"></div>
                <!-- 下拉资讯栏按钮，下拉后变为hide-information -->
                <div class="more-information-box">
                    <button class="more-information hidden">
                        <p>More information</p>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach;
else: ?>
    <p class="history-not-found">No order history found.</p>
<?php endif; ?>

