<?php
require_once __DIR__.'/app/config/URL_config.php';
require_once __DIR__.'/functions.php';

// 如果访问前没有预定义是API，说明是页面php，那么就会加载head.php
// 注！建议在api文件第一行预定义 define('IS_API', true);
if (!defined('IS_API')) {
    require_once 'head.php';
}

// global database pdo setup
require_once __DIR__.'/app/database/Database.php';
require_once __DIR__.'/app/config/DatabaseConfig.php';
$pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();