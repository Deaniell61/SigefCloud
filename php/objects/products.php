<?php
    class products{

        public function getProduct($mMasterSKU, $mProvider = '-1'){
            session_start();
            include_once ($_SERVER['DOCUMENT_ROOT'] . '/php/coneccion.php');
            $tProvider = '';
            if($mProvider != '-1'){
                $tProvider = " AND CODPROV = '$mProvider'";
            }
            $query = "SELECT * FROM cat_prod WHERE MASTERSKU = '$mMasterSKU'" . $tProvider;
            $result = mysqli_query(conexion($_SESSION['pais']), $query);
            $response = 0;
            if($result){
                if($result->num_rows > 0){
                    $response = mysqli_fetch_array($result);
                }
            }
            return $response;
        }
    }