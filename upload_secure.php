<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['success' => false, 'error' => 'Not authenticated.']);
    exit;
}

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'No file uploaded or upload error.']);
    exit;
}

$file       = $_FILES['file'];
$maxSize    = 2 * 1024 * 1024;
$allowedExt = ['jpg', 'jpeg', 'png'];

if ($file['size'] > $maxSize) {
    echo json_encode(['success' => false, 'error' => 'File is too large. Max size is 2MB.']);
    exit;
}

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, $allowedExt, true)) {
    echo json_encode(['success' => false, 'error' => 'Invalid file extension. Only JPG and PNG are allowed.']);
    exit;
}

$finfo    = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

$allowedMime = ['image/jpeg', 'image/png'];
if (!in_array($mimeType, $allowedMime, true)) {
    echo json_encode(['success' => false, 'error' => 'Invalid MIME type. Only image/jpeg and image/png are allowed.']);
    exit;
}

$uploadDir = __DIR__ . '/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$randomName = bin2hex(random_bytes(8)) . '.' . $ext;
$targetPath = $uploadDir . $randomName;

if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
    echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file.']);
    exit;
}

$stmt = $pdo->prepare('UPDATE users SET profile_image = :pic WHERE id = :id');
$stmt->execute([
    ':pic' => $randomName,
    ':id'  => $_SESSION['user_id'],
]);

$publicPath = 'uploads/' . $randomName;

echo json_encode([
    'success'      => true,
    'message'      => 'Secure upload successful. Profile picture updated.',
    'newProfilePic'=> $publicPath
]);

