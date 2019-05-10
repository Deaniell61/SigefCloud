<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/php/objects/dropdownBuilder/dropdownBuilder.php');
$tDropdownBuilder = new dropdownBuilder();
?>
<div hidden
     id="cargosProyectoForm"
     title="Cargos">
    <div id="controls">
        <input id="saveCargosProyectoButton"
               type="button"
               class="cmd button button-highlight button-pill"
               value="<?php echo $lang[$idioma]['Guardar']; ?>">
    </div>
    <div id="content">
        <!--row1-->
        <div class="row">
            <div class="smallCell bold rightAlign stackHorizontally">
                <?= $lang[$idioma]['Codigo'] ?>
            </div>
            <div class="largeCell stackHorizontally">
                <input id="codigoInput"
                       class="entradaTexto fullInput"
                       type="text">
            </div>
        </div>
        <!--row2-->
        <div class="row">
            <div class="smallCell bold rightAlign stackHorizontally">
                <?= $lang[$idioma]['Nombre'] ?>
            </div>
            <div class="largeCell stackHorizontally">
                <input id="nombreInput"
                       class="entradaTexto fullInput"
                       type="text">
            </div>
        </div>
        <!--row3-->
        <div class="row">
            <div class="smallCell bold rightAlign stackHorizontally">
                <?= $lang[$idioma]['Aplica'] ?>
            </div>
            <div class="largeCell stackHorizontally">
                <select id="aplicaInput" class="entradaTexto fullInput">
                    <option value="CLI">Cliente</option>
                    <option value="EMB">Embarque</option>
                    <option value="PES">Peso</option>
                    <option value="PAL">Pallet</option>
                    <option value="PRO">Producto</option>
                    <option value="ORD">Orden</option>
                </select>
                <!--
                <input id="aplicaInput"
                       class="entradaTexto fullInput"
                       type="text">
                       -->
            </div>
        </div>
        <!--row4-->
        <div class="row">
            <div class="smallCell bold rightAlign stackHorizontally">
                <?= $lang[$idioma]['formula'] ?>
            </div>
            <div class="largeCell stackHorizontally">
                <input id="formulaInput"
                       class="entradaTexto fullInput multiLine"
                       type="text">
            </div>
        </div>
        <!--row5-->
        <div class="row">
            <div class="smallCell bold rightAlign stackHorizontally">
                <?= $lang[$idioma]['estatus'] ?>
            </div>
            <div class="smallCell stackHorizontally">
                <select id="estatusInput" class="entradaTexto fullInput">
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
                <!--
                <input id="estatusInput"
                       class="entradaTexto fullInput"
                       type="text">
                       -->
            </div>
            <div class="smallCell bold rightAlign stackHorizontally">
                <?= $lang[$idioma]['monto'] ?>
            </div>
            <div class="smallCell stackHorizontally">
                <input id="montoInput"
                       class="entradaTexto fullInput"
                       type="text">
            </div>
        </div>
        <!--row6-->
        <div class="row">
            <div class="smallCell bold rightAlign stackHorizontally">
                <?= $lang[$idioma]['proyecto'] ?>
            </div>
            <div class="largeCell stackHorizontally">
                <?php
                $tDropdownBuilder->build("proyectoInput", "CODTIPROY", "NOMBRE", "1", "cat_tipos_proyecto", 0);
                ?>
                <!--<input id="proyectoInput"
                       class="entradaTexto fullInput"
                       type="text">
                       -->
            </div>
        </div>
        <!--row7-->
        <div class="row">
            <div class="smallCell bold rightAlign stackHorizontally">
                <?= $lang[$idioma]['Precio'] ?>
            </div>
            <div class="largeCell stackHorizontally">
                <input id="precioInput"
                       class="entradaTexto fullInput"
                       type="text">
            </div>
        </div>
    </div>
</div>
<script>
    function openCargosProyecto() {
        if ($("#cargosProyectoForm").hasClass("ui-dialog-content") &&
            $("#cargosProyectoForm").dialog("isOpen")) {
            $("#cargosProyectoForm").dialog("open");
        } else {
            $("#cargosProyectoForm").dialog({
                width: 700,
                height: 450,
                modal: true,
            });
        }
    }

    function closeCargosProyecto() {
        $("#cargosProyectoForm").dialog('close');
    }

    $("#saveCargosProyectoButton").click(function () {
        saveCargosProyectoData();
    });

    function saveCargosProyectoData() {
        var codigo = $("#codigoInput").val();
        var nombre = $("#nombreInput").val();
        var aplica = $("#aplicaInput").val();
        var formula = $("#formulaInput").val();
        var estatus = $("#estatusInput").val();
        var monto = $("#montoInput").val();
        var proyecto = $("#proyectoInput").val();
        var precio = $("#precioInput").val();

        $("#codigoInput").val("");
        $("#nombreInput").val("");
        $("#aplicaInput").val("");
        $("#formulaInput").val("");
        $("#estatusInput").val("");
        $("#montoInput").val("");
        $("#proyectoInput").val("");
        $("#precioInput").val("");

        $.ajax({
            url: "../../php/despachos/funcionesDespachos.php",
            type: "POST",
            data: {
                method: "saveCargoProyecto",
                codigo: codigo,
                nombre: nombre,
                aplica: aplica,
                formula: formula,
                estatus: estatus,
                monto: monto,
                proyecto: proyecto,
                precio: precio,
            },
            success: function (response) {
                console.log(response);
            }
        });

        closeCargosProyecto();
    }
</script>
<style>
    .row {
        width: 100%;
    }
    .smallCell {
        width: 25%;
    }
    .mediumCell {
        width: 50%;
    }
    .largeCell {
        width: 75%;
    }
    .fullCell {
        width: 100%;
    }
    .fullInput {
        width: 100%;
    }
    .stackHorizontally {
        float: left;
    }
    .alignRight {
        text-align: right;
    }
    .alignLeft {
        text-align: left;
    }
    .bold {
        font-weight: bold;
    }
    /**/

    #controls {
        width: 100%;
        height: 15%;
        text-align: center;
    }
    #content {
        width: 100%;
        height: 85%;
        text-align: center;
        padding-top: 15px;
    }
    #row {
        width: 75%;
    }
    #smallCell {
        width: 25%;
        float: left;
        padding: 0px 10px 0px 10px;
    }
    #proyEncMediumCell1 {
        width: 50%;
        float: left;
        padding: 0px 10px 0px 10px;
    }
    #largeCell {
        width: 75%;
        float: left;
        padding: 0px 10px 0px 10px;
    }
    .rightAlign {
        text-align: right;
    }
    .fullInput {
        width: 100%;
    }
    .multiLine {
        height: 50px;
    }
</style>