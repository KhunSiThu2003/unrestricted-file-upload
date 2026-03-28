<?php
$projectRoot = realpath(dirname(__DIR__));
if ($projectRoot === false) {
    die('Project root not found');
}

$file = $_GET['file'] ?? '';

if ($file === '') {
    die('No file specified');
}

$targetPath = realpath($projectRoot . DIRECTORY_SEPARATOR . $file);

if (
    $targetPath === false ||
    strpos($targetPath, $projectRoot) !== 0 || // must stay inside project
    !is_file($targetPath)
) {
    die('Access denied or file not found');
}

$content = file_get_contents($targetPath);

header('Content-Type: text/plain; charset=utf-8');
echo $content;
