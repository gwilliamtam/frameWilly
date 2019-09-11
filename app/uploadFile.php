<?php
include_once("Messages.php");
include_once("Document.php");
include_once("utils.php");

$messages = new Messages();

if ($_POST['id'] != $_SESSION['sessionId']) {
    $messages->add('error', 'Session Expired!');
    header('Location: /');
}

$target_dir = __DIR__ . "/" . "uploads";
$target_file = $target_dir . "/" . basename($_FILES["inputFile"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

$doc = new Document();
$temp = explode(".", $_FILES["inputFile"]["name"]);
$extension = end($temp);
$file = $_FILES["inputFile"];
$fileSizeLimit = 5000000;

if ((($file["type"] == "image/gif")
        || ($file["type"] == "image/jpeg")
        || ($file["type"] == "image/jpg")
        || ($file["type"] == "image/x-png")
        || ($file["type"] == "image/png")
        || ($file["type"] == "application/pdf")
    )
    && ($file["size"] < $fileSizeLimit)
    && $doc->isValidDocument($extension))
{
    if ($file["error"] > 0) {
        $messages->add('error', "Return Code: " . $file["error"] );
    } else {

        $personName = str_replace(' ', '', $_POST['name']);
        $recordName =  $personName . "_" . date("YmdHis");
        $newFileName = $recordName . "." .  $extension;

        if (file_exists($target_dir . $newFileName)) {
            $messages->add('error', $file["tmp_name"] . "->" . $newFileName . " already exists. ");
        } else {
            if (file_exists($target_dir)) {
                move_uploaded_file($file["tmp_name"], $target_dir . "/" .  $newFileName);
                $messages->add('message', "Stored in: " . $target_dir . $newFileName);
                $messages->add('success', "File uploaded correctly!");

                $recordFile = fopen(__DIR__ . '/data/' . $recordName . ".txt", "w") or $messages->add('error', "Could not store data!");
                fwrite($recordFile, "Name: " . $_POST['name'] . PHP_EOL);
                fwrite($recordFile, "Instructions: " . $_POST['instructions'] . PHP_EOL);
                fclose($recordFile);
                $messages->add('success', "Name and instructions stored correctly!");
            } else {
                $messages->add('error', "Target directory " . $target_dir . " not found.");
            }
        }
    }
} else {
    if ($file["size"] < $fileSizeLimit) {

        $messages->add('error', "Size exceed limit of " . $fileSizeLimit . " bytes");
    }
    $messages->add('error', "Invalid file");
}
session_write_close();
echo <<< HTML
<html lang="en">
<head>
<title>Redirect</title>
</head>
<body>
<script>

document.location = "/form";
</script>
</body>
</html>
HTML;
