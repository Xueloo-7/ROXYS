<div class="listing-container relative">
    <!-- Back button -->
    <a href="<?= BASE_URL ?>" class="back-button zoom"><i class="fas fa-arrow-left"></i> Back to Home Page</a>

    <form action="<?= BASE_URL ?>member_listing/1" style="margin: 50px 0px;" class="search-box">
        <input type="text" name="keyword" placeholder="Search Member">
        <button type="submit">Search</button>
    </form>

    <table style="margin-top: 100px;" border="1" cellspacing="0" cellpadding="8">
        <thead>
            <tr style="background-color: antiquewhite;">
                <th>Operation</th>
                <th>ID</th>
                <th>Avatar</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Active</th>
                <th>Role</th>
                <th>Address</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as &$user): ?>
            <tr data-id="<?= $user['id'] ?>" data-active="<?= $user['active'] ?>">
                <td>
                    <div style="display: flex; gap: 5px;">
                        <button class="save-btn">Save</button>
                        <button class="delete-btn" style="background-color: #f66; color: white;">Delete</button>
                        <button class="block-btn" style="background-color: #ccc;">
                            <?= $user['active'] ? 'Block' : 'Unblock' ?>
                        </button>
                    </div>
                </td>
                <td><?= $user['id'] ?></td>
                <td>
                    <img src="<?= BASE_URL.$user['avatar'] ?: 'default.jpg' ?>" 
                        alt="avatar" 
                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                </td>
                <td><input type="text" class="editable" name="name" value="<?= htmlspecialchars($user['name']) ?>"></td>
                <td><input type="text" class="editable" name="email" value="<?= htmlspecialchars($user['email']) ?>"></td>
                <td><input type="text" class="editable" name="gender" value="<?= htmlspecialchars($user['gender']) ?>"></td>
                <td>
                    <input type="text" class="editable" name="address_line" value="<?= htmlspecialchars($user['address_line']) ?>" placeholder="Address Line"><br>
                    <input type="text" class="editable" name="city" value="<?= htmlspecialchars($user['city']) ?>" placeholder="City"><br>
                    <input type="text" class="editable" name="postcode" value="<?= htmlspecialchars($user['postcode']) ?>" placeholder="Postcode">
                </td>                
                <td><?= $user['active'] ? 'Yes' : 'No' ?></td>
                <td><input type="text" class="editable" name="role" value="<?= htmlspecialchars($user['role']) ?>"></td>
                <td><?= $user['created_at'] ?></td>
                <td><?= $user['updated_at'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?= $pager->render('keyword='.$keyword,'style="margin: 80px 0px"','member_listing') ?>

    <button id="add-product-btn" class="center" style="margin:30px 0px">Add a member</button>

    <!-- Add User Modal -->
    <div id="add-product-modal" class="center" style="display: none; top: 3%; background: white; padding: 20px; border: 2px solid #ccc; box-shadow: 0 0 10px rgba(0,0,0,0.2); z-index: 1000;">
        <h3>Add a new member</h3>
        <form id="add-product-form">
            <label>Name: <input type="text" name="name" required></label><br><br>
            <label>Email: <input type="email" name="email" required></label><br><br>
            <label>Password: <input type="password" name="password" required></label><br><br>

            <button type="submit">confirm</button>
            <button type="button" id="cancel-add-product">cancel</button>
        </form>
    </div>
</div>

<script>
$('.save-btn').click(function(e) {
    e.preventDefault();
    const row = $(this).closest('tr');
    const id = row.data('id');
    const data = {
        id: id,
        name: row.find('[name="name"]').val(),
        email: row.find('[name="email"]').val(),
        gender: row.find('[name="gender"]').val(),
        role: row.find('[name="role"]').val(),
        address_line: row.find('[name="address_line"]').val(),
        city: row.find('[name="city"]').val(),
        postcode: row.find('[name="postcode"]').val()
    };
    $.post('<?= API_URL ?>update_user.php', data, function(res) {
        alert('Save Success');
    }).fail(function() {
        alert('Save Failed');
    });
});

$('.delete-btn').click(function(e) {
    e.preventDefault();
    if (!confirm("Are you sure you want to delete this user?")) return;
    const row = $(this).closest('tr');
    const id = row.data('id');
    $.post('<?= API_URL ?>delete_user.php', { id: id }, function(res) {
        alert('Delete Success');
        location.reload();
    }).fail(function() {
        alert('Delete Failed');
    });
});

$('.block-btn').click(function(e) {
    e.preventDefault();
    const row = $(this).closest('tr');
    const id = row.data('id');
    const active = row.data('active');
    const action = active ? 'block' : 'unblock';

    if (!confirm(`Are you sure to ${action} this user?`)) return;

    $.post('<?= API_URL ?>toggle_user_block.php', { id: id }, function(res) {
        alert(`${action.charAt(0).toUpperCase() + action.slice(1)} Success`);
        location.reload();
    }).fail(function() {
        alert(`${action.charAt(0).toUpperCase() + action.slice(1)} Failed`);
    });
});

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
        email: form.find('[name="email"]').val(),
        password: form.find('[name="password"]').val(),
    };

    $.post('<?= API_URL ?>add_user.php', data, function(res) {
        alert('Add Success');
        $('#add-product-modal').fadeOut();
        location.reload();
    }).fail(function() {
        alert('Add Failed');
    });
});
</script>
