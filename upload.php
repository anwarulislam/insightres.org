<?php
header('Content-Type: application/json');

$API_KEY = '2c4a92a58d6f556fa64780a7657c331b656e0aed6d0bf49e89215da9c5c42aa1';
$MAX_SIZE = 10 * 1024 * 1024;
$ALLOWED = ['html', 'css', 'js', 'json', 'txt', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'eot', 'webp'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(['status' => 'ok', 'message' => 'Ready']);
    exit;
}

$apiKey = $_SERVER['HTTP_X_API_KEY'] ?? '';
if (!hash_equals($API_KEY, $apiKey)) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid API key']);
    exit;
}

$file = $_FILES['file'] ?? null;
if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'Upload failed']);
    exit;
}

if ($file['size'] > $MAX_SIZE) {
    http_response_code(413);
    echo json_encode(['error' => 'File too large']);
    exit;
}

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, $ALLOWED)) {
    http_response_code(415);
    echo json_encode(['error' => 'Invalid file type']);
    exit;
}

if (preg_match('/[<>:"|?*]/', $file['name'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid filename']);
    exit;
}

if (!move_uploaded_file($file['tmp_name'], __DIR__ . '/' . $file['name'])) {
    http_response_code(500);
    echo json_encode(['error' => 'Save failed']);
    exit;
}

echo json_encode(['status' => 'success', 'filename' => $file['name']]);
