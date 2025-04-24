<!-- ============================================================================
这个是搜索物品界面，单纯展示所有物品，并且支持lazy laod
============================================================================  -->

<?php
require_once __DIR__.'/../partials/header.php';
link_css("home");
?>

<main>
    <div class="discover-container zoom" style="margin-top: 0px;">
        <h2>🔍 Search Result for "<?= htmlspecialchars($keyword) ?>"</h2>

        <?php if (empty($result)): ?>
            <p class="no-result">No products found.</p>
        <?php else: ?>
            <div class="sales-items">
                <?php foreach ($result as $product): ?>
                    <a class="sales-item" href="<?= BASE_URL ?>product/<?= $product['id'] ?>">
                        <div class="image-container">
                            <img src="<?= BASE_URL.$product['image_url'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                            <p class="jump-text">Jump To Item</p>
                        </div>
                        <p class="product-name"><?= htmlspecialchars($product['name']) ?></p>

                        <div class="price-sold-container">
                            <p class="price">RM <?= number_format($product['price'], 2) ?></p>
                            <?php if (!empty($product['original_price']) && $product['original_price'] > $product['price']): ?>
                                <p class="old-price">RM <?= number_format($product['original_price'], 2) ?></p>
                            <?php endif; ?>
                            <?= formatSoldCount($product['sold']) ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- 
        ============================================================================
        Lazy Load 懒加载
        ============================================================================  
        -->
        <!-- 附带功能：点击后加载更多产品在底部（研究了很久ಥ_ಥ） -->
        <a href="#" id="load-more" data-page="1" class="view-more">View More</a>
        <?php link_js("lazyload") ?>
    </div>
</main>

<?php require_once __DIR__.'/../partials/footer.php'; ?>