<?php

$direction = $_POST['direction'];
$imageurl = $_POST['imageurl'];

if($direction == 'iz'){
    $degrees = 90;
}

else{
    $degrees = 270;
}
$tImageurl = str_split($imageurl, '?');
$imageurl = strtolower($tImageurl[0]);
$source = imagecreatefromjpeg($imageurl);
$whiteBackground = imagecolorallocate($source, 255, 255, 255);
$rotate = imagerotate($source, $degrees, $whiteBackground);

imagejpeg($rotate,$imageurl);

imagedestroy($source);
imagedestroy($rotate);