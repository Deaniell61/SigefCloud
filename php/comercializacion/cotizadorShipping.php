<?php
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");

function getStatesDrop()
{
    $query = "
        SELECT 
            codigo, nombre
        FROM
            cat_estados
        ORDER BY codigo;
    ";
    $result = mysqli_query(conexion(""), $query);
    while ($row = mysqli_fetch_array($result)) {
        $tValue = $row["codigo"];
        $tName = $row["nombre"];
        $data .= "
                <option value='$tValue'>$tName</option>
            ";
    }
    $response = "
        <select id='shipState' class='entradaTexto fullInput'>
            $data
        </select>
    ";

    return $response;
}

function getPackagesDrop()
{
    $packagesQ = "
        SELECT
            NOMBRE, ALTO, ANCHO, LARGO
        FROM
            cat_package;
    ";
    $packagesR = mysqli_query(conexion(""), $packagesQ);
    while ($row = mysqli_fetch_array($packagesR)) {
        $nombre = $row["NOMBRE"];
        $alto = $row["ALTO"];
        $ancho = $row["ANCHO"];
        $largo = $row["LARGO"];
        if($alto != 0 && $ancho != 0 && $largo != 0){
            $data .= "
                <option value='$nombre' height='$alto' width='$ancho' length='$largo'>$alto x $largo x $ancho - $nombre</option>
            ";
        }

    }
    $response = "
        <select class='entradaTexto fullInput' id='packages' onchange='changePackage()'>
            <option value='custom' height='0' width='0' length='0'>CUSTOM</option>
            $data    
        </select>
    ";

    return $response;
}

?>
<div id="content">
    <div class="row">
        <div class="left group">
            <b>1. Address</b>

            <div class="row">
                <div class="left">
                    Address 1
                </div>
                <div class="right">
                    <input type="text" class="entradaTexto fullInput fullInput" id="address1">
                </div>
            </div>

            <div class="row">
                <div class="left">
                    Address 2
                </div>
                <div class="right">
                    <input type="text" class="entradaTexto fullInput" id="address2">
                </div>
            </div>

            <div class="row">
                <div class="left">
                    State
                </div>
                <div class="right">
                    <?php
                    echo getStatesDrop();
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="left">
                    City
                </div>
                <div class="right">
                    <input type="text" class="entradaTexto fullInput" id="city">
                </div>
            </div>

            <div class="row">
                <div class="left">
                    Zip
                </div>
                <div class="right">
                    <input type="text" class="entradaTexto fullInput" id="zip">
                </div>
            </div>
        </div>
        <div class="right group">
            <b>2. Dimensions</b>

            <div class="row">
                <div class="left">
                    Package
                </div>
                <div class="right">
                    <?php
                    echo getPackagesDrop();
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="left">
                    Measure units
                </div>
                <div class="right">
                    <select id="weightUnits" class="entradaTexto fullInput">
                        <option value="LB">LB</option>
                        <option value="KG">KG</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="left">
                    Weight
                </div>
                <div class="right">
                    <input type="text" class="entradaTexto fullInput" id="weight" name="weight" value="0">
                </div>
            </div>

            <div class="row">
                <div class="left">
                    Measure units
                </div>
                <div class="right">
                    <select id="dimensionUnits" class="entradaTexto fullInput">
                        <option value="IN">IN</option>
                        <option value="CM">CM</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="left">
                    Height
                </div>
                <div class="right">
                    <input type="text" class="entradaTexto fullInput" id="height" name="height" value="0">
                </div>
            </div>

            <div class="row">
                <div class="left">
                    Length
                </div>
                <div class="right">
                    <input type="text" class="entradaTexto fullInput" id="length" name="length" value="0">
                </div>
            </div>

            <div class="row">
                <div class="left">
                    Width
                </div>
                <div class="right">
                    <input type="text" class="entradaTexto fullInput" id="width" name="width" value="0">
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="left group">
            <b>3. Configure</b>

            <div class="row">
                <div class="left">
                    Carrier
                </div>
                <div class="right">
                    <select id="carrier" class="entradaTexto fullInput">
                        <option value="fedex">FEDEX</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="left">
                    Date
                </div>
                <div class="right">
                    <input type="date" id="shipDate" class="entradaTexto fullInput">
                </div>
            </div>
        </div>
        <div class="right group">
            <b>4. Quote</b>
            <br>
            <input id="quote" class="cmd button button-highlight button-pill" type="button" value="Quote">

            <div class="row">
                <div class="left">
                    2 day
                </div>
                <div id="responsePlan1" class="right">

                </div>
            </div>

            <div class="row">
                <div class="left">
                    Express Saver
                </div>
                <div id="responsePlan2" class="right">

                </div>
            </div>

            <div class="row">
                <div class="left">
                    Ground
                </div>
                <div id="responsePlan3" class="right">

                </div>
            </div>

            <div class="row">
                <div class="left">
                    Home Delivery
                </div>
                <div id="responsePlan4" class="right">

                </div>
            </div>
        </div>
    </div>

    <script>
        function changePackage() {
            $("#length").val($("#packages").find(':selected').attr('length'));
            $("#width").val($("#packages").find(':selected').attr('width'));
            $("#height").val($("#packages").find(':selected').attr('height'));
        }
        
        $("#quote").click(function () {

            $("#responsePlan1").html("calculating...");
            $("#responsePlan2").html("calculating...");
            $("#responsePlan3").html("calculating...");
            $("#responsePlan4").html("calculating...");


            var plan1 = "FEDEX_2_DAY";
            var plan2 = "FEDEX_EXPRESS_SAVER";
            var plan3 = "FEDEX_GROUND";
            var plan4 = "GROUND_HOME_DELIVERY";

            calc(plan1, "#responsePlan1");
            calc(plan2, "#responsePlan2");
            calc(plan3, "#responsePlan3");
            calc(plan4, "#responsePlan4");

        });

        function calc(plan, responseHolder){

            var tAddress1 = $("#address1").val();
            var tAddress2 = $("#address2").val();
            var tState = $("#shipState").val();
            var tCity = $("#city").val();
            var tZip = $("#zip").val();
            var tWeightUnit = $("#weightUnits").val();
            var tWeight = $("#weight").val();
            var tDimensionUnit = $("#dimensionUnits").val();
            var tHeight = $("#height").val();
            var tLength = $("#length").val();
            var tWidth = $("#width").val();
            var tDate = $("#shipDate").val();
            var tOrderType = 1;
            var tCarrier = $("#carrier").val();

            $.ajax({
                url: "../php/comercializacion/cotizadorShippingFunctions.php",
                type: "POST",
                data: {
                    method:"quote",
                    address1:tAddress1,
                    address2:tAddress2,
                    state:tState,
                    city:tCity,
                    zip:tZip,
                    weightUnit:tWeightUnit,
                    weight: tWeight,
                    dimensionUnit: tDimensionUnit,
                    height: tHeight,
                    length: tLength,
                    width: tWidth,
                    shipDate: tDate,
                    shippingMethod:plan,
                    orderType:tOrderType,
                    carrier:tCarrier,
                },
                success: function (response) {
                    var tResponse = response.split(" ")[0];
                    // console.log(tResponse);
                    if(tResponse != "ERROR"){
                        $(responseHolder).html("<b>$"+response+"</b>");
                    }
                    else{
                        $(responseHolder).html(response);
                    }
                    console.log("S" + response);

                },
                error:function (response) {
                    // console.log("E" + response)
                    $(responseHolder).html("ERROR: check the data and try again please." + response);
                }
            });
        }

        $(document).ready(function () {
            $("#shipDate").val(new Date().toISOString().split('T')[0]);
        });
    </script>


    <style>
        #content {
            width: 80%;
            margin-left: 10%;
        }

        .row{
            width: 100%;
            display: flex;
        }

        .left {
            width: 50%;
            float: left;
        }

        .right {
            width: 50%;
            float: left;
        }

        .fullInput {
            width: 100%;
        }

        .group {
            border: outset;
            border-width: 1px;
            border-radius: 10px;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .centered{
            flex-direction: row;
        }
    </style>