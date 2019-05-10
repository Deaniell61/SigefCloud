<?php
    session_start();
    include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
    $idioma = idioma();
    include('../idiomas/' . $idioma . '.php');

    if (isset($_POST["method"])) {
        $method = $_POST["method"];
        switch ($method) {
            case "save":
                $tConnectionType = $_POST["connectionType"];
                $tQuery = $_POST["query"];
                $tResult = null;
                $tLastCod = "SELECT codpaysta FROM cat_pay_sta ORDER BY codpaysta DESC LIMIT 1;";
                $tCodResult = null;
                switch ($tConnectionType) {
                    case 1:
                        $tResult = mysqli_query(conexion($_SESSION["pais"]), $tQuery);
                        $tCodResult = mysqli_query(conexion($_SESSION["pais"]), $tLastCod);
                        break;
                    case 2:
                        $tResult = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $tQuery);
                        $tCodResult = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $tLastCod);
                        break;
                    default:
                        $tResult = mysqli_query(conexion($_SESSION[""]), $tQuery);
                        $tCodResult = mysqli_query(conexion($_SESSION[""]), $tLastCod);
                        break;
                }
                echo mysqli_fetch_array($tCodResult)[0];
                break;
            case "load":
                $tConnectionType = $_POST["connectionType"];
                $tQuery = $_POST["query"];
                $tResult = null;
                switch ($tConnectionType) {
                    case 1:
                        $tResult = mysqli_query(conexion($_SESSION["pais"]), $tQuery);
                        break;
                    case 2:
                        $tResult = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $tQuery);
                        break;
                    default:
                        $tResult = mysqli_query(conexion($_SESSION[""]), $tQuery);
                        break;
                }
                echo json_encode(mysqli_fetch_array($tResult));
                break;
            case "refresh":

                $tRecordType = $_POST["recordType"];
                $tSelected = $_POST["selected"];
                $tDropId = $_POST["dropId"];
                //echo $tRecordType . '-' . $tSelected . '-' . $tDropId;
                include_once($_SERVER['DOCUMENT_ROOT'] . '/php/objects/dropdownBuilder/dropdownBuilder.php');
                $tDropdownBuilder = new dropdownBuilder();
                switch ($tRecordType) {
                    case "paymentStatusForm":
                        echo $tDropdownBuilder->build($tDropId, "CODPAYSTA", "NOMBRE", $tSelected, "cat_pay_sta", 0);
                        break;
                }

                break;
            default:
                break;
        }
    }