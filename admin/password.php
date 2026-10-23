<?php
require_once __DIR__ . '/auth.php';
require_login();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();

    $current = (string) ($_POST['current'] ?? '');
    $new = (string) ($_POST['new'] ?? '');
    $confirm = (string) ($_POST['confirm'] ?? '');
    $admin = get_admin();

    if (!password_verify($current, $admin['password_hash'])) {
        $errors[] = 'Current password is incorrect.';
    }
    if (strlen($new) < 6) {
        $errors[] = 'New password must be at least 6 characters.';
    }
    if ($new !== $confirm) {
        $errors[] = 'New password and confirmation do not match.';
    }

    if (!$errors) {
        $admin['password_hash'] = password_hash($new, PASSWORD_DEFAULT);
        save_admin($admin);
        $success = true;
    }
}

admin_header('Change password', 'password');
?>
<div class="page-head">
    <h1>Change password</h1>
</div>

<?php if ($success): ?>
<div class="alert alert-success">Password updated.</div>
<?php endif; ?>

<?php if ($errors): ?>
<div class="alert alert-error">
    <ul>
        <?php foreach ($errors as $err): ?>
        <li><?= e($err) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form method="post" class="card form" style="max-width:520px;">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

    <label for="current">Current password</label>
    <input type="password" id="current" name="current" autocomplete="current-password" required>

    <label for="new">New password</label>
    <input type="password" id="new" name="new" autocomplete="new-password" required>

    <label for="confirm">Confirm new password</label>
    <input type="password" id="confirm" name="confirm" autocomplete="new-password" required>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Update password</button>
        <a href="index.php" class="btn">Cancel</a>
    </div>
</form>
<?php admin_footer();