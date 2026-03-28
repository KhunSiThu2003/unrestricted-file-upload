<?php
function showFolder(string $dir, int $indent = 0): void
{
    if (!is_dir($dir)) {
        return;
    }

    $files = scandir($dir);

    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        echo str_repeat('─', $indent) . htmlspecialchars($file) . "<br>";

        $fullPath = $dir . DIRECTORY_SEPARATOR . $file;

        if (is_dir($fullPath)) {
            showFolder($fullPath, $indent + 4);
        }
    }
}

$projectPath = realpath(dirname(__DIR__));

if ($projectPath === false) {
    die('Project path not found');
}

showFolder($projectPath);
