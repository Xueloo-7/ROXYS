<?php

// ============================================================================
// Helper
// ============================================================================

// Is GET request?

use PHPMailer\PHPMailer\PHPMailer;

function is_get() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

// Is POST request?
function is_post() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

// Obtain GET parameter
function get($key, $value = null) {
    $value = $_GET[$key] ?? $value;
    return is_array($value) ? array_map('trim', $value) : trim($value);
}

// Obtain POST parameter
function post($key, $value = null) {
    $value = $_POST[$key] ?? $value;
    return is_array($value) ? array_map('trim', $value) : trim($value);
}

// Obtain REQUEST (GET and POST) parameter（Not Recommanded)
function req($key, $value = null) {
    $value = $_REQUEST[$key] ?? $value;
    return is_array($value) ? array_map('trim', $value) : trim($value);
}

// Redirect to URL
function redirect($url = null) {
    $url ??= $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit();
}

// Set or get temporary session variable
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

function flash_msg($message, $type = 'success') {
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type, // success, error, warning, info
    ];
}

function encode($value){
    echo htmlspecialchars($value);
}

function getRouteSegments(): array {
    $rawPath = getCurrentRoutePath(); // e.g., "product_listing/2"
    return explode('/', trim($rawPath, '/'));
}

function getRouteSegment(int $index, $default = null): ?string {
    $segments = getRouteSegments();
    return $segments[$index] ?? $default;
}


/**
 * 获取当前请求的路由路径（去除 BASE_URI 和前后斜杠）
 * 例如 /ROXYS/login?id=5 => login
 * @return string
 */
function getCurrentRoutePath(): string {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = str_replace(BASE_URI, '', $path); // 去除项目子目录
    return trim($path, '/'); // 去除前后斜杠
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
// Auth Helper
// ============================================================================

function isLoggedIn(): bool {
    return isset($_SESSION['user']);
}

function isAdmin(): bool {
    return isLoggedIn() && $_SESSION['user']['role'] === 'admin';
}

function getUserAvatarHtml() {
    if (!isLoggedIn()) return '<i class="fas fa-user"></i>';
    
    $avatar = $_SESSION['user']['avatar'] ?? '';

    if (!$avatar) return '<i class="fas fa-user"></i>';
    
    return '<img src="' . BASE_URL . $avatar . '" class="user-avatar">';
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

// debug and die
function dd($content){
    echo '<pre>';
    var_dump($content);
    echo '</pre>';
    die();
}

// Generate beautiful debug
function vv($content){
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

// ============================================================================
// Email
// ============================================================================

// Initialize and return mail object
function get_mail() {
    require_once __DIR__.'/app/lib/PHPMailer.php';
    require_once __DIR__.'/app/lib/SMTP.php';

    $m = new PHPMailer(true);
    $m->isSMTP();
    $m->SMTPAuth = true;
    $m->Host = 'smtp.gmail.com';
    $m->Port = 587;
    $m->Username = 'roxys.service@gmail.com';
    $m->Password = 'bzou bxen ptfv detc';
    $m->CharSet = 'utf-8';
    $m->setFrom($m->Username, 'ROXYS Online Shopping');

    return $m;
}