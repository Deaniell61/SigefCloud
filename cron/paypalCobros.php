<?php
echo "paypal charges<br>";

session_start();
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/paypal/obj/paypalfunctions.php");

$provs;

$getCountriesQuery = "
    SELECT 
        dir.nomPais, dir.CODIGO
    FROM
        direct AS dir
            INNER JOIN
        cat_empresas AS emp ON dir.codPais = emp.pais
    WHERE
        emp.companyid != '0'
        AND emp.companyid != '163';
";

$getCountriesResult = mysqli_query(conexion(""), $getCountriesQuery);

while ($getCountriesRow = mysqli_fetch_array($getCountriesResult)) {

    $tPais = $getCountriesRow[0];
    $monedaQuery = "
        SELECT 
            mone.CODMONE
        FROM
            direct AS dir
                INNER JOIN
            cat_empresas AS emp ON dir.codPais = emp.pais
                INNER JOIN
            cat_mone AS mone ON mone.codmone = emp.moneda
        WHERE
            nomPais = '$tPais';
    ";

    $monedaResult = mysqli_query(conexion(""), $monedaQuery);
    $moneda = mysqli_fetch_array($monedaResult)[0];

    $provsQuery = "
        SELECT 
            CODPROV, NOMBRE, PAYPALID, CODEMPRESA
        FROM
            cat_prov;
    ";

    $provsResult = mysqli_query(conexion($getCountriesRow[0]), $provsQuery);

    while ($provsRow = mysqli_fetch_array($provsResult)){
        $provs[$provsRow[0]] = [
            "NOMBRE" => $provsRow[1],
            "PAYPALID" => $provsRow[2],
            "CODPROV" => $provsRow[0],
            "CODEMPRESA" => $provsRow[3]
        ];
    }

    $getSaldoQuery = "
        SELECT
            CODFACT, CODCLIE, (TOTAL - ABONOS) as SALDO
        FROM
            tra_fact_enc
        WHERE
            (TOTAL - ABONOS) > 0
        ORDER BY codclie;
    ";

    $numFacQuery = "
        select numero from tra_fact_enc where serie = 'PPC' order by numero desc limit 1;
    ";

    $tNumFac;
    $numFacResult = mysqli_query(conexion($getCountriesRow[0]), $numFacQuery);
    if($numFacResult->num_rows > 0){
        $tNumFac = mysqli_fetch_array($numFacResult)[0];
    }

    else{
        $tNumFac = $getCountriesRow[1] . "0000001";
    }

    $getSaldoResult = mysqli_query(conexion($getCountriesRow[0]), $getSaldoQuery);

    $lastCodClie = "";
    $lastCodreca = "";

    while ($getSaldosRow = mysqli_fetch_array($getSaldoResult)){
        $tSaldo = $getSaldosRow[2];
        $tSaldo = round($tSaldo, 2);
        $tCodClie = $getSaldosRow[1];
        $tNombre = $provs[$tCodClie]["NOMBRE"];
        $tPayPalID = $provs[$tCodClie]["PAYPALID"];
        $tFactID = $getSaldosRow[0];
        $CODEMPRESA = $provs[$tCodClie]["CODEMPRESA"];

        if(floatval($tSaldo) > 0.00){
            echo "<br><br>*****NEW ENTRY*****<br>NOMBRE:$tNombre - SALDO:$tSaldo - PAYPALID:$tPayPalID<br>";
            $_SESSION["billing_agreemenet_id"] = 'B-3N311063VU5367716';
//            $_SESSION["billing_agreemenet_id"] = $tPayPalID;
            $response = DoReferenceTransaction($tSaldo, "USD");
            $ACK = $response["ACK"];
            echo "PP:$ACK<br>";
            if($response["ACK"] == "Success"){

                $abonoActualQuery = "
                    SELECT 
                        ABONOS
                    FROM
                        tra_fact_enc
                    WHERE
                        CODFACT = '$tFactID';
                ";

                $abonoActualResult = mysqli_query(conexion($getCountriesRow[0]), $abonoActualQuery);
                $abonoActual = mysqli_fetch_array($abonoActualResult)[0];

                $nSaldo = ($abonoActual + $tSaldo);

                $updateFactQuery = "
                    UPDATE
                        tra_fact_enc
                    SET
                        ABONOS = '$nSaldo'
                    WHERE
                        CODFACT = '$tFactID'";

                echo "<br>current code:$tCodClie - last code:$lastCodClie<br>";

                if($lastCodClie == "" || $tCodClie != $lastCodClie){

                    $CODRECA = sys2015();
                    $ABONO = $tSaldo;
                    $SERIE = "PPC";
                    $NUMERO = $tNumFac;
                    $FECHA = date("Y-m-d h:i:s");
                    $CODCOBRA = "PAYPAL";
                    $MONEDA = $moneda;
                    $CODCLIE = $tCodClie;
                    $TASACAMBIO = "1.00000";
                    $TOTAL_D = $tSaldo;
                    $TOTAL_Q = $tSaldo;

                    echo "new enc<br><br>";
                    $lastCodClie = $tCodClie;
                    $lastCodreca = $CODRECA;

                    $insertRecordQuery = "
                        INSERT INTO
                            tra_rec_enc (
                                CODRECA,
                                CODEMPRESA
                                ABONO,
                                SERIE,
                                NUMERO,
                                FECHA,
                                CODCOBRA,
                                MONEDA,
                                CODCLIE,
                                TASACAMBIO,
                                TOTAL_D,
                                TOTAL_Q)
                        VALUES (
                            '$CODRECA',
                            '$CODEMPRESA',
                            '$ABONO',
                            '$SERIE',
                            '$NUMERO',
                            '$FECHA',
                            '$CODCOBRA',
                            '$MONEDA',
                            '$CODCLIE',
                            '$TASACAMBIO',
                            '$TOTAL_D',
                            '$TOTAL_Q'
                        );
                    ";

//                    mysqli_query(conexion($getCountriesRow[0]), $insertRecordQuery);
                    echo "tra_rec_enc:<br>$insertRecordQuery<br>";
                }

                else{
                    $getEncQuery = "SELECT ABONO FROM tra_rec_enc WHERE CODRECA = '$lastCodreca';";
//                    echo "<br>$getEncQuery<br>";
                    $getEncResult = mysqli_query(conexion($getCountriesRow[0]), $getEncQuery);
                    $tAbono = mysqli_fetch_array($getEncResult)[0] + $tSaldo;
                    $updateEncQuery = "UPDATE tra_rec_enc SET ABONO = '$tAbono', TOTAL_D = '$tAbono', TOTAL_Q = '$tAbono' WHERE CODRECA = '$lastCodreca'";
                    echo "tra_rec_enc UPDATE:<br>$updateEncQuery<br>";
                }

                $tNumFac += 1;

                $CODDRECA = sys2015();
                $CODFACT = $tFactID;
                $VALFACT = $tSaldo;
                $DESCUENTO = "0.00000";
                $VALCOBRAR = $tSaldo;
                $NUMCHEQUE = $response["TRANSACTIONID"];
                $CODBANC = "PAYPAL";
                $VALCOBRADO = $tSaldo;
                $FECCHEQUE = $FECHA;
                $NUMDEPO = $response["TRANSACTIONID"];

                $insertRecordDQuery = "
                    INSERT INTO
                        tra_rec_det (
                            CODDRECA,
                            CODRECA,
                            CODFACT,
                            VALFACT,
                            DESCUENTO,
                            VALCOBRAR,
                            NUMCHEQUE,
                            CODBANC,
                            TASACAMBIO,
                            VALCOBRADO,
                            FECCHEQUE,
                            NUMDEPO
                            )
                    VALUES (
                        '$CODDRECA',
                        '$CODRECA',
                        '$CODFACT',
                        '$VALFACT',
                        '$DESCUENTO',
                        '$VALCOBRAR',
                        '$NUMCHEQUE',
                        '$CODBANC',
                        '$TASACAMBIO',
                        '$VALCOBRADO',
                        '$FECCHEQUE',
                        '$NUMDEPO'
                    );
                ";

//                mysqli_query(conexion($getCountriesRow[0]), $updateFactQuery);
//                mysqli_query(conexion($getCountriesRow[0]), $insertRecordDQuery);
                echo "tra_fact_enc:<br>$updateFactQuery<br>";
                echo "tra_rec_det:<br>$insertRecordDQuery<br>";
            }
            else{
                var_dump($response);
            }
        }
    }


    echo "<br><br>rsigef04:<br><br>";

    $lastCodClie = "";
    $lastCodreca = "";

    foreach ($provs as $prov){
        $tCodClie = $prov["CODPROV"];
        $getSaldoQuery = "
            SELECT
                CODFACT, CODCLIE, (TOTAL - ABONOS) as SALDO
            FROM
                tra_fact_enc
            WHERE
              CODCLIE = '$tCodClie';
        ";

//        echo "$getSaldoQuery<br>";

        $numFacQuery = "
            select numero from tra_fact_enc where serie = 'PPC' order by numero desc limit 1;
        ";

        $tNumFac;
        $numFacResult = mysqli_query(conexion($getCountriesRow[0]), $numFacQuery);
        if($numFacResult->num_rows > 0){
            $tNumFac = mysqli_fetch_array($numFacResult)[0];
        }

        else{
            $tNumFac = "9990000001";
        }

        $getSaldoResult = mysqli_query(rconexion04($getCountriesRow[0]), $getSaldoQuery);

        while ($getSaldosRow = mysqli_fetch_array($getSaldoResult)){
            $tSaldo = $getSaldosRow[2];
            $tSaldo = round($tSaldo, 2);
            $tCodClie = $getSaldosRow[1];
            $tNombre = $provs[$tCodClie]["NOMBRE"];
            $tPayPalID = $provs[$tCodClie]["PAYPALID"];
            $tFactID = $getSaldosRow[0];
            $CODEMPRESA = $provs[$tCodClie]["CODEMPRESA"];

            if(floatval($tSaldo) > 0.00){
                echo "<br>*****NEW ENTRY*****<br><br>NOMBRE:$tNombre - SALDO:$tSaldo - PAYPALID:$tPayPalID<br>";
                $_SESSION["billing_agreemenet_id"] = 'B-3N311063VU5367716';
//            $_SESSION["billing_agreemenet_id"] = $tPayPalID;
                //$response = DoReferenceTransaction($tSaldo, "USD");
                $ACK = $response["ACK"];
                $ACK = "Success";
                echo "PP:$ACK<br>";
                if($response["ACK"] == "Success"){

                    $abonoActualQuery = "
                    SELECT 
                        ABONOS
                    FROM
                        tra_fact_enc
                    WHERE
                        CODFACT = '$tFactID';
                ";

                    $abonoActualResult = mysqli_query(conexion($getCountriesRow[0]), $abonoActualQuery);
                    $abonoActual = mysqli_fetch_array($abonoActualResult)[0];

                    $nSaldo = ($abonoActual + $tSaldo);

                    $updateFactQuery = "
                    UPDATE
                        tra_fact_enc
                    SET
                        ABONOS = '$nSaldo'
                    WHERE
                        CODFACT = '$tFactID'";

                    echo "<br>current code:$tCodClie - last code:$lastCodClie<br>";

                    if($lastCodClie == "" || $tCodClie != $lastCodClie){

                        $CODRECA = sys2015();
                        $ABONO = $tSaldo;
                        $SERIE = "PPC";
                        $NUMERO = $tNumFac;
                        $FECHA = date("Y-m-d h:i:s");
                        $CODCOBRA = "PAYPAL";
                        $MONEDA = $moneda;
                        $CODCLIE = $tCodClie;
                        $TASACAMBIO = "1.00000";
                        $TOTAL_D = $tSaldo;
                        $TOTAL_Q = $tSaldo;

                        echo "new enc<br><br>";
                        $lastCodClie = $tCodClie;
                        $lastCodreca = $CODRECA;

                        $insertRecordQuery = "
                            INSERT INTO
                                tra_rec_enc (
                                    CODRECA,
                                    CODEMPRESA,
                                    ABONO,
                                    SERIE,
                                    NUMERO,
                                    FECHA,
                                    CODCOBRA,
                                    MONEDA,
                                    CODCLIE,
                                    TASACAMBIO,
                                    TOTAL_D,
                                    TOTAL_Q)
                            VALUES (
                                '$CODRECA',
                                '$CODEMPRESA',
                                '$ABONO',
                                '$SERIE',
                                '$NUMERO',
                                '$FECHA',
                                '$CODCOBRA',
                                '$MONEDA',
                                '$CODCLIE',
                                '$TASACAMBIO',
                                '$TOTAL_D',
                                '$TOTAL_Q'
                            );
                        ";

//                        mysqli_query(rconexion04($getCountriesRow[0]), $insertRecordQuery);
                        echo "$insertRecordQuery<br>";
                    }
                    else{
                        $getEncQuery = "SELECT ABONO FROM tra_rec_enc WHERE CODRECA = '$lastCodreca';";
//                    echo "<br>$getEncQuery<br>";
                        $getEncResult = mysqli_query(conexion($getCountriesRow[0]), $getEncQuery);
                        $tAbono = mysqli_fetch_array($getEncResult)[0] + $tSaldo;
                        $updateEncQuery = "UPDATE tra_rec_enc SET ABONO = '$tAbono', TOTAL_D = '$tAbono', TOTAL_Q = '$tAbono' WHERE CODRECA = '$lastCodreca'";
                        echo "tra_rec_enc UPDATE:<br>$updateEncQuery<br>";
                    }



                    $tNumFac += 1;

                    $CODDRECA = sys2015();
                    $CODFACT = $tFactID;
                    $VALFACT = $tSaldo;
                    $DESCUENTO = "0.00000";
                    $VALCOBRAR = $tSaldo;
                    $NUMCHEQUE = $response["TRANSACTIONID"];
                    $CODBANC = "";
                    $VALCOBRADO = $tSaldo;
                    $FECCHEQUE = $FECHA;
                    $NUMDEPO = $response["TRANSACTIONID"];

                    $insertRecordDQuery = "
                        INSERT INTO
                            tra_rec_det (
                                CODDRECA,
                                CODRECA,
                                CODFACT,
                                VALFACT,
                                DESCUENTO,
                                VALCOBRAR,
                                NUMCHEQUE,
                                CODBANC,
                                TASACAMBIO,
                                VALCOBRADO,
                                FECCHEQUE,
                                NUMDEPO
                                )
                        VALUES (
                            '$CODDRECA',
                            '$CODRECA',
                            '$CODFACT',
                            '$VALFACT',
                            '$DESCUENTO',
                            '$VALCOBRAR',
                            '$NUMCHEQUE',
                            '$CODBANC',
                            '$TASACAMBIO',
                            '$VALCOBRADO',
                            '$FECCHEQUE',
                            '$NUMDEPO'
                        );
                    ";

//                mysqli_query(rconexion04($getCountriesRow[0]), $updateFactQuery);
//                mysqli_query(rconexion04($getCountriesRow[0]), $insertRecordDQuery);
                    echo "$updateFactQuery<br>";
                    echo "$insertRecordDQuery<br>";
                }
            }
        }
    }

//    $response = DoReferenceTransaction(1, "USD");
//    var_dump($response);
//    echo "<br>" . $response["ACK"] . " - " . $response["TRANSACTIONID"] . "<br>";
//    var_dump($provs);
}
