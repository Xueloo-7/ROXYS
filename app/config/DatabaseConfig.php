<?php

class DatabaseConfig
{
    /**
     * 获取对应数据库配置
     *
     * @param string $name 数据库名称，可选值："pandora_database" 或 "xiwangly_database"
     * @return array 包含数据库连接信息的关联数组
     * 
     * 这里用phpmyadmin连接，因为远程连接很慢
     */
    public static function getDatabaseConfig(string $name = ''): array
    {
        if ($name === 'pandora_database') {
            return [
                'host' => '34.143.179.100',
                'dbname' => 'pandora_web_backup',
                'username' => 'root',
                'password' => 'yL$>XB2Ysr>p1Q(R',
            ];
        } else if ($name === 'xiwangly_database') {
            return [
                'host' => 'mysql.xiwangly.com',
                'dbname' => 'Web-Assignment-Code',
                'username' => 'Web-Assignment-Code',
                'password' => 'bnk4YMhra4mZd2YX',
            ];
        } else {
            return [
                'host' => 'localhost',
                'dbname' => 'roxy_db',
                'username' => 'root',
                'password' => '',
            ];
        }
    }

}
