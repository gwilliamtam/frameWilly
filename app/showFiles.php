<?php
include_once "Template.php";
include_once("Document.php");

$template = new Template();

$template->setTitle('Files');
$template->header();


$dir = scandir(__DIR__ . '/uploads');

$files = [];
$years = [];
foreach ($dir as $file) {
    if (substr($file, 0, 1) == '.') {
        continue;
    }

    $extPos = strrpos($file, '.');
    $rawFileName = substr($file, 0, $extPos);
    $ext = substr($file, $extPos+1);
    $timePos = strpos($file, '_');
    $rawTime = substr($file, $timePos+1, strlen($file) - $timePos - strlen($ext) -2);
    $year = substr($rawTime, 0, 4);

    $files[$rawTime] = [
        'name' => $rawFileName,
        'ext' => $ext
    ];
    if (!in_array($year, $years)) {
        $years[] = $year;
    }
}
krsort($files);
rsort($years);

$today = date('Y-m-d');
$show = 'today';
if (array_key_exists('show', $_GET)) {
    $show = $_GET['show'];
} else {
    $_GET['show'] = $show;
}
$months = ['January', 'February', 'March', 'April', 'May','June', 'July', 'August', 'September', 'November', 'December'];

?>

<div class="container">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link <?php echo showFilesActive('today') ?>" href="/files?show=today">Today</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo showFilesActive('month') ?>" href="/files?show=month"><?php echo date('F') ?></a>
      </li>
        <?php
        foreach ($years as $yr) {
            echo "<li class=\"nav-item\">";
            echo "  <a class=\"nav-link ".showFilesActive($yr)."\" href=\"/files?show=$yr\">$yr</a>";
            echo "</li>";
        }
        ?>
    </ul>
<?php

foreach ($files as $rawTime => $row) {
    $year = substr($rawTime, 0, 4);
    $month = substr($rawTime, 4, 2);
    $day = substr($rawTime, 6, 2);
    $hour = substr($rawTime, 8, 2);
    $min = substr($rawTime, 10, 2);
    $sec = substr($rawTime, 12, 2);

    if ($show == 'today') {
        if ($today != "$year-$month-$day") {
            continue;
        }
    }

    if ($show == 'month') {
        if ($year != date('Y') || $month != date('m')) {
            continue;
        }
    }

    if (intval($show) >= 2000 && intval($show) <= 3000) {
        if ($year != $show) {
            continue;
        }
    }

    $fileName = __DIR__ . "/data/" . $row['name'] . ".txt";
    $fileHandler = fopen($fileName, 'r');
    $content = fread($fileHandler, filesize($fileName));
    fclose($fileHandler);
    $content = str_replace(PHP_EOL, '<br>', $content);
    $doc = $row['name'] . "." . $row['ext'];
    $document = new Document();

    echo <<< HTML
    <div class="card files-card">
      <div class="card-body">
HTML;
    if ($document->isImage($row['ext'])) {
        echo <<< HTML
        <a href="/document?image=$doc" target="_new" class="document-link float-right">
            <img class="float-right" src="/document?image=$doc" alt="..." style="height: 100px">
        </a>
HTML;
    } else {
        echo <<< HTML
        <a href="/document?file=$doc" target="_new" class="document-link float-right">
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

function showFilesActive($value)
{
    if (array_key_exists('show', $_GET)) {
        if ($_GET['show'] == $value) {
            return 'active';
        }
    }
    return null;
}
