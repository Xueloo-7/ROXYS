<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROXYS Online Shopping</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <?php link_css("styles") ?>

    <!-- 先加载jQuery再加载需要jQuery的js -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <?php link_js("app") ?>
    <?php link_js("header") ?>
    <?php link_js("searchHistoryHandler") ?>
    <?php link_js("search_history") ?>

</head>
<body>

    <!-- flash message setup -->
    <?php if (!empty($_SESSION['flash'])): ?>
        <!-- set flash type and message -->
        <div class="flash-message <?= $_SESSION['flash']['type'] ?>">
            <?= htmlspecialchars($_SESSION['flash']['message']) ?>
        </div>
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $('.flash-message').addClass('hide');
                }, 3000);
            });
        </script>
    <!-- flash ended -->
    <?php unset($_SESSION['flash']); endif; ?>