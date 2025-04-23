<?php
require_once __DIR__.'/../partials/header.php';
link_css('product');
?>

<main>
    <div class="product-container">

        <!-- 上方图片 + 信息区 -->
        <div class="product-top">
            <!-- 图片区域 -->
            <div class="product-images">
                <img src="<?= BASE_URL . $product['image_url']; ?>" alt="Product Image">
            </div>

            <!-- 信息区域 -->
            <div class="product-info">
                <h1 class="product-name"><?= encode($product['name']); ?></h1>
                <div class="product-price">
                    <span class="current-price"><?= encode(number_format($product['price'], 2)); ?></span>
                    <span class="original-price"><?= encode(number_format($product['original_price'], 2)); ?></span>
                    <span class="discount"><?= $product['discount']; ?>% OFF</span>
                </div>

                <p class="product-description"><?= encode($product['description']); ?></p>

                <!-- Size -->
                <div class="product-size">
                    <label for="size">Size:</label>
                    <select id="size">
                        <?php foreach ($product['sizes'] as $size): ?>
                            <option value="<?= $size; ?>"><?= $size; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Color -->
                <div class="product-color">
                    <label for="color">Color:</label>
                    <div class="color-options">
                        <?php foreach ($product['colors'] as $color): ?>
                            <span class="color-swatch" style="background-color: <?= $color; ?>;"></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="product-quantity">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1">
                </div>
            </div>
        </div>

        <!-- Button 选择 -->
        <div class="product-buttons">
            <button class="buy-now">Buy Now</button>
            <button class="add-to-cart">Add to Cart</button>
            <button class="add-to-wishlist">Add to Wishlist</button>
        </div>

        <!-- 下方详情 -->
        <div class="product-details">
            <h2>Product Details</h2>
            <p><?= nl2br(htmlspecialchars($product['details'])); ?></p>
        </div>

        <!-- 评论区 -->
        <div class="product-reviews">
            <h2>Customer Reviews</h2>
            <?php foreach ($product['reviews'] as $review): ?>
                <div class="review">
                    <img src="<?= BASE_URL . $review['user_avatar']; ?>" alt="User Avatar">
                    <div class="review-rating">Rating: <?= $review['rating']; ?>/5</div>
                    <p class="review-text"><?= encode($review['review_text']); ?></p>
                    <small>Posted on <?= $review['created_at']; ?></small>
                </div>
            <?php endforeach; ?>

            <h3>Leave a Review</h3>
            <form id="review-form" method="POST">
                <textarea name="review_text" placeholder="Write your review here..." required></textarea>
                <div class="rating">
                    <label for="rating">Rating: </label>
                    <select name="rating" required>
                        <option value="1">1 - Poor</option>
                        <option value="2">2 - Fair</option>
                        <option value="3">3 - Good</option>
                        <option value="4">4 - Very Good</option>
                        <option value="5">5 - Excellent</option>
                    </select>
                </div>
                <button type="submit" class="submit-review">Submit Review</button>
            </form>
        </div>
    </div>
</main>


<script>
$(document).ready(function() {
    // 点击购买一个，跳转到payment界面
    $('.buy-now').click(function() {
        $.post('<?= API_URL ?>buy_now.php', {
            product_id: <?= $product['id']; ?>,
            size: $('#size').val(),
            color: $('.color-swatch.selected').css('background-color'),
            quantity: $('#quantity').val()
        }, function(response) {
            alert('Order placed successfully!');
            // 也可以跳转到付款页面 location.href = 'checkout.php';
        }).fail(function() {
            alert('Error placing order.');
        });
    });

    // 将产品添加到cart里
    $('.add-to-cart').click(function() {
        $.post('<?= API_URL ?>add_to_cart.php', {
            product_id: <?= $product['id']; ?>,
            size: $('#size').val(),
            color: $('.color-swatch.selected').css('background-color'),
            quantity: $('#quantity').val()
        }, function(response) {
            alert('Added to cart!');
        }).fail(function() {
            alert('Error adding to cart.');
        });
    });

    // 将产品添加到wishlist里
    $('.add-to-wishlist').click(function() {
        $.post('<?= API_URL ?>add_to_wishlist.php', {
            product_id: <?= $product['id']; ?>
        }, function(response) {
            alert('Added to wishlist!');
        }).fail(function() {
            alert('Error adding to wishlist.');
        });
    });

    // 颜色选中样式切换
    $('.color-swatch').click(function() {
        $('.color-swatch').removeClass('selected');
        $(this).addClass('selected');
    });

    // 评论
    $('#review-form').submit(function(e) {
        e.preventDefault(); // 阻止表单的默认提交行为

        var reviewText = $("textarea[name='review_text']").val();
        var rating = $("select[name='rating']").val();

        // 这里可以通过 Ajax 提交评论到服务器端
        $.ajax({
            url: '<?= API_URL ?>submit_review.php',
            method: 'POST',
            data: {
                review_text: reviewText,
                rating: rating,
                product_id: <?= $product['id']; ?>
            },
            success: function(response) {
                alert('Review submitted successfully!');
                // 可以重新加载评论部分，或直接显示新评论
                location.reload();
            },
            error: function() {
                alert('Error submitting review.');
            }
        });
    });
});
</script>

<?php require_once __DIR__.'/../partials/footer.php'; ?>