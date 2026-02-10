<?php
require_once __DIR__ . '/config.php';

function is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: index.php');
        exit;
    }
}

function get_authenticated_user(PDO $pdo)
{
    if (!is_logged_in()) {
        return null;
    }

    $stmt = $pdo->prepare('SELECT id, name, email, profile_image FROM users WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $user = $stmt->fetch();

    return $user ?: null;
}

