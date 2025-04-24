<div class="discover-container zoom">
    <h2>🛍️ Daily Discover 🔎</h2>
    <div class="sales-items">
        <?php foreach ($products as $product): ?>
            <a class="sales-item" href="product/<?= $product['id'] ?>">
                <div class="image-container">
                    <img src="<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>">
                    <p class="jump-text">Jump To Item</p>
                </div>
                <p class="product-name"><?= $product['name'] ?></p>

                <div class="price-sold-container">
                    <!-- 价格部分，若有折扣则显示原价和折扣价 -->
                    <p class="price">RM <?= $product['price'] ?></p>
                    <?php if (!empty($product['original_price']) && $product['original_price'] > $product['price']): ?>
                        <p class="old-price">RM <?= $product['original_price'] ?></p>
                    <?php endif; ?>

                    <!-- 销售数量 -->
                    <?= formatSoldCount($product['sold']) ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- 
    ============================================================================
    Lazy Load 懒加载
    ============================================================================  
    -->
    <!-- 附带功能：点击后加载更多产品在底部（研究了很久ಥ_ಥ） -->
    <a href="#" id="load-more" data-page="1" class="view-more">View More</a>
    <?php link_js("lazyload") ?>
</div>

