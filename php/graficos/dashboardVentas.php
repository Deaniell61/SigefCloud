<?php
require_once('../../php/fecha.php');
require_once('../../php/sesiones.php');
$idioma=idioma();
include('../../php/idiomas/'.$idioma.'.php');
session_start();
verTiempo3();
?>
<div style="position:absolute; width:97%; top:200px;">
<script src="../js/lib/d3.v3.min.js" charset="utf-8"></script>
<script src="../js/lib/c3.min.js"></script>               
                	<select class='entradaTexto' style="float:left;" id="filtro" onChange="cargarGrafico('1',document.getElementById('filtro').value,'<?php echo $_SESSION['codprov'];?>','');">
                    	<option value="1" selected>Hoy</option>
                        <option value="3">Ultimos 3 dias</option>
                        <option value="7">Ultimos 7 dias</option>
                        <option value="14">Ultimos 14 dias</option>
                        <option value="31">Ultimos 31 dias</option>
                        <option value="60">Ultimos 60 dias</option>
                        <option value="90">Ultimos 90 dias</option>
                        <option value="120">Ultimos 120 dias</option>
                        <option value="13">Inicio de los tiempos</option>
                    </select>
                    
               </div>
               
               <div><?php echo $lang[$idioma]['Dashboard'];?></div>
               <br>
               <div id="total"></div>
               <center>
             
<div id="chart" style=" width:500px;height: 300px;max-height: 300px;margin-left: 150px;position: absolute;"></div>
<div id="chart2" style="width: 500px;height: 300px;max-height: 300px;position: relative;margin-left: 850px;right: 200px;"></div>

<div>
<div id="PromD" class="tablaEstadisticasDatos" >
	<center>
    <div id="PromD1" class="tituloPromedio">
    	<strong><?php echo $lang[$idioma]['DiarioVentas'];?></strong>
    </div>
    </center>
    <div id="PromD2" class="averaPromedio">
    	<span style="font-size:24px;" id="PromD2A"></span>
        <br><?php echo $lang[$idioma]['Averg'];?>
    </div>
    <div id="PromD3" class="maxMinPromedio">
    		Max:<span id="PromD2MA"></span>
       <br> Min:<span id="PromD2MI"></span>
    </div>
    
    <div id="PromD4" class="miniEstadisticaPromedio">
    	
    </div>
    
</div>
<div id="PromO" class="tablaEstadisticasDatos" >
	<center>
    <div id="PromO1" class="tituloPromedio">
    	<strong><?php echo $lang[$idioma]['NoOrdenes'];?></strong>
    </div>
    </center>
    <div id="PromO2" class="averaPromedio">
    	<span style="font-size:24px;" id="PromO2A"></span>
        <br><?php echo $lang[$idioma]['Averg'];?>
    </div>
    <div id="PromO3" class="maxMinPromedio">
    		Max:<span id="PromO2MA"></span>
       <br> Min:<span id="PromO2MI"></span>
    </div>
    
    <div id="PromO4" class="miniEstadisticaPromedio">
    	
    </div>
</div>
<div id="PromTO" class="tablaEstadisticasDatos" >
	<center>
    <div id="PromTO1" class="tituloPromedio">
    	<strong><?php echo $lang[$idioma]['TipicaOrden'];?></strong>
    </div>
    </center>
    <div id="PromTO2" class="averaPromedio">
    	<span style="font-size:24px;" id="PromTO2A"></span>
        <br><?php echo $lang[$idioma]['Averg'];?>
    </div>
    <div id="PromTO3" class="maxMinPromedio">
    		Max:<span id="PromTO2MA"></span>
       <br> Min:<span id="PromTO2MI"></span>
    </div>
    
    <div id="PromTO4" class="miniEstadisticaPromedio">
    	titulo
    </div>
</div>
</div>

<div>
<div id="best5" style="display: inline-table;width: 50px;height: 250px;text-align: left;" ></div>
<div id="best5D" style="display: inline-table;width: 50px;height: 250px;text-align: left;"></div>
</div>

<div id="query"></div>

<div id="comoGraficar">
<script>
cargarGrafico('1',document.getElementById('filtro').value,'<?php echo $_SESSION['codprov'];?>','');


</script>
</div>