<!-- ============================================================================
这个是Payment界面
============================================================================  -->

<?php
require_once __DIR__.'/../partials/header.php';
link_css('payment');

?>

<main>
    <!-- body -->
    <div class="payment-container zoom">
        <h1>Order Summary</h1>

        <div class="cart-items">
            <?php if (!empty($cart)): ?>
                <ul>
                    <?php foreach ($cart as $item): ?>
                        <li class="cart-item">
                            <img src="<?= $item['image_url'] ?>" alt="<?= $item['product_name'] ?>" class="cart-item-image">
                            <div class="cart-item-info">
                                <h3><?= $item['product_name'] ?></h3>
                                <p>Size: <?= $item['size'] ?></p>
                                <p>Color: <?= $item['color_code'] ?></p>
                                <p>Quantity: <?= $item['quantity'] ?></p>
                                <p>Price: RM <?= number_format($item['price'], 2) ?></p>
                                <p>Original Price: RM <?= number_format($item['original_price'], 2) ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No items in cart</p>
            <?php endif; ?>
        </div>

        <div class="order-summary">
            <h2>Summary</h2>
            <p><strong>Original Subtotal: </strong>RM <?= number_format($original_subtotal, 2) ?></p>
            <p><strong>Discount: </strong>- RM <?= number_format($original_subtotal - $subtotal, 2) ?></p>
            <p><strong>Subtotal: </strong>RM <?= number_format($subtotal, 2) ?></p>
            <p><strong>Delivery Fee: </strong>RM <?= number_format($delivery_fee, 2) ?></p>
            <p><strong>Total Payable: </strong>RM <?= number_format($total_payable, 2) ?></p>
        </div>

        <form action="<?= BASE_URL ?>payment/success" method="POST">
            <div class="payment-method">
                <h2>Select Payment Method</h2>
                <div class="payment-options">
                    <label>
                        <input type="radio" name="payment_method" value="Touch n Go">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/f/fb/Touch_%27n_Go_eWallet_logo.svg" alt="Touch 'n Go" class="payment-icon">
                        Touch 'n Go
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="Credit/Debit Card">
                        <img src="https://cdn-icons-png.flaticon.com/512/633/633611.png" alt="Credit/Debit Card" class="payment-icon">
                        Credit/Debit Card
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="Online Banking">
                        <img src="https://cdn-icons-png.flaticon.com/512/2331/2331970.png" alt="Online Banking" class="payment-icon">
                        Online Banking
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="Cash">
                        <img src="https://cdn-icons-png.flaticon.com/512/1022/1022333.png" alt="Cash" class="payment-icon">
                        Cash
                    </label>
                </div>
            </div>


            <div class="payment-actions">
                <a href="#" id="backBtn" class="back-to-cart-btn">Back</a>
                <button type="submit" class="proceed-to-checkout-btn" id="proceedBtn" style="pointer-events: none; opacity: 0.5;">Proceed to Checkout</button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#backBtn').on('click', function(e) {
                e.preventDefault();
                // 返回上一级页面
                history.back();
            });

            $('input[name="payment_method"]').on('change', function() {
                if ($('input[name="payment_method"]:checked').length > 0) {
                    $('#proceedBtn').css({
                        'pointer-events': 'auto',
                        'opacity': '1'
                    });
                }
            });
        });
    </script>
</main>

<?php require_once __DIR__.'/../partials/footer.php'; ?>