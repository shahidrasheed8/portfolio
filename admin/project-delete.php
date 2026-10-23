<?php
require_once __DIR__ . '/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: projects.php');
    exit;
}

check_csrf();

$id = (int) ($_POST['id'] ?? 0);
$projects = get_projects();
$kept = [];

foreach ($projects as $project) {
    if ((int) ($project['id'] ?? 0) !== $id) {
        $kept[] = $project;
        continue;
    }

    if (is_uploaded_project_image($project['image'] ?? '')) {
        $file = dirname(__DIR__) . '/' . $project['image'];
        if (is_file($file)) {
            @unlink($file);
        }
    }
}

save_projects($kept);
header('Location: projects.php?msg=deleted');
exit;
