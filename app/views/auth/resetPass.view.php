

<div class="box-container">
    <div class="box">
    <form action="<?= BASE_URL ?>reset_password?email=<?= $_GET['email']; ?>" method="POST" autocomplete="off">
        <input type="text" name="fakeusernameremembered" style="display:none">
        <input type="password" name="fakepasswordremembered" style="display:none">

        <h1>Reset Password</h1>

        <div class="info-container">
            <label for="code">Enter Reset Code</label>
            <input id="code" name="code" type="text" placeholder="Enter the 6-digit code" autocomplete="off" required>
        </div>

        <div class="info-container">
            <label for="password">New Password</label>
            <input id="password" name="password" type="password" placeholder="Enter your new password" autocomplete="new-password" required>
        </div>

        <button type="submit" class="submit-button">Reset Password</button>
    </form>
    </div>
</div>

<style>
    /* 通用样式 */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f5f7fa;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.box-container {
    width: 100%;
    max-width: 400px;
    padding: 20px;
}

.box {
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    padding: 30px;
}

h1 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 24px;
    color: #333;
}

/* 输入容器 */
.info-container {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

label {
    font-size: 14px;
    margin-bottom: 6px;
    color: #555;
}

input[type="email"],
input[type="text"],
input[type="password"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.3s;
}

input:focus {
    border-color: #4a90e2;
    outline: none;
}

/* 提交按钮 */
.submit-button {
    width: 100%;
    padding: 12px;
    background-color: #4a90e2;
    color: white;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.submit-button:hover {
    background-color: #357ab8;
}

/* 错误提示 */
#submit-hint {
    color: red;
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
}

</style>