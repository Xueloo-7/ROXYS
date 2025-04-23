
<div class="listing-container relative">
    <!-- Back button -->
    <a href="<?= BASE_URL ?>" class="back-button zoom"><i class="fas fa-arrow-left"></i> Back to Home Page</a>

    <form action="<?= BASE_URL ?>product_listing/1" style="margin: 50px 0px;" class="search-box">
        <input type="text" name="keyword" placeholder="Search Product">
        <button type="submit">Search</button>
    </form>

    <table style="margin-top: 100px;" border="1" cellspacing="0" cellpadding="8">
        <thead>
            <tr style="background-color: antiquewhite;">
                <th>Operation</th>
                <th>ID</th>
                <th>Name</th>
                <th>Original Price</th>
                <th>Discount</th>
                <th>Stock</th>
                <th>Description</th>
                <th>Details</th>
                <th>Image</th>
                <th>Category</th>
                <th>Sizes</th>
                <th>Colors</th>
                <th>Sold</th>
            </tr>
        </thead>
        <tbody>
        <br>
            <?php foreach ($products as &$product): ?>
            <tr data-id="<?= $product['id'] ?>">
                <td>
                    <div style="display: flex; gap: 5px;">
                        <button class="save-btn">Save</button>
                        <button class="delete-btn" style="background-color: #f66; color: white;">Delete</button>
                    </div>
                </td>
                <td><?= $product['id'] ?></td>
                <td><input type="text" class="editable" name="name" value="<?= htmlspecialchars($product['name']) ?>"></td>
                <td><input type="number" class="editable" name="price" step="0.01" value="<?= $product['original_price'] ?>"></td>
                <td><input type="number" class="editable" name="discount" value="<?= $product['discount'] ?>"></td>
                <td><input type="number" class="editable" name="stock" value="<?= $product['stock'] ?>"></td>
                <td><input type="text" class="editable" name="description" value="<?= htmlspecialchars($product['description']) ?>"></td>
                <td><textarea name="details" class="editable"><?= htmlspecialchars($product['details']) ?></textarea></td>
                <td><input type="text" class="editable" name="image_url" value="<?= htmlspecialchars($product['image_url']) ?>"></td>
                <td><input type="text" class="editable" name="category" value="<?= htmlspecialchars($product['category']) ?>"></td>
                <td><input type="text" class="editable" name="sizes" value="<?= htmlspecialchars(implode(',', $product['sizes'] ?? [])) ?>"></td>
                <td><input type="text" class="editable" name="colors" value="<?= htmlspecialchars(implode(',', $product['colors'] ?? [])) ?>"></td>
                <td><?= $product['sold'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button id="add-product-btn" class="center" style="margin:30px 0px">Add a product</button>

    <!-- Add Product Modal -->
    <div id="add-product-modal" class="center" style="display: none; top: 3%; background: white; padding: 20px; border: 2px solid #ccc; box-shadow: 0 0 10px rgba(0,0,0,0.2); z-index: 1000;">
        <h3>Add a new product</h3>
        <form id="add-product-form">
            <label>Name: <input type="text" name="name" required></label><br><br>
            <label>Price: <input type="number" name="price" step="0.01" required></label><br><br>
            <label>Discount: <input type="number" name="discount" value="0"></label><br><br>
            <label>Stock: <input type="number" name="stock" required></label><br><br>
            <label>Description: <input type="text" name="description"></label><br><br>
            <label>Details: <textarea name="details"></textarea></label><br><br>
            <label>Image URL: <input type="text" name="image_url"></label><br><br>
            <label>Category: <input type="text" name="category"></label><br><br>
            <label>Sizes (seperate with , ): <input type="text" name="sizes"></label><br><br>
            <label>Colors (seperate with , ): <input type="text" name="colors"></label><br><br>

            <button type="submit">confirm</button>
            <button type="button" id="cancel-add-product">cancel</button>
        </form>
    </div>

    <?= $pager->render('keyword='.$keyword,'style="margin: 80px 0px"','product_listing') ?>
</div>

<script>

$('#add-product-btn').click(function() {
    $('#add-product-modal').fadeIn();
});

$('#cancel-add-product').click(function() {
    $('#add-product-modal').fadeOut();
});

$('#add-product-form').submit(function(e) {
    e.preventDefault();
    const form = $(this);
    const data = {
        name: form.find('[name="name"]').val(),
        price: form.find('[name="price"]').val(),
        discount: form.find('[name="discount"]').val(),
        stock: form.find('[name="stock"]').val(),
        description: form.find('[name="description"]').val(),
        details: form.find('[name="details"]').val(),
        image_url: form.find('[name="image_url"]').val(),
        category: form.find('[name="category"]').val(),
        sizes: form.find('[name="sizes"]').val(),
        colors: form.find('[name="colors"]').val()
    };

    $.post('<?= API_URL ?>add_product.php', data, function(res) {
        alert('Add Success');
        $('#add-product-modal').fadeOut();
        location.reload(); // 可选，刷新页面显示新产品
    }).fail(function() {
        alert('Add Failed');
    });
});


$('.delete-btn').click(function(e) {
    e.preventDefault();
    if (!confirm("Are you sure you want to delete this product?")) return;
    const row = $(this).closest('tr');
    const id = row.data('id');
    const data = {
        id: id
    };
    $.post('<?= API_URL ?>delete_product.php', data, function(res) {
        alert('Delete Success');
        location.reload();

    }).fail(function() {
        alert('Delete Failed');
    });
});

$('.save-btn').click(function(e) {
    e.preventDefault();
    const row = $(this).closest('tr');
    const id = row.data('id');
    const data = {
        id: id,
        name: row.find('[name="name"]').val(),
        price: row.find('[name="price"]').val(),
        discount: row.find('[name="discount"]').val(),
        stock: row.find('[name="stock"]').val(),
        description: row.find('[name="description"]').val(),
        details: row.find('[name="details"]').val(),
        image_url: row.find('[name="image_url"]').val(),
        category: row.find('[name="category"]').val(),
        sizes: row.find('[name="sizes"]').val(),
        colors: row.find('[name="colors"]').val(),
    };
    $.post('<?= API_URL ?>update_product.php', data, function(res) {
        alert('Save Success');
    }).fail(function() {
        alert('Save Failed');
    });
});
</script>