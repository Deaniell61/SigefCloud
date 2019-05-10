<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

$codigo= strtoupper($_POST['codigo']);

$sql="select codempresa,npatronal,nombre,rsocial,direccion,nit,telefono,fax,www,email,ctaIva_CR,ctaIva_DB,ctaInven,ctaIvaCRxL,ctaCCxP,ctaIDP,ctaCosto,ctaCajaGR,imagen,imagen1,cPIGSS,cPIntecap,cPIRTRA,cLIGSS,baseDatos,moneda,inventar,(select nompais from direct where codpais=pais) as pais from cat_empresas where codempresa='$codigo'";
## ejecución de la sentencia sql

$ejecutar=mysqli_query(conexion(""),$sql);
if($ejecutar)				
{
	$row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC);
	$in1="";
	session_start();
	$_SESSION['CodEmp']=$row['codempresa'];
	$_SESSION['NomEmp']=$row['nombre'];
$nombre= strtoupper($row['nombre']);
$email = $row['email'];
$npatronal = $row['npatronal'];
$rsocial = $row['rsocial'];
$direccion = $row['direccion'];
$nit = $row['nit'];
$telefono = $row['telefono'];
$fax = $row['fax'];
$www = $row['www'];
$ctaIva_CR = $row['ctaIva_CR'];
$ctaIva_DB = $row['ctaIva_DB'];
$ctaInven = $row['ctaInven'];
$ctaIvaCRxL = $row['ctaIvaCRxL'];
$ctaCCxP = $row['ctaCCxP'];
$ctaIDP = $row['ctaIDP'];
$ctaCosto = $row['ctaCosto'];
$ctaCajaGR = $row['ctaCajaGR'];
$cPIGSS = $row['cPIGSS'];
$cPIntecap = $row['cPIntecap'];
$cPIRTRA = $row['cPIRTRA'];
$cLIGSS = $row['cLIGSS'];
$baseDatos = $row['baseDatos'];
$moneda = $row['moneda'];
$inventar = $row['inventar'];	
$pais = $row['pais'];								
						
	function pais($cod,$pais)
	{
		$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
		if($cod=='')
		{
			echo "<tr><select id=\"pais\">".paises()."</select></tr>";
		}
		else
		{
			echo "<tr>".$lang[$idioma]['Pais']."<input type=\"text\" name=\"pais\" id=\"pais\" value=\"".$pais."\" disabled></tr>";
			}
           
	}
?>

<form id="empresas" name="empresas" action="return false" onSubmit="return false" method="POST">
                  <center>
        <table>
          <tr>
              Ingreso o Modificacion de Cuentas
      
                </tr>
                <tr><div id="resultado">Algunos Datos Son Obligatorios</div></tr>
				<tr><input type="text" hidden="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>" disabled placeholder="<?php echo $lang[$idioma]['Codigo'];?>" ></tr>
             
             <?php pais($codigo,$pais);?>
                
                
          <tr>
            <td class="text">Numero de Cuenta</td>
            <td>
               <input type="text" name="nombre" id="nombre" value="<?php echo $nombre;?>" onKeyDown="buenNombre();" autofocus placeholder="Numero de Cuenta" ></td>
            
             <td class="text">Nombre de la Cuenta</td>
              <td>
               <input type="text" name="npatronal" id="npatronal" value="<?php echo $npatronal;?>" autofocus placeholder="Nombre de Cuenta" ></td>
            </tr>
            
            <tr>
              <td class="text"><span>Seleccionar Banco</span></td>
            
              <td>
               <select type="text" name="rsocial" id="rsocial"  value="<?php echo $rsocial;?>" onKeyDown="buenrsocial();" autofocus placeholder="Banco" ></select><img src="../../images/document_add.png" id="subForm"  onClick="asignarExtrasBancos('tipoBanco','<?php echo $codigo;?>','<?php echo $pais;?>');"></td>
            
				<td class="text">Logo Banco</td>
              <td>
               <input type="text" name="direccion" id="direccion" value="<?php echo $direccion;?>" disabled placeholder="logo" ></td>
           </tr>
            
            <tr>
              <td class="text"><span>Tasa de Cambio</span></td>
              <td>
               <input type="text" name="nit" id="nit" value="<?php echo $nit;?>"  onKeyDown="buenNit();" disabled placeholder="Tasa" ></td>
            
				<td class="text">Compra de Dolares</td>
              <td>
               <input type="text" name="telefono" id="telefono" value="<?php echo $telefono;?>" disabled placeholder="Compra" ></td>
            </tr>
            
            <tr>
            <td class="text"><span>Venta de Dolares</span></td>
              <td>
               <input type="text" name="fax" id="fax" value="<?php echo $fax;?>" disabled placeholder="Venta" ></td>
            
			<td class="text">Seleccione Tipo de Moneda</td>
              <td>
               <select type="text" name="www" id="www" value="<?php echo $www;?>" autofocus placeholder="Moneda" ></select><img src="../../images/document_add.png" id="subForm" onClick=""></td>
            </tr>
            
            <tr>
            <td class="text"><span>Cantidad de Pagos</span></td>
              <td>
               <input type="text" name="ctaIva_CR" id="ctaIva_CR" value="<?php echo $ctaIva_CR;?>" autofocus placeholder="Pagos" ></td>
               
			   <td class="text">Fecha de Tasa de Cambio</td>
               <td>
               <input type="text" name="email" id="email"  value="<?php echo $email;?>" onKeyUp="comprobarEmailEmpresa();" autofocus placeholder="Fecha" ></input><img src="../../images/document_add.png" id="subForm" onClick=""><div id="comprobar" ></div></td>
           </tr>
            
          
           
			
			<tr><td><br><br></td></tr>
            <tr><td></td>
			<td id="guardar">
            <input type="button" onClick="editarTodosBanco(document.getElementById('nombre').value,document.getElementById('npatronal').value,document.getElementById('rsocial').value,document.getElementById('direccion').value,document.getElementById('nit').value,document.getElementById('telefono').value,document.getElementById('fax').value,document.getElementById('www').value,document.getElementById('email').value,document.getElementById('ctaIva_CR').value,document.getElementById('ctaIva_DB').value,document.getElementById('ctaInven').value,document.getElementById('ctaIvaCRxL').value,document.getElementById('ctaCCxP').value,document.getElementById('ctaIDP').value,document.getElementById('ctaCosto').value,document.getElementById('ctaCajaGR').value,document.getElementById('cPIGSS').value,document.getElementById('cPIntecap').value,document.getElementById('cPIRTRA').value,document.getElementById('cLIGSS').value,document.getElementById('baseDatos').value,document.getElementById('moneda').value,document.getElementById('inventar').value,document.getElementById('codigo').value,document.getElementById('pais').value);subirImagen(this.form,'subirArchivo.php','resultado');" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
           <input type="reset" onClick="envioDeDataBancos('empresa');" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
           <input type="button" onClick="window.opener.selecFormulario('6');window.close();;" value="<?php echo $lang[$idioma]['Salir'];?>"/>
            </td><td></td>
             </tr>
           
        </table>
        </center>
                </form>
                <br><br><br> 


<?php
}
else
{
	echo "<script>alert(\"Error de base de datos\");</script>";
}

function verImagen1($cod,$nom)
{
	$sql="select imagen from cat_empresas where codempresa='$cod' and nombre='$nom'";
	$ejecutar=mysqli_query(conexion(""),$sql);
if($ejecutar)				
{
	$row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC);
	
	if($row['imagen']!='')
	{ return "<center><img src=\"".$row['imagen']."\" width=\"40px\" height=\"40px\"/></center>";}
	else
	{
	 return "<input name=\"imagen\" type=\"file\" id=\"imagen\" />";
	}
}
}

function verImagen2($cod,$nom)
{
	$sql="select imagen1 from cat_empresas where codempresa='$cod' and nombre='$nom'";
	$ejecutar=mysqli_query(conexion(""),$sql);
if($ejecutar)				
{
	$row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC);
	
	if($row['imagen1']!='')
	{ return "<center><img src=\"".$row['imagen1']."\" width=\"40px\" height=\"40px\"/></center>";}
	else
	{
	 return "<input name=\"imagen1\" type=\"file\" id=\"imagen1\" />";
	}
}
}

?>