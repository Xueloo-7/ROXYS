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
function toggleEdit(id) {
    const input = document.getElementById(id);
    input.disabled = !input.disabled;
    markChanged();
}

function openEmailPopup() {
    document.getElementById("emailModal").style.display = 'block';
}

function closeEmailPopup() {
    document.getElementById("emailModal").style.display = 'none';
}

function sendOTP() {
    const email = document.getElementById('newEmail').value;
    if (!email.includes('@')) return alert('Invalid email');

    fetch('send_otp.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({email})
    }).then(res => res.json()).then(data => {
        alert(data.message);
    });
}

function verifyOTP() {
    const email = document.getElementById('newEmail').value;
    const otp = document.getElementById('otpCode').value;

    fetch('verify_otp.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({email, otp})
    }).then(res => res.json()).then(data => {
        if (data.success) {
            alert('Email updated!');
            location.reload();
        } else {
            alert(data.message || 'Verification failed');
        }
    });
}

document.getElementById('avatarPreview').addEventListener('click', function () {
    document.getElementById('avatarInput').click();
});

document.getElementById('avatarInput').addEventListener('change', function () {
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
        document.getElementById('avatarPreview').src = e.target.result;
        markChanged();
    };
    reader.readAsDataURL(file);
});

document.querySelectorAll('.gender-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.gender-btn').forEach(b => b.classList.remove('active'));

        btn.classList.add('active');
        markChanged();
    });
});

function markChanged() {
    document.getElementById('saveButton').disabled = false;
}

document.getElementById('saveButton').addEventListener('click', function () {
    const username = document.getElementById('username').value;
    const genderBtn = document.querySelector('.gender-btn.active');
    const gender = genderBtn ? genderBtn.dataset.gender : '';
    console.log(genderBtn);

    const formData = new FormData();
    formData.append('username', username);
    formData.append('gender', gender);

    const avatar = document.getElementById('avatarInput').files[0];
    if (avatar) {
        formData.append('avatar', avatar);
    }

    fetch('<?= API_URL ?>update_profile.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json()).then(data => {
        if (data.success) {
            console.log("reload");
            location.reload();
        } else {
            alert(data.message);
        }
    });
});

</script>