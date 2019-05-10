<?php


$res = calcDim(5, 4, 2.5);
var_dump($res);

function calcDim($qty, $ancho, $profun){
    $cont = 1;
    do{
        $cont ++;
        $sqr = $cont * $cont;
    }while($qty > $sqr);

    $row = ceil($qty / $cont);

    $ancho = $ancho * $cont;
    $profun = $profun * $row;

    return [$ancho, $profun];
}