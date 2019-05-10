<?php
    class buildData{
        function __construct() {

        }

        public function newOrder(){
            include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
            $getQuery = "SELECT * FROM cat_campos_sellercloud;";
            $getResult = mysqli_query(conexion(""), $getQuery);
            if($getResult){
                if($getResult->num_rows > 0){
                    while ($getRow = mysqli_fetch_array($getResult)){
                        echo $getRow["NOMBRE"] . " - " . $getRow["VALOR"] . "<br>";
                    }
                }
            }
        }
    }