
<?php
if(isset($_POST['tipoMovPOL']) )
{
	if($_POST['tipoMovPOL']=="poliza")
	{
		session_start();
		echo encabezado().tabla($_SESSION['queryPolizaPasar'],"../");
	}
	
}

if(isset($_POST['subgrupoconta1']) )
{

	$pais=$_POST['pais'];
	$subgrup=$_POST['subgrupoconta1'];
	
	echo combosubgrupoconta($pais,$subgrup);
	
}

if(isset($_POST['subgrupoconta2']) )
{
	$pais=$_POST['pais'];
	$subgrup1=$_POST['subgrupoconta2'];
	echo comboscuentaconta($pais,$subgrup1);
	
}

if(isset($_POST['cuentaconta12']) )
{
	$pais=$_POST['pais'];
	$subgrup3=$_POST['cuentaconta12'];
	echo comboscuentanivel1conta($pais,$subgrup3);
	/*echo '<script language="javascript">alert("hola");</script>';*/
	

}

if(isset($_POST['cuentacontanivel14']) )
{
	$pais=$_POST['pais'];
	$subgrup4=$_POST['cuentacontanivel14'];
	echo comboscuentanivel2conta($pais,$subgrup4);
	
}




function combogrupoconta($pais)
{
	require_once('../../coneccion.php');
	require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');

	$squery="select CODCUENTA,nombre from cat_nomenclatura where QUE_ES='1'";
	$res="<option value='' selected></option>";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['CODCUENTA']."\">".utf8_encode($row['nombre'])."</option>";
					}
				}
			return $res;
}




function combosubgrupoconta($pais,$grupoconta1)
{
	
	require_once('../coneccion.php');
	require_once('../fecha.php');

$idioma=idioma();
include('../idiomas/'.$idioma.'.php');


	$squery="select CODCUENTA,nombre from cat_nomenclatura where QUE_ES='2' and substring(codigo,1,1)='".$grupoconta1."'";
	$res="<option value='' selected></option>";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['CODCUENTA']."\">".utf8_encode($row['nombre'])."</option>";
					}
				}
			return $res;
}

function comboscuentaconta($pais,$grupoconta1)
{
	
	require_once('../coneccion.php');
	require_once('../fecha.php');

$idioma=idioma();
include('../idiomas/'.$idioma.'.php');


	$squery="select CODCUENTA,nombre from cat_nomenclatura where QUE_ES='3' and substring(codigo,1,2)='".$grupoconta1."'";
	$res="<option value='' selected></option>";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['CODCUENTA']."\">".utf8_encode($row['nombre'])."</option>";
					}
				}
			return $res;
}

function comboscuentanivel1conta($pais,$grupoconta1)
{
	
	require_once('../coneccion.php');
	require_once('../fecha.php');

$idioma=idioma();
include('../idiomas/'.$idioma.'.php');


	$squery="select CODCUENTA,nombre from cat_nomenclatura where QUE_ES='4'  and substring(codigo,1,3)='".$grupoconta1."'";
	$res="<option value='' selected></option>";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['CODCUENTA']."\">".utf8_encode($row['nombre'])."</option>";
					}
				}
			return $res;
}

function comboscuentanivel2conta($pais,$grupoconta1)
{
	
	require_once('../coneccion.php');
	require_once('../fecha.php');

$idioma=idioma();
include('../idiomas/'.$idioma.'.php');


	$squery="select CODCUENTA,nombre from cat_nomenclatura where QUE_ES='5'  and substring(codigo,1,5)='".$grupoconta1."'";
	$res="<option value='' selected></option>";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['CODCUENTA']."\">".utf8_encode($row['nombre'])."</option>";
					}
				}
			return $res;
}

function comboBancos($pais)
{
	require_once('../coneccion.php');
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

	$squery="select codbanc,nombre from cat_banc";
	$res="<option value='' selected></option>";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['codbanc']."\">".utf8_encode($row['nombre'])."</option>";

					}
				}
			return $res;
}


function combotipoCuenta($pais)
{
	require_once('../coneccion.php');
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

	$squery="select CODTCUEN, nombre from cat_tcuen";
	$res="<option value='' selected></option>";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['CODTCUEN']."\">".utf8_encode($row['nombre'])."</option>";
						echo 'selected';
					}
				}
			return $res;
}


function combocuentacont($pais)
{
	require_once('../coneccion.php');
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

	$squery="select codbanc,nombre from cat_banc";
	$res="<option value='' selected></option>";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['codbanc']."\">".utf8_encode($row['nombre'])."</option>";
					}
				}
			return $res;
}

function combotipoMone($pais)
{
	require_once('../coneccion.php');
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

	$squery="select CODMONE,nombre, moneda from cat_tipomone";
	$res="<option value='' selected></option>";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['CODMONE']."\">".utf8_encode($row['nombre'])."  |  ".utf8_encode($row['moneda'])."</option>";
					}
				}
			return $res;
}





function combotipoconta($pais)
{
	require_once('../../coneccion.php');
	require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');

	$squery="select letratipoconta,nombre from tipoconta";
	$res="<option value='T' selected></option>"; 
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['letratipoconta']."\">".utf8_encode($row['nombre'])."</option>";
					}
				}
			return $res;
}

function ubicaconta($pais)
{
	require_once('../../coneccion.php');
	require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');

	$squery="select tipoubica,nombre from ubicaconta ";
	$res="<option value='' selected></option>";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['tipoubica']."\">".utf8_encode($row['nombre'])."</option>";
					}
				}
			return $res;
}




function comboTasaCambio($pais)
{
	require_once('../coneccion.php');
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

	$squery="select CODBANCTC,nombre from cat_tipotasa";
	$res="<option value='' selected></option>";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['CODBANCTC']."\">".utf8_encode($row['nombre'])."</option>";
					}
				}
			return $res;
}

function comboFormafecha($pais)
{
	require_once('../coneccion.php');
	require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

	$squery="select CODMONE,nombre from cat_formafecha";
	$res="<option value='' selected></option>";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['CODMONE']."\">".utf8_encode($row['nombre'])."</option>";
					}
				}
			return $res;
}


function comboembarque($pais)
{
	require_once('../../coneccion.php');
	require_once('../../fecha.php');
$idioma=idioma();
include('../../idiomas/'.$idioma.'.php');

	$squery="select Codproy,nombre from cat_proyectos";
	$res="<option value='' selected></option>";
		$ejecutar=mysqli_query(conexion($pais),$squery);
				if($ejecutar)
				{
					
					$contador=0;
					while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$res=$res."<option value=\"".$row['Codproy']."\">".utf8_encode($row['nombre'])."</option>";

					}
				}
			return $res;
}

function tabla($squer,$esmas)
{
	require_once($esmas.'coneccion.php');
    $retornar="";
    $retornar=$retornar."<tbody>";
    $ejecutar=mysqli_query(conexion($_SESSION['pais']),$squer);
    $_SESSION['debe']=0;
    $_SESSION['haber']=0;

        if($ejecutar)
        {
            while($row=mysqli_fetch_array($ejecutar,MYSQL_ASSOC))
            {
                if($ejecutar->num_rows>0)
                {
                    $retornar.="<tr onclick=\"\";>
                                    
                                    
                                    <td hidden>".$row['codigo']."</td>
                                    <td class='bode12'>".$row['cuenta']."</td>
                                    <td class='bode12'>".$row['nombreconta']."</td>
                                    <td class='bode12'>".$row['debe']."</td>
                                    <td class='bode12'>".$row['haber']."</td>
                                </tr>
                                ";

                               $_SESSION['debe']=$row['debe']+$_SESSION['debe'];
                               $_SESSION['haber']=$row['haber']+$_SESSION['haber'];

                }
            }

        }
        $retornar.="</tbody></table></div></center>

            <script   type=\"text/javascript\">

           $(document).ready(function(){
    
   $('#tablas').DataTable( {
        \"scrollY\":        \"300px\",
        \"scrollX\": true,
        \"paging\":         true,
        \"info\":     false
        
         
    } );
});
           </script>
           </div>";
        
                return $retornar;
}

function encabezado()
{
    return "
    <div id='datos1'>
    <center>
            <div>
            <table id=\"tablas\" width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" class=\"hover tablas table\">
                <thead>
                <tr  class=\"titulo\">
                   
                    <th hidden=\"hidden\">Codigo</th>
                    <th>Cuenta</th>
                    <th>Nombre de la Cuenta</th>
                    <th>Debe</th>
                    <th>Haber</th>

                </tr> </thead>
            ";
}

?>