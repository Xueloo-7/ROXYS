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
                <a class="sales-item" href="product/${product.id}">
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