<?php
require_once('../fecha.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');
session_start();
verTiempo3();
include_once ("upsCsv.php");
?>
<script>
    paisGlobal = "";
    codPaisGlobal = "";

    function buscar() {
        <?php if($_SESSION['rol'] == 'P' or $_SESSION['rol'] == 'U'){
        ?>
        document.getElementById('pais').value = '<?php echo $_SESSION['CodPaisCod'];?>';
        <?php
        }?>
        nombre = document.getElementById('buscar').value;
        paisGlobal = pais = document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;
        filtro = document.getElementById('filtro').value;
        codPaisGlobal = codpais = document.getElementById('pais').value;
        $.ajax({
            url: '../php/ordenes/llenarOrdenes.php',
            type: 'POST',
            data: 'nombre=' + nombre + '&pais=' + pais + '&codpais=' + codpais + '&filtro=' + filtro,
            success: function (resp) {
                $('#datos').html("");
                $('#datos').html(resp);
            }
        });
    }

    function buscare(e) {
        <?php if($_SESSION['rol'] == 'P' or $_SESSION['rol'] == 'U'){
        ?>
        document.getElementById('pais').value = '<?php echo $_SESSION['CodPaisCod'];?>';
        <?php
        }?>
        nombre = document.getElementById('buscar').value;
        pais = document.getElementById('pais').options[document.getElementById('pais').options.selectedIndex].text;
        filtro = document.getElementById('filtro').value;
        codpais = document.getElementById('pais').value;
        if (validateEnter(e)) {
            $.ajax({
                url: '../php/ordenes/llenarOrdenes.php',
                type: 'POST',
                data: 'nombre=' + nombre + '&pais=' + pais + '&codpais=' + codpais + '&filtro=' + filtro,
                success: function (resp) {
                    $('#datos').html("");
                    $('#datos').html(resp);
                }
            });
        }
    }
</script>
<center>
    <?php echo $lang[$idioma]['ordenes']; ?>
</center>
<aside>
    <div id="resultado"></div>
    <div id="resultado1"></div>
    <div class="controls">
        <div class="row">
            <div class="col">
                <input type="button" class='cmd button button-highlight button-pill'
                       onClick="document.getElementById('filtro').value='1';document.getElementById('buscar').value='';buscar();"
                       value="<?php echo $lang[$idioma]['Cancelar']; ?>"/>
                <input type="button" class='cmd button button-highlight button-pill'
                       onClick="window.location.href='inicioEmpresa.php'" value="<?php echo $lang[$idioma]['Salir']; ?>"/>
                <select class='entradaTexto' style="" id="filtro" onChange="buscar();">
                    <option value="1" selected>Hoy</option>
                    <option value="8">Ultima semana</option>
                    <option value="2">Ultimas 24 horas</option>
                    <option value="4">Ultimos 3 dias</option>
                    <option value="8">Ultimos 7 dias</option>
                    <option value="15">Ultimos 14 dias</option>
                    <option value="32">Ultimos 31 dias</option>
                    <option value="60">Ultimos 60 dias</option>
                    <option value="90">Ultimos 90 dias</option>
                    <option value="120">Ultimos 120 dias</option>
                    <option value="13">Inicio de los tiempos</option>
                </select>
            </div>
            <div class="col grey">
<!--                <input class='cmd button button-highlight button-pill' type="button"-->
<!--                       onClick="openNewOrderForm();"-->
<!--                       value="--><?php //echo $lang[$idioma]['newOrder'] ?><!--"/>-->

                <input type="text" class='entradaTexto' id="buscar" name="buscar"
                       placeholder="<?php echo $lang[$idioma]['Buscar'] ?>" value="" onKeyUp="buscare(event);"/>

                <input type="button" class='cmd button button-highlight button-pill' onClick="buscar();"
                       value="<?php echo $lang[$idioma]['Buscar'] ?>"/>

<!--                <input class='cmd button button-highlight button-pill' type="button"-->
<!--                       onClick="abrirNotificacion('',paisGlobal,codPaisGlobal);"-->
<!--                       value="--><?php //echo $lang[$idioma]['Nuevo'] ?><!--"/>-->
            </div>
            <div class="col">

            </div>
            <div class="col grey">
                <span><?php echo $lang[$idioma]['grandtotal']; ?></span>
                <span id="totalGrid"></span>
                <br>
                <img src="../images/excel.png" id="exportExcel" onClick="llamarReporte(12,document.getElementById('filtro'))"
                     style="width:20px; height:20px; float:right; margin-left:5px;margin-top:5px; cursor:pointer;">
<!--                <span>--><?php //echo $lang[$idioma]['grandtotal']; ?><!--</span>-->
<!--                <span id="totalGrid"></span>-->
<!--                <br>-->
                <input class='cmd button button-highlight button-pill' type="button"
                       id="upsCsv_OpenDialog"
                       value="Shipping"/>
            </div>
        </div>
    </div>
    <div style="position:absolute; width:97%; top:160px; text-align:left; z-index:0;">
        <div class="guardar">

        </div>
    </div>
    <div style="position:absolute; width:97%; top:200px;">

    </div>
    <table>
        <tr <?php if ($_SESSION['rol'] == 'P' or $_SESSION['rol'] == 'U') {
            echo "hidden";
        } ?>>
            <td colspan="4">
                <select class='entradaTexto' onChange="buscar();" id="pais" style="width:100%">
                    <?php echo paises(); ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <br>
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>
                <div class="">

                </div>
            </td>
            <!-- <td>
                    <div class="">
                        <input class='cmd button button-highlight button-pill' type="button" onClick="abrirNotificacion('',paisGlobal,codPaisGlobal);" value="<?php echo $lang[$idioma]['Nuevo'] ?>" />
                    </div>
                </td>-->
        </tr>
    </table>
</aside>
<!--<div style="position:absolute; width:97%; top:270px; text-align:right;">-->
<!---->
<!--</div>-->
<div id="datos">
    <script>
        buscar();
    </script>
</div>
</div>


<style>
    .leftSide {
        text-align: right;
        float: left;
        width: 35%;
        font-size: 12px;
    }

    .rightSide {
        float: left;
        width: 50%;
        font-size: 12px;
    }

    .frame {
        border: outset;
        border-width: 1px;
        border-radius: 10px;
    }

    .dataTables_empty {
        display: none;
    }

    ul.ui-autocomplete {
        z-index: 1100;
        max-width: 500px;
        max-height: 400px;
        overflow-y: scroll;
        overflow-x: hidden;
        font-size: 12px;
    }

    .controls{
        height: 75px;
    }

    .row{
        width: 100%;
        height: 100%;
    }

    .col{
        width: 25%;
        height: 100%;
        float: left;
    }

    .grey{
        background-color: white;
    }
</style>