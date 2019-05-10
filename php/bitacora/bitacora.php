<?php
class bitacora{

    //connections
    const regularConnection = 'regularConnection';
    const localConnection = 'localConnection';

    //modules
    const moduleDespachos = 'Despachos';

    //tables
    const tableDespachosEncabezado = 'tra_des_enc';

    public function __construct(){
        session_start();
        include_once($_SERVER['DOCUMENT_ROOT'] . '/php/fecha.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/php/coneccion.php');
    }

    public function newEntry($reference, $changes, $module, $table, $connectionType = self::regularConnection){
        $insertEntry = "
            INSERT INTO bitacora 
            (CODBITA,
            CODIGO,
            USUARIO,
            CAMBIOS,
            MODULO,
            TABLA,
            FECHAHORA) 
            VALUES 
            ('".sys2015()."',
            '$reference',
            '".$_SESSION['codigo']."',
            '$changes',
            '$module',
            '$table',
            '".date('Y-m-d G:i:s')."')";
        $insertEntryResult = mysqli_query($this->getConnection($connectionType), $insertEntry);
        if($insertEntryResult){
            if($insertEntryResult->num_rows > 0){
                return 1;
            }
        }
        return 0;
    }

    private function getConnection($connectionType){
        switch ($connectionType){
            case self::regularConnection:
                return conexion($_SESSION['pais']);
            case self::localConnection:
                return conexionProveedorLocal($_SESSION['pais']);
            default:
                return conexion($_SESSION['pais']);
        }
    }
}