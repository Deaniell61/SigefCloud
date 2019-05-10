<?php
session_start();
require_once('../../php/fecha.php');
$idioma = idioma();
include('../../php/idiomas/' . $idioma . '.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
function getList() {

    $tbody = "";
    $codprov = $_SESSION["codprov"];
    $isProv = "";
    if ($_SESSION["rol"] != "U") {
        $isProv = "
            WHERE
                CODPROV = '$codprov'
        ";
    }
    $query = "
    SELECT 
        ID, FECHA, NOMBRE
    FROM
        cot_emb_enc
    $isProv
    ORDER BY FECHA DESC;
    ";
    $result = mysqli_query(conexionProveedorLocal($_SESSION["pais"]), $query);
    while ($row = mysqli_fetch_array($result)) {
        $id = $row["ID"];
        $nombre = $row["NOMBRE"];
        $fecha = explode(" ", $row["FECHA"])[0];
        $pdf = "pdf";
        $tbody .= "
            <tr>
                <td><a href='#' docid='$id' class='cotLink'>$id</a></td>
                <td>$fecha</td>
                <td>$nombre</td>
                <td><image docid='$id' class='getPDF' src='../../images/down.png'></image></td>
            </tr>
        ";
    }
    $table = "    
        <table id='summaryTable' class='table'>
            <thead>
                <tr>
                    <td>
                        id
                    </td>
                    <td>
                        fecha
                    </td>
                    <td class='td50'>
                        nombre
                    </td>
                    <td>
                        pdf
                    </td>
                </tr>
            </thead>
            <tbody>
                $tbody
            </tbody>
        </table>
    ";
    $response = $table;
    return $response;
}

?>
<script src="../../js/jquery.tabletojson.min.js"></script>
<div id="content">
    <div id="controls"
         class="group">
        <div class="row">
            <input id="tags"
                   class="entradaTexto smallInput">
            <image disabled id='getSearchPDF' docid='$id' src='../../images/down.png'/>
            <input id="cargarCot"
                   class="cmd button button-highlight button-pill"
                   type="button"
                   value="<?php echo $lang[$idioma]['cargar']; ?>">
        </div>
        <br>
        <div class="row">
            <?php
            echo getList();
            ?>
        </div>
    </div>
    <div id="enc"
         class="group">
        <!--form and image-->
        <div class="row">
            <!--form-->
            <div id="left" class="stackHorizontally mediumCell">
                <div class="row">
                    <div class="oneThirdCell stackHorizontally bold alignRight ">
                        <?= $lang[$idioma]['id'] ?>
                    </div>
                    <div class="twoThirdsCell stackHorizontally alignLeft">
                        <input disabled
                               id="COTID"
                               class="entradaTexto fullInput"
                               type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="oneThirdCell stackHorizontally bold alignRight ">
                        <?= $lang[$idioma]['nomEmpresa'] ?>
                    </div>
                    <div class="twoThirdsCell stackHorizontally alignLeft">
                        <input id="NOMBRE"
                               class="entradaTexto fullInput"
                               type="text" value="<?php
                        if ($_SESSION['rol'] == 'P') {
                            echo $_SESSION['nomEmpresa'];
                        }
                        ?>">
                    </div>
                </div>
                <?php
                if ($_SESSION["rol"] == "U") {
                    ?>
                    <div class="row">
                        <div class="oneThirdCell stackHorizontally bold alignRight ">
                            <?= $lang[$idioma]['numEmpresas'] ?>
                        </div>
                        <div class="twoThirdsCell stackHorizontally alignLeft">
                            <input id="empQuantity"
                                   class="entradaTexto fullInput"
                                   type="number"
                                   min="1"
                                   max="20"
                                   value="1">
                        </div>
                    </div>
                    <?
                }
                ?>
                <div class="row">
                    <div class="oneThirdCell stackHorizontally bold alignRight ">
                        <?= $lang[$idioma]['tipoContenedor'] ?>
                    </div>
                    <div class="smallCell stackHorizontally alignLeft">
                        <select id="tipoContenedor" class="entradaTexto fullInput">
                            <option value="20_seco">20' seco</option>
                            <option value="40_seco">40' seco</option>
                            <option value="20_refrigerado">20' refrigerado</option>
                            <option value="40_refrigerado">40' refrigerado</option>
                        </select>
                    </div>
                    <div class="oneThirdCell stackHorizontally bold alignLeft ">
                        <input id="isPallet" type="checkbox"> <?= $lang[$idioma]['isPallet'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="oneThirdCell stackHorizontally bold alignRight ">
                        <?= $lang[$idioma]['numPallets'] ?>
                    </div>
                    <div class="twoThirdsCell stackHorizontally alignLeft">
                        <input id="palletsQuantity"
                               class="entradaTexto fullInput"
                               type="number"
                               min="1"
                               max="20"
                               value="1">
                    </div>
                </div>
                <div hidden class="row">
                    <div class="oneThirdCell stackHorizontally bold alignRight ">
                        <?= $lang[$idioma]['tipoTarifa'] ?>
                    </div>
                    <div class="twoThirdsCell stackHorizontally alignLeft">
                        <select disabled id="tipoTarifa" class="entradaTexto fullInput">
                            <option value="1">Fijo</option>
                            <option value="2">Descuento</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="oneThirdCell stackHorizontally bold alignRight ">
                        <?= $lang[$idioma]['Fecha'] ?>
                    </div>
                    <div class="twoThirdsCell stackHorizontally alignLeft">
                        <input id="date"
                               class="entradaTexto fullInput"
                               type="date" value="<?php echo date('Y-m-d') ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="oneThirdCell stackHorizontally bold alignRight ">
                        <?= $lang[$idioma]['discountDirect'] ?>
                    </div>
                    <div class="twoThirdsCell stackHorizontally alignLeft">
                        <input id="discountDirectInput"
                               class="entradaTexto fullInput"
                               type="text" min="0" step=".01" value="0">
                    </div>
                </div>
                <div class="row">
                    <div class="oneThirdCell stackHorizontally bold alignRight ">
                        <?= $lang[$idioma]['discountPercentage'] ?>
                    </div>
                    <div class="twoThirdsCell stackHorizontally alignLeft">
                        <input id="discountPercentageInput"
                               class="entradaTexto fullInput"
                               type="number" min="0" step=".01" value="0">
                    </div>
                </div>
                <?php
                if ($_SESSION["rol"] == "U") {
                    ?>
                    <div class="row">
                        <div class="oneThirdCell stackHorizontally bold alignRight ">
                            <?= $lang[$idioma]['signature'] ?>
                        </div>
                        <div class="twoThirdsCell stackHorizontally alignLeft">
                            <select id="SIGNATURE" class="entradaTexto fullInput">
                                <?php
                                $codEmpresa = $_SESSION["codEmpresa"];
                                $usersQuery = "
                                        SELECT 
                                            us.CODUSUA, us.NOMBRE, us.APELLIDO, us.EMAIL
                                        FROM
                                            cat_empresas AS emp
                                                INNER JOIN
                                            sigef_accesos AS acc ON emp.CODEMPRESA = acc.CODEMPRESA
                                                INNER JOIN
                                            sigef_usuarios AS us ON acc.CODUSUA = us.CODUSUA
                                        WHERE
                                            emp.CODEMPRESA = '$codEmpresa'
                                        GROUP BY us.CODUSUA
                                        ORDER BY us.APELLIDO;
                                    ";

                                $usersResult = mysqli_query(conexion(""), $usersQuery);

                                while ($usersRow = mysqli_fetch_array($usersResult)) {
                                    $tCod = $usersRow["CODUSUA"];
                                    $tNombre = $usersRow["NOMBRE"];
                                    $tApellido = $usersRow["APELLIDO"];
                                    $tEmail = $usersRow["EMAIL"];
                                    $selected = ($tCod == $_SESSION["codigo"]) ? "selected" : "";
                                    echo "<option $selected value='$tCod'>$tNombre $tApellido - $tEmail</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?
                }

                else {
                    ?>
                    <select disable hidden id="SIGNATURE">
                        <option value="<?php echo $_SESSION["codigo"] ?>"><?php echo $_SESSION["codigo"] ?></option>
                    </select>
                    <?
                }
                ?>
            </div>
            <!--image-->
            <div id="right" class="stackHorizontally mediumCell">
            </div>
        </div>
        <!--controls-->
        <div class="row">
            <input id="cotizarButton"
                   class="cmd button button-highlight button-pill"
                   type="button"
                   value="<?php echo $lang[$idioma]['cotizar']; ?>">
            <input disabled
                   id="saveButton"
                   class="cmd button button-highlight button-pill"
                   type="button"
                   value="<?php echo $lang[$idioma]['Guardar']; ?>">
            <image hidden id='getCurrentPDF' src='../../images/down.png'/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="newCot"
                   class="cmd button button-highlight button-pill"
                   type="button"
                   value="<?php echo $lang[$idioma]['nueva']; ?>">
        </div>
    </div>
    <div id="det"
         class="group">
        <div id="countryExpenses"></div>
        <div id="usaExpenses"></div>
        <div id="summary"></div>
    </div>
</div>
<script>
    showContInfo();
    $("#cotizarButton").click(function () {
        if ($("#palletsQuantity").val() != "") {

            $("#saveButton").prop('disabled', false);

            $("#countryExpenses").html("");
            $("#usaexpenses").html("");
            $("#summary").html("");

            var empQuant = ($("#empQuantity").length) ? $("#empQuantity").val() : 1;

            $.ajax({
                url: "../php/comercializacion/cotizadorEmbarqueFunctions.php",
                type: "POST",
                data: {
                    method: "getCountryExpenses",
                    quantity: $("#palletsQuantity").val(),
                    tipo: $("#tipoContenedor").val().split("_")[0],
                    empQuantity: empQuant,
                    isPallet: $("#isPallet").is(":checked"),
                    isRefri: $("#tipoContenedor").val().split("_")[1],
                    tipoTarifa: $("#tipoTarifa").val(),
                },
                success: function (response) {
                    console.log(response);
                    $("#countryExpenses").html(response);
                },
                error: function (response) {
                    console.log(response);
                }
            });
            $.ajax({
                url: "../php/comercializacion/cotizadorEmbarqueFunctions.php",
                type: "POST",
                data: {
                    method: "getUSAExpenses",
                    quantity: $("#palletsQuantity").val(),
                    tipo: $("#tipoContenedor").val().split("_")[0],
                    empQuantity: empQuant,
                    isPallet: $("#isPallet").is(":checked"),
                    isRefri: $("#tipoContenedor").val().split("_")[1],
                    tipoTarifa: $("#tipoTarifa").val(),
                },
                success: function (response) {
                    $("#usaExpenses").html(response);
                }
            });
            setTimeout(function () {
                $.ajax({
                    url: "../php/comercializacion/cotizadorEmbarqueFunctions.php",
                    type: "POST",
                    data: {
                        method: "getSummary",
                        quantity: $("#palletsQuantity").val(),
                        empQuantity: empQuant,
                    },
                    success: function (response) {
                        $("#summary").html(response);
                    }
                });
            }, 1000);
        }
        else {
//            alert("Ingrese");
        }
    });

    $("#saveButton").click(function () {
        if ($("#COTID").val() == "") {
            var NOMBRE = $("#NOMBRE").val();
            var CLIENTES = ($("#empQuantity").length) ? $("#empQuantity").val() : 1;
            var TIPO = $("#tipoContenedor").val().split("_")[0];
            var ESPALLET = $("#isPallet").is(":checked");
            var ESREFRI = $("#tipoContenedor").val().split("_")[1];
            var CANTIDAD = $("#palletsQuantity").val();
            var TARIFA = $("#tipoTarifa").val();
            var FECHA = $("#date").val();
            var SIGNATURE = $("#SIGNATURE").val();
            var DESCDIR = $("#discountDirectInput").val();
            var DESCPOR = $("#discountPercentageInput").val();
            console.log(TARIFA);
            var countryExpensesTable = $('#countryExpensesTable').tableToJSON({
                headings: ["Gastos Operativos", "Precio", "Cantidad", "Total Costo"],
            });
            var usaExpensesTable = $('#usaExpensesTable').tableToJSON();

            $.ajax({
                url: "../php/comercializacion/cotizadorEmbarqueFunctions.php",
                type: "POST",
                data: {
                    method: "saveData",
                    NOMBRE: NOMBRE,
                    CLIENTES: CLIENTES,
                    TIPO: TIPO,
                    ESPALLET: ESPALLET,
                    ESREFRI: ESREFRI,
                    CANTIDAD: CANTIDAD,
                    TARIFA: TARIFA,
                    FECHA: FECHA,
                    SIGNATURE: SIGNATURE,
                    DESCDIR: DESCDIR,
                    DESCPOR: DESCPOR,
                    bloque1: JSON.stringify(countryExpensesTable),
                    bloque2: JSON.stringify(usaExpensesTable),
                },
                success: function (response) {
                    $("#COTID").val(response);
                    $("#getCurrentPDF").removeAttr("hidden");
                    alert("Guardado exitosamente, ID: " + response);
                },
                error: function (response) {
                    alert("Por favor intente mas tarde...");
                }
            });
        }
    })

    $(".getPDF").click(function (event) {
        var docid = event.target.getAttribute("docid");
        window.open("../php/comercializacion/cotizadorEmbarqueFunctions.php?method=getPDF&DOCID=" + docid);
    });
    $('#summaryTable').DataTable({
        "paging": true,
        "filter": false,
        "info": false,
        "scrollY": "175px",
        "scrollCollapse": true,
        "pageLength": 4,
        "order": [[0, "desc"]]
    });

    $("#tags").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "../php/comercializacion/cotizadorEmbarqueFunctions.php",
                dataType: "json",
                data: {
                    method: "searchID",
                    term: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 3
    });

    $("#getSearchPDF").click(function (event) {

        var searchTerm = $("#tags").val();

        if (searchTerm != "") {
            $.ajax({
                url: "../php/comercializacion/cotizadorEmbarqueFunctions.php",
                type: "POST",
                data: {
                    method: "confirmSearch",
                    docid: searchTerm,
                },
                success: function (response) {
                    if (response == 1) {
                        window.open("../php/comercializacion/cotizadorEmbarqueFunctions.php?method=getPDF&DOCID=" + searchTerm);
                    }
                    else {
                        alert("Cotizacion no existe...");
                    }
                },
            });
        }
    });

    $("#getCurrentPDF").click(function (event) {
        if ($("#COTID").val() != "") {
            window.open("../php/comercializacion/cotizadorEmbarqueFunctions.php?method=getPDF&DOCID=" + $("#COTID").val());
        }
    });

    $("#newCot").click(function (event) {
        formulario("18");
    });

    $("#tipoContenedor").change(function () {
        showContInfo();
    });

    function showContInfo() {
        var tTipoContenedor = $("#tipoContenedor").val().split("_")[0];
        $.ajax({
            url: "../php/comercializacion/cotizadorEmbarqueFunctions.php",
            type: "POST",
            data: {
                method: "getContInfo",
                id: $("#tipoContenedor").val(),
            },
            success: function (response) {
                $("#right").html(response);
            }
        });
    }
    ;

    $(".cotLink").click(function (event) {
        var docid = event.target.getAttribute("docid");
        cargarCotizacion(docid);
    });

    $("#cargarCot").click(function (event) {
        if ($("#tags").val() != "") {
            var docid = $("#tags").val();
            $.ajax({
                url: "../php/comercializacion/cotizadorEmbarqueFunctions.php",
                type: "POST",
                data: {
                    method: "confirmSearch",
                    docid: docid,
                },
                success: function (response) {
                    if (response == 1) {

                        cargarCotizacion(docid);
                    }
                    else {
                        alert("Cotizacion no existe...");
                    }
                },
            });
        }
    });

    function cargarCotizacion(docid) {
        $.ajax({
            url: "../php/comercializacion/cotizadorEmbarqueFunctions.php",
            type: "POST",
            data: {
                method: "loadCotEnc",
                id: docid,
            },
            success: function (response) {
                $("#cotizarButton").prop('disabled', true);
                $("#getCurrentPDF").removeAttr("hidden");
                var data = JSON.parse(response);
                $("#COTID").val(data["ID"]);
                $("#NOMBRE").val(data["NOMBRE"]);
                $("#empQuantity").val(data["CLIENTES"]);
                $("#tipoContenedor").val(data["TIPO"] + "_" + ((data["ES_REFRI"] == "0") ? "seco" : "refrigerado"));
                $("#tipoContenedor").change();
                $("#isPallet").prop('checked', (data["ES_PALLET"] == "1") ? true : false);
                $("#palletsQuantity").val(data["CANTIDAD"]);
                $("#tipoTarifa").val(data["TARIFA"]);
                $("#date").val(data["FECHA"].split(" ")[0]);
                $("#SIGNATURE").val(data["SIGNATURE"]);
                $("#discountDirectInput").val(data["DESCDIR"]);
                $("#discountPercentageInput").val(data["DESCPOR"]);
            }
        });

        $.ajax({
            url: "../php/comercializacion/cotizadorEmbarqueFunctions.php",
            type: "POST",
            data: {
                method: "loadCot",
                id: docid,
            },
            success: function (response) {
                $("#det").html(response);
            }
        });
    }

    $("#discountDirectInput").on("change keyup", function () {
        if ($("#discountDirectInput").val() != 0) {
            $("#discountPercentageInput").val(0);
        }
    })

    $("#discountPercentageInput").on("change keyup", function () {
        if($("#discountPercentageInput").val() != 0){
            $("#discountDirectInput").val(0);
        }
    })
</script>
<style>
    #content {
        width: 100%;
        height: 100%;
    }
    #controls {
        width: 90%;
        margin: 10px auto;
        padding: 15px;
    }
    #enc {
        width: 90%;
        margin: 10px auto;
        padding: 15px;
    }
    #det {
        width: 90%;
        margin: 10px auto;
        padding: 15px;
    }
    .row {
        width: 100%;
        height: 100%;
        margin: 2px;
    }
    .smallCell {
        width: 25%;
        padding: 0px 10px 0px 10px;
    }
    .mediumCell {
        width: 50%;
        padding: 0px 10px 0px 10px;
    }
    .largeCell {
        width: 75%;
        padding: 0px 10px 0px 10px;
    }
    .fullCell {
        width: 100%;
        padding: 0px 10px 0px 10px;
    }
    .oneThirdCell {
        width: 33%;
        padding: 0px 10px 0px 10px;
    }
    .twoThirdsCell {
        width: 66%;
        padding: 0px 10px 0px 10px;
    }
    .stackHorizontally {
        float: left;
    }
    .bold {
        font-weight: bold;
    }
    .alignRight {
        text-align: right;
    }
    .alignLeft {
        text-align: left;
    }
    .group {
        border: outset;
        border-width: 1px;
        border-radius: 10px;
    }
    .smallInput {
        width: 25%;
        height: 30px;
    }
    .mediumInput {
        width: 50%;
        height: 30px;
    }
    .largeInput {
        width: 75%;
        height: 30px;
    }
    .fullInput {
        width: 100%;
        height: 30px;
    }
    .table {
        width: 100%;
    }
    .td10 {
        width: 10%;
    }
    .td50 {
        width: 50%;
    }
    #contimage {
        display: block;
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        vertical-align: bottom;
        text-align: center;
    }
    #contDescription.table, th, td {
        border: 0px solid black;
        border-collapse: collapse;
        padding: 2px 5px 2px 5px;
    }
    .customLeft {
        width: 35%;
    }
    .customRight {
        width: 65%;
    }
</style>