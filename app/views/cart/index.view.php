<!-- ============================================================================
这个是Shopping Cart界面
============================================================================  -->

<?php
require_once __DIR__.'/../partials/header.php';
link_css('cart');

?>

<main>
    <h2>My Cart</h2>

    <div class="cart-container zoom">
        <div class="cart-items">
            <?php if (isset($cart['error'])): ?>
                <p><?= htmlspecialchars($cart['error']) ?></p>
            <?php elseif (empty($cart)): ?>
                <p>Oops, Your cart is empty.</p>
            <?php else: ?>
                <?php foreach ($cart as $item): ?>
                    <div class="cart-item">
                        <a href="<?= SCRIPT_URL ?>product/<?= $item['product_id'] ?>">
                            <img src="<?= BASE_URL . $item['image_url'] ?>" alt="Product Image">
                        </a>
                        <div class="cart-details">
                            <p class="item-name"><?= htmlspecialchars($item['product_name']) ?></p>
                            <p class="item-price">RM <?= number_format($item['price'], 2) ?></p>
                            <p class="item-info">Qty: <?= $item['quantity'] ?></p>
                            <p class="item-info">
                                Color: <?= htmlspecialchars($item['color_code']) ?>
                                <span class="color-box" style="background-color: <?= htmlspecialchars($item['color_code']) ?>;"></span>
                            </p>
                            <p class="item-info">Size: <?= htmlspecialchars($item['size'] ?? "none") ?></p>

                            <!-- 删除按钮 -->
                            <button class="remove-btn" data-cart-id="<?= $item['id'] ?>" >Remove</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="cart-summary">
            <p>Original Subtotal <span id="original-subtotal">RM <?= number_format($original_subtotal, 2) ?></span></p>
            <p>Discount <span id="discount">- RM <?= number_format($original_subtotal - $subtotal, 2) ?></span></p>
            <p>Subtotal <span id="subtotal">RM <?= number_format($subtotal, 2) ?></span></p>
            <p>Delivery <span id="delivery-fee">RM <?= number_format($delivery_fee, 2) ?></span></p>
            <hr>
            <p><strong>Total <span id="total-price">RM <?= number_format(round($total_payable), 2) ?></span></strong></p>
            <a href="<?= empty($cart) ? '#' : SCRIPT_URL . 'payment' ?>" class="checkout-btn">
                <?php if(empty($cart)): ?>
                    Disable
                <?php else: ?>
                    Continue to Checkout
                <?php endif ?>
            </a>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to remove this item from your cart?");
        }

        $(document).ready(function() {
            $('.remove-btn').click(function(e) {
                e.preventDefault();
                if (!confirmDelete()) return;

                const cartId = $(this).data('cart-id');
                const $button = $(this);

                console.log(cartId)

                $.ajax({
                    url: '<?= API_URL ?>delete_from_cart.php',
                    method: 'POST',
                    data: { cart_id: cartId },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Failed to remove item: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Something went wrong. Please try again.');
                    }
                });
            });
        });
    </script>
</main>

<?php require_once __DIR__.'/../partials/footer.php'; ?>