<?php
require_once('../../php/fecha.php');
$idioma = idioma();
include('../../php/idiomas/' . $idioma . '.php');
?>

<div id="proyEncContainer">
    <!--row1-->
    <div id="proyEncRow1">
        <div id="proyEncSmallCell1"
             class="rightAlign">
            <b><?= $lang[$idioma]['Codigo'] ?></b>
        </div>
        <div id="proyEncSmallCell1">
            <input id="proyEncCodigo"
                   class="entradaTexto proyEncInput1"
                   type="text">
        </div>
        <div id="proyEncSmallCell1"
             class="rightAlign">
            <b><?= $lang[$idioma]['estatus'] ?></b>
        </div>
        <div id="proyEncSmallCell1">
            <input id="proyEncEstatus"
                   class="entradaTexto proyEncInput1"
                   type="text">
        </div>
    </div>

    <!--row2-->
    <div id="proyEncRow1">
        <div id="proyEncSmallCell1"
             class="rightAlign">
            <b><?= $lang[$idioma]['Nombre'] ?></b>
        </div>
        <div id="proyEncLargeCell1">
            <input id="proyEncNombre"
                   class="entradaTexto proyEncInput1"
                   type="text">
        </div>
    </div>

    <!--row3-->
    <div id="proyEncRow1">
        <div id="proyEncSmallCell1"
             class="rightAlign">
            <b><?= $lang[$idioma]['Descripcion'] ?></b>
        </div>
        <div id="proyEncLargeCell1">
            <input id="proyEncNombre"
                   class="entradaTexto proyEncInput1 multiLine"
                   type="text">
        </div>
    </div>

    <!--row4-->
    <div id="proyEncRow1">
        <div id="proyEncSmallCell1"
             class="rightAlign">
            <b><?= $lang[$idioma]['cuentaContable'] ?></b>
        </div>
        <div id="proyEncLargeCell1">
            <input id="proyEncNombre"
                   class="entradaTexto proyEncInput1"
                   type="text">
        </div>
    </div>

    <!--row5-->
    <div id="proyEncRow1">
        <div id="proyEncSmallCell1"
             class="rightAlign">
            <b><?= $lang[$idioma]['tipoProyecto'] ?></b>
        </div>
        <div id="proyEncLargeCell1">
            <input id="proyEncNombre"
                   class="entradaTexto proyEncInput1"
                   type="text">
        </div>
    </div>

    <!--row6-->
    <div id="proyEncRow1">
        <div id="proyEncSmallCell1"
             class="rightAlign">
            <b><?= $lang[$idioma]['contenedor'] ?></b>
        </div>
        <div id="proyEncMediumCell1">
            <input id="proyEncNombre"
                   class="entradaTexto proyEncInput1"
                   type="text">
        </div>
        <div id="proyEncSmallCell1"
             class="">
            <input type="checkbox" name="proyEncPaletizado"
                   value="proyEncPaletizado"><b><?= $lang[$idioma]['paletizado'] ?></b>
        </div>
    </div>
</div>

<style>
    #proyEncContainer {
        width: 100%;
        height: 100%;
        text-align: center;
    }

    #proyEncRow1 {
        width: 80%;
    }

    #proyEncSmallCell1 {
        width: 25%;
        float: left;
        padding: 0px 10px 0px 10px;
    }

    #proyEncMediumCell1 {
        width: 50%;
        float: left;
        padding: 0px 10px 0px 10px;
    }

    #proyEncLargeCell1 {
        width: 75%;
        float: left;
        padding: 0px 10px 0px 10px;
    }

    .rightAlign {
        text-align: right;
    }

    .proyEncInput1 {
        width: 100%;
        height: 25px;
    }

    .multiLine {
        height: 50px;
    }
</style>