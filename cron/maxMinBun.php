<?php
require_once('../php/coneccion.php');
require_once('../php/fecha.php');

    $periodo=date('Y-m');
    
    $datos=obtenerDatos("");
    /*$datos[0]="localhost";
    $datos[1]="root";
    $datos[2]="1234";
    */
    $pla="";
    $con=conexion("");
    $conP=conexion("Guatemala");
   // echo var_dump($datos);
    $squery="select marmin,marmax,codprov from cat_prov";
    if($ejecuta=$conP->query($squery)){
        while($fila=$ejecuta->fetch_row()){
            if($fila[0]!="0" && $fila[1]!="0"){
                echo $sbundle="update tra_bun_det set maxpri=((1+((".$fila[1]."-".$fila[0].")/100))*sugsalpric), minpri=((1-((".$fila[1]."-".$fila[0].")/100))*sugsalpric)";
                if($conP->query($sbundle)){
                    echo "bundles modificados <br>";
                }else{
                    echo "no se puede modificar";
                }
            }else{
                echo "usa cat_empresa <br>";
            }
        }
    }



?>