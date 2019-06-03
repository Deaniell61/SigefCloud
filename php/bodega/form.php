<?php
header('Content-type: text/html; charset=UTF-8');
require_once('../fecha.php');
$idioma = idioma();
include('../idiomas/' . $idioma . '.php');

session_start();
verTiempo3();

include_once($_SERVER['DOCUMENT_ROOT'] . '/php/objects/products.php');
$tProducts = new products();
include_once($_SERVER['DOCUMENT_ROOT'] . '/php/objects/dropdownBuilder/dropdownBuilder.php');
$tDropdownBuilder = new dropdownBuilder();

?>
<script src="../../js/jquery.tabletojson.min.js"></script>
<script>
function keuyp(event){
    if(event.keyCode == '13'){
            evento = $('#productoId').val()
            cargarOrdenBodega(evento)
            // console.log("pusiste enter");
        }else if(!event.keyCode ){
            evento = $('#productoId').val()
            cargarOrdenBodega(evento)
        }
}
$(document).ready(function () {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;
    // console.log(today);
    $('.fullInputx').addClass('fullInput');
    $('.fullInputx').removeClass('fullInputx');
    document.getElementById('fecha').value = today;
    $('#ordenId').keyup(event => {
        if(event.keyCode == '13'){
            evento = $('#ordenId').val()
            buscarOrdenBodega(evento)
            // console.log("pusiste enter");
        }else if(!event.keyCode ){
            evento = $('#ordenId').val()
            buscarOrdenBodega(evento)
        }
    })

    $('#productoId').keyup(event => {
        if(event.keyCode == '13'){
            evento = $('#productoId').val()
            cargarOrdenBodega(evento)
            // console.log("pusiste enter");
        }else if(!event.keyCode ){
            evento = $('#productoId').val()
            cargarOrdenBodega(evento)
        }
    })

    
});

</script>
<div class="row">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <?= $lang[$idioma]['Bodegas'] ?>
        <?php
            $tDropdownBuilder->build("bodegaCombo", "CODIGO", "NOMBRE", "01", "cat_bodegas", 0, "");
        ?>
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <?= $lang[$idioma]['Movimiento'] ?>
        <select name="movimientosCombo" id="movimientosCombo" class="entradaTextoDrop fullInput" required="required">
            <option value="I" selected>Ingreso a Bodega</option>
            <option value="S">Salida de Bodega</option>
        </select>
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
    </div>

    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <?= $lang[$idioma]['Fecha'] ?>
        <input type="date" name="fecha" id="fecha" class="entradaTextoBuscar fullInput" value="" required="required" pattern="" title="">
    </div>

    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
    </div>

    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <?= $lang[$idioma]['OrdersSummary'] ?>
        <input type="text" name="ordenId" id="ordenId" class="entradaTextoBuscar fullInput">
    </div>
    
    <div class="productoId col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3 hidden" style="margin-top:2%;margin-bottom:2%;">
        Producto
        <input type="text" name="productoId" id="productoId" class="entradaTextoBuscar fullInput">
    </div>
    
    
    
</div>

<div id="ordenesData" style="margin-left:3rem;margin-right:3rem;">
   
</div>
<div id="esperaD"></div>