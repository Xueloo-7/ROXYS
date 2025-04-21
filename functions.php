<?php

// ============================================================================
// Helper
// ============================================================================

function temp($key, $value = null, $delete = true) {
    if ($value !== null) {
        $_SESSION["temp_$key"] = $value;
        return null;
    }
    else {
        $value = $_SESSION["temp_$key"] ?? null;
        if($delete)
            unset($_SESSION["temp_$key"]);
        return $value;
    }
}

// ============================================================================
// Format
// ============================================================================

// Number to sold-count
function formatSoldCount($sold_count) {
    if ($sold_count >= 10000) {
        $sold_count = '10000+';
    } elseif ($sold_count >= 5000) {
        $sold_count = '5000+';
    } elseif ($sold_count >= 1000) {
        $sold_count = '1000+';
    } elseif ($sold_count >= 500) {
        $sold_count = '500+';
    } elseif ($sold_count >= 100) {
        $sold_count = '100+';
    }

    return "<p class='sold-count'>sold {$sold_count}</p>";
}

// convert dateTime to this format [02 Mar 2025 18:21:53]
function formatDate($datetime){
    $dateObj = new DateTime($datetime);
    return $dateObj->format('d M Y H:i:s');
}

function formatStatus($status){
    switch($status){
        case "to_pay":
            return "Wait For Paying";
        case "to_ship":
            return "Is Shipping";
        case "to_review":
            return "Completed";
        case "to_receive":
            return "Wait For Receive";
    }
}

// ============================================================================
// Header Helper
// ============================================================================

function setAccountButton() {
    // 根据是否登录，设置相应的链接、文本和头像
    $loggedIn = isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'];

    // 设置链接、按钮文本和头像
    temp('data-link', $loggedIn ? SCRIPT_URL . 'user_profile' : SCRIPT_URL . 'login');
    temp('text', $loggedIn ? "Account" : "Login");
    temp('avatar', $loggedIn ? getAvatarUrl() : null);
}

function getAvatarUrl() {
    // 从数据库查询用户头像（暂时用默认头像代替）
    // TODO: 替换为实际从数据库获取头像的逻辑
    return BASE_URL . '/image/default_avatar.gif';
}

function isAdmin(){
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
}

// ============================================================================
// Link Helper
// ============================================================================

function link_css($path) {
    echo '<link rel="stylesheet" href="' . BASE_URL . 'css/' . $path . '.css">';
}

function link_js($path) {
    echo '<script src="' . BASE_URL . 'js/' . $path . '.js"></script>';
}

// ============================================================================
// Debug
// ============================================================================

function dd($content){
    echo '<pre>';
    var_dump($content);
    echo '</pre>';
    die();
}

// Generate beautiful debug
function pre_var_dump($content){
    echo '<pre>';
    var_dump($content);
    echo '</pre>';
}

// ============================================================================
// Error Handling
// ============================================================================

function abort(){
    http_response_code(404);
    require_once __DIR__.'/app/views/404.view.php';
    die();
}