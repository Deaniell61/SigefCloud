<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php";
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
        $data .= "
                <option value='$nombre' alto='$alto' ancho='$ancho' largo='$largo'>$nombre</option>
            ";
    }

    $response = "
            <select class='entradaTexto inputFull' id='packagesDrop' onchange='changePackage()'>
                <option value='custom' alto='0' ancho='0' largo='0'>CUSTOM</option>
                $data    
            </select>
        ";

    return $response;
}

?>


<link href="../../css/estiloPrincipal.css" rel="stylesheet" type="text/css">
        <link href="../../css/estiloLupa.css" rel="stylesheet" type="text/css">
        <link href="../../css/estiloForms.css" rel="stylesheet" type="text/css">
        <link href="../../css/grid.css" rel="stylesheet" type="text/css">
        <link href="../menu/css/encabezado.css" rel="stylesheet" type="text/css">
        <link href="../../Inicio/css/productos.css" rel="stylesheet" type="text/css">
        <link href="../../css/verificar.css" rel="stylesheet" type="text/css">
        <link href="../../css/botones.css" rel="stylesheet" type="text/css">
        <link href="../../css/textos.css" rel="stylesheet" type="text/css">
        <link href="../../css/tabla.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../../css/jquery-ui.min.css" type="text/css"/>
<script type="text/javascript" src="../../js/jquery-2.2.3.min.js"></script>
<script src="../../js/jquery-ui.min.js" type="text/javascript"></script>
<script src="../../js/colResizable-1.5.min.js"></script>
<script src="../../js/jqueryRotate.js"></script>
<script src="../../js/jquery.tablesorter.js"></script>
<script src="../../js/Lupa.js" type="text/javascript"></script>
<script src="../../js/jquery-barcode.js" type="text/javascript"></script>
<script src="../../js/funcionesScript.js" type="text/javascript"></script>
<script src="../../js/Jqueryvalidation.js" type="text/javascript"></script>
<script src="../../js/funcionesScriptUsuarios.js" type="text/javascript"></script>
<script src="../../js/funcionesScriptEmpresas.js" type="text/javascript"></script>
<script src="../../js/funcionesScriptModulos.js" type="text/javascript"></script>
<script src="../../js/funcionesScriptTerminos.js" type="text/javascript"></script>
<script>$.ajaxSetup({cache: false});</script>
<script src="../../js/funcionesScriptUsuarioLogiado.js" type="text/javascript"></script>
<script src="../../js/datatables.min.js" type="text/javascript"></script>
<script src="../../js/estibar.js" type="text/javascript"></script>
<script src="../../js/lib/ckeditor/ckeditor.js" type="text/javascript"></script>
<div id="cargaLoad"></div>
<div hidden id="upsCsv" title="Shipping">
    <div class="divRow">
        <div class="divCol">
            <select id="carriers">
                <option selected value="all">ALL</option>
                <option value="ups">UPS</option>
                <option value="fedex">FEDEX</option>
                <option value="usps">USPS</option>
            </select>
            <image id="refreshContent" src="../images/refresh.png"></image>
        </div>
        <div class="divCol">
            <input type="button" id="upsCsvGenerate" class="cmd button button-highlight button-pill" value="Labels CSV">
        </div>
        <div class="divCol">
            <input type="button" id="picklistCsvGenerate" class="cmd button button-highlight button-pill"
                   value="Picklist">
        </div>
        <div class="divCol">
            <iframe hidden width="0" height="0" border="0" name="dummyframe" id="dummyframe"></iframe>

            <!--            to debug change target to _blank from dummyframe-->
            <form action="../php/walmart/cleanTrackingNumber.php" method="post" enctype="multipart/form-data"
                  target="dummyframe" onsubmit="refreshContent()" style="float: left">
                <input id="trackingCarrier" name="trackingCarrier" type="hidden" value="">
                <input id="formOrderIds" name="formOderIds" type="hidden" value="">
                <input style="float: left; width: 225px;" type="file" name="csv" id="csv" value="" accept=".csv"
                       onchange="check_file()"/>
                <input id="trackingSubmit" disabled style="float: left;" class="cmd button button-highlight button-pill"
                       type="submit" name="submit" value="Update Tracking"/>
                <input disabled formaction="/php/productos/generateLabels.php" formtarget="_blank" id="generateLabels"
                       style="float: left;" class="cmd button button-highlight button-pill"
                       type="submit" name="submit" value="Package Labels"/>
            </form>

        </div>
    </div>
    <br>
    <div class="gridRow">
        <div style="width: 98%; text-align: right">
            <input disabled id="openSinglePackage" type="button" class="cmd button button-highlight button-pill"
                   value="Single Package">
            &nbsp;&nbsp;
            <b>Select/Deselect All</b>&nbsp;<input checked type="checkbox" id="allCheckboxes">
        </div>
    </div>
    <br>
    <div class='gridRow'>
        <div class='stackHorizontally upsCsvCellS'><b>#</b></div>
        <div class='stackHorizontally upsCsvCell'><b>Order Id</b></div>
        <div class='stackHorizontally upsCsvCellL'><b>Name</b></div>
        <div class='stackHorizontally upsCsvCell'><b>Date</b></div>
        <div class='stackHorizontally upsCsvCell'><b>Carrier</b></div>
        <div class='stackHorizontally upsCsvCellS'><b>Label</b></div>
        <div class='stackHorizontally upsCsvCellS'><b>Edit</b></div>
        <div class='stackHorizontally upsCsvCellS'><b>Cancel</b></div>
        <div class='stackHorizontally upsCsvCellS'><b>Use</b></div>
    </div>
    <div id="upsCsvContent">
    </div>
</div>

<div hidden id="singlePackage">
    <div class="divRow">
        <form enctype="multipart/form-data" action="/php/productos/generateLabels.php" method="post" target="_blank">
            <b>Order ID</b>
            <input id="singlePackageOrderID" name="singlePackageOrderID" type="number" class="entradaTexto"
                   value="">
            <input id="loadOrder" type="button" class="cmd button button-highlight button-pill" value="Load Order">
            <input readonly hidden id="singlePackageLimits" name="singlePackageLimits" type="text">
            <input id="downloadSinglePackageLabels" type="submit" name="submit"
                   class="cmd button button-highlight button-pill" value="Generate Labels">
        </form>

    </div>

    <div class="divRow" style="text-align: center;">
        <span id="singlePackageMessage"></span>
    </div>

    <div id="singlePackageContent" class="divRow">

    </div>
</div>

<div hidden id="generateLabel" title="Label">
    <div class="divRow">
        <div class="labelCol">
            <b>1. Validate address</b>
            <div style="width: 100%;">
                <div id="selectedAddress">Validating address...</div>
                <div style="width: 25%; float: left">
                    Status:
                </div>
                <div id="addressStatusResponse" style="width: 10%; float: left">
                    &nbsp;
                </div>

            </div>
        </div>
        <div class="labelCol">
            <b>2. Input values</b>
            <div style="width: 100%;">
                <div style="width: 50%; float: left">Packages</div>
                <div style="width: 50%; float: left">
                    <?php
                    echo getPackagesDrop();
                    ?>
                </div>
            </div>
            <div style="width: 100%;">
                <div style="width: 50%; float: left">Measure Units</div>
                <div style="width: 50%; float: left">
                    <select id="lblWUnit" class="entradaTexto inputFull">
                        <option value="LB">LB</option>
                        <option value="KG">KG</option>
                    </select>
                </div>
            </div>
            <div style="width: 100%;">
                <div style="width: 50%; float: left">Weight</div>
                <div style="width: 50%; float: left">
                    <input class="entradaTexto inputFull" id="lblW" type="text" value="0">
                </div>
            </div>
            <div style="width: 100%;">
                <div style="width: 50%; float: left">Measure Units</div>
                <div style="width: 50%; float: left">
                    <select id="lblDUnit" class="entradaTexto inputFull">
                        <option value="IN">IN</option>
                        <option value="CM">CM</option>
                    </select>
                </div>
            </div>
            <div style="width: 100%;">
                <div style="width: 50%; float: left">Length</div>
                <div style="width: 50%; float: left">
                    <input class="entradaTexto inputFull" id="lblDLength" type="text" value="0">
                </div>
            </div>
            <div style="width: 100%;">
                <div style="width: 50%; float: left">Width</div>
                <div style="width: 50%; float: left">
                    <input class="entradaTexto inputFull" id="lblDWidth" type="text" value="0">
                </div>
            </div>
            <div style="width: 100%;">
                <div style="width: 50%; float: left">Height</div>
                <div style="width: 50%; float: left">
                    <input class="entradaTexto inputFull" id="lblDHeight" type="text" value="0">
                </div>
            </div>


        </div>
        <div class="labelCol">
            <b>3. Quote shipping</b>
            <div style="width: 100%;">
                <div style="width: 50%; float: left">Date</div>
                <div style="width: 50%; float: left">
                    <input type="date" id="quoteShippingDate" class="entradaTexto inputFull">
                </div>
            </div>
            <div style="width: 100%; text-align: center">
                <input id="quoteFedexButton" class="cmd button button-highlight button-pill" type="button"
                       value="Quote">
            </div>
            <div style="width: 100%;">
                <form>
                    <input type="radio" name="shippingType" value="twoDay" checked>2 day<p id="plan1"></p>
                    <input type="radio" name="shippingType" value="expressSaver">Express Saver<p id="plan2"></p>
                    <input type="radio" name="shippingType" value="ground">Ground<p id="plan3"></p>
                    <input type="radio" name="shippingType" value="homeDelivery">Home Delivery<p id="plan4"></p>
                </form>
            </div>

        </div>
        <div class="labelCol">
            <b>4. Generate label</b>
            <div id="generateLabelContent">
                <input disabled id="generateLabelButton" class="cmd button button-highlight button-pill" type="button"
                       value="Generate Label">
            </div>
        </div>
    </div>

    <div><input hidden disabled id="tOrderId" type="text" value=""></div>
</div>

<div hidden id="editShipping" title="Edit">
    <br>
    <div class="row1">
        <div class="col2">Tracking number:</div>
        <div class="col2"><input id="editTrackingNumber" class="entradaTexto" type="text" style="width: 100%"></div>
    </div>
    <div class="row1">
        <div class="col2">Ship date:</div>
        <div class="col2"><input id="editShipDate" class="entradaTexto" type="date" style="width: 100%"></div>
    </div>
    <div class="row1">
        <div class="col2">Shipping carrier:</div>
        <div class="col2">
            <select id="editShippingCarrier" class="entradaTexto" style="width: 100%">
                <option value="ups">UPS</option>
                <option value="fedex">FEDEX</option>
                <option value="usps">USPS</option>
            </select>
        </div>
    </div>
    <div class="row1">
        <div class="col2">Shipping method:</div>
        <div class="col2"><input id="editShippingMethod" class="entradaTexto" type="text" style="width: 100%"></div>
    </div>
    <div class="row1">
        <div class="col2">Pay date:</div>
        <div class="col2"><input id="editPayDate" class="entradaTexto" type="date" style="width: 100%"></div>
    </div>
    <div class="row1">
        <div class="col2">Pay ref number:</div>
        <div class="col2"><input id="editPayRefNumber" class="entradaTexto" type="text" style="width: 100%"></div>
    </div>
    <div class="row1" id="editMessage">
    </div>
    <div hidden class="row1">
        <div class="col2"><input id="editOrderId" class="entradaTexto" type="text" style="width: 100%"></div>
    </div>
    <div class="row1" style="text-align: center; padding-top: 20px;">
        <input id="editTrackingButton" class="cmd button button-highlight button-pill" type="button" value="Save">
    </div>
</div>

<div hidden id="cancelShipping" title="Cancel">
    <br>
    <input hidden disabled id="cancelOrderId" class="entradaTexto" type="text" style="width: 100%">
    <div class="row1" id="cancelText">
    </div>
    <div class="row1" id="cancelMessage">
    </div>
    <div class="row1" style="text-align: center; padding-top: 20px;">
        <input id="cancelShippingButton" class="cmd button button-highlight button-pill" type="button" value="Cancel">
    </div>
</div>
<script>
    $("#upsCsv_OpenDialog").click(function () {
        upsCsv_OpenDialog();
    });
    $("#upsCsvGenerate").click(function () {
        upsCsv_Generate();
    });
    $("#picklistCsvGenerate").click(function () {
        picklistCsv_Generate();
    });
    $("#quoteFedexButton").click(function () {
        quoteFedex();
    });
    $("#openSinglePackage").click(function () {
        openSinglePackage();
    });

    function editShipping(id, carrier) {
        editShipping_OpenDialog(id, carrier);
    }

    function generateLabel(id, carrier) {
        generateLabel_OpenDialog(id, carrier);
    }

    function cancelShipping(id) {
        cancelShipping_OpenDialog(id);
    }

    $("#generateLabelButton").click(function () {
        var id = $("#tOrderId").val();

        var lblWUnit = $("#lblWUnit").val();
        var lblW = $("#lblW").val();
        var lblDUnit = $("#lblDUnit").val();
        var lblDLength = $("#lblDLength").val();
        var lblDWidth = $("#lblDWidth").val();
        var lblDHeight = $("#lblDHeight").val();
        $("#generateLabelContent").html("<p>Generating...</p>");

        $.ajax({
            type: "POST",
            url: "/php/shipping/fedex/ShipService/ShipService/Ground/Domestic/ShipWebServiceClient.php5",
            data: {
                method: "generateGroundDomestic",
                id: id,
                lblWUnit: lblWUnit,
                lblW: lblW,
                lblDUnit: lblDUnit,
                lblDLength: lblDLength,
                lblDWidth: lblDWidth,
                lblDHeight: lblDHeight,
            },
            success: function (response) {
                console.log(response);
                if (response == "1") {
                    $("#generateLabelContent").html("Success: <a href='http://desarrollo.sigefcloud.com/php/shipping/fedex/ShipService/ShipService/Ground/Domestic/shipgroundlabel.pdf' target='_blank'>label</a>");
                    window.open('http://desarrollo.sigefcloud.com/php/shipping/fedex/ShipService/ShipService/Ground/Domestic/shipgroundlabel.pdf', '_blank');
                    window.print();
                } else {
                    $("#generateLabelContent").html("<p>" + response + "</p>");
                }

            },
            error: function (response) {
                console.log(response);
            }
        });
    });

    function upsCsv_OpenDialog() {
        $("#upsCsv").dialog({
            modal: true,
            height: 550,
            width: 1250,
            close: function (event, ui) {
                $("#upsCsv").dialog("close");
                $("#openSinglePackage").prop("disabled", true);
                $("#generateLabels").prop("disabled", true);
            }
        });
        $("#upsCsv").dialog("open");
        $('#upsCsvContent').html("<p style='text-align: center;'>loading...</p>");
        $('#upsCsvContent').load("../php/ordenes/upsCsvData.php?carrier=all", function () {
            fillFormIds();
            $("#openSinglePackage").prop("disabled", false);
            $("#generateLabels").prop("disabled", false);
        });
    }

    function editShipping_OpenDialog(id, carrier) {
        $("#editShipping").dialog({
            modal: true,
            height: 300,
            width: 450,
            close: function (event, ui) {
                $("#editShipping").dialog("close");
            }
        });
        var d = new Date(); // duplicate start date
        d.setDate(d.getDate() - (d.getDay() - 6)); // move to last sunday
        var tRef = "WMBAL" + d.getFullYear() + ("0" + (d.getMonth() + 1)).slice(-2) + d.getDate();
        $("#editOrderId").val(id);
        $("#editTrackingNumber").val("");
        $("#editShippingMethod").val(carrier);
        $("#editPayRefNumber").val(tRef);
        $("#editShippingCarrier").val(carrier);
        $('#editShipDate').val(new Date().toDateInputValue());
        $('#editPayDate').val(new Date(d).toDateInputValue());
        $("#editShipping").dialog("open");
        $("#editTrackingButton").prop("disabled", false);
        $('#editMessage').html("");
    }

    function cancelShipping_OpenDialog(id) {
        $("#cancelText").html("Cancel shipping for order:<b>" + id + "</b>?");
        $("#cancelMessage").html("");
        $("#cancelOrderId").val(id);
        $("#cancelShipping").dialog({
            modal: true,
            height: 275,
            width: 450,
            close: function (event, ui) {
                $("#cancelShipping").dialog("close");
            }
        });
        $("#cancelShippingButton").prop("disabled", false);
    }

    function generateLabel_OpenDialog(id, carrier) {
        $("#generateLabel").dialog({
            modal: true,
            height: 400,
            width: 1150,
            close: function (event, ui) {
                $("#generateLabel").dialog("close");
                $("#addressStatusResponse").html("&nbsp;");
                $("#selectedAddress").html("&nbsp");
                $("#generateLabelButton").prop("disabled", true);
                $("#tOrderId").val("");
                $("#generateLabelContent").html("&nbsp");

                $("#lblWUnit").val("KG");
                $("#lblW").val("0");
                $("#lblDUnit").val("CM");
                $("#lblDLength").val("0");
                $("#lblDWidth").val("0");
                $("#lblDHeight").val("0");

                $("#plan1").html("");
                $("#plan2").html("");
                $("#plan3").html("");
                $("#plan4").html("");
                $("#quoteStatus").html("");
            }
        });

        $("#tOrderId").val(id);

        $("#quoteShippingDate").val(new Date().toISOString().split('T')[0]);

        $("#selectedAddress").html("Validating address...");
        $.ajax({
            type: "POST",
            url: "/php/shipping/fedex/AddressValidationWebServiceClient/AddressValidationWebServiceClient.php5",
            data: {
                method: "validate",
                id: id,
            },
            success: function (response) {
                console.log(response);
                var tResponse = response.split(" ")[0];
                // console.log(tResponse);
                if (tResponse != "INVALID") {
                    $("#addressStatusResponse").html("<img src='http://desarrollo.sigefcloud.com/images/yes.jpg'>");
                    $("#selectedAddress").html(response);
                    $("#generateLabelButton").prop("disabled", false);
                    getOrderWeight();
                } else {
                    $("#addressStatusResponse").html("<img src='http://desarrollo.sigefcloud.com/images/no.jpg'>");
                    $("#selectedAddress").html(response);
                    $("#generateLabelButton").prop("disabled", true);

                }

            },
            error: function (response) {
                $("#addressStatusResponse").html("Error..." + JSON.stringify(response));
                console.log(response);
            }
        });
    }

    function getOrderWeight() {
        var orderId = $("#tOrderId").val();
        // console.log(orderId);
        $.ajax({
            type: "POST",
            url: "/php/ordenes/getOrderWeight.php",
            data: {
                method: "getOrderWeight",
                orderId: orderId,
            },
            success: function (response) {
                console.log(response);
                $("#lblW").val(response);
            },
            error: function (response) {
                console.log(response);
            }
        });
    }

    function upsCsv_Generate() {
        var checks = document.getElementsByName("orderids[]");
        var orderids = [];
        for (var i = 0; i < checks.length; i++) {
            if (checks[i].checked == true) {
                orderids.push(checks[i].value);
            }
        }
        var carrierName = $("#carriers").val();
        window.open("http://desarrollo.sigefcloud.com/php/shipping/uspsCsvGenerator.php?carrierName=" + carrierName + "&orderids=" + orderids);
        // $('#upsCsvContent').load("http://desarrollo.sigefcloud.com/php/shipping/uspsCsvGenerator.php?orderids=" + orderids);
    }

    function picklistCsv_Generate() {
        /*
        var checks = document.getElementsByName("orderids[]");
        var orderids = [];
        for (var i=0; i < checks.length; i++) {
            if(checks[i].checked == true){
                orderids.push(checks[i].value);
            }
        }
        var carrierName = $("#carriers").val();
        */
        window.open("http://desarrollo.sigefcloud.com/php/shipping/picklistCsvGenerator.php");
        // $('#upsCsvContent').load("http://desarrollo.sigefcloud.com/php/shipping/uspsCsvGenerator.php?orderids=" + orderids);
    }

    function refreshContent() {
        fillFormIds();
        ventana('cargaLoad',300,400);
        document.getElementById('cargaLoad').innerHTML = '<center><img src="../../images/Cargando.gif" height="200" width="200" /><br><span>Por favor Espere... Procesando ordenes </span></center>';
        setTimeout(function () {
            var carrierName = $("#carriers").val();
            $('#upsCsvContent').html("<p style='text-align: center;'>loading...</p>");
            $('#upsCsvContent').load("../php/ordenes/upsCsvData.php?carrier=" + carrierName);
            fillFormIds();
            $('#cargaLoad').dialog('close');
            // console.log("here");
        }, 1000);
    };

    function fillFormIds() {
        var checks = document.getElementsByName("orderids[]");
        var orderids = [];
        for (var i = 0; i < checks.length; i++) {
            if (checks[i].checked == true) {
                orderids.push(checks[i].value);
            }
        }
        $('#formOrderIds').val(orderids);
    };
    $(document).on('change', '.orderidchk', function () {
        fillFormIds();
    });
    $("#carriers").change(function () {
        $('#upsCsvContent').html("<p style='text-align: center;'>loading...</p>");
        $('#upsCsvContent').load("../php/ordenes/upsCsvData.php?carrier=" + this.value);
        $("#trackingCarrier").val(this.value);
        if (this.value != "all") {
            $("#trackingSubmit").prop("disabled", false);
        } else {
            $("#trackingSubmit").prop("disabled", true);
        }
    });
    $("#refreshContent").click(function () {
        $('#upsCsvContent').html("<p style='text-align: center;'>loading...</p>");
        $('#upsCsvContent').load("../php/ordenes/upsCsvData.php?carrier=" + $("#carriers").val());
        fillFormIds();
    });

    function check_file() {
        str = document.getElementById('csv').value.toUpperCase();
        suffix = ".CSV";
        if (str.indexOf(suffix, str.length - suffix.length) == -1) {
            alert('wrong file type. file must be CSV');
            document.getElementById('csv').value = '';
        }
    }

    Date.prototype.toDateInputValue = (function () {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0, 10);
    });

    $("#editTrackingButton").click(function () {
        $('#editMessage').html("<p style='text-align: center;'>saving...</p>");
        $("#editTrackingButton").prop("disabled", false);
        var tOrderId = $("#editOrderId").val();
        var tTrackingNumber = $("#editTrackingNumber").val();
        var tShipDate = $("#editShipDate").val();
        var tShipCarrier = $("#editShippingCarrier").val();
        var tShipMethod = $("#editShippingMethod").val();
        var tPayDate = $("#editPayDate").val();
        var tPayRefNum = $("#editPayRefNumber").val();

        $.ajax({
            url: "../php/walmart/editTracking.php",
            type: "POST",
            data: {
                tOrderId: tOrderId,
                tTrackingNumber: tTrackingNumber,
                tShipDate: tShipDate,
                tShipCarrier: tShipCarrier,
                tShipMethod: tShipMethod,
                tPayDate: tPayDate,
                tPayRefNum: tPayRefNum,
            },
            success: function (response) {
                console.log(response)
                $('#editMessage').html("<p style='text-align: center; color: green;'>success...</p>");
                $("#editTrackingButton").prop("disabled", true);
                refreshContent();
            },
            error: function (response) {
                console.log(response)
                $('#editMessage').html("<p style='text-align: center; color: red;'>error...</p>");
            }
        });
    });

    $("#cancelShippingButton").click(function () {
        console.log("!");
        $('#cancelMessage').html("<p style='text-align: center;'>cancelling...</p>");

        var tOrderId = $("#cancelOrderId").val();

        $.ajax({
            url: "../php/ordenes/cancelOrder.php",
            type: "POST",
            data: {
                tOrderId: tOrderId,
            },
            success: function (response) {
                console.log(response)
                $('#cancelMessage').html("<p style='text-align: center; color: green;'>success...</p>");
                $("#cancelShippingButton").prop("disabled", true);
                refreshContent();
            },
            error: function (response) {
                console.log(response)
                $('#cancelMessage').html("<p style='text-align: center; color: red;'>error...</p>");
            }
        });
    });

    function changePackage() {
        $("#lblDLength").val($("#packagesDrop").find(':selected').attr('largo'));
        $("#lblDWidth").val($("#packagesDrop").find(':selected').attr('ancho'));
        $("#lblDHeight").val($("#packagesDrop").find(':selected').attr('alto'));
    }

    function quoteFedex() {

        $("#plan1").html("loading...");
        $("#plan2").html("loading...");
        $("#plan3").html("loading...");
        $("#plan4").html("loading...");

        var orderId = $("#tOrderId").val();
        var tWeightUnit = $("#lblWUnit").val();
        var tWeight = $("#lblW").val();
        var tDimensionUnit = $("#lblDUnit").val();
        var tHeight = $("#lblDHeight").val();
        var tLength = $("#lblDLength").val();
        var tWidth = $("#lblDWidth").val();
        var tDate = $("#quoteShippingDate").val();


        //plan 1
        $.ajax({
            url: "../php/ordenes/fedexQuoteHelper.php",
            type: "POST",
            data: {
                method: "quote",
                id: orderId,
                plan: "plan1",
                lblWUnit: tWeightUnit,
                lblW: tWeight,
                lblDUnit: tDimensionUnit,
                lblDHeight: tHeight,
                lblDLength: tLength,
                lblDWidth: tWidth,
                shipDate: tDate,
            },
            success: function (response) {
                console.log("S" + response);
                $("#plan1").html("$" + response);
            },
            error: function (response) {
                console.log("E" + response)
            }
        });
        //plan 2
        $.ajax({
            url: "../php/ordenes/fedexQuoteHelper.php",
            type: "POST",
            data: {
                method: "quote",
                id: orderId,
                plan: "plan2",
                lblWUnit: tWeightUnit,
                lblW: tWeight,
                lblDUnit: tDimensionUnit,
                lblDHeight: tHeight,
                lblDLength: tLength,
                lblDWidth: tWidth,
                shipDate: tDate,
            },
            success: function (response) {
                console.log("S" + response);
                $("#plan2").html("$" + response);
            },
            error: function (response) {
                console.log("E" + response)
            }
        });
        //plan 3
        $.ajax({
            url: "../php/ordenes/fedexQuoteHelper.php",
            type: "POST",
            data: {
                method: "quote",
                id: orderId,
                plan: "plan3",
                lblWUnit: tWeightUnit,
                lblW: tWeight,
                lblDUnit: tDimensionUnit,
                lblDHeight: tHeight,
                lblDLength: tLength,
                lblDWidth: tWidth,
                shipDate: tDate,
            },
            success: function (response) {
                console.log("S" + response);
                $("#plan3").html("$" + response);
            },
            error: function (response) {
                console.log("E" + response)
            }
        });
        //plan 4
        $.ajax({
            url: "../php/ordenes/fedexQuoteHelper.php",
            type: "POST",
            data: {
                method: "quote",
                id: orderId,
                plan: "plan4",
                lblWUnit: tWeightUnit,
                lblW: tWeight,
                lblDUnit: tDimensionUnit,
                lblDHeight: tHeight,
                lblDLength: tLength,
                lblDWidth: tWidth,
                shipDate: tDate,
            },
            success: function (response) {
                console.log("S" + response);
                $("#plan4").html("$" + response);
            },
            error: function (response) {
                console.log("E" + response)
            }
        });
    }

    $("#allCheckboxes").change(function () {
        $(".orderidchk").prop("checked", $(this).is(":checked"))
    });


    function openSinglePackage() {
        $("#singlePackage").dialog({
            modal: true,
            height: 450,
            width: 1000,
            close: function (event, ui) {
                $("#singlePackage").dialog("close");
                $("#singlePackageOrderID").val("");
                $("#singlePackageMessage").html("");
                $("#singlePackageContent").html("");
                $("#singlePackageLimits").val("");
            }
        });
        $("#singlePackage").dialog("open");
    }

    $("#loadOrder").click(function () {
        var orderID = $("#singlePackageOrderID").val();
        $.ajax({
            url: "../php/ordenes/singlePackageLabel.php",
            type: "POST",
            data: {
                orderID: orderID,
            },
            success: function (response) {
                $("#singlePackageContent").html(response);
                $('#singlePackageDetail').DataTable({
                    "paging": false,
                    "filter": false,
                    "info": false,
                    "scrollCollapse": true
                });
                getLimits();
            },
            error: function (response) {
                $("#singlePackageMessage").html("ERROR...");
            }
        });
    });

    function getLimits() {
        var values = "";
        $('.singlePackageProduct').each(function () {
            values += "{\"" + this.name + "\":" + this.value + "},";
        });
        values = values.slice(0,-1);
        $("#singlePackageLimits").val(values);
    }



</script>
<style>
    .divRow {
        width: 100%;
        min-height: 25px;
        margin: 5px 0px 5px 0px;
    }

    .divCol {
        float: left;
        margin: 10px;
    }

    .gridRow {
        width: 100%;
        min-height: 25px;
    }

    .upsCsvCellS {
        width: 5%;
    }

    .upsCsvCellL {
        width: 30%;
    }

    .upsCsvCell {
        width: 15%;
        height: 25px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stackHorizontally {
        float: left;
    }

    #upsCsvContent {
        height: 400px;
        overflow: auto;
    }

    .shadowRow {
        background-color: #e8e8e8;
    }

    .row1 {
        width: 100%;
        height: 23px;
    }

    .col2 {
        width: 50%;
        float: left;
    }

    .labelCol {
        width: 25%;
        float: left;
        padding: 5px;
    }

    .alignCenter {
        text-align: center;
    }

    .inputFull {
        width: 100%;
    }
</style>