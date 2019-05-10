<?php

include_once('encrypt.php');
include_once('/home/quintoso/etc/sigefcloud.com/config.php');

$response = '';
$inputText = $_GET['inputText'];

$encrypt = new encrypt();

if($inputText != ''){

    switch($_GET['action']){

        case 'encrypt':
            $response = $encrypt->encrypt($inputText);
            break;

        case 'decrypt':
            $response = $encrypt->decrypt($inputText);
            break;
    }
}
?>

<html>
    <body>
        <form action="index.php" method="get">
            string:<input name="inputText" type="text">
            <input type="submit" name="action" value="encrypt">
            <input type="submit" name="action" value="decrypt">
        </form>
        <div id="response"><h1><?= $response ?></h1></div>
    </body>
</html>