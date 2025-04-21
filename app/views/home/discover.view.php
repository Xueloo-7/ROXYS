<div class="discover-container zoom">
    <h2>🛍️ Daily Discover 🔎</h2>
    <div class="sales-items">
        <?php foreach ($products as $product): ?>
            <a class="sales-item" href="<?= SCRIPT_URL ?>product_info?id=<?= $product['id'] ?>">
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

    <!-- 附带功能：点击后加载更多产品在底部（研究了很久ಥ_ಥ） -->
    <a href="#" id="load-more" data-page="1" class="view-more">View More</a>
</div>

<!-- 
============================================================================
Lazy Load 懒加载
============================================================================  
-->

<script>
    
const BASE_URL = "<?= BASE_URL ?>";

// AJAX请求获取下一页的产品数据然后附加到sales-items底部
$(document).ready(function () {
    $('#load-more').on('click', function (e) {
        e.preventDefault();

        const $btn = $(this);

        let page = parseInt($btn.data('page')) + 1;

        $.get(BASE_URL+'app/api/products.php', { page: page }, function (products) {

            if (products.length === 0) {
                $btn.hide(); // 没有更多数据就隐藏按钮
                return;
            }

            products.forEach(function (product) {
                let html = `
                <a class="sales-item" href="product?id=${product.id}">
                    <div class="image-container">
                        <img src="${BASE_URL + product.image_url}" alt="${product.name}">
                        <p class="jump-text">Jump To Item</p>
                    </div>
                    <p class="product-name">${product.name}</p>

                    <div class="price-sold-container">
                        <p class="price">RM ${product.price}</p>
                        ${product.show_old_price
                            ? `<p class="old-price">RM ${product.original_price}</p>`
                            : ''
                        }
                        ${product.sold}
                    </div>
                </a>
                `;
                $('.discover-container .sales-items').append(html);
            });

            $btn.data('page', page);
        }, 'json');
    });
});

</script>