<?php

include_once "Document.php";

if (array_key_exists('image', $_GET)) {
    $filepath = "../app/uploads/" . $_GET['image'];

    $type = exif_imagetype($filepath); // [] if you don't have exif you could use getImageSize()
    $allowedTypes = array(
        1,  // [] gif
        2,  // [] jpg
        3,  // [] png
        6   // [] bmp
    );
    if (!in_array($type, $allowedTypes)) {
        return false;
    }
    switch ($type) {
        case 1 :
            $im = imageCreateFromGif($filepath);
            header('Content-Type: image/gif');
            imagegif($im);
            break;
        case 2 :
            $im = imageCreateFromJpeg($filepath);
            header('Content-Type: image/jpeg');
            imagejpeg($im);
            break;
        case 3 :
            $im = imageCreateFromPng($filepath);
            header('Content-Type: image/png');
            imagepng($im);
            break;
        case 6 :
            $im = imageCreateFromBmp($filepath);
            header('Content-Type: image/bmp');
            imagebmp($im);
            break;
        default:
            echo $type;
            die();
    }
}

if (array_key_exists('file', $_GET)) {
    $document = new Document();
    $type = $document->getExtension($_GET['file']);

    if (!$document->isValidDocument($type) || $type != 'pdf') {
        return false;
    }

    header('Content-type: application/pdf');
    header('Content-Disposition: attachment; filename="downloaded.pdf"');
    readfile(__DIR__ . "/uploads/" . $_GET['file']);
}

