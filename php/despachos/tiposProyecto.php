<?php
?>

<div hidden
     id="tiposProyectoForm"
     title="Tipos">

    <div id="controls">
        <input id="saveTiposProyectoButton"
               type="button"
               class="cmd button button-highlight button-pill"
               value="<?php echo $lang[$idioma]['Guardar']; ?>">
    </div>

    <div id="content">
        <!--row1-->
        <div class="row">
            <div class="smallCell stackHorizontally bold alignRight">
                <?= $lang[$idioma]['tipoProyecto'] ?>
            </div>
            <div class="largeCell stackHorizontally">
                <input id="tipoProyectoInput"
                       class="entradaTexto fullInput"
                       type="text">
            </div>
        </div>
        <!--row2-->
        <div class="row">
            <div class="smallCell stackHorizontally bold alignRight">
                <?= $lang[$idioma]['Facturacion'] ?>
            </div>
            <div class="largeCell stackHorizontally">
                <input id="diasFacturacionInput"
                       class="entradaTexto fullInput"
                       type="text">
            </div>
        </div>
        <!--row3-->
        <div class="row">
            <div class="smallCell stackHorizontally bold alignRight">
                <?= $lang[$idioma]['funcion'] ?>
            </div>
            <div class="largeCell stackHorizontally">
                <input id="funcionInput"
                       class="entradaTexto fullInput"
                       type="text">
            </div>
        </div>
    </div>
</div>

<script>
    function openTiposProyecto() {
        if ($("#tiposProyectoForm").hasClass("ui-dialog-content") &&
            $("#tiposProyectoForm").dialog("isOpen")) {
            $("#tiposProyectoForm").dialog("open");
        } else {
            $("#tiposProyectoForm").dialog({
                width: 700,
                height: 450,
                modal: true,
            });
        }
    }

    function closeTiposProyecto() {
        $("#tiposProyectoForm").dialog('close');
    }

    $("#saveTiposProyectoButton").click(function () {
        saveTiposProyectoData();
    });

    function saveTiposProyectoData() {
        var tipoProyecto = $("#tipoProyectoInput").val();
        var diasFacturacion = $("#diasFacturacionInput").val();
        var funcion = $("#funcionInput").val();

        $("#tipoProyectoInput").val("");
        $("#diasFacturacionInput").val("");
        $("#funcionInput").val("");

        $.ajax({
            url:"../../php/despachos/funcionesDespachos.php",
            type:"POST",
            data:{
                method:"saveTipoProyecto",
                tipoProyecto: tipoProyecto,
                diasFacturacion: diasFacturacion,
                funcion: funcion,
            },
            success:function (response) {
                console.log(response);
            }
        });

        closeTiposProyecto();
    }
</script>

<style>
    #content{
        width: 100%;
    }

    .row{
        width: 100%;
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

    .fullInput{
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
    .multiLine {
        height: 50px;
    }
</style>