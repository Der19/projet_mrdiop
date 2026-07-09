<?php
header('Content-Type: text/html; charset=UTF-8');

define('DB_HOST', 'localhost');
define('DB_NAME', 'mglsi_news');
define('DB_USER', 'mglsi_user');
define('DB_PASS', 'passer');

function getDB() {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            Pdo\Mysql::ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
        ]
    );
    return $pdo;
}
