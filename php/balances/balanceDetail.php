<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
$idioma = idioma();
include('../../php/idiomas/' . $idioma . '.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/balances/balancesFunctions.php");
$balanceFunctions = new balancesFunctions();
function getListDrop() {

    $balancesQuery = "
        SELECT 
            codbalance, inicia, termina, estatus
        FROM
            cat_bal_cobro;
    ";

    $balancesResult = mysqli_query(conexion(""), $balancesQuery);
//    var_dump($balancesResult);
//    echo "<br><br>";
    while ($balancesRow = mysqli_fetch_array($balancesResult)) {
        $tIni = date_format(date_create(explode(" ", $balancesRow["inicia"])[0]), "M d, Y");
        $tFin = date_format(date_create(explode(" ", $balancesRow["termina"])[0]), "M d, Y");
        $tEstatus = ($balancesRow["estatus"] == 1) ? "" : "(Abierto)";
        $balances[$balancesRow["codbalance"]] = "$tIni - $tFin $tEstatus";
    }

    $codProv = $_SESSION["codprov"];
    $listQuery = "
        SELECT 
            *
        FROM
            tra_balances
        WHERE
            CODPROV = '$codProv'
        ORDER BY CODIGOBAL DESC;
    ";

    $listResult = mysqli_query(conexion($_SESSION["pais"]), $listQuery);

    $table = "<select id='balanceDropD'>";

    $balCont = 1;
    while ($listRow = mysqli_fetch_array($listResult)) {
        if ($balances[$listRow["CODBALANCE"]] != "") {
            $codigo = $listRow["CODBALANCE"];
            $name = str_pad($balCont, 2, "0", STR_PAD_LEFT) . ". " . $balances[$listRow["CODBALANCE"]];
            $table .= "
            <option value='$codigo'>$name</option>
        ";
            $balCont += 1;
        }
    }

    $table .= "</select>";

    return $table;
}

function getOrdenes() {

    //ordenes
    $codProv = $_SESSION["codprov"];
    $oQuery = "
                    SELECT 
                        *
                    FROM
                        tra_ord_enc
                    WHERE
                        CODBALCOM IN (SELECT 
                                CODBALCOM
                            FROM
                                tra_balances
                            WHERE
                                CODBALANCE = '$balanceId'
                                    AND CODPROV = '$codProv')
                ";
    echo $oQuery;
    $oResult = mysqli_query(conexion($_SESSION["pais"]), $oQuery);
    while ($oRow = mysqli_fetch_array($oResult)) {
//                    $oResponse[] = $oRow;
        $tOrderId = $oRow["ORDERID"];
        $tCanal = $oRow["ORDERID"];
        $tFecha = $oRow["ORDERID"];
        $tEstado = $oRow["ORDERID"];
        $tUnidades = $oRow["ORDERID"];
        $tSubtotal = $oRow["ORDERID"];
        $tShipping = $oRow["ORDERID"];
        $tTotal = $oRow["ORDERID"];
        $tCargosCanal = $oRow["ORDERID"];
        $tCargosShipping = $oRow["ORDERID"];
        $tNeto = $oRow["ORDERID"];
        echo "
                        <tr>
                        <td>$tOrderId</td>
                        <td>$tCanal</td>
                        <td>$tFecha</td>
                        <td>$tEstado</td>
                        <td>$tUnidades</td>
                        <td>$tSubtotal</td>
                        <td>$tShipping</td>
                        <td>$tTotal</td>
                        <td>$tCargosCanal</td>
                        <td>$tCargosShipping</td>
                        <td>$tNeto</td>
                        </tr>
                    ";
    }
}

?>
<div id="container">
    <div id="select">
        <?php
        echo getListDrop();
        ?>
    </div>
    <div>
        <input id="generateReportButton" type="button" class="cmd button button-highlight button-pill" value="Descargar">
    </div>
    <div id="detail">
        <br>
        <br>
        <b>Ordenes</b>
        <div id="ordenesDiv">
        </div>
        <br>
        <br>
        <b>Cargos de Canal</b>
        <div id="cargosCanalDiv">
        </div>
        <br>
        <br>
        <b>Shipping</b>
        <div id="shippingDiv">
        </div>
        <br>
        <br>
        <b>Otros Cargos</b>
        <div id="otrosCargosDiv">
        </div>
    </div>
</div>
<script>
    $("#generateReportButton").click(function () {
        var docid = $("#balanceDropD").val();
        window.open("../php/balances/balancePDF.php?method=getPDF&DOCID=" + docid);
    });

    $("#balanceDropD").change(function () {
        getBalanceDetail(this.value);
    });

    function getBalanceDetail(balanceId) {
        getOrdenesDetail(balanceId);
        getCargosCanalDetail(balanceId);
        getShippingDetail(balanceId);
        getOtrosCargosDetail(balanceId);
    }

    function getOrdenesDetail(balanceId){
        $.ajax({
            url: "../php/balances/balanceOperations.php",
            type: "POST",
            data: {
                method: "getOrdenesDetail",
                balanceId: balanceId,
            },
            success: function (response) {
                $("#ordenesDiv").html(response);
            }
        });
    }

    function getCargosCanalDetail(balanceId){
        $.ajax({
            url: "../php/balances/balanceOperations.php",
            type: "POST",
            data: {
                method: "getCargosCanalDetail",
                balanceId: balanceId,
            },
            success: function (response) {
                $("#cargosCanalDiv").html(response);
            }
        });
    }

    function getShippingDetail(balanceId){
        $.ajax({
            url: "../php/balances/balanceOperations.php",
            type: "POST",
            data: {
                method: "getShippingDetail",
                balanceId: balanceId,
            },
            success: function (response) {
                $("#shippingDiv").html(response);
            }
        });
    }

    function getOtrosCargosDetail(balanceId){
        $.ajax({
            url: "../php/balances/balanceOperations.php",
            type: "POST",
            data: {
                method: "getOtrosCargosDetail",
                balanceId: balanceId,
            },
            success: function (response) {
                $("#otrosCargosDiv").html(response);
            }
        });
    }
</script>