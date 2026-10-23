<?php
require_once __DIR__ . '/auth.php';
require_login();

$projects = get_projects();
$messages = get_contact_messages();
$featured = get_featured_projects();

admin_header('Dashboard', 'dashboard');
?>
<div class="page-head">
    <h1>Dashboard</h1>
    <a href="project-edit.php" class="btn btn-primary">+ Add project</a>
</div>

<div class="cards">
    <div class="stat-card">
        <strong><?= count($projects) ?></strong>
        <span class="muted">Projects</span>
    </div>
    <div class="stat-card">
        <strong><?= count($featured) ?></strong>
        <span class="muted">Featured on homepage</span>
    </div>
    <div class="stat-card">
        <strong><?= count($messages) ?></strong>
        <span class="muted">Contact messages</span>
    </div>
</div>

<div class="card">
    <p>Use this panel to add, edit, or hide projects. Changes show on the homepage and the projects page immediately.</p>
    <p class="muted small">Logged in as <?= e((string) ($_SESSION['admin_username'] ?? 'admin')) ?>.</p>
    <div class="form-actions">
        <a href="projects.php" class="btn btn-primary">Manage projects</a>
        <a href="messages.php" class="btn">View messages</a>
    </div>
</div>
<?php admin_footer();