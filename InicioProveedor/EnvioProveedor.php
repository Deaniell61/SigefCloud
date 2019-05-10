<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
require_once('../php/coneccion.php');
require_once('../php/fecha.php');
$idioma = idioma();
include('../php/idiomas/' . $idioma . '.php');
$codigo = $_POST['codprov'];
$rol = $_POST['rol'];
session_start();
$_POST['codprov'] = '';
$squery = "select codprov,nombre,nit from cat_prov where codprov='$codigo'";
$ejecutar = mysqli_query(conexion($_SESSION['pais']), $squery);
if ($ejecutar) {
    if ($row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC)) {
        $_SESSION['codprov'] = $row['codprov'];
        $_SESSION['nomProv'] = $row['nombre'];
        $_SESSION['nitProv'] = $row['nit'];
        $_SESSION['rolEmpresa'] = $rol;
    }
}
?>