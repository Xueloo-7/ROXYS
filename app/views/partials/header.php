<header>

    <!-- 顶部导航 -->
    <div class="top-nav">
        <a href="<?=BASE_URL?>about">About Us</a>
        <a href="<?=BASE_URL?>help">Help Center</a>
        <a href="<?=BASE_URL?>contact">Contact Us</a>
    </div>

    <!-- 底部导航 -->
    <div class="bottom-nav">
        <div class="logo pointer" data-get="<?=BASE_URL?>">
            <img src="<?= BASE_URL; ?>/image/logo.png" alt="Roxys Logo">
            <p>RΩXY'S</p>
        </div>

        <!-- 搜索栏 -->
        <div class="search-container">
            <i class="fas fa-search"></i>
            <label class="search-bar">
                <input type="text" id="searchInput" placeholder="Search" autocomplete="off" autocorrect="off" spellcheck="false">
            </label>
            <div class="search-history" id="searchHistory"></div>
        </div>
        <!-- 搜索栏js -->
        <?= link_js("searchHistoryHandler") ?>
        <?= link_js("search_history") ?>

        <div class="right-nav">
            <!-- 购物车 -->
            <div class="nav-item" data-get="cart">
                <div class="icon-container">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <span>Cart</span>
            </div>

            <!-- 用户账户 --> 
            <div class="nav-item" data-get="<?= isLoggedIn() ?  'account' :  'login' ?>">
                <div class="icon-container"><?= getUserAvatarHtml();?></div>
                <span><?= isLoggedIn() ? "Account" : "Login" ?></span>
            </div>

            <!-- 菜单（点击后滑出侧边栏） -->
            <div class="nav-item menu-toggle">
                <div class="icon-container">
                    <i class="fas fa-bars"></i>
                </div>
                <span>Menu</span>
            </div>
        </div>
    </div>
</header>

<?php require __DIR__.'/side_menu.php';