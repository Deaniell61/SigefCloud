<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

$codigo= strtoupper($_POST['codigo']);

$sql="select codempresa,npatronal,nombre,rsocial,direccion,nit,telefono,fax,www,email,ctaIva_CR,ctaIva_DB,ctaInven,ctaIvaCRxL,ctaCCxP,ctaIDP,ctaCosto,ctaCajaGR,imagen,imagen1,cPIGSS,cPIntecap,cPIRTRA,cLIGSS,baseDatos,moneda,inventar,(select nompais from direct where codpais=pais) as pais,incre1,incre2,incre3,incre4,mmin,mpro,mmax,marmincom from cat_empresas where codempresa='$codigo'";
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

if(	$row['incre1']==0)
{
	$incre1=70;
}
else
{
	$incre1=$row['incre1'];
}

if(	$row['incre2']==0)
{
	$incre2=55;
}
else
{
	$incre2=$row['incre2'];
}

if(	$row['incre3']==0)
{
	$incre3=45;
}
else
{
	$incre3=$row['incre3'];
}

if(	$row['incre4']==0)
{
	$incre4=35;
}
else
{
	$incre4=$row['incre4'];
}
						
	function pais($cod,$pais)
	{
		$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
		if($cod=='')
		{
			echo "<tr><td></td><td colspan=\"3\"><select id=\"pais\" class='entradaTexto textoGrande'  style=\"width:calc(98% );\">".paises()."</select></td></tr>";
		}
		else
		{
			echo "<tr><td class=\"text\">".$lang[$idioma]['Pais']."</td> <td colspan=\"3\"> <input class='entradaTexto textoGrande'  style=\"width:calc(95% );\" type=\"text\" name=\"pais\" id=\"pais\" value=\"".$pais."\" disabled></td></tr>";
			}
           
	}
?>

<form id="empresas" name="empresas" action="return false" onSubmit="return false" method="POST">
                  <center>
        <table>
          <tr>
          <td colspan="4">
              <center><?php echo $lang[$idioma]['Ingreso_Empresas'];?></td></center>
                </tr>
                <tr><td colspan="4"><div id="resultado"><?php echo $lang[$idioma]['Adevertencia_Rojo'];?></div></td></tr>
				<tr><input class='entradaTexto' type="text" hidden="hidden" name="codigo" id="codigo" value="<?php echo $codigo;?>" disabled placeholder="<?php echo $lang[$idioma]['Codigo'];?>" ></tr>
             
                  <?php pais($codigo,$pais);?>
                
                
          <tr>
              <td class="text"><?php echo $lang[$idioma]['Nombre'];?></td>
              <td>
               <input type="text" class='entradaTexto' name="nombre" id="nombre" value="<?php echo $nombre;?>" onKeyDown="buenNombre();" autofocus placeholder="<?php echo $lang[$idioma]['Nombre'];?>" ></td>
            
             <td class="text"><?php echo $lang[$idioma]['Npatronal'];?></td>
              <td>
               <input type="text" class='entradaTexto' name="npatronal" id="npatronal" value="<?php echo $npatronal;?>" autofocus placeholder="<?php echo $lang[$idioma]['Npatronal'];?>" ></td>
            </tr>
            
            <tr>
              <td class="text"><span><?php echo $lang[$idioma]['Rsocial'];?></span></td>
            
              <td>
               <input type="text" class='entradaTexto' name="rsocial" id="rsocial"  value="<?php echo $rsocial;?>" onKeyDown="buenrsocial();" autofocus placeholder="<?php echo $lang[$idioma]['Rsocial'];?>" ></td>
            
				<td class="text"><?php echo $lang[$idioma]['Direccion'];?></td>
              <td>
               <input type="text" class='entradaTexto' name="direccion" id="direccion" value="<?php echo $direccion;?>" autofocus placeholder="<?php echo $lang[$idioma]['Direccion'];?>" ></td>
           </tr>
            
            <tr>
              <td class="text"><span><?php echo $lang[$idioma]['Nit'];?></span></td>
              <td>
               <input type="text" class='entradaTexto' name="nit" id="nit" value="<?php echo $nit;?>"  onKeyDown="buenNit();" autofocus placeholder="<?php echo $lang[$idioma]['Nit'];?>" ></td>
            
				<td class="text"><?php echo $lang[$idioma]['Nit'];?></td>
              <td>
               <input type="text" class='entradaTexto' name="telefono" id="telefono" value="<?php echo $telefono;?>" autofocus placeholder="<?php echo $lang[$idioma]['Telefono'];?>" ></td>
            </tr>
            
            <tr>
            <td class="text"><span><?php echo $lang[$idioma]['Fax'];?></span></td>
              <td>
               <input type="text" class='entradaTexto' name="fax" id="fax" value="<?php echo $fax;?>" autofocus placeholder="<?php echo $lang[$idioma]['Fax'];?>" ></td>
            
			<td class="text"><?php echo $lang[$idioma]['Pagina Web'];?></td>
              <td>
               <input type="text" class='entradaTexto' name="www" id="www" value="<?php echo $www;?>" autofocus placeholder="<?php echo $lang[$idioma]['Pagina Web'];?>" ></td>
            </tr>
            
            <tr>
            <td class="text"><span><?php echo $lang[$idioma]['Cuenta Iva CR'];?></span></td>
              <td>
               <input type="text" class='entradaTexto' name="ctaIva_CR" id="ctaIva_CR" value="<?php echo $ctaIva_CR;?>" autofocus placeholder="<?php echo $lang[$idioma]['Cuenta Iva CR'];?>" ></td>
               
			   <td class="text"><?php echo $lang[$idioma]['Email'];?></td>
               <td>
               <input type="text" class='entradaTexto' name="email" id="email"  value="<?php echo $email;?>" onKeyUp="comprobarEmailEmpresa();" autofocus placeholder="<?php echo $lang[$idioma]['Email'];?>" ><div id="comprobar" ></div></td>
           </tr>
            
            <tr>
            <td class="text"><span><?php echo $lang[$idioma]['Cuenta Iva DB'];?></span></td>
              <td>
               <input type="text" class='entradaTexto' name="ctaIva_DB" id="ctaIva_DB" value="<?php echo $ctaIva_DB;?>" autofocus placeholder="<?php echo $lang[$idioma]['Cuenta Iva DB'];?>" ></td>
			   
			   <td class="text"><?php echo $lang[$idioma]['Cuenta Inventario'];?></td>
            
              <td>
               <input type="text" class='entradaTexto' name="ctaInven" id="ctaInven" value="<?php echo $ctaInven;?>" autofocus placeholder="<?php echo $lang[$idioma]['Cuenta Inventario'];?>" ></td>
            </tr>
            
            <tr>
            <td class="text"><span><?php echo $lang[$idioma]['Cuenta Iva CRxL'];?></span></td>
              <td>
               <input type="text" class='entradaTexto' name="ctaIvaCRxL" id="ctaIvaCRxL" value="<?php echo $ctaIvaCRxL;?>" autofocus placeholder="<?php echo $lang[$idioma]['Cuenta Iva CRxL'];?>" ></td>
            
			<td class="text"><?php echo $lang[$idioma]['Cuenta CCxP'];?></td>
              <td>
               <input type="text" class='entradaTexto' name="ctaCCxP" id="ctaCCxP" autofocus value="<?php echo $ctaCCxP;?>" placeholder="<?php echo $lang[$idioma]['Cuenta CCxP'];?>" ></td>
            </tr>
            
            <tr>
            <td class="text"><span><?php echo $lang[$idioma]['Cuenta IDP'];?></span></td>
              <td>
               <input type="text" class='entradaTexto' name="ctaIDP" id="ctaIDP" value="<?php echo $ctaIDP;?>" autofocus placeholder="<?php echo $lang[$idioma]['Cuenta IDP'];?>" ></td>
            <td class="text"><?php echo $lang[$idioma]['Cuenta Costos'];?></td>
              <td>
               <input type="text" class='entradaTexto' name="ctaCosto" id="ctaCosto" value="<?php echo $ctaCosto;?>" autofocus placeholder="<?php echo $lang[$idioma]['Cuenta Costos'];?>" ></td>
           </tr>
            
            <tr> 
            <td class="text"><span><?php echo $lang[$idioma]['Cuenta CajaGR'];?></span></td>
              <td>
               <input type="text" class='entradaTexto' name="ctaCajaGR" id="ctaCajaGR" value="<?php echo $ctaCajaGR;?>" autofocus placeholder="<?php echo $lang[$idioma]['Cuenta CajaGR'];?>" ></td>
            
			<td class="text"><?php echo $lang[$idioma]['Cuota Patronal IGSS'];?></td>
              <td>
               <input type="text" class='entradaTexto' name="cPIGSS" id="cPIGSS" value="<?php echo $cPIGSS;?>" autofocus placeholder="<?php echo $lang[$idioma]['Cuota Patronal IGSS'];?>" ></td>
            </tr>
            
            <tr>
            <td class="text"><span><?php echo $lang[$idioma]['Cuota Patronal Intecap'];?></span></td>
              <td>
               <input type="text" class='entradaTexto' name="cPIntecap" id="cPIntecap" value="<?php echo $cPIntecap;?>" autofocus placeholder="<?php echo $lang[$idioma]['Cuota Patronal Intecap'];?>" ></td>
            
			<td class="text"><?php echo $lang[$idioma]['Cuota Patronal IRTRA'];?></td>
              <td>
               <input type="text" class='entradaTexto' name="cPIRTRA" id="cPIRTRA" autofocus value="<?php echo $cPIRTRA;?>" placeholder="<?php echo $lang[$idioma]['Cuota Patronal IRTRA'];?>" ></td>
            </tr>
            
            <tr>
            <td class="text"><span><?php echo $lang[$idioma]['Cuota Laboral IGSS'];?></span></td>
              <td>
               <input type="text" class='entradaTexto' name="cLIGSS" id="cLIGSS" autofocus value="<?php echo $cLIGSS;?>" placeholder="<?php echo $lang[$idioma]['Cuota Laboral IGSS'];?>" ></td>
            
			<td class="text"><?php echo $lang[$idioma]['BaseDatos'];?></td>
              <td>
               <input type="text" class='entradaTexto' name="baseDatos" id="baseDatos" value="<?php echo $baseDatos;?>" autofocus placeholder="<?php echo $lang[$idioma]['BaseDatos'];?>" ></td>
            </tr>
            
            <tr>
            <td class="text"><span><?php echo $lang[$idioma]['Moneda'];?></span></td>
              <td>
               <input type="text" class='entradaTexto' name="moneda" id="moneda" value="<?php echo $moneda;?>" autofocus placeholder="<?php echo $lang[$idioma]['Moneda'];?>" ></td>
            
            <td class="text"><?php echo $lang[$idioma]['Inventario'];?></td>
              <td>
               <input type="text" class='entradaTexto' name="inventar" id="inventar" value="<?php echo $inventar;?>" autofocus placeholder="<?php echo $lang[$idioma]['Inventario'];?>" ></td>
            </tr>
            
            
                <tr>
                	<!--margen base-->
                    <td class="text" >
                        <?php echo $lang[$idioma]['marpro']; ?>
                    </td>
                    <td colspan="" >
                        <input class='entradaTexto ' type="text" autocomplete="off" value="<?php echo $row['mpro'];?>" id="marpro">
                    </td>
                    
                    <td class="text" >
                        <?php echo $lang[$idioma]['incre1']; ?>
                    </td>
                    <td colspan="" >
                        <input class='entradaTexto ' type="number"  autocomplete="off" value="<?php echo $incre1;?>" id="incre1">
                    </td>
                    
                </tr>

                <!--2 row-->
                <tr>
                    <!--margen minimo-->
                    <td class="text" >
                        <?php echo $lang[$idioma]['marmin']; ?>
                    </td>
                    <td colspan="" >
                        <input class='entradaTexto ' type="text" autocomplete="off" value="<?php echo $row['mmin'];?>" id="marmin">
                    </td>
                    <td class="text" >
                        <?php echo $lang[$idioma]['incre2']; ?>
                    </td>
                    <td colspan="" >
                        <input class='entradaTexto ' type="number" autocomplete="off" value="<?php echo $incre2;?>" id="incre2">
                    </td>
                    
                </tr>
                <!--3 row-->
                <tr>
                    <!--margen maximo-->
                    <td class="text" >
                        <?php echo $lang[$idioma]['marmax']; ?>
                    </td>
                    <td colspan="" >
                        <input class='entradaTexto ' type="text" autocomplete="off" value="<?php echo $row['mmax'];?>" id="marmax">
                    </td>
                     <td class="text" >
                        <?php echo $lang[$idioma]['incre3']; ?>
                    </td>
                    <td colspan="" >
                        <input class='entradaTexto ' type="number" autocomplete="off" value="<?php echo $incre3;?>" id="incre3">
                    </td>
                </tr>
                
                <tr>
                    <!--margen competencia-->
                    <td class="text" >
                        <?php echo $lang[$idioma]['marmincon']; ?>
                    </td>
                    <td colspan="" >
                        <input class='entradaTexto' type="text" autocomplete="off" value="<?php echo $row['marmincom'];?>" id="marmincon">
                    </td>
                    
                     <td class="text" >
                        <?php echo $lang[$idioma]['incre4']; ?>
                    </td>
                    <td colspan="" >
                        <input class='entradaTexto ' type="number" autocomplete="off" value="<?php echo $incre4;?>" id="incre4">
                    </td>
                </tr>
            
			<tr>
			
            <td class="text"><span><?php echo $lang[$idioma]['Imagen'];?></span></td>
              <td class="imagen">
               
        <?php echo verImagen1($codigo,$nombre);?>
		
				
			</td>
			<td class="text"></td>
			<td class="imagen">
			
			 <?php echo verImagen2($codigo,$nombre);?>
			</td>
            </tr>
			
            
            
            <tr>
			<td class="" colspan="4">
            <br><br><br>
            <center>
            <input type="button"   class='cmd button button-highlight button-pill' onClick="editarTodaEmpresa(document.getElementById('nombre').value,document.getElementById('npatronal').value,document.getElementById('rsocial').value,document.getElementById('direccion').value,document.getElementById('nit').value,document.getElementById('telefono').value,document.getElementById('fax').value,document.getElementById('www').value,document.getElementById('email').value,document.getElementById('ctaIva_CR').value,document.getElementById('ctaIva_DB').value,document.getElementById('ctaInven').value,document.getElementById('ctaIvaCRxL').value,document.getElementById('ctaCCxP').value,document.getElementById('ctaIDP').value,document.getElementById('ctaCosto').value,document.getElementById('ctaCajaGR').value,document.getElementById('cPIGSS').value,document.getElementById('cPIntecap').value,document.getElementById('cPIRTRA').value,document.getElementById('cLIGSS').value,document.getElementById('baseDatos').value,document.getElementById('moneda').value,document.getElementById('inventar').value,document.getElementById('codigo').value,document.getElementById('pais').value);subirImagen(this.form,'subirArchivo.php','resultado');" value="<?php echo $lang[$idioma]['Guardar'];?>"/>
           <input type="reset"  class='cmd button button-highlight button-pill' onClick="envioDeData('empresa');" value="<?php echo $lang[$idioma]['Cancelar'];?>"/>
           </center>
            </td>
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