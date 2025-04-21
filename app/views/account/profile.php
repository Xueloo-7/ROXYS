<!-- ============================================================================
这是Account的Profile界面，也是默认界面
============================================================================  -->

<?php
require_once __DIR__.'/../partials/header.php';
link_css("account");
?>

<main>
    <a href="profile">Profile</a>
    <a href="address">Address</a>
    <a href="logout">Logout</a>
</main>

<?php require_once __DIR__.'/../partials/footer.php'; ?>