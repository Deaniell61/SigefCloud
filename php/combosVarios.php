<?php
if(isset($_POST['tipo']))
{
switch($_POST['tipo'])
{
	case "pais":
	{
		echo comboPaisOrigen($_POST['empresa'],$_POST['pais'],$_POST['puntos']);
		break;
	}
	case "ciudad":
	{
		echo comboCiudadOrigen($_POST['empresa'],$_POST['pais'],$_POST['puntos']);
		break;
	}
	case "tags":
	{
		echo llnearTags('',$_POST['codigo']);
		break;
	}
	case "dbTable":
	{
		echo tablasDBFiltro('',$_POST['db'],$_POST['plat']);
		break;
	}
	case "dbColumna":
	{
		echo tablasDBColumnas('',$_POST['db'],$_POST['plat'],$_POST['tabla']);
		break;
	}
}
}
function comboPaisOrigen($empresa,$pais,$puntos)
{
	require_once($puntos.'coneccion.php');
	require_once($puntos.'fecha.php');
$idioma=idioma();
include($puntos.'idiomas/'.$idioma.'.php');
	$squery="select codeco as codcountry,nombre from cat_country order by nombre";
	$res="<option value=\"\" selected></option>";
		$ejecutar=mysqli_query(conexion(''),$squery);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['codcountry']."\">".utf8_encode($row['nombre'])."</option>";
					}
				}
				else
				{
					$res=$squery;
				}
				
			return $res;
}
function comboCiudadOrigen($empresa,$pais,$puntos)
{
	require_once($puntos.'coneccion.php');
	require_once($puntos.'fecha.php');
$idioma=idioma();
include($puntos.'idiomas/'.$idioma.'.php');
	$squery="select codeco as codcountry,nombre from cat_country order by nombre";
	$res="<option value=\"\" selected></option>";
		$ejecutar=mysqli_query(conexion(''),$squery);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['codcountry']."\">".utf8_encode($row['nombre'])."</option>";
					}
				}
				else
				{
					$res=$squery;
				}
				
			return $res;
}
function comboBodegas($empresa,$pais,$puntos)
{
	require_once($puntos.'coneccion.php');
	require_once($puntos.'fecha.php');
$idioma=idioma();
include($puntos.'idiomas/'.$idioma.'.php');
	$squery="select codbodega,nombre from cat_bodegas order by nombre";
	$res="<option value=\"\" selected></option>";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
					{
						$res=$res."<option value=\"".$row['0']."\">".utf8_encode($row['1'])."</option>";
					}
				}
				else
				{
					$res=$squery;
				}
				
			return $res;
}
function tags($puntos)
{
	require_once($puntos.'coneccion.php');
	require_once($puntos.'fecha.php');
$idioma=idioma();
include($puntos.'idiomas/'.$idioma.'.php');
$res="";
	$squery="select codigo,nombre from cat_nomenclatura order by codigo";
		$ejecutar=mysqli_query(conexion("Guatemala"),$squery);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
					{
						$res=$res."\"".$row['0']." ".utf8_encode($row['1'])."\",\n";
					}
				}
				else
				{
					$res=$squery;
				}
				
			return substr($res,0,(strlen($res)-2));
}
function tablasDB($puntos)
{
	require_once($puntos.'coneccion.php');
	require_once($puntos.'fecha.php');
$idioma=idioma();
include($puntos.'idiomas/'.$idioma.'.php');
$res="";
	$squery="show tables";
		$ejecutar=mysqli_query(conexion("Guatemala"),$squery);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
					{
						$res=$res."\"".utf8_encode($row['0'])."\",\n";
					}
					$ejecutar2=mysqli_query(conexion(""),$squery);
					if($ejecutar2)
					{
						$contador=0;
						while($row=mysqli_fetch_array($ejecutar2,MYSQLI_NUM))
						{
							$res=$res."\"".utf8_encode($row['0'])."\",\n";
						}
						
					}
					else
					{
						$res=$squery;
					}
				}
				else
				{
					$res=$squery;
				}
				
			return substr($res,0,(strlen($res)-2));
}
function tablasDBFiltro($puntos,$bd,$plat)
{
	require_once('coneccion.php');
	require_once('fecha.php');
	$idioma=idioma();
	include('idiomas/'.$idioma.'.php');
		
		$datos=obtenerDatos("");
		if($bd=="1")
		{
			$sigu="";
		}
		else
		{
			$sigu="01";
		}
		$con = mysqli_connect($datos[0], $datos[1], $datos[2], 'quintoso_'.strtolower($plat).'sigef'.$sigu);
	$res="";
	$squery="show tables";
	$res="
		<script>
		$( \"#tablaDB\" ).autocomplete( \"option\", \"source\",[";
		$ejecutar=mysqli_query($con,$squery);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
					{
						$res=$res."\"".utf8_encode($row['0'])."\",";
					}
					
				}
				else
				{
					$res=$squery;
				}
				$res=substr($res,0,(strlen($res)-1));
		$res.="]);
	</script>
	";
			echo $res;
}

function tablasDBColumnas($puntos,$bd,$plat,$tabla)
{
	require_once('coneccion.php');
	require_once('fecha.php');
	$idioma=idioma();
	include('idiomas/'.$idioma.'.php');
		
		$datos=obtenerDatos("");
		if($bd=="1")
		{
			$sigu="";
		}
		else
		{
			$sigu="01";
		}
		$con = mysqli_connect($datos[0], $datos[1], $datos[2], 'quintoso_'.strtolower($plat).'sigef'.$sigu);
	$res="";
	$squery="describe ".$tabla;
	$res="
		<script>
		$( \"#campo\" ).autocomplete( \"option\", \"source\",[";
		$ejecutar=mysqli_query($con,$squery);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
					{
						$res=$res."\"".utf8_encode($row['0'])."\",";
					}
					
				}
				else
				{
					$res=$squery;
				}
				$res=substr($res,0,(strlen($res)-1));
		$res.="]);
	</script>
	";
			echo $res;
}
function llnearTags($puntos,$codigo)
{
	require_once($puntos.'coneccion.php');
	require_once($puntos.'fecha.php');
$idioma=idioma();
include($puntos.'idiomas/'.$idioma.'.php');
$res="";
	$squery="select nombre from cat_nomenclatura where codigo='".$codigo."'";
		$ejecutar=mysqli_query(conexion("Guatemala"),$squery);
				if($ejecutar)
				{
					if($ejecutar->num_rows>0)
					{
						$contador=0;
						while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
						{
							$res=utf8_encode($row['0']);
						}
					}
					else
					{
						if($codigo!="")
						{
							$res="No existe ese codigo";
						}
						else
						{
							$res="";
						}
					}
				}
				else
				{
					$res=$squery;
				}
				
			return ($res);
}
function comboModulos($empresa,$pais,$puntos)
{
	require_once($puntos.'coneccion.php');
	require_once($puntos.'fecha.php');
$idioma=idioma();
include($puntos.'idiomas/'.$idioma.'.php');
	$squery="select codbodega,nombre from cat_bodegas order by nombre";
	$res="<option value=\"\" selected></option>";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
					{
						$res=$res."<option value=\"".$row['0']."\">".utf8_encode($row['1'])."</option>";
					}
				}
				else
				{
					$res=$squery;
				}
				
			return $res;
}

function comboTitulos($empresa,$pais,$puntos)
{
	require_once($puntos.'coneccion.php');
	require_once($puntos.'fecha.php');
$idioma=idioma();
include($puntos.'idiomas/'.$idioma.'.php');
	$squery="select titulo,codwiki from wiki order by titulo";
	$res="";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_NUM))
					{
						$res.='
						<ul class="nav nav-stacked" id="accordion'.$contador.'">
            				<li class="panel"> <a data-toggle="collapse" data-parent="#accordion'.$contador.'" href="#firstLink'.$contador.'" onClick="cargarWiki(\''.$row[1].'\');">'.$row[0].'</a>

								<ul id="firstLink'.$contador.'" class="collapse">
									<center>
										<li onClick="cargarFormularioGrafico(\'1\');" class="menuCollapseLi">banco1</li>
											
										<li onClick="cargarFormularioGrafico(\'1\');" class="menuCollapseLi">banco1</li>
										<li onClick="cargarFormularioGrafico(\'1\');" class="menuCollapseLi">banco1</li>
										
									</center>
									
									
								</ul>
              
							</li>
							
						</ul>
						';
					}
				}
				else
				{
					$res=$squery;
				}
				
			return $res;
}

function comboEstados($empresa,$pais,$puntos)
{
	require_once($puntos.'coneccion.php');
	require_once($puntos.'fecha.php');
$idioma=idioma();
include($puntos.'idiomas/'.$idioma.'.php');
	$squery="select codestado,codigo,nombre from cat_estados order by codigo";
	$res="<option value=\"\" selected></option>";
		$ejecutar=mysqli_query(conexion(''),$squery);
				if($ejecutar)
				{
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['codestado']."\">".utf8_encode($row['codigo'])." - ".buscaNomEstado($row['codigo'],"")."</option>";
					}
				}
				else
				{
					$res=$squery;
				}
				
			return $res;
}
?>