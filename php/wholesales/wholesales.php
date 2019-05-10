<?php
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
$idioma = idioma();
include('../../php/idiomas/' . $idioma . '.php');

function getSelectEmp() {
    $select = "";
    $codEmpresa = $_SESSION["codEmpresa"];
    $empresasQuery = "
                SELECT 
                    codprov, nombre
                FROM
                    cat_prov
                WHERE
                    codempresa = '$codEmpresa' AND estado = 2
                        AND tipo = 1;
            ";
    $empresasResult = mysqli_query(conexion($_SESSION["pais"]), $empresasQuery);
    $select .= "<select id='empSelect' class='entradaTexto fullInput'>";
    while ($empresasRow = mysqli_fetch_array($empresasResult)) {
        $nombre = $empresasRow["nombre"];
        $codProv = $empresasRow["codprov"];
        $select .= "<option value='$codProv'>$nombre</option>";
    }
    $select .= "</select>";
    return $select;
}


function getSelectVendedores() {
    $select = "";
    $empresasQuery = "
        SELECT 
            codvende, CONCAT(nombre, ' ', apellido) AS nombre
        FROM
            cat_vendedores;
    ";
    $empresasResult = mysqli_query(conexion($_SESSION["pais"]), $empresasQuery);
    $select .= "<select id='vendSelect' class='entradaTexto fullInput'>";
    while ($empresasRow = mysqli_fetch_array($empresasResult)) {
        $nombre = $empresasRow["nombre"];
        $codVende = $empresasRow["codvende"];
        $select .= "<option value='$codVende'>$nombre</option>";
    }
    $select .= "</select>";
    return $select;
}

?>
<div id="content" class="center">
    <div id="filters" class="fullCell">
        <div class="oneThirdCell stackHorizontally">
            <b>Empresa</b>
            <?php
            echo getSelectEmp();
            ?>
        </div>
        <div class="oneThirdCell stackHorizontally">
            <b>Tipo de Filtro</b>
            <select id="filterType" class="entradaTexto stackHorizontally fullInput">
                <option value="MARCA">Marca</option>
<!--                <option value="CODMANUFAC">Manufacturador</option>-->
<!--                <option value="CODPROLIN">Linea</option>-->
            </select>
        </div>
<!--        <div class="oneThirdCell stackHorizontally">-->
<!--            <b>Filtro</b>-->
<!--            <div id="filterDrop"></div>-->
<!--        </div>-->
    </div>
    <br>
    <div id="filters" class="fullCell" style="margin-top: 15px">
        <div class="oneThirdCell stackHorizontally">
            <b>Vendedor</b>
            <?php
            echo getSelectVendedores();
            ?>
        </div>
        <div class="oneThirdCell stackHorizontally">
            <b>Porcentaje Venta</b>
            <br>
            <input id="porcentajeVendedor" type="number" class="entradaTexto fullInput" value="0">
        </div>
<!--        <div class="oneThirdCell stackHorizontally">-->
<!--        </div>-->
    </div>
    <br>
    <br>
    <div id="controls">
        <input id="generateReportButton" type="button" class="cmd button button-highlight button-pill" value="<?php echo $lang[$idioma]['generar']; ?>"/>
        <input disabled id="downloadReportButton" type="button" class="cmd button button-highlight button-pill" value="<?php echo $lang[$idioma]['descargar']; ?>"/>
        <input disabled id="downloadReportButtonV2" type="button" class="cmd button button-highlight button-pill" value="<?php echo $lang[$idioma]['descargar'] . " V2"; ?>"/>
    </div>
    <div id="response">
    </div>
</div>

<div hidden title="Descripcion" id="saveProvDescDialog" style="text-align: center">
    <textarea id="saveProvDescText" type="text" class="entradaTexto fullInput" rows="6"></textarea>
    <input type="button" id="saveProvDesc" class="cmd button button-highlight button-pill" value="Guardar">
</div>
<script>
    $("#downloadReportButton").click(function () {
        var id = ($("#empSelect").length == 1) ? $("#empSelect").val() : -999;
        var filterType = $("#filterType").val();
        var dropFilter = $("#dropFilter").val();
//        console.log(filterType + " " +  dropFilter);
        window.open("../../php/wholesales/wholesaleFunctions.php?method=downloadReport&id=" + id + "&filterType=" + filterType + "&dropFilter=" + dropFilter);
    });
    $("#downloadReportButtonV2").click(function () {
        var id = ($("#empSelect").length == 1) ? $("#empSelect").val() : -999;
        var filterType = $("#filterType").val();
        var dropFilter = $("#dropFilter").val();
        var pventa = $("#porcentajeVendedor").val();
        var vend = $("#vendSelect").val();
//        console.log(filterType + " " +  dropFilter);
        window.open("../../php/wholesales/wholesaleFunctions.php?method=downloadReportV2&id=" + id + "&filterType=" + filterType + "&dropFilter=" + dropFilter + "&pventa=" + pventa + "&vend=" + vend);
    });
    $("#saveProvDesc").click(function () {
        var prov = $("#empSelect").val();
        var desc = $("#saveProvDescText").val();
        $.ajax({
            url: "../../php/wholesales/wholesaleFunctions.php",
            type: "POST",
            data: {
                method: "saveProvDesc",
                prov: prov,
                desc:desc,
            },
            success: function (response) {
                setTimeout(function () {
                    $("#saveProvDescDialog").dialog('close')
                }, 1000);
            }
        });
    });



    $("#generateReportButton").click(function () {
        $("#downloadReportButton").prop("disabled", false);
        $("#downloadReportButtonV2").prop("disabled", false);
        var id = ($("#empSelect").length == 1) ? $("#empSelect").val() : -999;
        var filterType = $("#filterType").val();
        var dropFilter = $("#dropFilter").val();
        $.ajax({
            url: "../../php/wholesales/wholesaleFunctions.php",
            type: "POST",
            data: {
                method: "getReport",
                id: id,
                filterType:filterType,
                dropFilter:dropFilter,
            },
            success: function (response) {
                $("#response").html(response);

                $("#priceReportTable").DataTable({
                    "paging": true,
                    "filter": false,
                    "info": false,
                    "scrollX": true,
                    "scrollCollapse": true,
                    "autoWidth": true,
                    "order": [[0, "asc"]],
                    "pageLength": 5,
                    "columnDefs": [
                        { width: 500, targets: 0 }
                    ],
                });

                $("#imagesTable").DataTable({
                    "paging": true,
                    "filter": false,
                    "info": false,
                    "scrollY": "175px",
                    "scrollCollapse": true,
                    "pageLength": 4,
                });

                setTimeout(function () {
                    $("#priceReportTable").DataTable().draw();
                }, 250);
            }
        });

        $.ajax({
            url: "../../php/wholesales/wholesaleFunctions.php",
            type: "POST",
            data: {
                method: "checkProvDesc",
                prov: $("#empSelect").val(),
            },
            success: function (response) {
                if(response == false){
                    $("#saveProvDescDialog").dialog({
                        width: 350,
                        height: 250,
                        modal: true,
                    });
                }
            }
        });
    });

    $("#empSelect").change(function () {
        $("#filterType").val("MARCA");
        $("#filterType").change();
    });

    $("#filterType").change(function () {

        var emp = ($("#empSelect").length == 1) ? $("#empSelect").val() : -999;
        $.ajax({
            url:"../../php/wholesales/wholesaleFunctions.php",
            type:"POST",
            data:{
                method:"getFilterDrop",
                filterType:this.value,
                emp:emp,
            },
            success:function (response) {
                $("#filterDrop").html(response);
            },
            error:function (response) {
                console.log(response);
            }
        });
    });
    setTimeout(function () {
        $("#filterType").change();
    },500)
</script>
<style>
    #priceReportTable{
        width: 100%;
    }

    #filters{
        height: 25px;
        width: 50%;
        margin: auto;
    }

    #content #response{
        width: 100%;
    }

    #imagesTable{
        width: 100%;
    }

    #imagesTable tr td{
        border: 1px solid black;
        border-collapse: collapse;
    }

    .smallCell{
        width: 25%;
    }

    .mediumCell{
        width: 50%;
    }

    .largeCell{
        width: 75%;
    }

    .fullCell{
        width: 100%;
    }

    .oneThirdCell{
        width: 45%;
        margin-left: 2.5%;
        margin-right: 2.5%;
    }

    .fullInput{
        width:100%;
    }

    .center{
        text-align: center;
    }

    .red{
        background-color: red;
    }

    .bold{
        font-weight: bold;
    }

    .imagePreview{
        max-width: 150px;
        max-height: 150px;
        width: auto;
        height: auto;
    }
    
    .stackHorizontally{
        float: left;
    }
</style>