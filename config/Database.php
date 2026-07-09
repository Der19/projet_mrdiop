<?php
class Database {
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new PDO(
                'mysql:host=localhost;dbname=mglsi_news;charset=utf8mb4',
                'mglsi_user',
                'passer',
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    Pdo\Mysql::ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
                ]
            );
        }
        return self::$instance;
    }
}
