<div class="address-container">
    <?php if (!$address): ?>
        <p>Address not found.</p>
        <?php exit; ?>
    <?php endif; ?>

    <!-- Address Line -->
    <div class="form-group">
        <label>Address Line</label>
        <div class="input-row">
            <input type="text" id="address_line" value="<?= htmlspecialchars($address['address_line']) ?>" disabled>
            <button type="button" onclick="toggleEdit('address_line')">Edit</button>
        </div>
    </div>

    <!-- City -->
    <div class="form-group">
        <label>City</label>
        <div class="input-row">
            <input type="text" id="city" value="<?= htmlspecialchars($address['city']) ?>" disabled>
            <button type="button" onclick="toggleEdit('city')">Edit</button>
        </div>
    </div>

    <!-- Postcode -->
    <div class="form-group">
        <label>Postcode</label>
        <div class="input-row">
            <input type="text" id="postcode" value="<?= htmlspecialchars($address['postcode']) ?>" disabled>
            <button type="button" onclick="toggleEdit('postcode')">Edit</button>
        </div>
    </div>

    <!-- Save button -->
    <button id="saveAddressBtn" type="button" disabled>Save</button>
</div>

<script>
function toggleEdit(id) {
    const input = document.getElementById(id);
    input.disabled = !input.disabled;
    markChanged();
}

function markChanged() {
    document.getElementById('saveAddressBtn').disabled = false;
}

document.getElementById('saveAddressBtn').addEventListener('click', () => {
    const address_line = document.getElementById('address_line').value.trim();
    const city = document.getElementById('city').value.trim();
    const postcode = document.getElementById('postcode').value.trim();

    if (!address_line || !city || !postcode) {
        alert("Please fill all fields.");
        return;
    }

    fetch('<?= API_URL ?>update_address.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ address_line, city, postcode })
    }).then(res => res.json()).then(data => {
        if (data.success) {
            location.reload();
        } else {
            location.reload();
        }
    });
});
</script>