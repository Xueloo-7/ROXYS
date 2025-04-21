<!-- ============================================================================
这个是Home Page，包含了Home该有的各个部分
============================================================================  -->

<?php
require_once __DIR__.'/../partials/header.php';
link_css("home");
?>

<main>
    <?php include __DIR__.'/navigation.view.php'; ?>
    <?php include __DIR__.'/topsales.view.php'; ?>
    <?php include __DIR__.'/discover.view.php'; ?>
</main>

<?php require_once __DIR__.'/../partials/footer.php'; ?>