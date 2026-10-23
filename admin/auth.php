<?php

require_once dirname(__DIR__) . '/includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in(): bool
{
    return !empty($_SESSION['admin_logged_in']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf'];
}

function check_csrf(): void
{
    $token = $_POST['csrf'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf'] ?? '', $token)) {
        http_response_code(400);
        exit('Invalid form token. Please go back and try again.');
    }
}

function attempt_login(string $username, string $password): bool
{
    $admin = get_admin();
    if ($username !== $admin['username'] || $admin['password_hash'] === '') {
        return false;
    }

    if (!password_verify($password, $admin['password_hash'])) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_username'] = $admin['username'];
    $_SESSION['login_failures'] = 0;

    return true;
}

function admin_header(string $title, string $active = ''): void
{
    $user = e((string) ($_SESSION['admin_username'] ?? 'admin'));
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?> · Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
    <div class="topbar-inner">
        <a class="brand" href="index.php">Shahid Admin</a>
        <nav class="topbar-nav">
            <a href="index.php" class="<?= $active === 'dashboard' ? 'is-active' : '' ?>">Dashboard</a>
            <a href="projects.php" class="<?= $active === 'projects' ? 'is-active' : '' ?>">Projects</a>
            <a href="messages.php" class="<?= $active === 'messages' ? 'is-active' : '' ?>">Messages</a>
            <a href="password.php" class="<?= $active === 'password' ? 'is-active' : '' ?>">Password</a>
            <a href="../" target="_blank" rel="noopener">View site</a>
            <a href="logout.php" class="danger">Logout</a>
        </nav>
    </div>
</header>
<main class="container">
    <?php
}

function admin_footer(): void
{
    ?>
</main>
</body>
</html>
    <?php
}
