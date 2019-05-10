<?php
session_start();
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
$method = $_POST["method"];
switch ($method){
    case "agregarIngrediente":
        $descripcion = $_POST["descripcion"];
        $cantidad = $_POST["cantidad"];
        $producto = $_POST["producto"];
        $pais = $_POST["pais"];
        $codEmpresa = $_POST["codEmpresa"];
        echo agregarIngrediente($descripcion, $cantidad, $producto, $pais);
        break;
    case "editarIngrediente":
        $id = $_POST["id"];
        $cantidad = $_POST["cantidad"];
        $descripcion = $_POST["descripcion"];
        echo editarIngrediente($id, $cantidad, $descripcion);
        break;
    case "eliminarIngrediente":
        $id = $_POST["id"];
        echo eliminarIngrediente($id);
        break;
}

function agregarIngrediente($descripcion, $cantidad, $producto, $pais){
    $getProd = "
        SELECT 
            CODPROD
        FROM
            cat_prod
        WHERE
            MASTERSKU = '$producto';";
    $CODINGRE = sys2015();
    $CODPROD = getSingleValue($getProd, $pais);
    $DESCRIP = $descripcion;
    $CANTIDAD = $cantidad;
    $ingredienteQuery = "
        INSERT INTO tra_prod_ingredientes (CODINGRE, CODPROD, DESCRIP, CANTIDAD) VALUES ('$CODINGRE', '$CODPROD', '$DESCRIP', '$CANTIDAD');
    ";
    $result = mysqli_query(conexion($pais), $ingredienteQuery);
    if($result){
        return "S";
    }
    else{
        return "E";
    }
}

function editarIngrediente($id, $cantidad, $descripcion){
    $q = "UPDATE tra_prod_ingredientes SET DESCRIP = '$descripcion', CANTIDAD = '$cantidad' WHERE CODINGRE = '$id'";
    mysqli_query(conexion($_SESSION["pais"]), $q);
    return $q;
}
function eliminarIngrediente($id){
    $q = "DELETE FROM tra_prod_ingredientes WHERE CODINGRE = '$id'";
    mysqli_query(conexion($_SESSION["pais"]), $q);
    return $q;
}