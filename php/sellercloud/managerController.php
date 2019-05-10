<?php
if (isset($_POST["method"])) {
    $method = $_POST["method"];
    $managerController = new managerController();
    switch ($method) {
        case "getModuleFields":
            $module = $_POST["module"];
            $webservice = $_POST["webservice"];
            $managerController->getModuleFields($module, $webservice);
            break;
        case "deleteField":
            $id = $_POST["id"];
            $managerController->deleteField($id);
            break;
        case "getField":
            $id = $_POST["id"];
            $managerController->getField($id);
            break;
        case "saveField":
            $id = $_POST["id"];
            $orden = $_POST["orden"];
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            $modulo = $_POST["modulo"];
            $valor = $_POST["valor"];
            $webservice = $_POST["webservice"];
            $managerController->saveField($id, $orden, $nombre, $descripcion, $modulo, $valor, $webservice);
            break;
        case "changeModuleFields":
            $webservice = $_POST["webservice"];
            $managerController->changeModuleFields($webservice);
            break;
        default:
            break;
    }
}

class managerController {
    public function getWebservices() {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        $query = "SELECT WEBSERVICE FROM cat_campos_sellercloud GROUP BY WEBSERVICE;";
        $result = mysqli_query(conexion(""), $query);
        $response = [];
        while ($row = mysqli_fetch_array($result)) {
            $response[$row[0]] = $row[0];
        }
        return $response;
    }

    public function getModuleFields($module, $webservice) {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        $query = "SELECT * FROM cat_campos_sellercloud WHERE MODULO = '$module' AND WEBSERVICE = '$webservice' ORDER BY ORDEN";
        $result = mysqli_query(conexion(""), $query);
        $response = [];
        while ($row = mysqli_fetch_array($result)) {
            $response[] = [
                "CODCAMPO" => $row[0],
                "ORDEN" => $row[1],
                "NOMBRE" => $row[2],
                "DESCRIP" => $row[3],
                "MODULO" => $row[4],
                "VALOR" => $row[5],
            ];
        }
        echo json_encode($response);
    }

    public function deleteField($id) {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        $query = "DELETE FROM cat_campos_sellercloud WHERE CODCAMPO = '$id';";
        mysqli_query(conexion(""), $query);
    }

    public function getField($id) {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        $query = "SELECT * FROM cat_campos_sellercloud WHERE CODCAMPO = '$id';";
        $result = mysqli_query(conexion(""), $query);
        $response = [];
        $row = mysqli_fetch_array($result);
        $response[] = [
            "CODCAMPO" => $row[0],
            "ORDEN" => $row[1],
            "NOMBRE" => $row[2],
            "DESCRIP" => $row[3],
            "MODULO" => $row[4],
            "VALOR" => $row[5],
            "WEBSERVICE" => $row[6],
        ];
        echo json_encode($response);
    }

    public function saveField($id, $orden, $nombre, $descripcion, $modulo, $valor, $webservice) {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
        if ($id == "") {
            $id = sys2015();
        }
        $query = "INSERT INTO cat_campos_sellercloud (CODCAMPO, ORDEN, NOMBRE, DESCRIP, MODULO, VALOR, WEBSERVICE) VALUES ('$id','$orden','$nombre','$descripcion','$modulo','$valor','$webservice') ON DUPLICATE KEY UPDATE CODCAMPO='$id', ORDEN='$orden', NOMBRE='$nombre', DESCRIP='$descripcion', MODULO='$modulo', VALOR='$valor', WEBSERVICE='$webservice';";
        mysqli_query(conexion(""), $query);
    }

    public function changeModuleFields($webservice) {
        $modules = $this->getModules($webservice);
        $response = "";
        foreach ($modules as $module) {
            $response = $response . "<option value='$module'>$module</option>";
        }
        echo $response;
    }

    public function getModules($webservice) {
        include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
        $query = "SELECT MODULO FROM cat_campos_sellercloud WHERE WEBSERVICE = '$webservice' GROUP BY MODULO;";
        $result = mysqli_query(conexion(""), $query);
        $response = [];
        while ($row = mysqli_fetch_array($result)) {
            $response[$row[0]] = $row[0];
        }
        return $response;
    }
}