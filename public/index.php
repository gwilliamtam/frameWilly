<?php
session_cache_expire(5);
$cache_expire = session_cache_expire();
session_start();
$request = $_SERVER['REQUEST_URI'];

$appDir = __DIR__ . '/../app/';

switch ($request) {
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
    default:
        require $appDir . 'error.php';
        break;
}

