<div class="Top-Sales-Container zoom">
    <h2>Top 5 Sales 🔥</h2>
    <div class="sales-items">
        <?php foreach ($top5sales as $product): ?>
            <!-- 每个产品展示 -->
            <a class="sales-item" href="product/<?= $product['id'] ?>">
                <div class="image-container">
                    <!-- 产品图片 -->
                    <img src="<?= BASE_URL.$product['image_url'] ?>" alt="<?= $product['name'] ?>">
                    <p class="jump-text">View</p>
                </div>
                <p class="product-name"><?= $product['name'] ?></p>
                <!-- 格式化显示销量 -->
                <?= formatSoldCount($product['sold']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>