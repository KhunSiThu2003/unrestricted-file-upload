<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['success' => false, 'error' => 'Not authenticated.']);
    exit;
}

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    $code = $_FILES['file']['error'] ?? null;

    $message = 'No file uploaded or upload error.';
    if ($code !== null && $code !== UPLOAD_ERR_OK) {
        $message .= " (PHP upload error code: {$code})";
    }

    echo json_encode(['success' => false, 'error' => $message]);
    exit;
}

$uploadDir = __DIR__ . '/uploads/';
if (!is_dir($uploadDir)) {
    @mkdir($uploadDir, 0777, true);
}

if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
    echo json_encode(['success' => false, 'error' => 'Upload directory is not writable. Check filesystem permissions.']);
    exit;
}

$originalName = $_FILES['file']['name'] ?? 'upload';
$originalName = basename(str_replace(["\0", "/", "\\"], "_", $originalName));
if ($originalName === '') {
    $originalName = 'upload_' . time();
}

$targetPath = $uploadDir . $originalName;

if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
    echo json_encode(['success' => false, 'error' => 'Failed to move uploaded file.']);
    exit;
}

$newProfilePic = null;
if (isset($_FILES['file']['tmp_name'])) {
    $finfo    = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $targetPath);
    finfo_close($finfo);

    if (strpos($mimeType, 'image/') === 0) {
        // Update profile_image in DB for this user
        $stmt = $pdo->prepare('UPDATE users SET profile_image = :pic WHERE id = :id');
        $stmt->execute([
            ':pic' => $originalName,
            ':id'  => $_SESSION['user_id'],
        ]);
        $newProfilePic = 'uploads/' . $originalName;
    }
}

echo json_encode([
    'success'      => true,
    'message'      => 'File uploaded (vulnerable path). This endpoint is intentionally unsafe!',
    'storedAs'     => 'uploads/' . $originalName,
    'newProfilePic'=> $newProfilePic,
]);

