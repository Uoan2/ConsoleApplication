<?php

$fileName =  'dmitry-fedorov-console-config.php';
$file = __DIR__ . '/' . $fileName;

$line = readline("Are you sure want copy dmitry-fedorov-console-config.php?   \n" . PHP_EOL . 'Write "Yes" to confirm');

if (strripos($line, "Yes") && !copy($file, $fileName)) {
    echo "Can't copy $file...\n";
} else {
    echo "Success \n";
}
