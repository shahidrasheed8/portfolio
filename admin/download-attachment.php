<?php
require_once __DIR__ . '/auth.php';
require_login();

$file = basename((string) ($_GET['file'] ?? ''));
if ($file === '' || !preg_match('/^[a-zA-Z0-9._-]+$/', $file)) {
    http_response_code(400);
    exit('Invalid file.');
}

$path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'contact-uploads' . DIRECTORY_SEPARATOR . $file;
if (!is_file($path)) {
    http_response_code(404);
    exit('File not found.');
}

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Content-Length: ' . filesize($path));
readfile($path);
exit;
