<?php
header('Content-Type: application/json');

define('UPLOAD_DIR', __DIR__);
define('MAX_FILE_SIZE', 10 * 1024 * 1024);
define('ALLOWED_EXTENSIONS', ['html', 'css', 'js', 'json', 'txt', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'eot', 'webp']);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    http_response_code(200);
    echo json_encode(['status' => 'ok', 'message' => 'Upload endpoint ready']);
    exit;
}

if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!isset($_SERVER['HTTP_X_API_KEY'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Missing API key']);
    exit;
}

$apiKey = $_SERVER['HTTP_X-API-KEY'];

$expectedKey = getenv('UPLOAD_API_KEY');
if (!$expectedKey) {
    http_response_code(500);
    echo json_encode(['error' => 'Server not configured']);
    exit;
}

if (!hash_equals($expectedKey, $apiKey)) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid API key']);
    exit;
}

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'No file uploaded or upload error']);
    exit;
}

$file = $_FILES['file'];

if ($file['size'] > MAX_FILE_SIZE) {
    http_response_code(413);
    echo json_encode(['error' => 'File too large']);
    exit;
}

$filename = $file['name'];
$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

if (!in_array($extension, ALLOWED_EXTENSIONS)) {
    http_response_code(415);
    echo json_encode(['error' => 'File type not allowed']);
    exit;
}

if (preg_match('/[<>:"|?*]/', $filename)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid filename']);
    exit;
}

$destination = UPLOAD_DIR . '/' . $filename;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to move file']);
    exit;
}

http_response_code(200);
echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully', 'filename' => $filename]);
