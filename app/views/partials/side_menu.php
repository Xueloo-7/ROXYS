<!-- 侧边栏菜单 -->
<div class="sideMenu zoom">
    <div class="menu-header">
        <p>Menu</p>
        <i class="fas fa-times closeMenu"></i>
    </div>
    <ul>
        <li class="nav-item" data-get=<?= BASE_URL ?>>Home</li>
        <li class="nav-item" data-get="<?= isLoggedIn() ?  'account' :  'login' ?>"><?= isLoggedIn() ? "Account" : "Login"?></li>
        <li class="nav-item" data-get="<?= BASE_URL ?>cart">Shopping Cart</li>
        <li class="nav-item" data-get="<?= BASE_URL ?>order">My Orders</li>
        <li class="nav-item" data-get="<?= BASE_URL ?>product_info/my_wishlist">My Wishlist</li>
        <li class="nav-item" data-get="<?= BASE_URL ?>seller">Seller</li>
        <!-- Admin Only -->
        <?php if (isAdmin()): ?>
            <hr>
            <li class="nav-item" data-get="<?= BASE_URL ?>member_listing/1">Member Management</li> <!-- 管理用户 -->
            <li class="nav-item" data-get="<?= BASE_URL ?>order_listing/1">Order Management</li> <!-- 管理订单 -->
            <li class="nav-item" data-get="<?= BASE_URL ?>product_listing/1">Product Management</li> <!-- 管理商品 -->
            <li class="nav-item" data-get="<?= BASE_URL ?>report">Report</li> <!-- 统计信息报告 -->
        <?php endif; ?>
    </ul>

</div>

<!-- 侧边栏的遮罩 -->
<div class="overlay"></div>