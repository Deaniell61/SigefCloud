<?php
/**
 * Created by JDR
 * For more information www.facebook.com/DEANIELL6195
 * Unique creator
 */
require_once('../php/coneccion.php');
require_once('../php/fecha.php');
$idioma=idioma();
include('../php/idiomas/'.$idioma.'.php');
$codigo=$_POST['codempresa'];
$rol=$_POST['rol'];
session_start();

$squery="select codempresa,nombre,imagen,rsocial,nit,mempresa from cat_empresas where codempresa='$codigo'";
$ejecutar=mysqli_query(conexion(""),$squery);
				if($ejecutar)
				{
					
					if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
					{
						$_SESSION['codEmpresa']=$row['codempresa'];
						$_SESSION['nomEmpresa']=$row['nombre'];
						$_SESSION['img']=substr($row['imagen'],3);
						$_SESSION['rsocialEmpresa']=$row['rsocial'];
						$_SESSION['nitEmpresa']=$row['nit'];
						$_SESSION['mEmpresa']=$row['mempresa'];
						$_SESSION['rolEmpresa']=$rol;
						$_SESSION['parametro']="";
						$_SESSION['codprov']="";
						$_SESSION['nomProv']="";
						$squery="select p.nompais,p.codigo,p.codpais from direct p inner join cat_empresas e on e.pais=p.codpais where e.codempresa='$codigo'";
						$ejecutar=mysqli_query(conexion(""),$squery);
							if($ejecutar)
								{
					
									if($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
									{
										$_SESSION['pais']=$row['nompais'];
										$_SESSION['CodSKUPais']=$row['codigo'];
										$_SESSION['CodPaisCod']=$row['codpais'];
									}
								}
						
					}
					
				}
				
?>