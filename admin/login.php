<?php
require_once __DIR__ . '/auth.php';

if (is_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = '';
$failures = (int) ($_SESSION['login_failures'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();

    if ($failures >= 8) {
        $error = 'Too many failed attempts. Wait a moment and try again.';
    } else {
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if (attempt_login($username, $password)) {
            header('Location: index.php');
            exit;
        }

        $_SESSION['login_failures'] = $failures + 1;
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login · Shahid Rasheed</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">
    <form class="login-card" method="post" action="login.php">
        <h1>Admin Login</h1>
        <p class="muted">Sign in to manage projects and messages.</p>

        <?php if ($error): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
        <?php endif; ?>

        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

        <label for="username">Username</label>
        <input type="text" id="username" name="username" autocomplete="username" required autofocus>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" autocomplete="current-password" required>

        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
        <p class="muted small">Default: <strong>admin / admin123</strong> — change this after login.</p>
    </form>
</body>
</html>
