<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/php/productos/formulas.php";
$formulas = new formulas();
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<h1>Formulas Test</h1>

<div id="countriesDropContainer">
</div>
<div id="channelsDropContainer">
</div>


<!--01 units per case-->
<div>
    <h2><a id="unitsPerCaseLink" href="#">01 units per case</a></h2>

    <div hidden class="formContainer" id="unitsPerCaseForm">
        <div class="row">
            Parametros: MasterSKU y pais
        </div>
        <div class="row">
            <div class="left">master sku:</div>
            <div class="right"><input type="text" id="unitsPerCaseMasterSKU" value="300001"></div>
        </div>
        <div class="row">
            <input type="button" id="calcUnitsPerCase" value="calcular"><br>
        </div>
        <div class="row">
            <div class="left">response:</div>
            <div class="right"><b><div id="unitsPerCaseResponse"></div></b></div>
        </div>
    </div>
</div>

<!--02 bundle units-->
<div>
    <h2><a id="bundleUnitsLink" href="#">02 bundle units</a></h2>

    <div hidden class="formContainer" id="bundleUnitsForm">
        <div class="row">
            Parametros: MasterSKU y pais
        </div>
        <div class="row">
            <div class="left">master sku:</div>
            <div class="right"><input type="text" id="bundleUnitsMasterSKU" value="300001"></div>
        </div>
        <div class="row">
            <input type="button" id="calcBundleUnits" value="calcular"><br>
        </div>
        <div class="row">
            <div class="left">response:</div>
            <div class="right"><b><div id="bundleUnitsResponse"></div></b></div>
        </div>
    </div>
</div>

<!--03 cospri-->
<div>
    <h2><a id="cospriLink" href="#">03 cospri</a></h2>

    <div hidden class="formContainer" id="cospriForm">
        <div class="row">
            Parametros: MasterSKU, bundle units y pais
        </div>
        <div class="row">
            <div class="left">master sku:</div>
            <div class="right"><input type="text" id="cospriMasterSKU" value="300001"></div>
        </div>
        <div class="row">
            <div class="left">bundle units:</div>
            <div class="right"><input type="text" id="cospriBundleUnits" value="1"></div>
        </div>
        <div class="row">
            <input type="button" id="calcCospri" value="calcular"><br>
        </div>
        <div class="row">
            <div class="left">response:</div>
            <div class="right"><b><div id="cospriResponse"></div></b></div>
        </div>
    </div>
</div>

<!--04 fbaordhanf-->
<div>
    <h2><a id="fbaordhanfLink" href="#">04 fbaordhanf</a></h2>

    <div hidden class="formContainer" id="fbaordhanfForm">
        <div class="row">
            Parametros: canal, parametro y pais
        </div>
        <div class="row">
            <input type="button" id="calcFbaordhanf" value="calcular"><br>
        </div>
        <div class="row">
            <div class="left">response:</div>
            <div class="right"><b><div id="fbaordhanfResponse"></div></b></div>
        </div>
    </div>
</div>

<!--05 fbapicpacf-->
<div>
    <h2><a id="fbapicpacfLink" href="#">05 fbapicpacf</a></h2>

    <div hidden class="formContainer" id="fbapicpacfForm">
        <div class="row">
            Parametros: canal, parametro y pais
        </div>
        <div class="row">
            <input type="button" id="calcFbapicpacf" value="calcular"><br>
        </div>
        <div class="row">
            <div class="left">response:</div>
            <div class="right"><b><div id="fbapicpacfResponse"></div></b></div>
        </div>
    </div>
</div>

<!--06 fbaweihanf-->
<div>
    <h2><a id="fbaweihanfLink" href="#">06 fbaweihanf</a></h2>

    <div hidden class="formContainer" id="fbaweihanfForm">
        <div class="row">
            Parametros: mastersku, cantidad, canal y pais
        </div>
        <div class="row">
            <div class="left">mastersku:</div>
            <div class="right"><input type="text" id="fbaweihanfMastersku" value="300001"></div>
        </div>
        <div class="row">
            <div class="left">units:</div>
            <div class="right"><input type="text" id="fbaweihanfUnits" value="1"></div>
        </div>
        <div class="row">
            <input type="button" id="calcFbaweihanf" value="calcular"><br>
        </div>
        <div class="row">
            <div class="left">response:</div>
            <div class="right"><b><div id="fbaweihanfResponse"></div></b></div>
        </div>
    </div>
</div>

<!--07 fbainbshi-->
<div>
    <h2><a id="fbainbshiLink" href="#">07 fbainbshi</a></h2>

    <div hidden class="formContainer" id="fbainbshiForm">
        <div class="row">
            Parametros: mastersku, cantidad y pais
        </div>
        <div class="row">
            <div class="left">mastersku:</div>
            <div class="right"><input type="text" id="fbainbshiMastersku" value="300001"></div>
        </div>
        <div class="row">
            <div class="left">units:</div>
            <div class="right"><input type="text" id="fbainbshiUnits" value="1"></div>
        </div>
        <div class="row">
            <input type="button" id="calcFbainbshi" value="calcular"><br>
        </div>
        <div class="row">
            <div class="left">response:</div>
            <div class="right"><b><div id="fbainbshiResponse"></div></b></div>
        </div>
    </div>
</div>

<!--08 fbapicpacf-->
<div>
    <h2><a id="pacMatLink" href="#">08 pacmat</a></h2>

    <div hidden class="formContainer" id="pacMatForm">
        <div class="row">
            Parametros: canal, parametro y pais
        </div>
        <div class="row">
            <input type="button" id="calcPacMat" value="calcular"><br>
        </div>
        <div class="row">
            <div class="left">response:</div>
            <div class="right"><b><div id="pacMatResponse"></div></b></div>
        </div>
    </div>
</div>

<!--09 shipping-->
<div>
    <h2><a id="shippingLink" href="#">09 shipping</a></h2>

    <div hidden class="formContainer" id="shippingForm">
        <div class="row">
            Parametros: MasterSKU, cantidad y pais
        </div>
        <div class="row">
            <div class="left">master sku:</div>
            <div class="right"><input type="text" id="shippingMasterSKU" value="300146"></div>
        </div>
        <div class="row">
            <div class="left">unidades:</div>
            <div class="right"><input type="text" id="shippingUnits" value="3"></div>
        </div>
        <div class="row">
            <input type="button" id="calcShipping" value="calcular"><br>
        </div>
        <div class="row">
            <div class="left">response:</div>
            <div class="right"><b><div id="shippingResponse"></div></b></div>
        </div>
    </div>
</div>


<!--10 shipping rate-->
<div>
    <h2><a id="shippingRateLink" href="#">10 shipping rate</a></h2>

    <div hidden class="formContainer" id="shippingRateForm">
        <div class="row">
            Parametros: MasterSKU, cantidad y pais
        </div>
        <div class="row">
            <div class="left">master sku:</div>
            <div class="right"><input type="text" id="shippingRateMasterSKU" value="300146"></div>
        </div>
        <div class="row">
            <div class="left">unidades:</div>
            <div class="right"><input type="text" id="shippingRateUnits" value="3"></div>
        </div>
        <div class="row">
            <input type="button" id="calcShippingRate" value="calcular"><br>
        </div>
        <div class="row">
            <div class="left">response:</div>
            <div class="right"><b><div id="shippingRateResponse"></div></b></div>
        </div>
    </div>
</div>

<!--min price-->
<div>
    <h2><a id="minPriceLink" href="#">minprice</a></h2>

    <div hidden class="formContainer" id="minPriceForm">
        <div class="row">
            para calcular el precio minimo primero necesitamos<br>
            facreff, mmin y mmax<br>
            para tener facreff necesitamos el canal<br><br>
        </div>

        <div class="row">
            Parametros: MasterSKU, cantidad y pais
        </div>
        <div class="row">
            <div class="left">master sku:</div>
            <div class="right"><input type="text" id="minPriceMasterSKU" value="300146"></div>
        </div>
        <div class="row">
            <div class="left">unidades:</div>
            <div class="right"><input type="text" id="minPriceUnits" value="3"></div>
        </div>
        <div class="row">
            <input type="button" id="calcMinPrice" value="calcular"><br>
        </div>
        <div class="row">
            <div class="left">response:</div>
            <div class="right"><b><div id="minPriceResponse"></div></b></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $.ajax({
            type: "POST",
            url: "formulasHelper.php",
            data:{
                method:"getCountriesDrop",
            },
            success:function (response) {
//                    console.log("S"+response);
                $("#countriesDropContainer").html(response);

                $("#countriesDrop").change(function () {
                    var tCountry = $("#countriesDrop").val();
                    $.ajax({
                        type: "POST",
                        url: "formulasHelper.php",
                        data:{
                            method:"getChannelsDrop",
                            country: tCountry,
                        },
                        success:function (response) {
//                    console.log("S"+response);
                            $("#channelsDropContainer").html(response);
                        },
                        error:function (response) {
                            console.log("E"+response);
                        }
                    });
                });

                $("#countriesDrop").change();
            },
            error:function (response) {
                console.log("E"+response);
            }
        });

        //form listeners
        $("#unitsPerCaseLink").click(function () {
            toggleHide("unitsPerCase");
        });
        $("#bundleUnitsLink").click(function () {
            toggleHide("bundleUnits");
        });
        $("#cospriLink").click(function () {
            toggleHide("cospri");
        });
        $("#fbaordhanfLink").click(function () {
            toggleHide("fbaordhanf");
        });
        $("#fbapicpacfLink").click(function () {
            toggleHide("fbapicpacf");
        });
        $("#fbaweihanfLink").click(function () {
            toggleHide("fbaweihanf");
        });
        $("#fbainbshiLink").click(function () {
            toggleHide("fbainbshi");
        });
        $("#pacMatLink").click(function () {
            toggleHide("pacMat");
        });
        $("#shippingLink").click(function () {
            toggleHide("shipping");
        });
        $("#shippingRateLink").click(function () {
            toggleHide("shippingRate");
        });
        $("#minPriceLink").click(function () {
            toggleHide("minPrice");
        });

        //form calcs
        $("#calcUnitsPerCase").click(function () {
            var masterSKU = $("#unitsPerCaseMasterSKU").val();
            var country = $("#countriesDrop").val();

            $.ajax({
                url:"../php/formulas/formulasOperations.php",
                type:"POST",
                data:{
                    method:"unitsPerCase",
                    masterSKU:masterSKU,
                    country:country,
                },
                success:function (response) {
                    console.log("S: " + response);
                    $("#unitsPerCaseResponse").html(response);
                },
                error:function (response) {
                    console.log("E: " + response);
                }
            });
        });

        $("#calcBundleUnits").click(function () {
            var masterSKU = $("#bundleUnitsMasterSKU").val();
            var country = $("#countriesDrop").val();

            $.ajax({
                url:"../php/formulas/formulasOperations.php",
                type:"POST",
                data:{
                    method:"bundleUnits",
                    masterSKU:masterSKU,
                    country:country,
                },
                success:function (response) {
//                    response = JSON.parse(response);
                    console.log("S: " + response);
                    $("#bundleUnitsResponse").html(response);
                },
                error:function (response) {
                    console.log("E: " + response);
                }
            });
        });

        $("#calcCospri").click(function () {
            var masterSKU = $("#cospriMasterSKU").val();
            var bundleUnits = $("#cospriBundleUnits").val();
            var country = $("#countriesDrop").val();

            $.ajax({
                url:"../php/formulas/formulasOperations.php",
                type:"POST",
                data:{
                    method:"cospri",
                    masterSKU:masterSKU,
                    bundleUnits:bundleUnits,
                    country:country,
                },
                success:function (response) {
//                    response = JSON.parse(response);
                    console.log("S: " + response);
                    $("#cospriResponse").html(response);
                },
                error:function (response) {
                    console.log("E: " + response);
                }
            });
        });

        $("#calcFbaordhanf").click(function () {
            var channel = $("#channelsDrop").val();
            var country = $("#countriesDrop").val();

            $.ajax({
                url:"../php/formulas/formulasOperations.php",
                type:"POST",
                data:{
                    method:"fbaordhanf",
                    channel:channel,
                    country:country,
                },
                success:function (response) {
//                    response = JSON.parse(response);
                    console.log("S: " + response);
                    $("#fbaordhanfResponse").html(response);
                },
                error:function (response) {
                    console.log("E: " + response);
                }
            });
        });

        $("#calcFbapicpacf").click(function () {
            var channel = $("#channelsDrop").val();
            var country = $("#countriesDrop").val();

            $.ajax({
                url:"../php/formulas/formulasOperations.php",
                type:"POST",
                data:{
                    method:"fbapicpacf",
                    channel:channel,
                    country:country,
                },
                success:function (response) {
//                    response = JSON.parse(response);
                    console.log("S: " + response);
                    $("#fbapicpacfResponse").html(response);
                },
                error:function (response) {
                    console.log("E: " + response);
                }
            });
        });

        $("#calcFbaweihanf").click(function () {
            var channel = $("#channelsDrop").val();
            var country = $("#countriesDrop").val();
            var masterSKU = $("#fbaweihanfMastersku").val();
            var units = $("#fbaweihanfUnits").val();

            $.ajax({
                url:"../php/formulas/formulasOperations.php",
                type:"POST",
                data:{
                    method:"fbaweihanf",
                    masterSKU:masterSKU,
                    units:units,
                    country:country,
                    channel:channel,
                },
                success:function (response) {
//                    response = JSON.parse(response);
                    console.log("S: " + response);
                    $("#fbaweihanfResponse").html(response);
                },
                error:function (response) {
                    console.log("E: " + response);
                }
            });
        });

        $("#calcFbainbshi").click(function () {
            var country = $("#countriesDrop").val();
            var masterSKU = $("#fbainbshiMastersku").val();
            var units = $("#fbainbshiUnits").val();

            $.ajax({
                url:"../php/formulas/formulasOperations.php",
                type:"POST",
                data:{
                    method:"fbainbshi",
                    masterSKU:masterSKU,
                    units:units,
                    country:country,
                },
                success:function (response) {
//                    response = JSON.parse(response);
                    console.log("S: " + response);
                    $("#fbainbshiResponse").html(response);
                },
                error:function (response) {
                    console.log("E: " + response);
                }
            });
        });

        $("#calcPacMat").click(function () {
            var channel = $("#channelsDrop").val();
            var country = $("#countriesDrop").val();

            $.ajax({
                url:"../php/formulas/formulasOperations.php",
                type:"POST",
                data:{
                    method:"pacMat",
                    channel:channel,
                    country:country,
                },
                success:function (response) {
//                    response = JSON.parse(response);
                    console.log("S: " + response);
                    $("#pacMatResponse").html(response);
                },
                error:function (response) {
                    console.log("E: " + response);
                }
            });
        });

        $("#calcShipping").click(function () {
            var masterSKU = $("#shippingMasterSKU").val();
            var units = $("#shippingUnits").val();
            var country = $("#countriesDrop").val();

            $.ajax({
                url:"../php/formulas/formulasOperations.php",
                type:"POST",
                data:{
                    method:"shipping",
                    masterSKU:masterSKU,
                    units:units,
                    country:country,
                },
                success:function (response) {
                    console.log("S: " + response);
                    $("#shippingResponse").html(response);
                },
                error:function (response) {
                    console.log("E: " + response);
                }
            });
        });

        $("#calcShippingRate").click(function () {
            var masterSKU = $("#shippingRateMasterSKU").val();
            var units = $("#shippingRateUnits").val();
            var country = $("#countriesDrop").val();

            $.ajax({
                url:"../php/formulas/formulasOperations.php",
                type:"POST",
                data:{
                    method:"shippingRate",
                    masterSKU:masterSKU,
                    units:units,
                    country:country,
                },
                success:function (response) {
                    console.log("S: " + response);
                    $("#shippingRateResponse").html(response);
                },
                error:function (response) {
                    console.log("E: " + response);
                }
            });
        });

        $("#calcMinPrice").click(function () {
            var masterSKU = $("#minPriceMasterSKU").val();
            var units = $("#minPriceUnits").val();
            var country = $("#countriesDrop").val();

            $.ajax({
                url:"../php/formulas/formulasOperations.php",
                type:"POST",
                data:{
                    method:"minPrice",
                    masterSKU:masterSKU,
                    units:units,
                    country:country,
                },
                success:function (response) {
                    console.log("S: " + response);
                    $("#minPriceResponse").html(response);
                },
                error:function (response) {
                    console.log("E: " + response);
                }
            });
        });

        //auxs
        function toggleHide(element) {
            if($("#" + element + "Form").is(':visible')){
                $("#" + element + "Form").hide(250);
            }
            else{
                $("#" + element + "Form").show(250);
            }
        }
    });
</script>

<style>
    .formContainer{
        width: 500px;
    }

    .row{
        width: 100%;
    }

    .left{
        width: 25%;
        float: left;
    }

    .right{
        width: 75%;
        float: left;
    }
</style>