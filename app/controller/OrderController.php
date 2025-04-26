<?php

require_once __DIR__.'/../database/Model/Product.php';
require_once __DIR__.'/../database/Model/Review.php';
require_once __DIR__.'/../../base.php';

if (!isLoggedIn()) {
    header("Location: " .BASE_URL. '/login?redirect='.urlencode('order'));
    exit;
}

// Product Page
require_once __DIR__.'/../views/order/index.view.php';