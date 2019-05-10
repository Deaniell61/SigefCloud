<?php
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
    if(isset($_POST["method"])){
        $method = $_POST["method"];
        switch ($method){
            case "updateInventory":
                $mastersku = $_POST["mastersku"];
                $q1 = $_POST["q1"];
                $q2 = $_POST["q2"];
                echo updateInventory($mastersku, $q1, $q2);
                break;

            case "updateTraExi":
                $id = $_POST["id"];
                $value = $_POST["value"];
                echo updateTraExi($id, $value);
                break;

            case "deleteBod":
                $id = $_POST["id"];
                echo deleteBod($id);
                break;
            default:
                echo "unknown mehtod";
                break;
        }
    }

    function updateInventory($mastersku, $qt1, $qt2){
        $q1 = "select codprod from cat_prod where MASTERSKU = '$mastersku';";
        $q1Res = mysqli_query(conexion($_SESSION["pais"]), $q1);
        $codprod = mysqli_fetch_array($q1Res)["codprod"];
        $q2 = "update sageinventario set PHYSICALIN = '$qt2', actualiza = '1' WHERE productid = '$mastersku';";
//        $q3 = "update tra_exi_pro set existencia = '$qt1' WHERE CODPROD = '$codprod';";
        mysqli_query(conexion($_SESSION["pais"]), $q2);
//        mysqli_query(conexion($_SESSION["pais"]), $q3);
        return "";
    }

    function updateTraExi($id, $value){
        $_SESSION["updateTraExi"] = 1;
        $q3 = "update tra_exi_pro set existencia = '$value' WHERE CODEPROD = '$id';";
        mysqli_query(conexion($_SESSION["pais"]), $q3);
        return $q3;
    }

    function deleteBod($id){
        $query = "delete from tra_exi_pro where codeprod = '$id';";
        mysqli_query(conexion($_SESSION["pais"]), $query);
        return $query;
    }