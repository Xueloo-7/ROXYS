<div class="listing-container relative">
    <!-- Back button -->
    <a href="<?= BASE_URL ?>" class="back-button zoom"><i class="fas fa-arrow-left"></i> Back to Home Page</a>

    <form action="<?= BASE_URL ?>order_listing/1" style="margin: 50px 0px;" class="search-box">
        <input type="text" name="keyword" placeholder="Search Order">
        <button type="submit">Search</button>
    </form>

    <table style="margin-top: 100px;" border="1" cellspacing="0" cellpadding="8">
        <thead>
            <tr style="background-color: antiquewhite;">
                <th>Operation</th>
                <th>ID</th>
                <th>User</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Delivery Detail</th>
                <th>Place Date</th>
                <th>Paid Date</th>
                <th>Shipped Date</th>
                <th>Delivered Date</th>
                <th>Completed Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as &$order): ?>
            <tr data-id="<?= $order['id'] ?>">
                <td>
                    <div style="display: flex; gap: 5px;">
                        <button class="save-btn">Save</button>
                        <button class="delete-btn" style="background-color: #f66; color: white;">Delete</button>
                    </div>
                </td>
                <td><?= $order['id'] ?></td>
                <td><?= htmlspecialchars($order['user_name']) ?></td>
                <td><?= htmlspecialchars($order['product_name']) ?></td>
                <td><input type="number" class="editable" name="quantity" value="<?= $order['quantity'] ?>"></td>
                <td><input type="text" class="editable" name="payment_method" value="<?= htmlspecialchars($order['payment_method']) ?>"></td>
                <td><input type="text" class="editable" name="order_status" value="<?= htmlspecialchars($order['order_status']) ?>"></td>
                <td><textarea class="editable" name="delivery_detail"><?= htmlspecialchars($order['delivery_detail']) ?></textarea></td>
                <td><?= $order['place_date'] ?></td>
                <td><input type="datetime-local" class="editable" name="paid_date" value="<?= date('Y-m-d\TH:i', strtotime($order['paid_date'])) ?>"></td>
                <td><input type="datetime-local" class="editable" name="shipped_date" value="<?= date('Y-m-d\TH:i', strtotime($order['shipped_date'])) ?>"></td>
                <td><input type="datetime-local" class="editable" name="delivered_date" value="<?= date('Y-m-d\TH:i', strtotime($order['delivered_date'])) ?>"></td>
                <td><input type="datetime-local" class="editable" name="completed_date" value="<?= date('Y-m-d\TH:i', strtotime($order['completed_date'])) ?>"></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?= $pager->render('keyword='.$keyword,'style="margin: 80px 0px"','order_listing') ?>
</div>

<script>
$('.save-btn').click(function(e) {
    e.preventDefault();
    const row = $(this).closest('tr');
    const id = row.data('id');
    const data = {
        id: id,
        quantity: row.find('[name="quantity"]').val(),
        payment_method: row.find('[name="payment_method"]').val(),
        order_status: row.find('[name="order_status"]').val(),
        delivery_detail: row.find('[name="delivery_detail"]').val(),
        paid_date: row.find('[name="paid_date"]').val(),
        shipped_date: row.find('[name="shipped_date"]').val(),
        delivered_date: row.find('[name="delivered_date"]').val(),
        completed_date: row.find('[name="completed_date"]').val()
    };
    $.post('<?= API_URL ?>update_order.php', data, function(res) {
        alert('Save Success');
    }).fail(function() {
        alert('Save Failed');
    });
});

$('.delete-btn').click(function(e) {
    e.preventDefault();
    if (!confirm("Are you sure you want to delete this order?")) return;
    const row = $(this).closest('tr');
    const id = row.data('id');
    $.post('<?= API_URL ?>delete_order.php', { id: id }, function(res) {
        alert('Delete Success');
        location.reload();
    }).fail(function() {
        alert('Delete Failed');
    });
});
</script>
