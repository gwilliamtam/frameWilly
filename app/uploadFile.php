<?php
include_once("Messages.php");
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

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["inputFile"]["name"]);
$extension = end($temp);
$file = $_FILES["inputFile"];
if ((($file["type"] == "image/gif")
        || ($file["type"] == "image/jpeg")
        || ($file["type"] == "image/jpg")
        || ($file["type"] == "image/pjpeg")
        || ($file["type"] == "image/x-png")
        || ($file["type"] == "image/png"))
    && ($file["size"] < 1000000)
    && in_array($extension, $allowedExts))
{
    if ($file["error"] > 0) {
        $messages->add('error', "Return Code: " . $file["error"] );
    } else {

        $personName = str_replace(' ', '', $_POST['name']);
        $newFileName = $personName . "_" . date("YmdHis") . "." .  $extension;

        if (file_exists($target_dir . $newFileName)) {
            $messages->add('error', $file["tmp_name"] . "->" . $newFileName . " already exists. ");
        } else {
            if (file_exists($target_dir)) {
                move_uploaded_file($file["tmp_name"], $target_dir . "/" .  $newFileName);
                $messages->add('message', "Stored in: " . $target_dir . $newFileName);
                $messages->add('success', "File uploaded correctly!");
            } else {
                $messages->add('error', "Target directory " . $target_dir . " not found.");
            }
        }
    }
} else {
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
