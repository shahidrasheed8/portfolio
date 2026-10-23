<?php

require_once __DIR__ . '/includes/captcha.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => false,
        'message' => 'Method not allowed.',
        'captcha' => ['html' => mq_captcha_generate()['html']],
    ]);
    exit;
}

$name = trim((string) ($_POST['name'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));
$captcha = trim((string) ($_POST['captcha'] ?? ''));
$secret = trim((string) ($_POST['captcha_secret'] ?? ''));

$errors = [];

if ($name === '') {
    $errors['name'] = ['The name field is required.'];
}

if ($email === '') {
    $errors['email'] = ['The email field is required.'];
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = ['Please enter a valid email address.'];
}

if ($message === '') {
    $errors['message'] = ['The message field is required.'];
}

if (!mq_captcha_verify($captcha, $secret)) {
    $errors['captcha'] = ['Captcha is incorrect.'];
}

$savedAttachment = null;
$allowed = ['pdf', 'doc', 'docx', 'txt', 'zip'];

if (!empty($_FILES['attachment']['name'])) {
    $file = $_FILES['attachment'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors['attachment'] = ['The file could not be uploaded.'];
    } elseif ($file['size'] > 5 * 1024 * 1024) {
        $errors['attachment'] = ['The file must be 5MB or smaller.'];
    } else {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed, true)) {
            $errors['attachment'] = ['Only PDF, Word, Text, or ZIP files are allowed.'];
        }
    }
}

$captchaNew = mq_captcha_generate();

if ($errors) {
    echo json_encode([
        'status' => false,
        'message' => 'Please check the form and try again.',
        'errors' => $errors,
        'captcha' => ['html' => $captchaNew['html']],
    ]);
    exit;
}

$messagesDir = __DIR__ . '/contact-messages';
$uploadsDir = __DIR__ . '/contact-uploads';

if (!is_dir($messagesDir)) {
    mkdir($messagesDir, 0755, true);
}

$entry = [
    'name' => $name,
    'email' => $email,
    'message' => $message,
    'created_at' => date('c'),
    'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
];

if (!empty($_FILES['attachment']['name']) && ($_FILES['attachment']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0755, true);
    }

    $ext = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));
    $savedAttachment = date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadsDir . '/' . $savedAttachment);
    $entry['attachment'] = $savedAttachment;
}

file_put_contents(
    $messagesDir . '/' . date('Ymd_His') . '_' . bin2hex(random_bytes(3)) . '.json',
    json_encode($entry, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);

echo json_encode([
    'status' => true,
    'message' => 'Thank you! Your message has been sent.',
    'captcha' => ['html' => $captchaNew['html']],
]);
