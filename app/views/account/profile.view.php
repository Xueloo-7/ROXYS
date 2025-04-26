<div class="info-box">
    <!-- 左侧信息 -->
    <div class="input-container">
        <!-- Username -->
        <div class="input">
            <label><strong>Username</strong></label>
            <div class="input-group">
                <input type="text" id="username" value="<?= htmlspecialchars($user['name']) ?>" disabled>
                <button type="button" class="edit-button" onclick="toggleEdit('username')">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
        </div>

        <!-- Gender -->
        <div class="input">
            <label><strong>Gender</strong></label>
            <div id="gender-buttons">
                <?php
                $genders = ['male' => '♂', 'female' => '♀', 'other' => '⚧'];
                foreach ($genders as $key => $icon):
                    $isActive = (strtolower($user['gender']) === $key) ? 'active' : '';
                ?>
                    <button type="button" class="gender-btn <?= $isActive ?>" data-gender="<?= $key ?>">
                        <?= $icon ?> <?= ucfirst($key) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Email -->
        <div class="input">
            <label><strong>Email</strong></label>
            <div class="input-group">
                <input type="text" id="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                <button type="button" class="edit-button" onclick="openEmailPopup()">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
        </div>

        <!-- Password -->
        <div class="input">
            <label><strong>Password</strong></label>
            <div class="input-group">
                <input type="password" id="password" value="********" disabled>
                <button type="button" class="edit-button" onclick="window.location.href='<?= BASE_URL ?>forgot_password?email=<?= urlencode($user['email']) ?>'">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- 右侧头像 -->
    <div class="avatar-container">
        <img id="avatarPreview" class="avatar-img" 
            src="<?= $avatar_url ?>" 
            alt="Avatar"
            style="cursor: pointer;">
        <input type="file" id="avatarInput" accept="image/*" class="hidden-input">
    </div>
</div>

<!-- 底部 Save 按钮 -->
<div class="save-btn">
    <button id="saveButton" type="button" disabled>Save</button>
</div>

<!-- 邮箱修改弹窗 -->
<div id="emailModal">
    <h3>Change Email</h3>
    <label>
        <input type="text" id="newEmail" placeholder="New email">
        <button onclick="sendOTP()">Send OTP</button>
    </label>
    
    <input type="text" id="otpCode" placeholder="Enter OTP">
    <div>
        <button onclick="closeEmailPopup()">Cancel</button>
        <button onclick="verifyOTP()">Confirm</button>
    </div>
</div>

<script>
// 移出 document.ready 作用域，放到脚本最外层
function toggleEdit(id) {
    const $input = $('#' + id);
    $input.prop('disabled', !$input.prop('disabled'));
    markChanged();
}

// Mark form as changed
function markChanged() {
    $('#saveButton').prop('disabled', false);
}

// Open and close email modal
function openEmailPopup() {
    $('#emailModal').show();
}

function closeEmailPopup() {
    $('#emailModal').hide();
}

// Send OTP
function sendOTP() {
    const email = $('#newEmail').val();
    if (!email.includes('@')) return alert('Invalid email');

    $.ajax({
        url: '<?= API_URL ?>send_otp.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ email }),
        success: function (data) {
            alert(data.message);
        }
    });
}

// Verify OTP
function verifyOTP() {
    const email = $('#newEmail').val();
    const otp = $('#otpCode').val();

    $.ajax({
        url: '<?= API_URL ?>verify_otp.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ email, otp }),
        success: function (data) {
            if (data.success) {
                alert('Email updated!');
                location.reload();
            } else {
                alert(data.message || 'Verification failed');
            }
        }
    });
}

// Avatar preview
$('#avatarPreview').click(function () {
    $('#avatarInput').click();
});

$('#avatarInput').change(function () {
    const file = this.files[0];
    if (!file) return;

    if (!file.type.startsWith('image/')) {
        alert("Only image files are allowed.");
        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        alert("Max image size is 2MB.");
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        $('#avatarPreview').attr('src', e.target.result);
        markChanged();
    };
    reader.readAsDataURL(file);
});

// Gender button selection
$('.gender-btn').click(function () {
    $('.gender-btn').removeClass('active');
    $(this).addClass('active');
    markChanged();
});

// Save profile
$('#saveButton').click(function () {
    const username = $('#username').val();
    const genderBtn = $('.gender-btn.active');
    const gender = genderBtn.length ? genderBtn.data('gender') : '';

    const formData = new FormData();
    formData.append('username', username);
    formData.append('gender', gender);

    const avatar = $('#avatarInput')[0].files[0];
    if (avatar) {
        formData.append('avatar', avatar);
    }

    $.ajax({
        url: '<?= API_URL ?>update_profile.php',
        method: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        success: function (data) {
            if (data.success) {
                location.reload();
            } else {
                location.reload();
            }
        }
    });
});
</script>