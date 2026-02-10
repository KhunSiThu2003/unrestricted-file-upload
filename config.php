<?php
$db_host = '127.0.0.1';
$db_name = 'unrestricted_upload_db';
$db_user = 'khunsithu';
$db_pass = 'Asdf@1234';

$pdoOptions = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $serverDsn = "mysql:host=$db_host;charset=utf8mb4";
    $serverPdo = new PDO($serverDsn, $db_user, $db_pass, $pdoOptions);
    $serverPdo->exec(
        "CREATE DATABASE IF NOT EXISTS `$db_name`
         CHARACTER SET utf8mb4
         COLLATE utf8mb4_unicode_ci"
    );

    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
    $pdo = new PDO($dsn, $db_user, $db_pass, $pdoOptions);

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS `users` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(100) NOT NULL,
            `email` VARCHAR(100) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `plain_password` VARCHAR(255) DEFAULT NULL,
            `profile_image` VARCHAR(255) DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB
          DEFAULT CHARSET=utf8mb4
          COLLATE=utf8mb4_unicode_ci"
    );
} catch (PDOException $e) {
        die('Database setup/connection failed: ' . htmlspecialchars($e->getMessage()));
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

