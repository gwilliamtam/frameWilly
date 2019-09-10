<?php
include_once "Template.php";
include_once("Document.php");

$template = new Template();

$template->setTitle('Files');
$template->header();


$dir = scandir(__DIR__ . '/uploads');

$files = [];
foreach ($dir as $file) {
    if (substr($file, 0, 1) == '.') {
        continue;
    }

    $extPos = strrpos($file, '.');
    $rawFileName = substr($file, 0, $extPos);
    $ext = substr($file, $extPos+1);
    $timePos = strpos($file, '_');
    $rawTime = substr($file, $timePos+1, strlen($file) - $timePos - strlen($ext) -2);

    $files[$rawTime] = [
        'name' => $rawFileName,
        'ext' => $ext
    ];
}

arsort($files);

echo <<< HTML
<div class="container">
    <h4>Recent Submits</h4>
    
HTML;

foreach ($files as $rawTime => $row) {
    $year = substr($rawTime, 0, 4);
    $month = substr($rawTime, 4, 2);
    $day = substr($rawTime, 6, 2);
    $hour = substr($rawTime, 8, 2);
    $min = substr($rawTime, 10, 2);
    $sec = substr($rawTime, 12, 2);

    $fileName = __DIR__ . "/data/" . $row['name'] . ".txt";
    $fileHandler = fopen($fileName, 'r');
    $content = fread($fileHandler, filesize($fileName));
    fclose($fileHandler);
    $content = str_replace(PHP_EOL, '<br>', $content);
    $doc = $row['name'] . "." . $row['ext'];
    $document = new Document();

    echo <<< HTML
    <div class="card" style="width: 100%; float: left; margin: 20px;">
      <div class="card-body">
HTML;
    if ($document->isImage($row['ext'])) {
        echo <<< HTML
        <a href="/image?image=$doc" target="_new" class="document-link float-right">
            <img class="float-right" src="/image?image=$doc" alt="..." style="height: 100px">
        </a>
HTML;
    } else {
        echo <<< HTML
        <a href="/doc?doc=$doc" target="_new" class="document-link float-right">
            <i class="far fa-file fa-5x"></i>
        </a>            
HTML;
    }

    echo <<< HTML
        
        <h6 class="card-title">$year-$month-$day $hour:$min:$sec</h6>
        <p class="card-text">$content</p>
      </div>
    </div>
HTML;

}


echo <<< HTML
</div>
HTML;


$template->footer();
