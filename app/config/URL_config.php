<?php

/* 


    之后要使用某个文件直接
    require SCRIPT_PATH . 'home/header.php'; // 这样以后更改文件位置会比较容易修改和维护
    require ROOT_PATH . '_base.php';

    链接
    <img src="<?= BASE_URL; ?>/image/web_icon.png">
    <script src="<?= BASE_URL; ?>js/header.js" defer></script>

    如果是 PHP 代码要用的，就用 ROOT_PATH，如果是网页要访问的，就用 BASE_URL。


*/


/** @noinspection HttpUrlsUsage */
$is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') 
            || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') 
            || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);

$protocol = $is_https ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST']; // 直接使用 HTTP_HOST

// 计算正确的 BASE_PATH
$base_path = str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '', str_replace('\\', '/', dirname(__DIR__, 2)));
$base_path = trim($base_path, '/'); // 确保没有多余的 /

$base_url = $protocol . $host;

if (!empty($base_path)) {
    $base_url .= '/' . trim($base_path, '/');
}

define('BASE_URL', rtrim($base_url, '/') . '/');
define('ROOT_PATH', dirname(__DIR__, 2) . '/'); 
define('API_URL', BASE_URL . 'app/api/'); 
//define('SCRIPT_URL', BASE_URL . 'scripts/');
define('SCRIPT_URL', BASE_URL);
define('BASE_URI', "/ROXYS/");

// Debug
// echo "<pre>";
// echo "HTTPS: " . ($_SERVER['HTTPS'] ?? 'Not Set') . PHP_EOL;
// echo "HTTP_X_FORWARDED_PROTO: " . ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? 'Not Set') . PHP_EOL;
// echo "SERVER_PORT: " . ($_SERVER['SERVER_PORT'] ?? 'Not Set') . PHP_EOL;
// echo "HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'Not Set') . PHP_EOL;
// echo "Calculated BASE_URL: " . BASE_URL . PHP_EOL;
// echo "</pre>";

// echo "<pre>";
// echo "ROOT_PATH:\t" . ROOT_PATH . "\n";
// echo "BASE_URL:\t" . BASE_URL . "\n";
// echo "API_URL:\t" . API_URL . "\n";
// echo "SCRIPT_PATH:\t" . SCRIPT_PATH . "\n";
// echo "SCRIPT_URL:\t" . SCRIPT_URL . "\n";
// echo "</pre>";

// exit;
