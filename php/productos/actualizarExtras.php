<?php
require_once('../coneccion.php');
require_once('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');

## usuario y clave pasados por el formulario
$formul= strtoupper($_POST['formul']);
$codempresa= strtoupper($_POST['empresa']);
$nombre= limpiar_caracteres_sql($_POST['nombre']);
$pais=limpiar_caracteres_sql($_POST['pais']);
$ancho=limpiar_caracteres_sql($_POST['ancho']);
$alto=limpiar_caracteres_sql($_POST['alto']);
$largo=limpiar_caracteres_sql($_POST['largo']);
$pesoUni=limpiar_caracteres_sql($_POST['pesoUni']);
$pesoUni2=limpiar_caracteres_sql($_POST['pesni']);
$codigoUnico="";
$idunico="";
session_start();
verTiempo2();
switch($formul)
{
	case 'MARCA':
		{
			$cod=$_SESSION['codExtra'];
			$codigoUnico=$cod;
			$idunico="marca";
			$codprov=limpiar_caracteres_sql($_POST['alto']);
			$squery="update cat_marcas set nombre='".$nombre."' where codmarca='".$cod."'";			
			
			break;
		}
	case 'CATEGORY':
		{
			$squery="insert into cat_cat_pro(codcate,nombre,codempresa) values('".$_SESSION['codExtra']."','".$nombre."','".$codempresa."');";
			break;
		}
	case 'SUBCATEGORY':
		{
			$squery="insert into cat_sca_pro(codscapro,nombre,url,codempresa) values('".$_SESSION['codExtra']."','".$nombre."','".$alto."','".$codempresa."');";
			break;
		}
	case 'PRODLIN':
		{
			$cod=$_SESSION['codExtra'];
			$codigoUnico=$cod;
			$idunico="prodLin";
			$codprov=limpiar_caracteres_sql($_POST['ancho']);
			$squery="update cat_pro_lin set prodline='".$nombre."',codigo='".$alto."' where codprolin='".$cod."'";
			
			break;
		}
	case 'COMERCIALIZA':
		{
			$squery="insert into cat_COM_CANALES(codcomcan,nombre,codigo) values('".$_SESSION['codExtra']."','".$nombre."','".$alto."');";
			break;
		}
	case 'EXPORTACION':
		{
			$squery="insert into cat_For_exportar(codforexp,nombre,codigo) values('".$_SESSION['codExtra']."','".$nombre."','".$alto."');";
			break;
		}
	case 'TRANSPORTE':
		{
			$squery="insert into cat_transportes(codtransporte,nombre,codigo) values('".$_SESSION['codExtra']."','".$nombre."','".$alto."');";
			break;
		}
	case 'PAKAGE':
		{
			$cod=$_SESSION['codExtra'];
			
			$squery="insert into cat_tip_emp(codpack,nombre,codempresa,alto,ancho,largo) values('".$cod."','".$nombre."','".$codempresa."','".$alto."','".$ancho."','".$largo."');";
			
			break;
		}
	case 'SIZE':
		{
			$cod=$_SESSION['codExtra'];
			$codigoUnico=$cod;
			$idunico="size";
			$codprov=limpiar_caracteres_sql($_POST['pesoUni']);
			
			$squery="update cat_pre_prod set nombre='".$nombre."',peso='".$alto."',unidades='".$ancho."',presenta='".$largo."',pesouni='".$pesoUni2."' where codprepro='".$cod."'";
			
			break;
		}
		case 'FLAVOR':
		{
			$cod=$_SESSION['codExtra'];
			$codigoUnico=$cod;
			$idunico="flavor";
			$codprov=limpiar_caracteres_sql($_POST['alto']);
			$squery="update cat_flavors set nombre='".$nombre."' where codflavor='".$cod."'";
			
			break;
		}
		case 'AGESEGMENT':
		{
			$squery="insert into cat_agesegment(codageseg,nameageseg,code,codempresa) values('".$_SESSION['codExtra']."','".$nombre."','".$alto."','".$codempresa."');";
			break;
		}
		case 'COCINA':
		{
			$cod=$_SESSION['codExtra'];
			$codigoUnico=$cod;
			$idunico="cocina";
			$codprov=limpiar_caracteres_sql($_POST['alto']);
			$squery="update cat_cocina set nombre='".$nombre."' where codcocina='".$cod."'";
			
			break;
		}
		case 'CONCERNS':
		{
			$squery="insert into cat_concerns(codconcern,nombre,codempresa) values('".$_SESSION['codExtra']."','".$nombre."','".$codempresa."');";
			break;
		}
		case 'SELLER':
		{
			$cod=$_SESSION['codExtra'];
			$codigoUnico=$cod;
			$idunico="competencia";
			$codprov=limpiar_caracteres_sql($_POST['pesoUni']);
			$squery="insert into cat_sellers(codseller,nombre,codempresa,codprov) values('".$cod."','".$nombre."','".$_SESSION['codEmpresa']."','".$_SESSION['codprov']."');";
			
			
			break;
		}
		case 'FORMULA':
		{
			$cod=$_SESSION['codExtra'];
			$codigoUnico=$cod;
			$idunico="formula";
			$codprov=limpiar_caracteres_sql($_POST['pesoUni']);
			$squery="update cat_forms set nombre='".$nombre."' where codform='".$cod."'; ";
			
			break;
		}
		case 'MANUFACT':
		{
			$cod=$_SESSION['codExtra'];
			$codigoUnico=$cod;
			$idunico="manufacturadores";
			
			$codprov=limpiar_caracteres_sql($_POST['pesoUni']);
			$ciudad=limpiar_caracteres_sql($_POST['ciudad']);
			$estado=limpiar_caracteres_sql($_POST['estado']);
			$codpos=limpiar_caracteres_sql($_POST['codpos']);
			$pais23=limpiar_caracteres_sql($_POST['pais2']);
			$squery="update cat_manufacturadores set nombre='".$nombre."',codigo='".$alto."',codempresa='".$codempresa."',fda='".$ancho."',direccion='".$largo."',ciudad='".$ciudad."',estado='".$estado."',codpos='".$codpos."',pais='".$pais23."' where codmanufac='".$cod."'";
			
			break;
		}
		case 'ARANCEL':
		{
			$squery="insert into cat_par_arancel(codarancel,nombre,codigo) values('".$_SESSION['codExtra']."','".$nombre."','".$alto."');";
			break;
		}
		case 'PAISORIGEN':
		{
			$cod1=$_POST['cod1'];
			$cod2=$_POST['cod2'];
			$cod3=$_POST['cod3'];
			$squery="insert into cat_country(codcountry,nombre,nombreonu,codeco,codigo1,codigo2,codigo3,codigo4,codigo5,codigo6) values('".$_SESSION['codExtra']."','".$nombre."','".$codempresa."','".$alto."','".$ancho."','".$largo."','".$pesoUni."','".$cod1."','".$cod2."','".$cod3."');";
			$pais='';
			break;
		}
		case 'BUNDLE':
		{
			require_once('../formulas.php');
			$masteSKU=$alto;
			$prodName=$ancho;
			$uBundle=$nombre;
			$bundle=$largo;
			$uniVenta=$pesoUni;
			$bundles=intval($uniVenta/$bundle);
			$cantBundle=$uniVenta-($bundles*$bundle);
		
					$amSKU="";
					$amazonQuery="select amazonsku from tra_bun_det order by amazonsku desc limit 1";
					if($ejecutaAmazon=mysqli_query(conexion($_SESSION['pais']),$amazonQuery))
					{
						if(mysqli_num_rows($ejecutaAmazon)>0)
						{
							if($row=mysqli_fetch_array($ejecutaAmazon,MYSQLI_ASSOC))
								{
									$amSKU=$row['amazonsku'];
									$amSKU=intval($amSKU)+1;
								}
						}
						else
						{
							$amSKU="500001";
							$amSKU=intval($amSKU);
						}
					}
					$contadors=0;
					
				
			$chanelQuery="select codchan from cat_sal_cha where columna!=''";
					if($ejecutaChanel=mysqli_query(conexion($_SESSION['pais']),$chanelQuery))
					{
						if(mysqli_num_rows($ejecutaChanel)>0)
						{
							while($rowChanel=mysqli_fetch_array($ejecutaChanel,MYSQLI_ASSOC))
								{
									crearBundle($codempresa,$masteSKU,$prodName,$rowChanel['codchan'],$uBundle,$amSKU,$uniVenta,$cantBundle);
								}
								
								
						}
					}
					$squery="select * from tra_bun_det";
				
			break;
		}
		default:
		{
					$squery="select * from tra_bun_det";
					break;
					
		}
}
if($nombre=='')
{
	echo "Debe ingresar un Dato";
}
else
{
if(mysqli_query(conexion($pais),$squery))
{
	if(isset($squery2))
	{
		mysqli_query(conexion($pais),$squery2);
	}
						if($idunico=="size")
						{
							echo "<span>Guardado correctamente <script>setTimeout(function(){window.opener.\$('#Busqueda').html('');window.opener.\$('#Busqueda').dialog('close');},500);setTimeout(function(){if(window.opener.document.getElementById('".$idunico."')){window.opener.document.getElementById('".$idunico."').value='".$codigoUnico."';window.opener.document.getElementById('uniVenta').value='".$ancho."';}},1300);</script></span>";
						}
						else
						{
							echo "<span>Guardado correctamente <script>setTimeout(function(){window.opener.\$('#Busqueda').html('');window.opener.\$('#Busqueda').dialog('close');},500);setTimeout(function(){if(window.opener.document.getElementById('".$idunico."')){window.opener.document.getElementById('".$idunico."').value='".$codigoUnico."';}},1300);</script></span>";
						}
						mysqli_close(conexion($pais));
}
else
{
	echo "$squery";
}
}
?>
