<?php
require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

session_start();
verTiempo();
$codigo=$_POST['codigo'];
$filtro=$_POST['fecha'];
$fecha = date('Y-m-d');
$fecha3 = date('Y-m-d');
$meses="";
if($filtro=='1')
{
	$nuevafecha = strtotime ( '+0 hour' , strtotime ( $fecha ) ) ;
}
else
if($filtro=='13')
{
	$nuevafecha = strtotime ( '-10000 year' , strtotime ( $fecha ) ) ;
}
else
{
	$nuevafecha = strtotime ( '-'.$filtro.' day' , strtotime ( $fecha ) ) ;
}
$nuevafecha3 = strtotime ( '-1 hour' , strtotime ( $fecha3 ) ) ;
$fecha3 = date ( 'Y-m-d' , $nuevafecha3 );
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

switch($_POST['tipo'])
{
	case '1':
	{
		buscarGrafico($codigo,$fecha,$nuevafecha,$fecha3);//activa 8
		break;
	}
	case '2':
	{
		buscarGraficoPie($codigo,$fecha,$nuevafecha,$fecha3);//activa 3
		break;
	}
	case '3':
	{
		buscarBestFive($codigo,$fecha,$nuevafecha,$fecha3,$_POST['id']);//activa 4
		break;
	}
	case '4':
	{
		buscarBestFiveDolar($codigo,$fecha,$nuevafecha,$fecha3,$_POST['id']);//activa 5
		break;
	}
	case '5':
	{
		buscarAveSales($codigo,$fecha,$nuevafecha,$fecha3,$_POST['id']);//activa 6
		break;
	}
	case '6':
	{
		buscarAveCant($codigo,$fecha,$nuevafecha,$fecha3,$_POST['id']);//activa 7
		break;
	}
	case '7':
	{
		buscarAveMODA($codigo,$fecha,$nuevafecha,$fecha3,$_POST['id']);//cierra
		break;
	}
	case '8':
	{
		buscarGraficoP2Avg($codigo,$fecha,$nuevafecha,$fecha3);//activa 9
		break;
	}
	case '9':
	{
		buscarGraficoP3Cant($codigo,$fecha,$nuevafecha,$fecha3);//activa 10
		break;
	}
	case '10':
	{
		buscarGraficoP4Tipica($codigo,$fecha,$nuevafecha,$fecha3);//activa 2
		break;
	}
}

function buscarGrafico($codigo,$fecha,$nuevafecha,$ayer)
{
	require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
	 $squery="select orderid, timoford, sum(grandtotal), orderunits, ordsou, tranum,codorden,shifee,(grandtotal),shicar from tra_ord_enc where (timoford >= '".$nuevafecha." 00:00:00' and timoford <='".$fecha." 23:59:58') and timoford!='' and codprov='".$_SESSION['codprov']."' group by date(timoford) order by timoford ";
	//echo $squery;
		?>
        <script>
							
							
		var chart = c3.generate({
								bindto: '#chart',
								data: {
									x: 'x',
							//        xFormat: '%Y%m%d', // 'xFormat' can be used as custom format of 'x'
									columns: [
										
									],
									type:"bar"
								},
								axis: {
									x: {
										type: 'timeseries',
										tick: {
											format: '%m-%d',
											 rotate: 0
										}
									},
									y: {
											show: true,
											tick: {
												format: d3.format("$")
											}
										}
									
								},
								bar: {
									width: {
										ratio: 0.25// this makes bar width 50% of length between ticks
									}
								},
								color: {
								  pattern: ['#ff571c']
								},
								tooltip: {
									format: {
										value: function (value, id) {
											var format = d3.format('$');
											return format(value);
										}
							
									}
								}
							});
			
							
							
		
					</script>
        
        <?php
		$titulo="['x'";
		$meses="";
		$total=0;
		$contar=0;
		$contarA="a";
		$fechas[]="";
		$fecha2=$nuevafecha;
		$titulo.=",'".$fecha2."'";
			$meses.=",'".($contarA)."'";
			$fechas[$contar]=$fecha2;
			$contar++;
			$contarA++;	
		while($fecha2<($ayer))
		{
			
			
			$nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha2 ) ) ;
			$fecha2 = date ( 'Y-m-d' , $nuevafecha2 );
			$titulo.=",'".$fecha2."'";
			$meses.=",'".($contarA)."'";
			$fechas[$contar]=$fecha2;
			$contar++;
			$contarA++;			
			
		}
		
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				$contar2=0;
				while($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
						//$titulo.=",'".substr($row[1],0,10)."'";
						
						$reem=(ceil($row[2]));
						$meses=verificarDato($reem,$fechas,$contar,substr($row[1],0,10),$meses);
						$total=$total+ceil($row[2]);
				}
				$meses=limpiarDato($reem,$fechas,$contarA,"",$meses);
				echo "
							<script>
							document.getElementById('total').innerHTML='".$lang[$idioma]['TotalDiaGraf']." ".toMoney($total)."';
							chart.load({
									columns: [
										".$titulo."],
										['Sales'".$meses."]
												
											]
											
									});
							
							
							document.getElementById('total').innerHTML='".$lang[$idioma]['TotalDiaGraf']." ".toMoney($total)."';
							
							setTimeout(function(){document.getElementById('chart').style.position='absolute';},200);
							//setTimeout(function(){\$('#cargaLoadG').dialog('close');},500);
							//document.getElementById('query').innerHTML='".str_replace("'","\'",$squery)."';
							cargarGrafico('8',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							</script>
							";
			}
			else
			{
				echo "
							<script>
							
							document.getElementById('total').innerHTML='".$lang[$idioma]['TotalDiaGraf']." ".toMoney($total)."';
							setTimeout(function(){document.getElementById('chart').style.position='absolute';},200);
							cargarGrafico('8',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							//document.getElementById('query').innerHTML='".str_replace("'","\'",$squery)."';
							
							</script>
							";
			}
			mysqli_close(conexion($_SESSION['pais']));
			
		}
}
function buscarGraficoP2Avg($codigo,$fecha,$nuevafecha,$ayer)
{
	require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
	 $squery="select orderid, timoford, avg(grandtotal), orderunits, ordsou, tranum,codorden,shifee,(grandtotal),shicar from tra_ord_enc where (timoford >= '".$nuevafecha." 00:00:00' and timoford <='".$fecha." 23:59:58') and timoford!='' and codprov='".$_SESSION['codprov']."' group by date(timoford) order by timoford";
	//echo $squery;
		?>
        <script>
							document.getElementById('PromD4').style.width = '100%';
							
		
			var chart2 = c3.generate({
								bindto: '#PromD4',
								data: {
									x: 'x',
							//        xFormat: '%Y%m%d', // 'xFormat' can be used as custom format of 'x'
									columns: [
										
									],
									type:"bar"
								},
								axis: {
									x: {
										show: true,
										type: 'timeseries',
										tick: {
											format: '%d',
											 rotate: 0
										},
										 height: 0.1
									},
									y: {
											show: true,
											tick: {
												format: d3.format("$")
											}
										}
									
								},
								bar: {
									width: {
										ratio: 0.25// this makes bar width 50% of length between ticks
									}
								},
								color: {
								  pattern: ['#ff571c']
								},
								tooltip: {
									format: {
										value: function (value, id) {
											var format = d3.format('$');
											return format(value);
										}
							
									}
								}
							});
							
							
		
					</script>
        
        <?php
		$titulo="['x'";
		$meses="";
		$total=0;
		$contar=0;
		$contarA="a";
		$fechas[]="";
		$fecha2=$nuevafecha;
		$titulo.=",'".$fecha2."'";
			$meses.=",'".($contarA)."'";
			$fechas[$contar]=$fecha2;
			$contar++;
			$contarA++;	
		while($fecha2<($ayer))
		{
			
			
			$nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha2 ) ) ;
			$fecha2 = date ( 'Y-m-d' , $nuevafecha2 );
			$titulo.=",'".$fecha2."'";
			$meses.=",'".($contarA)."'";
			$fechas[$contar]=$fecha2;
			$contar++;			
			$contarA++;
		}
		
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				$contar2=0;
				while($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
						//$titulo.=",'".substr($row[1],0,10)."'";
						
						$reem=(ceil($row[2]));
						$meses=verificarDato($reem,$fechas,$contar,substr($row[1],0,10),$meses);
						$total=$total+ceil($row[2]);
				}
				$meses=limpiarDato($reem,$fechas,$contarA,"",$meses);
				echo "
							<script>
							
							chart2.load({
									columns: [
										".$titulo."],
										[''".$meses."]
												
											]
											
									});
							//document.getElementById('query').innerHTML='".str_replace("'","\'",$squery)."';
							cargarGrafico('9',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							</script>
							";
			}
			else
			{
				echo "
							<script>
							cargarGrafico('9',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							//document.getElementById('query').innerHTML='".str_replace("'","\'",$squery)."';
							
							</script>
							";
			}
			mysqli_close(conexion($_SESSION['pais']));
			
		}
}
function buscarGraficoP3Cant($codigo,$fecha,$nuevafecha,$ayer)
{
	require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
	 $squery="select orderid, timoford, count(*), orderunits, ordsou, tranum,codorden,shifee,(grandtotal),shicar from tra_ord_enc where (timoford >= '".$nuevafecha." 00:00:00' and timoford <='".$fecha." 23:59:58') and timoford!='' and codprov='".$_SESSION['codprov']."' group by date(timoford) order by timoford ";
	echo $squery;
		?>
        <script>
							
							document.getElementById('PromO4').style.width = '100%';
		
			var chart3 = c3.generate({
								bindto: '#PromO4',
								data: {
									x: 'x',
							//        xFormat: '%Y%m%d', // 'xFormat' can be used as custom format of 'x'
									columns: [
										
									],
									type:"bar"
								},
								axis: {
									x: {
										show: true,
										type: 'timeseries',
										tick: {
											format: '%d',
											 rotate: 0
										},
										 height: 0.1
									}
									
								},
								bar: {
									width: {
										ratio: 0.25// this makes bar width 50% of length between ticks
									}
								},
								color: {
								  pattern: ['#ff571c']
								}
							});
			
							/*,
								tooltip: {
									format: {
										value: function (value, id) {
											var format = d3.format('$');
											return format(value);
										}
							
									}
								}
								
								,
									y: {
											show: true,
											tick: {
												format: d3.format("$")
											}
										}*/
							
		
					</script>
        
        <?php
		$titulo="['x'";
		$meses="";
		$total=0;
		$contar=0;
		$contarA="a";
		$fechas[]="";
		$fecha2=$nuevafecha;
		$titulo.=",'".$fecha2."'";
			$meses.=",'".($contarA)."'";
			$fechas[$contar]=$fecha2;
			$contar++;	
			$contarA++;	
		while($fecha2<($ayer))
		{
			
			
			$nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha2 ) ) ;
			$fecha2 = date ( 'Y-m-d' , $nuevafecha2 );
			$titulo.=",'".$fecha2."'";
			$meses.=",'".($contarA)."'";
			$fechas[$contar]=$fecha2;
			$contar++;			
			$contarA++;
		}
		
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				$contar2=0;
				while($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
						//$titulo.=",'".substr($row[1],0,10)."'";
						
						$reem=(ceil($row[2]));
						$total=$total+ceil($row[2]);
						$meses=verificarDato($reem,$fechas,$contar,substr($row[1],0,10),$meses);
						
						
				}
				$meses=limpiarDato($reem,$fechas,$contarA,"",$meses);
				echo "
							<script>
							
							chart3.load({
									columns: [
										".$titulo."],
										[''".$meses."]
												
											]
											
									});
							
							
							
							//setTimeout(function(){\$('#cargaLoadG').dialog('close');},500);
							//document.getElementById('query').innerHTML='".str_replace("'","\'",$squery)."';
							cargarGrafico('10',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							</script>
							";
			}
			else
			{
				echo "
							<script>
							$('.c3-legend-item-tile').hide();
							cargarGrafico('10',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							//document.getElementById('query').innerHTML='".str_replace("'","\'",$squery)."';
							
							</script>
							";
			}
			mysqli_close(conexion($_SESSION['pais']));
			
		}
}
function buscarGraficoP4Tipica($codigo,$fecha,$nuevafecha,$ayer)
{
	require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
	$squery="select distinct de.grandtotal,count(de.grandtotal),de.timoford,max(en.oriunipri),min(en.oriunipri) from tra_ord_det en inner join tra_ord_enc de on de.codorden=en.codorden where (de.timoford >= '".$nuevafecha." 00:00:00' and de.timoford <='".$fecha." 23:59:58') and de.timoford!='' and codprov='".$_SESSION['codprov']."' group by date(de.timoford) order by date(de.timoford)";
	echo $squery;
		?>
        <script>
							
							document.getElementById('PromTO4').style.width = '100%';
		
			var chart4 = c3.generate({
								bindto: '#PromTO4',
								data: {
									x: 'x',
									
							//        xFormat: '%Y%m%d', // 'xFormat' can be used as custom format of 'x'
									columns: [
										
									],
									show: false,
									type:"bar"
								},
								axis: {
									x: {
										show: true,
										type: 'timeseries',
										tick: {
											format: '%d',
											 rotate: 0
										},
										 height: 0.1
									},
									y: {
											show: true,
											tick: {
												format: d3.format("$")
											}
										}
									
								},
								bar: {
									width: {
										ratio: 0.25// this makes bar width 50% of length between ticks
									}
								},
								color: {
								  pattern: ['#ff571c']
								},
								tooltip: {
									format: {
										value: function (value, id) {
											var format = d3.format('$');
											return format(value);
										}
							
									}
								}
							});
							
							
		
					</script>
        
        <?php
		$titulo="['x'";
		$meses="";
		$total=0;
		$contar=0;
		$contarA="a";
		$fechas[]="";
		$fecha2=$nuevafecha;
		$titulo.=",'".$fecha2."'";
			$meses.=",'".($contarA)."'";
			$fechas[$contar]=$fecha2;
			$contar++;	
			$contarA++;
		while($fecha2<($ayer))
		{
			
			
			$nuevafecha2 = strtotime ( '+1 day' , strtotime ( $fecha2 ) ) ;
			$fecha2 = date ( 'Y-m-d' , $nuevafecha2 );
			$titulo.=",'".$fecha2."'";
			$meses.=",'".($contarA)."'";
			$fechas[$contar]=$fecha2;
			$contar++;
			$contarA++;			
			
		}
		
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				$contar2=0;
				while($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
						//$titulo.=",'".substr($row[1],0,10)."'";
						
						$reem=(ceil($row[0]));
						$meses=verificarDato($reem,$fechas,$contar,substr($row[2],0,10),$meses);
						$total=$total+ceil($row[0]);
				}
				$meses=limpiarDato($reem,$fechas,$contarA,"",$meses);
				echo "
							<script>
							
							chart4.load({
									columns: [
										".$titulo."],
										[''".$meses."]
												
											]
											
									});
							$('.c3-legend-item-tile').hide();
							setTimeout(function(){document.getElementById('chart').style.position='absolute';},200);
							//setTimeout(function(){\$('#cargaLoadG').dialog('close');},500);
							//document.getElementById('query').innerHTML='".str_replace("'","\'",$squery)."';
							cargarGrafico('2',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							</script>
							";
			}
			else
			{
				echo "
							<script>
							
							//document.getElementById('total').innerHTML='".$lang[$idioma]['TotalDiaGraf']." ".toMoney($total)."';
							setTimeout(function(){document.getElementById('chart').style.position='absolute';},200);
							cargarGrafico('2',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							//document.getElementById('query').innerHTML='".str_replace("'","\'",$squery)."';
							
							</script>
							";
			}
			mysqli_close(conexion($_SESSION['pais']));
			
		}else
		{
			//echo "error";
		}
}
function buscarGraficoPie($codigo,$fecha,$nuevafecha,$ayer)
{
	require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
	$squery="select orderid, timoford, sum(grandtotal), orderunits, ordsou, tranum,codorden,shifee,(grandtotal),shicar from tra_ord_enc where (timoford >= '".$nuevafecha." 00:00:00' and timoford <='".$fecha." 23:59:58') and timoford!='' and codprov='".$_SESSION['codprov']."' group by ordsou order by ordsou ";
	//echo $squery;
		?>
        <script>
		var chart2 = c3.generate({
								bindto: '#chart2',
								data: {
									columns: [
										
									],
									type:"pie"
									,
										selection: {
													enabled: true
												  },
									onselected: function (d, element) 
									{ 
										
										
										cargarGrafico('5',document.getElementById('filtro').value,'<?php echo $_SESSION['codprov'];?>',d.id);
										
									 },
									 onunselected: function (d, element) 
									{ 
										
										
										cargarGrafico('5',document.getElementById('filtro').value,'<?php echo $_SESSION['codprov'];?>','');
										
									 }
								},
								color: {
								  pattern: ['#61B045','#F7742C','#D4AE18','#F6921E','#9E1F63','#26A9E0','#8BC53F','#D6DE23']
								}/*,
								
								pie: {
									label: {
										format: function (value, ratio, id) {
											
											return "$"+currency(d3.format('')((value)));
										}
									}
								}*/,
								tooltip: {
									format: {
										value: function (value, id) {
											var format = d3.format('$');
											return format(value);
										}
							
									}
								}
							});
					</script>
        
        <?php
		
		$meses="";
		
		$total=0;
		
		
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				$contar2=0;
				while($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
						
						$meses.="['".(($row[4]))."','".(ceil($row[2]))."'],";
						
						$total=$total+round($row[2],10,2);
				}
				
				echo "
							<script>
							/*document.getElementById('total').innerHTML='Grand Total Sales: ".toMoney(ceil($total))."';*/
							chart2.load({
									columns: [
										
										".substr($meses,0,strlen($meses)-1)."
												
											]
											
									});
								//setTimeout(function(){document.getElementById('chart').style.position='absolute';},200);
								cargarGrafico('3',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							</script>
							";
			}
			else
			{
				echo "
							<script>
							
							cargarGrafico('3',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							</script>
							";
			}
			mysqli_close(conexion($_SESSION['pais']));
			
		}
}


function buscarBestFive($codigo,$fecha,$nuevafecha,$ayer,$cod2)
{
require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$mas="";
	if($cod2!='')
	{
		$mas="and en.ordsou='".$cod2."'";
	}
	
	$squery="select a.codorden, a.timoford, b.productid, b.disnam, sum(b.qty) as Cantidad,sum(b.linetotal) as total from tra_ord_enc as a, tra_ord_det as b where (timoford >= '".$nuevafecha." 00:00:00' and timoford <='".$fecha." 23:59:58') and b.codorden = a.codorden and codprov='".$_SESSION['codprov']."' group by b.productid order by cantidad desc limit 5";
	//echo $squery;
	 
		?>
                
        <?php
		
		$meses="";
		
		$total=0;
		
		
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				$meses.="<table id=\"tablas\" style=\"font-size:12px;width:500px;\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\"><thead><th>".$lang[$idioma]['Nombre']."</th><th>".$lang[$idioma]['amazonSKU']."</th><th>".$lang[$idioma]['cantidadDespacho']."</th><th>".$lang[$idioma]['Sale']."</th></thead><tbody>";
				while($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
						
						$meses.= "<tr><td style=\"white-space: nowrap;\">".substr($row[3],0,50)."</td><td>".$row[2]."</td><td>".$row[4]."</td><td>".toMoney($row[5])."</td></tr>";
						
						$total=$total+round($row[0],10,2);
				}
				
				echo "
							<script>
							document.getElementById('best5').innerHTML='';
							document.getElementById('best5').innerHTML='".$lang[$idioma]['Top5Unit']." <div style=\" float:right; margin-right:20px;\"><strong>".$cod2."</strong></div><br>".str_replace("'","\'",$meses)."</tbody></table>';
							cargarGrafico('4',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							setTimeout(function(){document.getElementById('chart').style.position='absolute';},200);
							//setTimeout(function(){\$('#cargaLoadG').dialog('close');},500);
							</script>
							";
			}
			else
			{
				echo "
							<script>
							document.getElementById('best5').innerHTML='';
							document.getElementById('best5').innerHTML='".$lang[$idioma]['Top5Unit']." <div style=\" float:right; margin-right:20px;\"><strong>".$cod2."</strong></div><br>".str_replace("'","\'",$meses)."</tbody></table>';
							cargarGrafico('4',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							setTimeout(function(){document.getElementById('chart').style.position='absolute';},200);
							//setTimeout(function(){\$('#cargaLoadG').dialog('close');},500);
							</script>
							";
			}
			mysqli_close(conexion($_SESSION['pais']));
			
		}
}
function buscarBestFiveDolar($codigo,$fecha,$nuevafecha,$ayer,$cod2)
{
require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$mas="";
	if($cod2!='')
	{
		$mas="and en.ordsou='".$cod2."'";
	}
	$squery="select a.codorden, a.timoford, b.productid, b.disnam, sum(b.qty) as Cantidad,sum(b.linetotal) as total from tra_ord_enc as a, tra_ord_det as b where (timoford >= '".$nuevafecha." 00:00:00' and timoford <='".$fecha." 23:59:58') and b.codorden = a.codorden and codprov='".$_SESSION['codprov']."' group by b.productid order by total desc limit 5";
	
	 echo $squery;
		?>
                
        <?php
		
		$meses="";
		
		$total=0;
		
		
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				$meses.="<table id=\"tablas\" style=\"font-size:12px;width:500px;\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\"><thead><th>".$lang[$idioma]['Nombre']."</th><th>".$lang[$idioma]['amazonSKU']."</th><th>".$lang[$idioma]['cantidadDespacho']."</th><th>".$lang[$idioma]['Sale']."</th></thead><tbody>";
				$contar2=0;
				
				while($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
						
						$meses.= "<tr><td style=\"white-space: nowrap;\">".substr($row[3],0,50)."</td><td>".$row[2]."</td><td>".$row[4]."</td><td>".toMoney($row[5])."</td></tr>";
						
						
				}
				
				echo "
							<script>
							document.getElementById('best5D').innerHTML='';
							document.getElementById('best5D').innerHTML='".$lang[$idioma]['Top5Dol']." <div style=\" float:right; margin-right:20px;\"><strong>".$cod2."</strong></div><br>".str_replace("'","\'",$meses)."</tbody></table>';
							
							cargarGrafico('5',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							//setTimeout(function(){\$('#cargaLoadG').dialog('close');},500);
							
							</script>
							";
			}
			else
			{
				echo "
							<script>
							
							document.getElementById('best5D').innerHTML='';
							document.getElementById('best5D').innerHTML='".$lang[$idioma]['Top5Dol']." <div style=\" float:right; margin-right:20px;\"><strong>".$cod2."</strong></div><br>".$meses."</tbody></table>';
							
							cargarGrafico('5',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							//setTimeout(function(){\$('#cargaLoadG').dialog('close');},500);
							</script>
							";
			}
			mysqli_close(conexion($_SESSION['pais']));
			
		}
}

function buscarAveSales($codigo,$fecha,$nuevafecha,$ayer,$cod2)
{
require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$mas="";
	if($cod2!='')
	{
		$mas="and en.ordsou='".$cod2."'";
	}
	 $squery="select avg(en.grandtotal),max(en.grandtotal),min(en.grandtotal) from tra_ord_enc en where ((en.timoford BETWEEN '".$nuevafecha." 00:00:00' and '".$fecha." 23:59:58') and en.timoford!='') and en.grandtotal!=0 and codprov='".$_SESSION['codprov']."' $mas";
	//echo $squery;
	 
		?>
                
        <?php
		
		$meses="";
		
		$total=0;
		
		
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				
				while($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
						
						$avg= toMoney(ceil($row[0]));
						$max= toMoney(ceil($row[1]));
						$min= toMoney(ceil($row[2]));
						
				}
				
				echo "
							<script>
							document.getElementById('PromD2A').innerHTML='';
							document.getElementById('PromD2A').innerHTML='".$avg." ';
							document.getElementById('PromD2MI').innerHTML='';
							document.getElementById('PromD2MI').innerHTML='".$min." ';
							document.getElementById('PromD2MA').innerHTML='';
							document.getElementById('PromD2MA').innerHTML='".$max." ';
							cargarGrafico('6',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							//setTimeout(function(){\$('#cargaLoadG').dialog('close');},500);
							</script>
							";
			}
			else
			{
				echo "
							<script>
							document.getElementById('PromD2A').innerHTML='';
							document.getElementById('PromD2MI').innerHTML='';
							document.getElementById('PromD2MA').innerHTML='';
							cargarGrafico('6',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							//setTimeout(function(){\$('#cargaLoadG').dialog('close');},500);
							</script>
							";
			}
			mysqli_close(conexion($_SESSION['pais']));
			
		}
}
function buscarAveCant($codigo,$fecha,$nuevafecha,$ayer,$cod2)
{
require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$mas="";
	if($cod2!='')
	{
		$mas="and en.ordsou='".$cod2."'";
	}
	 $squery="select count(de.codorden),max(en.qty),min(en.qty) from tra_ord_enc de inner join tra_ord_det en on de.codorden=en.codorden where (de.timoford >= '".$nuevafecha." 00:00:00' and de.timoford <='".$fecha." 23:59:58') and de.timoford!='' and codprov='".$_SESSION['codprov']."' $mas";
	//echo $squery;
	 
		?>
                
        <?php
		
		$meses="";
		
		$total=0;
		
		
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				
				while($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
						
						
						$max= ceil($row[1]);
						$min= ceil($row[2]);
						
				}
				$arr= aveCantidadDias($codigo,$fecha,$nuevafecha,$ayer,$cod2);
				
					$avg=$arr[0];
					$min=$arr[2];
					$max=$arr[1];
				echo "
							<script>
							document.getElementById('PromO2A').innerHTML='';
							document.getElementById('PromO2A').innerHTML='".$avg." ';
							document.getElementById('PromO2MI').innerHTML='';
							document.getElementById('PromO2MI').innerHTML='".$min." ';
							document.getElementById('PromO2MA').innerHTML='';
							document.getElementById('PromO2MA').innerHTML='".$max." ';
							cargarGrafico('7',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							//setTimeout(function(){\$('#cargaLoadG').dialog('close');},500);
							</script>
							";
			}
			else
			{
				echo "
							<script>
							document.getElementById('PromO2A').innerHTML='';
							document.getElementById('PromO2MI').innerHTML='';
							document.getElementById('PromO2MA').innerHTML='';
							cargarGrafico('7',document.getElementById('filtro').value,'".$_SESSION['codprov']."','');
							//setTimeout(function(){\$('#cargaLoadG').dialog('close');},500);
							</script>
							";
			}
			mysqli_close(conexion($_SESSION['pais']));
			
		}
}

function aveCantidadDias($codigo,$fecha,$nuevafecha,$ayer,$cod2)
{
require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$mas="";
	if($cod2!='')
	{
		$mas="and en.ordsou='".$cod2."'";
	}
	 $squery="select count(*) from tra_ord_enc de inner join tra_ord_det en on de.codorden=en.codorden where (de.timoford >= '".$nuevafecha." 00:00:00' and de.timoford <'".$fecha."') and de.timoford!='' and de.codprov='".$_SESSION['codprov']."' $mas group by date(de.timoford)";
	//echo $squery."\n";
	 $mayor=0;
	 $menor=999999999;
		?>
                
        <?php
		
		$meses="";
		
		$total=0;
		
		$avg=0;
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				
				while($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
						
						$avg= $avg+($row[0]);
						//echo $avg."\n";
						$total++;
						$mayor=ceil(mayor(ceil($row[0]),$mayor));
						$menor=ceil(menor(ceil($row[0]),$menor));
						
						
				}
				
				//echo "\n\n".$total."   ".$avg;
				if(ceil($avg/($total))>0)
				{
					$avg= ceil($avg/($total));
				}
				else
				{
					$avg= ceil($avg);
				}
				$arr[0]=$avg;
				$arr[1]=$mayor;
				$arr[2]=$menor;
				return $arr;
				
			}
			else
			{
				 $squery="select count(*) from tra_ord_enc de inner join tra_ord_det en on de.codorden=en.codorden where (de.timoford >= '".$nuevafecha." 00:00:00' and de.timoford <'".$fecha." 23:59:59') and de.timoford!='' and de.codprov='".$_SESSION['codprov']."' $mas group by date(de.timoford)";
					//echo $squery."\n";
					 						
						$total=0;
						
						$avg=0;
						if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
						{
							if($ejecuta->num_rows>0)
							{
								
								while($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
								{
									
										
										$avg= $avg+($row[0]);
										//echo $avg."\n";
										$total++;
										$mayor=ceil(mayor(ceil($row[0]),$mayor));
										$menor=ceil(menor(ceil($row[0]),$menor));
										
								}
								
								//echo "\n\n".$total."   ".$avg;
								if(ceil($avg/($total))>0)
								{
									$avg= ceil($avg/($total));
								}
								else
								{
									$avg= ceil($avg);
								}
								$arr[0]=$avg;
								$arr[1]=$mayor;
								$arr[2]=$menor;
								return $arr;
							}
							else
							{
								//return 666;
							}
							mysqli_close(conexion($_SESSION['pais']));
							
						}
			}
			mysqli_close(conexion($_SESSION['pais']));
			
		}
}
function buscarAveMODA($codigo,$fecha,$nuevafecha,$ayer,$cod2)
{
require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$mas="";
	if($cod2!='')
	{
		$mas="and en.ordsou='".$cod2."'";
	}
	 $squery="select distinct de.grandtotal,count(de.grandtotal),max(en.oriunipri),min(en.oriunipri) from tra_ord_det en inner join tra_ord_enc de on de.codorden=en.codorden where (de.timoford >= '".$nuevafecha." 00:00:00' and de.timoford <='".$fecha." 23:59:58') and de.timoford!='' and de.codprov='".$_SESSION['codprov']."' group by date(de.timoford) order by count(de.grandtotal) desc limit 1;";
	//echo $squery;
	 
		?>
                
        <?php
		
		$meses="";
		
		$total=0;
		
		$avg= 0;
						$max= 0;
						$min= 0;
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				
				while($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
						
						
						$max= toMoney(ceil($row[2]));
						$min= toMoney(ceil($row[3]));
						
				}
				
				$arr=AveMODAGroup($codigo,$fecha,$nuevafecha,$ayer,$cod2);
				
				$avg=$arr[0];
				$min=$arr[2];
				$max=$arr[1];
				
				echo "
							<script>
							document.getElementById('PromTO2A').innerHTML='';
							document.getElementById('PromTO2A').innerHTML='".toMoney($avg)." ';
							document.getElementById('PromTO2MI').innerHTML='';
							document.getElementById('PromTO2MI').innerHTML='".toMoney($min)." ';
							document.getElementById('PromTO2MA').innerHTML='';
							document.getElementById('PromTO2MA').innerHTML='".toMoney($max)." ';
							setTimeout(function(){\$('#cargaLoadG').dialog('close');},500);
							</script>
							";
			}
			else
			{
				echo "
							<script>
							document.getElementById('PromTO2A').innerHTML='';
							document.getElementById('PromTO2MI').innerHTML='';
							document.getElementById('PromTO2MA').innerHTML='';
							setTimeout(function(){\$('#cargaLoadG').dialog('close');},500);
							</script>
							";
			}
			mysqli_close(conexion($_SESSION['pais']));
			
		}
}

function AveMODAGroup($codigo,$fecha,$nuevafecha,$ayer,$cod2)
{
require_once('../fecha.php');
require_once('../coneccion.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$mas="";
	if($cod2!='')
	{
		$mas="and en.ordsou='".$cod2."'";
	}
	
	$avg= 0;
	$con=0;
	$mayor=0;
		$menor=9999999999999;
$nueva2=$nuevafecha;
	while($nueva2<$fecha)
	{
	 $squery="select distinct de.grandtotal,count(de.grandtotal),max(en.oriunipri),min(en.oriunipri) from tra_ord_det en inner join tra_ord_enc de on de.codorden=en.codorden where (de.timoford like '".$nueva2."%') and de.timoford!='' and de.codprov='".$_SESSION['codprov']."' group by date(de.timoford) order by count(de.grandtotal) desc limit 1;";
	//echo $squery."\n";
	 $nuevafecha2 = strtotime ( '+1 day' , strtotime ( $nueva2 ) ) ;
	 $nueva2 = date ( 'Y-m-d' , $nuevafecha2 );
		
		
		
		if($ejecuta=mysqli_query(conexion($_SESSION['pais']),$squery))
		{
			if($ejecuta->num_rows>0)
			{
				
				if($row=mysqli_fetch_array($ejecuta,MYSQLI_NUM))
				{
					
						$con++;
						$avg= $avg+(ceil($row[0]));
						$mayor=ceil(mayor(ceil($row[0]),$mayor));
						$menor=ceil(menor(ceil($row[0]),$menor));
						
						
				}
				
				
			}
			else
			{
				//$avg+=666;
			}
			
			mysqli_close(conexion($_SESSION['pais']));
			
		}
	}
	$arr[1]=$mayor;
	$arr[2]=$menor;
	//echo $con." ".$avg;
		if(ceil($avg/$con)>0)
		{
			$avg= ceil($avg/$con);
		}
		else
		{
			$avg= ceil($avg);
		}
		$arr[0]=$avg;
		
		return $arr;
}
function verificarDato($reem,$fechas,$contar,$fecha,$meses)
{
	$contarA="a";
	for($i=1;$i<=$contar+1;$i++)
	{
		if($fecha==$fechas[$i-1])
		{
			$meses=str_replace(",'".$contarA."'",",'".$reem."'",$meses);
			break;
		}
		$contarA++;
		
	}
	return $meses;
}
function limpiarDato($reem,$fechas,$contar,$fecha,$meses)
{
	for($i="a";$i<=$contar;$i++)
	{
			$meses=str_replace(",'".$i."'",",''",$meses);
		
		
	}
	return $meses;
}
function mayor($cant,$may)
{
	if($cant>$may)
	{
		return $cant;
	}
	else
	{
		return $may;
	}
}
function menor($cant,$may)
{
	if($cant<$may)
	{
		return $cant;
	}
	else
	{
		return $may;
	}
}
?>