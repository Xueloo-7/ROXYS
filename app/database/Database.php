<?php

class Database
{
    private PDO $pdo;

    public function __construct($config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']}";
        $this->pdo = new PDO($dsn, $config['username'], $config['password']);
        // 让数据库能捕获错误
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    public function createDatabase($dbname): false|int
    {
        return $this->pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
    }
}