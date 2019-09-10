<?php
$file = $_POST['image'];
$content = __DIR__ . '/uploads/' . file_get_contents($file);
header('Content-Type: image/jpeg');
echo $content;
exit();