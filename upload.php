<?php
header('Content-Type: application/json');

$API_KEY = '2c4a92a58d6f556fa64780a7657c331b656e0aed6d0bf49e89215da9c5c42aa1';
$MAX_SIZE = 10 * 1024 * 1024;
$ALLOWED = ['php', 'html', 'css', 'js', 'json', 'txt', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'eot', 'webp', 'sh'];

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

// Extract directory path if present
$filename = $file['name'];
$directory = '';

if (strpos($filename, '/') !== false) {
    $pathParts = explode('/', $filename);
    $filename = array_pop($pathParts);
    $directory = implode('/', $pathParts);
}

// Create directory if it doesn't exist
if ($directory && !is_dir(__DIR__ . '/' . $directory)) {
    if (!mkdir(__DIR__ . '/' . $directory, 0755, true)) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to create directory']);
        exit;
    }
}

// Build destination path
$destination = $directory ? __DIR__ . '/' . $directory . '/' . $filename : __DIR__ . '/' . $filename;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    http_response_code(500);
    echo json_encode(['error' => 'Save failed']);
    exit;
}

echo json_encode(['status' => 'success', 'filename' => $file['name']]);
