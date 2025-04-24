<?php
require_once __DIR__.'/../partials/header.php';
link_css("payment");

?>

<main>
    <div class="payment-success-container zoom">
        <h1>✅ Payment Success</h1>

        <div class="payment-info">
            <p><strong>Payment Amount:</strong> RM <?= number_format($total_payable, 2) ?></p>
        </div>

        <div class="change-address">
            <p>You can <a href="<?= SCRIPT_URL ?>user_profile/address.php">Change Shipping Address</a> within <span id="countdown">--:--</span></p>
        </div>

        <div class="address-info">
            <h3>Current Shipping Address:</h3>
            <p><?= htmlspecialchars($address) ?></p>
        </div>

        <div class="view-order-btn">
            <a href="<?= SCRIPT_URL ?>purchase_history">View Order</a>
        </div>
    </div>

    <!-- 倒计时 -->
    <script>
        let duration = <?= $remaining_time ?>;
        const countdownEl = document.getElementById('countdown');
        const timer = setInterval(() => {
            const minutes = Math.floor(duration / 60);
            const seconds = duration % 60;
            countdownEl.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            duration--;
            if (duration < 0) {
                clearInterval(timer);
                countdownEl.textContent = "Expired";
            }
        }, 1000);
    </script>

</main>

<?php require_once __DIR__.'/../partials/footer.php'; ?>