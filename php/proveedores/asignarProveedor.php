<?php
require_once('../fecha.php');
require_once('../coneccion.php');

if ($_POST['hacer'] == "llenarCombo") {
    $codEmpresa = $_POST['empresa'];
    $pais = "select nompais from cat_empresas inner join direct on codpais=pais where codempresa='" . $codEmpresa . "' ";
    $ejecutarpais = mysqli_query(conexion(""), $pais);
    if ($ejecutarpais) {
        while ($rowpais = mysqli_fetch_array($ejecutarpais, MYSQLI_ASSOC)) {
            echo proveedores($codEmpresa, $rowpais['nompais']);
        }
    }
}


function proveedores($codEmpresa, $pais)
{

    $squery = "select codprov,nombre from cat_prov where codempresa='" . $codEmpresa . "'";
    $res = "<option value=\"\" selected></option>";
    $ejecutar = mysqli_query(conexion($pais), $squery);
    if ($ejecutar) {
        $contador = 0;
        while ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
            $res = $res . "<option value=\"" . $row['codprov'] . "\">" . $row['nombre'] . "</option>";

        }
    } else {
        $res = $squery;
    }

    return $res;
}
?>