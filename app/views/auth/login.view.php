<?php link_css("auth"); ?>



<div class="box-container login-version">
    <div class="box">
        <form action="<?= isset($_GET['redirect']) ? "?redirect=" . urlencode($_GET['redirect']) : ""; ?>" method="POST">
            <h1>Login</h1>
            <button type="button" class="quit" data-get="<?=BASE_URL?>">
            <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="info-container">
                <label for="email">Email</label>
                <i class="fa-solid fa-circle-user icon"></i>
                <input id="email" name="email" type="text" placeholder="Type your email" required>
                <hr class="line">
            </div>
            <div class="info-container">
                <label for="password">Password</label>
                <i class="fa-solid fa-lock icon"></i>
                <input id="password" name="password" type="password" placeholder="Type your password" required>
                <hr class="line">
            </div>

            <label class="remember"><input type="checkbox" name="remember"> Remember me</label>

            <label class="forgot-password"><a href="login/forgot_password">Forgot password?</a></label>

            <label class="create-account"><a href="register">Don't have account? Click me to create!</a></label>

            <p id="submit-hint"><?= $error ?? ''; ?></p>

            <button type="submit" class="submit-button">Login</button>
        </form>
    </div>
</div>