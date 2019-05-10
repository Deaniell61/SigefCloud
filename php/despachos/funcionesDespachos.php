<?php
if(isset($_POST["method"])){
    $method = $_POST["method"];
    switch($method){
        case "saveTipoProyecto":
            $tipoProyecto = $_POST["tipoProyecto"];
            $diasFacturacion = $_POST["diasFacturacion"];
            $funcion = $_POST["funcion"];
            echo saveTipoProyecto($tipoProyecto, $diasFacturacion, $funcion);
            break;

        case "saveCargoProyecto":
            $codigo = $_POST["codigo"];
            $nombre = $_POST["nombre"];
            $aplica = $_POST["aplica"];
            $formula = $_POST["formula"];
            $estatus = $_POST["estatus"];
            $monto = $_POST["monto"];
            $proyecto = $_POST["proyecto"];
            $precio = $_POST["precio"];
            echo saveCargoProyecto($codigo, $nombre, $aplica, $formula, $estatus, $monto, $proyecto, $precio);
            break;
    }
}

function saveTipoProyecto($tipoProyecto, $diasFacturacion, $funcion){

    include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
    include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");

    $CODTIPROY = sys2015();
    $NOMBRE = $tipoProyecto;
    $PERIFACT = $diasFacturacion;
    $FUNCION = $funcion;
    $BALANCE = date("Y-m-d H:m:s");

    $insertQuery = "
        INSERT INTO cat_tipos_proyecto 
        (CODTIPROY, NOMBRE, PERIFACT, FUNCION, BALANCE)
        VALUES 
        ('$CODTIPROY', '$NOMBRE', '$PERIFACT', '$FUNCION', '$BALANCE');
    ";

//    mysqli_query(conexion(""), $insertQuery);

    return "";
}

function saveCargoProyecto($codigo, $nombre, $aplica, $formula, $estatus, $monto, $proyecto, $precio){

    include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
    include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");

    $CODCARGO = sys2015();
    $CODIGO = $codigo;
    $NOMBRE = $nombre;
    $APLICA = $aplica;
    $FORMULA = $formula;
    $ESTATUS = $estatus;
    $TIPOPROY = $proyecto;
    $MINIMO = $monto;
    $PRECIO = $precio;
    $ORDEN = "0";
    $UBICACION = "";
    $OBSER = "";

    $insertQuery = "
        INSERT INTO cat_car_proyecto 
        (CODCARGO, CODIGO, NOMBRE, APLICA, FORMULA, ESTATUS, TIPOPROY, MINIMO, PRECIO, ORDEN, UBICACION, OBSER)
        VALUES 
        ('$CODCARGO', '$CODIGO', '$NOMBRE', '$APLICA', '$FORMULA', '$ESTATUS', '$TIPOPROY', '$MINIMO', '$PRECIO', '$ORDEN', '$UBICACION', '$OBSER');
    ";

//    mysqli_query(conexion($_SESSION["pais"]), $insertQuery);

    return "";
}