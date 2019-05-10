<?php
session_start();
$path = "/imagenes/firmas/";
if (!file_exists($path)) {
    mkdir($path, 0777, true);
}
$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
if ($extension == "jpg") {
    $path .=
    $_SESSION["codigo"] . "." . $extension;
    move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . $path);
    echo $path;
}
else {
    echo "NO";
}