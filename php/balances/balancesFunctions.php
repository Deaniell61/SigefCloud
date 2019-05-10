<?php

class balancesFunctions {

    private $balances = null;
    private $cargos = null;

    function __construct() {
        session_start();
        $this->getBalances();
        $this->getCargos();
    }

    private function getBalances() {


        include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $balancesQuery = "
            SELECT 
                *
            FROM
                cat_bal_cobro;
        ";

        $balancesResult = mysqli_query(conexion(""), $balancesQuery);

        while ($balancesRow = mysqli_fetch_array($balancesResult)) {
            $this->balances[$balancesRow["CODBALANCE"]] = $balancesRow;
        }
    }

    private function getCargos() {

        include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

        $cargosQuery = "
            SELECT 
                *
            FROM
                cat_car_proyecto;
        ";

        $cargosResult = mysqli_query(conexion(""), $cargosQuery);

        while ($cargosRow = mysqli_fetch_array($cargosResult)) {
            $this->cargos[$cargosRow["CODCARGO"]] = $cargosRow;
        }
    }

    public function getB1(){

        $codrov = $_SESSION["codprov"];

        $b1Query = "
            SELECT 
                *
            FROM
                tra_balances
            WHERE
                CODPROV = '$codrov';
        ";

        $b1Result = mysqli_query(conexion($_SESSION["pais"]), $b1Query);
    }
}