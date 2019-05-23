<?php
    class products{

        public function getProduct($mMasterSKU, $mProvider = '-1'){
            session_start();
            include_once ($_SERVER['DOCUMENT_ROOT'] . '/php/coneccion.php');
            $tProvider = '';
            if($mProvider != '-1'){
                $tProvider = " AND CODPROV = '$mProvider'";
            }
            $query = "SELECT * FROM cat_prod INNER JOIN tra_bun_det ON cat_prod.MASTERSKU = tra_bun_det.MASTERSKU WHERE cat_prod.MASTERSKU = '$mMasterSKU' AND tra_bun_det.UNITBUNDLE = '1' " . $tProvider;
//            echo $query;
            $result = mysqli_query(conexion($_SESSION['pais']), $query);
            $response = 0;
            if($result){
                if($result->num_rows > 0){
                    $response = mysqli_fetch_array($result);
                }
                else{
                    $query1 = "SELECT * FROM tra_bun_det INNER JOIN cat_prod ON cat_prod.MASTERSKU = tra_bun_det.MASTERSKU WHERE AMAZONSKU = '$mMasterSKU'" . $tProvider;
                    $result1 = mysqli_query(conexion($_SESSION['pais']), $query1);
                    if($result1) {
                        if ($result1->num_rows > 0) {
                            $response = mysqli_fetch_array($result1);
                        }
                    }
                }
            }
            return $response;
        }

        public function updateProduct($data, $filter){
            $query = "UPDATE cat_prod SET ";
            foreach ($data as $key => $value){
                $query = $query . "$key='$value',";
            }
            $query = rtrim($query, ",");
            $query = $query . " WHERE ".key($filter)."='".reset($filter)."';";
            //echo $query;
            //$result = mysqli_query(conexion($_SESSION['pais']), $query);

        }

        public function getPriceByDistribution($mMasterSKU, $Quantity){
            session_start();
            include_once ($_SERVER['DOCUMENT_ROOT'] . '/php/coneccion.php');
            $query = "SELECT precio FROM tra_pre_dis WHERE ('$Quantity' BETWEEN de AND a) AND codprod = (SELECT CODPROD FROM cat_prod WHERE MASTERSKU = '$mMasterSKU');";
            $result = mysqli_query(conexion($_SESSION['pais']), $query);
            $response = 0;
            if($result){
                if($result->num_rows > 0){
                    $response = mysqli_fetch_array($result)[0];
                }
            }
            return $response;
        }

        public function setPVenta($mMasterSKU, $mPrice){
            session_start();
            include_once ($_SERVER['DOCUMENT_ROOT'] . '/php/coneccion.php');
            $query = "
                UPDATE cat_prod 
                SET 
                    PVENTA = '$mPrice'
                WHERE
                    MASTERSKU = '$mMasterSKU';
            ";

            $result = mysqli_query(conexion($_SESSION['pais']), $query);
            $response = 0;
            if($result){
                if($result->num_rows > 0){
                    $response = mysqli_fetch_array($result)[0];
                }
            }
            return $query;
        }

        public function searchProduct($term){
            session_start();
            include_once ($_SERVER['DOCUMENT_ROOT'] . '/php/coneccion.php');
            $query = "
                SELECT CONCAT(MASTERSKU, ' - ', PRODNAME) as NAME  FROM cat_prod WHERE MASTERSKU LIKE '%$term%' OR PRODNAME LIKE '%$term%'
                UNION
                SELECT CONCAT(AMAZONSKU, ' - ', PRODNAME) FROM tra_bun_det WHERE AMAZONSKU LIKE '%$term%';
            ";

//            echo $query;

            $result = mysqli_query(conexion($_SESSION["pais"]), $query);

            while ($row = mysqli_fetch_array($result)) {
                $data[] = $row["NAME"];
            }

            return ($data);
        }
    }