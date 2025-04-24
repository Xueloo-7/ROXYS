<!-- ============================================================================
这是Account的主界面
============================================================================  -->

<?php
require_once __DIR__.'/../partials/header.php';
link_css("account");
?>

<main>
    <div class="container zoom">
        <div class="tab-nav">
            <a href="<?=BASE_URL?>account/profile" class="tab-link <?= ($_ROUTE_PARAMS['tab'] === 'profile') ? 'active' : ''; ?>">Profile</a>
            <a href="<?=BASE_URL?>account/address" class="tab-link <?= ($_ROUTE_PARAMS['tab'] === 'address') ? 'active' : ''; ?>">Address</a>
            <a href="<?=BASE_URL?>logout" class="tab-link">Logout</a>
        </div>

        <div class="tab-content">
            <?php
                // 默认加载 profile.php
                if ($_ROUTE_PARAMS['tab'] === 'profile') {
                    include __DIR__ . '/profile.view.php';
                } else if ($_ROUTE_PARAMS['tab'] === 'address') {
                    include __DIR__ . '/address.view.php';
                }
            ?>
        </div>
    </div>
</main>

<?php require_once __DIR__.'/../partials/footer.php'; ?>