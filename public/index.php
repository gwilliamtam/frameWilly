<?php
session_cache_expire(5);
$cache_expire = session_cache_expire();
session_start();
$uri = $_SERVER['REQUEST_URI'];

$appDir = __DIR__ . '/../app/';

switch ($uri) {
    case '/' :
        require $appDir . 'welcome.php';
        break;
    case '' :
        require $appDir . 'welcome.php';
        break;
    case '/form' :
        require $appDir . 'formFiles.php';
        break;
    case '/upload' :
        require $appDir . 'uploadFile.php';
        break;
    case '/image/a' :
        require $appDir . 'showFiles.php';
        break;
    case '/files' :
        require $appDir . 'showFiles.php';
        break;
    default:
        if (substr($uri, 0, 6) == "/image") {
            require $appDir . 'showImage.php';
            break;
        }
        require $appDir . 'error.php';
        break;
}


