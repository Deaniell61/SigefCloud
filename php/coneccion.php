<?php
if (!defined("DB_HOST")){
    define ("DB_HOST", "3RNpvB5rIyGCK8BIAwW9YSehyM3tapZCIL7sL0Kp5XU=");
}
if (!defined("DB_USER")){
    define ("DB_USER", 'qpUMN73uNTme5IAZAMcXhDuFk5Mk52pgfUQ7M2Ehbf0=');
}
if (!defined("DB_PASSWORD")){
    define ("DB_PASSWORD", 'UzQ2rrm//jeWLvZ0z6IHzE0NQ2TPaOMrhnGfiK578yc=');
}
if (!defined("DB_DATABASE")){
    define ("DB_DATABASE", 'x3jOjWfFF5NWAp59ICEgLrwmOa72PeWq8FtYbpJq5Xc=');
}

function conexion($pais) {
    if(!isset($_SESSION)){
        session_start();
    }
    include_once($_SERVER['DOCUMENT_ROOT'] . '/encrypt/encrypt.php');
    $encrypt = new encrypt();
    if ($pais == "") {
        $con = mysqli_connect($encrypt->decrypt(DB_HOST), $encrypt->decrypt(DB_USER), $encrypt->decrypt(DB_PASSWORD), $encrypt->decrypt(DB_DATABASE));
    } else {
        if (!isset($_SESSION[$pais . 'db'])) {
            $query = "SELECT lpad(emp.CODIGO, '2', '0') as codigo FROM cat_empresas as emp INNER JOIN direct as dir ON emp.pais = dir.codPais WHERE dir.nomPais = '$pais';";
            $result = mysqli_query(conexion(''), $query);
            if ($result) {
                if ($result->num_rows > 0) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $_SESSION[$pais . 'db'] = $encrypt->decrypt(DB_DATABASE) . $row['codigo'];
                }
            }
        }
        $con = mysqli_connect($encrypt->decrypt(DB_HOST), $encrypt->decrypt(DB_USER), $encrypt->decrypt(DB_PASSWORD), $_SESSION[$pais . 'db']);
        mysqli_set_charset($con,"utf8");
    }
    return $con;
}

    function conexionProveedorLocal($pais) {
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/encrypt/encrypt.php');
    include_once('/home/quintoso/etc/sigefcloud.com/encrypt/encrypt.php');
    include_once('/home/quintoso/etc/sigefcloud.com/config.php');
    $encrypt = new encrypt();
    if (!isset($_SESSION[$pais . 'dbpl'])) {
        $query = "SELECT prov.basedatos FROM cat_prov_local as prov INNER JOIN direct as dir ON prov.codproloc = dir.codproloc WHERE dir.nomPais = '$pais';";
        $result = mysqli_query(conexion(''), $query);
        if ($result) {
            if ($result->num_rows > 0) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $_SESSION[$pais . 'dbpl'] = 'quintoso_' . $row['basedatos'];
            }
        }
        }
    $con = mysqli_connect($encrypt->decrypt(DB_HOST), $encrypt->decrypt(DB_USER), $encrypt->decrypt(DB_PASSWORD), $_SESSION[$pais . 'dbpl']);
    return $con;
}

function obtenerDatos($pais) {
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/encrypt/encrypt.php');
    include_once('/home/quintoso/etc/sigefcloud.com/encrypt/encrypt.php');
    include_once('/home/quintoso/etc/sigefcloud.com/config.php');
    $encrypt = new encrypt();
    $datos[0] = $encrypt->decrypt(DB_HOST);
    $datos[1] = $encrypt->decrypt(DB_USER);
    $datos[2] = $encrypt->decrypt(DB_PASSWORD);
    return $datos;
}

function idiomaC() {
    $idioma = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
    switch ($idioma) {
        case 'en':
            return 'en';
            break;
        default:
            return 'es';
            break;
    }
}

function getSingleValue($query, $connectionType = "") {
    $response = "";
    $result = mysqli_query(conexion($connectionType), $query);
    if ($result) {
        if ($result->num_rows > 0) {
            $response = mysqli_fetch_array($result)[0];
        }
    }
    return $response;
}

function rconexion() {
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/encrypt/encrypt.php');
    include_once('/home/quintoso/etc/sigefcloud.com/encrypt/encrypt.php');
    include_once('/home/quintoso/etc/sigefcloud.com/config.php');
    $encrypt = new encrypt();
    $con = mysqli_connect($encrypt->decrypt(DB_HOST), $encrypt->decrypt(DB_USER), $encrypt->decrypt(DB_PASSWORD), "quintoso_rsigef");
    return $con;
}


function rconexion04() {
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/encrypt/encrypt.php');
    include_once('/home/quintoso/etc/sigefcloud.com/encrypt/encrypt.php');
    include_once('/home/quintoso/etc/sigefcloud.com/config.php');
    $encrypt = new encrypt();
    $con = mysqli_connect($encrypt->decrypt(DB_HOST), $encrypt->decrypt(DB_USER), $encrypt->decrypt(DB_PASSWORD), "quintoso_rsigef04");
    return $con;
}

function rconexionLocal($prefix) {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/encrypt/encrypt.php');
    include_once('/home/quintoso/etc/sigefcloud.com/encrypt/encrypt.php');
    include_once('/home/quintoso/etc/sigefcloud.com/config.php');
    $encrypt = new encrypt();
    $con = mysqli_connect($encrypt->decrypt(DB_HOST), $encrypt->decrypt(DB_USER), $encrypt->decrypt(DB_PASSWORD), "quintoso_rsigef" . $prefix);
    return $con;
}

function rconexionProveedorLocal($pais) {
    session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . '/encrypt/encrypt.php');
    include_once('/home/quintoso/etc/sigefcloud.com/encrypt/encrypt.php');
    include_once('/home/quintoso/etc/sigefcloud.com/config.php');
    $encrypt = new encrypt();

    if (!isset($_SESSION[$pais . 'rdbpl'])) {
        $query = "SELECT codproloc FROM direct WHERE nomPais = '$pais';";
        $result = mysqli_query(conexion(''), $query);
        if ($result) {
            if ($result->num_rows > 0) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $queryDB = "SELECT CODIGO FROM cat_empresas WHERE CODEMPRESA = (SELECT DESTINO FROM cat_empresas WHERE CODEMPRESA = '".$row["codproloc"]."');";
                $resultDB = mysqli_query(rconexion(), $queryDB);
                if($resultDB){
                    if($resultDB->num_rows > 0){
                        $rowDB = mysqli_fetch_array($resultDB);
                        $_SESSION[$pais . 'rdbpl'] = 'quintoso_rsigef' . $rowDB['CODIGO'];
                    }
                }
            }
        }
    }
    $con = mysqli_connect($encrypt->decrypt(DB_HOST), $encrypt->decrypt(DB_USER), $encrypt->decrypt(DB_PASSWORD), $_SESSION[$pais . 'rdbpl']);
    return $con;
}