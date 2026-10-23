<?php
require_once __DIR__ . '/auth.php';
require_login();

$flash = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_file'])) {
    check_csrf();
    if (delete_contact_message((string) $_POST['delete_file'])) {
        $flash = 'deleted';
    }
}

$messages = get_contact_messages();
admin_header('Messages', 'messages');
?>
<div class="page-head">
    <h1>Contact messages</h1>
</div>

<?php if ($flash === 'deleted'): ?>
<div class="alert alert-success">Message deleted.</div>
<?php endif; ?>

<?php if (!$messages): ?>
<div class="empty">No messages yet.</div>
<?php else: ?>
<?php foreach ($messages as $msg): ?>
<div class="message-card">
    <strong><?= e($msg['name'] ?? 'Unknown') ?></strong>
    <div class="muted small">
        <a href="mailto:<?= e($msg['email'] ?? '') ?>"><?= e($msg['email'] ?? '') ?></a>
        · <?= e($msg['created_at'] ?? '') ?>
    </div>
    <p><?= e($msg['message'] ?? '') ?></p>
    <?php if (!empty($msg['attachment'])): ?>
    <p class="small"><a href="download-attachment.php?file=<?= e(urlencode((string) $msg['attachment'])) ?>">Download attachment</a></p>
    <?php endif; ?>
    <form method="post" onsubmit="return confirm('Delete this message?');" style="margin-top:12px;">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="delete_file" value="<?= e($msg['_file'] ?? '') ?>">
        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
    </form>
</div>
<?php endforeach; ?>
<?php endif; ?>
<?php admin_footer();