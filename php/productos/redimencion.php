<?php

function redimencionImagen($dir, $dir2, $imagen) {

    //echo $dir.'<br>'.$dir2.'<br>'.$imagen.'<br><br>';

    redimencionImagenFinal($dir, $dir2, $imagen);

    $rutaImagenOriginal = $dir . $imagen;

    $img_original = imagecreatefromjpeg($rutaImagenOriginal);
    $final_min = 480;
    list($ancho, $alto) = getimagesize($rutaImagenOriginal);
    $posx = 0;
    $posy = 0;
    if ($ancho > $alto) {
        $ancho_final = $ancho;
        $alto_final = $ancho;
        $posy += ($ancho / 2) - ($alto / 2);
    }
    else {
        $ancho_final = $alto;
        $alto_final = $alto;
        $posx += ($alto / 2) - ($ancho / 2);
    }
//    echo "AF:$ancho_final - AF:$alto_final";
    $temp_image = imagecreatetruecolor($ancho_final, $alto_final);

    $whiteBackground = imagecolorallocate($temp_image, 255, 255, 255);
    imagefill($temp_image, 0, 0, $whiteBackground);
    imagecopyresampled($temp_image, $img_original, $posx, $posy, 0, 0, $ancho, $alto, $ancho, $alto);
    $thumbnail = imagecreatetruecolor($final_min, $final_min);
    imagecopyresampled($thumbnail, $temp_image, 0, 0, 0, 0, $final_min, $final_min, $ancho_final, $alto_final);
    imagedestroy($img_original);
    $calidad = 100;

    if (imagejpeg($thumbnail, "$dir2$imagen", $calidad)) {
        return true;
    }
    else {
        return false;
    }
}

function redimencionImagenFinal($dir, $dir2, $imagen) {

    $rutaImagenOriginal = $dir . $imagen;
    $img_original = imagecreatefromjpeg($rutaImagenOriginal);
    list($ancho, $alto) = getimagesize($rutaImagenOriginal);
    $final_min = 502;
    if ($ancho < $final_min || $alto < $final_min) {

        if ($ancho > $alto) {
            $cambio = $ancho / $alto;

            $ancho_final = $final_min * $cambio;
            $alto_final = $final_min;
        }
        else {
            $cambio = $alto / $ancho;

            $ancho_final = $final_min;
            $alto_final = $final_min * $cambio;
        }

        $tmp = imagecreatetruecolor($ancho_final, $alto_final);

        imagecopyresampled($tmp, $img_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);

        imagedestroy($img_original);

        $calidad = 100;

        if (imagejpeg($tmp, "$dir$imagen", $calidad)) {
            return true;
        }
        else {
            return false;
        }
    }
}

?>