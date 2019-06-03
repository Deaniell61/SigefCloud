<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
session_start();
    $fecha = date('Y-m-d');
    $controller = $_REQUEST['controller'];

    switch ($controller) {
        case 'orden/detalle':{
            $data = (object) array(
                "codorden" => $_GET['codorden'],
                "orderId" => $_GET['orderId'],
                "pais" => $_GET['pais'], 
                "codpais" => $_GET['codpais']
            );
            echo json_encode(orderDetalle($data)) ;
            break;
        }
        default:{
            # code...
            break;
        }
    }

    function orderDetalle($data){
        $orderIdsQ = "
            SELECT 
                *
            FROM
                tra_ord_det
            WHERE
                codorden = '".$data->codorden."';
            ";

        //echo "$orderIdsQ<br>";
        $orderIdsResult = mysqli_query(conexion($_SESSION["pais"]), $orderIdsQ);
        return mysqli_fetch_assoc($orderIdsResult);
    }
?>