<?php

// 定义这是api文件，让base.php里的head.php不要输出html
define('IS_API', true);

// 基础api该有的引用
require_once __DIR__.'/../../base.php';
require_once __DIR__.'/../config/DatabaseConfig.php';
require_once __DIR__.'/../database/Database.php';