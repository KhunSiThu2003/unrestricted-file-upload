function showFolder($dir, $indent = 0) {
    if (!is_dir($dir)) return;

    $files = scandir($dir);

    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo str_repeat('─', $indent) . $file . "<br>";

            if (is_dir($dir . '/' . $file)) {
                showFolder($dir . '/' . $file, $indent + 4);
            }
        }
    }
}

showFolder('/var/www/html/uploads');