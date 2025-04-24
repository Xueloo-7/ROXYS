<?php
// 确保没有session重复开启
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__.'/app/config/URL_config.php';
require_once __DIR__.'/functions.php';

// 如果访问前没有预定义是API，说明是页面php，那么就会加载head.php
// 注！！！建议在api文件第一行预定义 define('IS_API', true);
// 主要是为了避免污染json输出
if (!defined('IS_API')) {
    require_once 'head.php';
}

// global database pdo setup
require_once __DIR__.'/app/database/Database.php';
require_once __DIR__.'/app/config/DatabaseConfig.php';
$pdo = (new Database(DatabaseConfig::getDatabaseConfig()))->getConnection();

?>

<?php if (!defined('IS_API')): ?>
    <!-- 只有非API文件才能使用的JS的常量（避免污染json输出） -->
    <script>
        // setup js global variable (Because JS cannot use php const variable)
        const BASE_URL = "<?= BASE_URL ?>";
        const API_URL = "<?= API_URL ?>";
    </script>
<?php endif ?>