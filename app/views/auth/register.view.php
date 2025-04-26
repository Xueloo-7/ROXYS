<?php link_css("auth"); ?>

<div class="box-container register-version">
    <div class="box">
        <form action="<?php echo isset($_GET['redirect']) ? "?redirect=" . urlencode($_GET['redirect']) : ""; ?>" method="POST">
            <h1>Register</h1>
            <button type="button" class="quit" data-get='<?= BASE_URL ?>'>
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="info-container">
                <label for="name">Name</label>
                <i class="fa-solid fa-circle-user icon"></i>
                <input id="name" name="name" type="text" placeholder="Type your name" required>
                <hr class="line">
            </div>
            <div class="info-container">
                <label for="email">Email</label>
                <i class="fa-solid fa-envelope icon"></i>
                <input id="email" name="email" type="email" placeholder="Type your email" required>
                <hr class="line">
            </div>
            <div class="info-container">
                <label for="password">Password</label>
                <i class="fa-solid fa-lock icon"></i>
                <input id="password" name="password" type="password" placeholder="Type your password" required>
                <hr class="line">
            </div>
            <div class="info-container">
                <label for="confirm-password">Confirm password</label>
                <i class="fa-solid fa-lock icon"></i>
                <input id="confirm-password" name="confirm-password" type="password" placeholder="Confirm your password" required>
                <hr class="line">
            </div>
            <label class="jump-to-login"><a href="login">Already have account? Click here login!</a></label>

            <p id="submit-hint"><?php echo $error ?? ''; ?></p>

            <button type="submit" class="submit-button">Register</button>
        </form>
    </div>
</div>