<?php
require_once __DIR__.'/partials/header.php';

?>

<main>
    <div>
        <?= pre_var_dump($_ROUTE_PARAMS) ?>
        <?= pre_var_dump($query) ?>
    </div>
</main>

<?php require_once __DIR__.'/partials/footer.php'; ?>