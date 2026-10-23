<?php
require_once __DIR__ . '/auth.php';
require_login();

$projects = get_projects();
$flash = $_GET['msg'] ?? '';

admin_header('Projects', 'projects');
?>
<div class="page-head">
    <h1>Projects</h1>
    <a href="project-edit.php" class="btn btn-primary">+ Add project</a>
</div>

<?php if ($flash === 'created'): ?>
<div class="alert alert-success">Project created.</div>
<?php elseif ($flash === 'updated'): ?>
<div class="alert alert-success">Project updated.</div>
<?php elseif ($flash === 'deleted'): ?>
<div class="alert alert-success">Project deleted.</div>
<?php endif; ?>

<?php if (!$projects): ?>
<div class="empty">No projects yet. Click <strong>Add project</strong> to create the first one.</div>
<?php else: ?>
<table class="table">
    <thead>
        <tr>
            <th style="width:90px;">Image</th>
            <th>Title</th>
            <th>Category</th>
            <th>Featured</th>
            <th style="width:70px;">Order</th>
            <th style="width:170px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($projects as $p): ?>
        <tr>
            <td>
                <img class="thumb" src="<?= e(project_image_url($p['image'] ?? '', 'admin')) ?>" alt="<?= e($p['title'] ?? '') ?>">
            </td>
            <td>
                <strong><?= e($p['title'] ?? '') ?></strong>
                <div class="muted small"><?= e(function_exists('mb_strimwidth') ? mb_strimwidth((string) ($p['description'] ?? ''), 0, 90, '…') : substr((string) ($p['description'] ?? ''), 0, 90)) ?></div>
            </td>
            <td class="muted small"><?= e($p['category_label'] ?? $p['category'] ?? '') ?></td>
            <td><?= !empty($p['featured']) ? 'Yes' : 'No' ?></td>
            <td><?= (int) ($p['sort_order'] ?? 0) ?></td>
            <td class="actions">
                <a href="project-edit.php?id=<?= (int) $p['id'] ?>" class="btn btn-sm">Edit</a>
                <a href="../projects/<?= e(rawurlencode((string) $p['slug'])) ?>/" class="btn btn-sm" target="_blank" rel="noopener">View</a>
                <form method="post" action="project-delete.php" onsubmit="return confirm('Delete this project?');" style="display:inline;">
                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
<?php admin_footer();