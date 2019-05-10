<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
$idioma = idioma();
include('../../php/idiomas/' . $idioma . '.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/balances/balancesFunctions.php");
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
    while($balancesRow = mysqli_fetch_array($balancesResult)){
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

    $table = "<select id='balanceDrop'>";

    $balCont = 1;
    while($listRow = mysqli_fetch_array($listResult)){
        if($balances[$listRow["CODBALANCE"]] != ""){
            $codigo = $listRow["CODBALANCE"];
            $name = str_pad($balCont , 2 , "0" , STR_PAD_LEFT) . ". " . $balances[$listRow["CODBALANCE"]];
            $table .= "
            <option value='$codigo'>$name</option>
        ";
            $balCont += 1;
        }
    }

    $table .= "</select>";

    return $table;
}

?>
<div id="container">
    <div id="select">
        <?php
        echo getListDrop();
        ?>
    </div>
    <br>
    <div id="detail">
        <div id="detailTable">
            <div class="row">
                <div class="mediumCell stackHorizontally bold alignRight">
                    Balance
                </div>
                <div class="mediumCell stackHorizontally">&nbsp;</div>
            </div>
            <div class="row">
                <div class="bold stackHorizontally mediumCell alignRight">
                    Saldo Inicial:
                </div>
                <div id="mSI" class="stackHorizontally mediumCell">

                </div>
            </div>
            <br>
            <div class="row">
                <div class="mediumCell stackHorizontally bold alignRight">
                    Ordenes
                </div>
                <div class="mediumCell stackHorizontally">&nbsp;</div>
            </div>
            <div class="row">
                <div class="bold stackHorizontally mediumCell alignRight">
                    Venta de Productos:
                </div>
                <div id="mVP" class="stackHorizontally mediumCell">

                </div>
            </div>
            <div class="row">
                <div class="bold stackHorizontally mediumCell alignRight">
                    Extra Shipping y Otros:
                </div>
                <div id="mES" class="stackHorizontally mediumCell">

                </div>
            </div>
            <div class="row">
                <div class="bold stackHorizontally mediumCell alignRight">
                    Cargos de Canal:
                </div>
                <div id="mCC" class="stackHorizontally mediumCell">

                </div>
            </div>
            <div class="row">
                <div class="bold stackHorizontally mediumCell alignRight">
                    Shipping:
                </div>
                <div id="mS" class="stackHorizontally mediumCell">

                  </div>
            </div>
            <div class="row">
                <div class="bold stackHorizontally mediumCell alignRight">
                    Sub Total Ventas:
                </div>
                <div id="mSTV" class="stackHorizontally mediumCell">

                </div>
            </div>
            <br>
            <div class="row">
                <div class="mediumCell stackHorizontally bold alignRight">
                    Otros Cargos
                </div>
                <div class="mediumCell stackHorizontally">&nbsp;</div>
            </div>
            <div class="row">
                <div class="bold stackHorizontally mediumCell alignRight">
                    Otros Cargos:
                </div>
                <div id="mOC" class="stackHorizontally mediumCell">

                </div>
            </div>
            <br>
            <div class="row">
                <div class="mediumCell stackHorizontally bold alignRight">
                    Balance
                </div>
                <div class="mediumCell stackHorizontally">&nbsp;</div>
            </div>
            <div class="row">
                <div class="bold stackHorizontally mediumCell alignRight">
                    Saldo Final:
                </div>
                <div id="mSF" class="stackHorizontally mediumCell bold">

                </div>
            </div>
        </div>
    </div>
</div>
<div>
<!--    <input id="getDetalle" type="button" class="cmd button button-highlight button-pill" value="Detalle">-->
</div>
<script>

    function getBalance(balanceId) {
        $.ajax({
            url:"../php/balances/balanceOperations.php",
            type:"POST",
            data:{
                method:"getBalance",
                balanceId:balanceId,
            },
            success:function (response) {
                console.log(data);
                var data = JSON.parse(response);
                $("#mSI").html(data.SALDO_INI);
                $("#mSTV").html((data.TOTALING - data.CANALCAR).toFixed(2));
                $("#mOC").html("<div id='OtrosCargosLink'><a href='#'>" + "-" + data.OTROSCAR + "</a></div>");
                $("#mSF").html(data.SALDO);
                $("#mVP").html("<div id='OrdenesLink'><a href='#'>" + data.vp.toFixed(2) + "</a></div>");
                $("#mES").html(data.es.toFixed(2));
                $("#mCC").html("<div id='CargosCanalLink'><a href='#'>" + "-" + data.cf.toFixed(2) + "</a></div>");
                $("#mS").html("<div id='ShippingLink'><a href='#'>" + "-" + data.sh.toFixed(2) + "</a></div>");

                $("#OrdenesLink").click(function (event) {
                    var id = $("#balanceDrop").val();
                    $( "#tabs" ).tabs({ active: 2 });
                    $("#balanceDropD").val(id);
                    $("#balanceDropD").change();
                    setTimeout(function () {
                        location.hash = "ordenesDiv";
                    }, 500);
                });
                $("#ShippingLink").click(function (event) {
                    var id = $("#balanceDrop").val();
                    $( "#tabs" ).tabs({ active: 2 });
                    $("#balanceDropD").val(id);
                    $("#balanceDropD").change();
                    setTimeout(function () {
                        location.hash = "shippingDiv";
                    }, 500);
                });
                $("#CargosCanalLink").click(function (event) {
                    var id = $("#balanceDrop").val();
                    $( "#tabs" ).tabs({ active: 2 });
                    $("#balanceDropD").val(id);
                    $("#balanceDropD").change();
                    setTimeout(function () {
                        location.hash = "cargosCanalDiv";
                    }, 500);
                });
                $("#OtrosCargosLink").click(function (event) {
                    var id = $("#balanceDrop").val();
                    $( "#tabs" ).tabs({ active: 2 });
                    $("#balanceDropD").val(id);
                    $("#balanceDropD").change();
                    setTimeout(function () {
                        location.hash = "otrosCargosDiv";
                    }, 500);
                });
            }
        });
    }

    $("#balanceDrop").change(function () {
        getBalance(this.value);
    });

    $("#getDetalle").click(function (event) {
        var id = $("#balanceDrop").val();
        $( "#tabs" ).tabs({ active: 2 });
//        console.log("codigo" + id);
        $("#balanceDropD").val(id);
        $("#balanceDropD").change();
//        $("#generateReportButton").trigger("click");
    });



</script>

<style>
    .row{
        width: 100%;
    }
    .smallCell{
        width:25%;
    }
    .mediumCell{
        width:50%;
    }
    .largeCell{
        width:75%;
    }
    .fullCell{
        width:100%;
    }
    .bold {
        font-weight: bold;
    }
    .stackHorizontally {
        float: left;
    }
    .alignRight {
        text-align: right;
    }
    .alignLeft{
        text-align: left;
    }
    .entradaTexto {
        border-radius: 10px 10px 10px 10px;
    }
    #detailTable{
        width: 50%;
        margin: 0 auto;
    }
</style>