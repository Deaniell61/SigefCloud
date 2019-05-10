<?php
$nombre   =   'sellers/ByB_Picamas_Green_Hot_sauce_3.52_oz_-_Salsa_verde_picante_FRO2.jpg';


$guardar     =   "sellers/prueva.jpg";

$giro = 90;

RotateJpg($nombre,$giro,$nombre);

function RotateJpg($nombre, $angulo, $guardarnombre)
    {
      
        $original   =   imagecreatefromjpeg($nombre);
  
        $rotated    =   imagerotate($original, $angulo, 0);
       
        if($guardarnombre == false) 
		{
                header('Content-Type: image/jpeg');
                imagejpeg($rotated);
        }
        else
		{
        	imagejpeg($rotated,$guardarnombre);
		}

       
        imagedestroy($rotated);
    }







?>