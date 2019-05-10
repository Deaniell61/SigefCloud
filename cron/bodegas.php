<?php
require_once('../php/coneccion.php');
require_once('../php/fecha.php');
$idioma=idioma();
include('../php/idiomas/'.$idioma.'.php');

  $con=conexion("");
  $datos=obtenerDatos("");
  //$conR=conexionProveedorLocal("");
  $conR = mysqli_connect($datos[0], $datos[1], $datos[2], 'quintoso_rsigef');
	require_once('../php/funciones.php');
    
	$qBalance="select * from cat_bal_cobro order by inicia desc limit 1";
    $rBalance=getArrayBD($qBalance,$con);
	$qProyectos="select * from cat_car_proyecto";
    $rProyectos=getArrayBD($qProyectos,$con);
    $qEmpR='select codigo,origen from cat_empresas where balcobro=1';
	$rEmpR=getArrayBD($qEmpR,$conR);
    foreach($rEmpR as $EmpR){
	$qPais='select d.codigo,
                   d.nompais,
                   d.codproloc,
                   (select se.nombre from cat_empresas se where se.pais=d.codpais limit 1),
                   (select se.notiprov from cat_empresas se where se.pais=d.codpais limit 1) from direct d where d.codproloc="'.$EmpR['origen'].'"';
	$rPais=getArrayBD($qPais,$con);
	$lcFecha=date('Y-m-d');
    if(isset($_GET['fecha'])){
        $lcFecha=$_GET['fecha'];
        $lcFechaF=$_GET['fecha'];
    }else{
        $lcFecha=date('Y-m-d');
        $lcFechaF=date('Y-m-d');
    }
	$nuevafecha = strtotime ( '-14 day' , strtotime ( $lcFechaF ) ) ;
	$lcFechaI = date ( 'Y-m-d' , $nuevafecha );
	foreach($rBalance as $Balance){
        if($lcFechaF." 00:00:00">=$Balance['INICIA'] && $lcFechaF." 00:00:00"<=$Balance['TERMINA']){
            foreach($rProyectos as $proyectos){
                if($proyectos['APLICA']=='PA'){
                        foreach($rPais as $pais){
                            echo $pais['nompais']."<br>";
                            $conD=null;
                            $sqlProloc="select * from cat_empresas where codempresa='".$pais['codproloc']."'";
                            $rProloc=getArrayBD($sqlProloc,$conR);
                            foreach($rProloc as $proloc){
                                $sqlDestino="select * from cat_empresas where codempresa='".$proloc['DESTINO']."'";
                                $rDestino=getArrayBD($sqlDestino,$conR);
                                foreach($rDestino as $destino){
                                    $conD = mysqli_connect($datos[0], $datos[1], $datos[2], 'quintoso_rsigef'.$destino['CODIGO']);
                                   // echo 'el destino es quintoso_rsigef'.$destino['CODIGO'];
                                }
                            }
                            $conP=conexion($pais['nompais']);
		                    $conRP = mysqli_connect($datos[0], $datos[1], $datos[2], 'quintoso_rsigef'.$EmpR['codigo']);
                           
                            //$conRP=conexionProveedorLocal($pais['nompais']);
                            //$qCobroExistencia="select * from tra_exi_pro where existencia > 0";
                            //$rCobroExistencia=getArrayBD($qCobroExistencia,$conP);                            
                                $qProveedores="select * from cat_prov";
                                $rProveedores=getArrayBD($qProveedores,$conP);
                                foreach($rProveedores as $Proveedores){
                                    $st=0;
                                    $total1=0;
                                    $lcObser = '';
                                    $qVerificaIns='';
                                    $qProductos="select * from cat_prod where codprov='".$Proveedores['CODPROV']."'";
                                    $rProductos=getArrayBD($qProductos,$conP);
                                    foreach($rProductos as $Productos){
                                        
                                        $qCobroBodegas="select * from cat_bodegas where bodegaje=1";
                                        $rCobroBodegas=getArrayBD($qCobroBodegas,$con);
                                        foreach($rCobroBodegas as $CobroBodegas){
                                            //$qCobroExistencia="select * from tra_exi_pro where codprod='".$Productos['CODPROD']."' and existencia>=1";
                                            
                                            $qCobroExistencia="select a.codmovbod, 
                                                                    a.fecha, 
                                                                    a.codbod, 
                                                                    a.codprove, 
                                                                    b.codtmov, 
                                                                    b.codprod, 
                                                                    b.cantidad, 
                                                                    b.movimiento, 
                                                                    b.existencia, 
                                                                    b.ubicacion from tra_mob_enc as a, 
                                                                                    tra_mob_det as b where a.tipomov = 'IB' and 
                                                                                                            a.fecha <= '".$lcFecha." 23:59:59' and 
                                                                                                            b.codmovbod = a.codmovbod  and 
                                                                                                            b.existencia >= 1 and 
                                                                                                            b.codprod='".$Productos['CODPROD']."'  order by ubicacion";
                                                                                                            /* and 
                                                                                                            b.codprod='".$Productos['CODPROD']."' */
                                            $rCobroExistencia=getArrayBD($qCobroExistencia,$conP);
                                            $lcUbi2="";
                                            foreach($rCobroExistencia as $CobroExistencia2){
                                                $lcUbi2=$CobroExistencia2['ubicacion'];
                                                break;
                                            }
                                           // echo "esto<br>";
                                           $qProductosVen="select * from cat_prod_ven where codigo='".$proyectos['CODIGO']."'";
                                           $rProductosVen=getArrayBD($qProductosVen,$conRP);
                                            foreach($rProductosVen as $ProductosVen){
                                            
                                                    foreach($rCobroExistencia as $CobroExistencia){
                                                        $lcUbi1=$CobroExistencia['ubicacion'];
                                                        $lcPallets = 0;
                                                        $lcDias = 1;
                                                        
                                                        $lcPeso = 0;
                                                        $lcPrecio = $ProductosVen['PVENTA'];
                                                        $total=((($CobroExistencia['existencia'] / $Productos['UNIVENTA']) / ($Productos['NIVPALET'] * $Productos['CAJANIVEL'])));
                                                        $total1+=($total); 
                                                            $qCobroCliente="select * from cat_clie where ".((SUBSTR($lcUbi2,1,1) == '_' || SUBSTR($lcUbi2,1,1) == '')?"codclie = '":"codigo = '").$lcUbi2."'";
                                                            $rCobroCliente=getArrayBD($qCobroCliente,$conP);
                                                            $lcPallets = $lcPallets + (($CobroExistencia['existencia']/$Productos['UNIVENTA']) / ($Productos['NIVPALET'] * $Productos['CAJANIVEL']));
                                                            $lcObser = $lcObser.(EMPTY($lcObser)?'':"\n").TRIM($Productos['MASTERSKU']).' - ('.TRIM(($CobroExistencia['existencia'])).'/'.TRIM(($Productos['UNIVENTA'])).'='.TRIM(($CobroExistencia['existencia']/$Productos['UNIVENTA'])).')'.'/('.TRIM(($Productos['NIVPALET'])).'*'.TRIM(($Productos['CAJANIVEL'])).'='.TRIM(($Productos['NIVPALET'] * $Productos['CAJANIVEL'])).') = '.TRIM($total);
                                                                $qDetaCobro="select * from tra_det_cobro_1 where codbalance = '".$Balance['CODBALANCE']."' and 
                                                                                                                codprov = '".$Proveedores['CODPROV']."' and 
                                                                                                                codtiproy = '".$proyectos['TIPOPROY']."' and 
                                                                                                                codcargo = '".$proyectos['CODCARGO']."'";
                                                                //if(intval(getCountArrayBD($qDetaCobro,$conP))==0){
                                                                if(intval(getCountArrayBD($qDetaCobro,$conD))==0){
                                                                    $qDetaCobroIns="insert into tra_det_cobro_1(coddetcob,codbalance,codprov,codtiproy,codcargo,valor) 
                                                                                                            values('".sys2015()."',
                                                                                                                '".$Balance['CODBALANCE']."', 
                                                                                                                '".$Proveedores['CODPROV']."', 
                                                                                                                '".$proyectos['TIPOPROY']."', 
                                                                                                                '".$proyectos['CODCARGO']."',0);";
                                                                    if($conD->query($qDetaCobroIns)){
                                                                        echo "Ingresado detaCobro<br>";
                                                                    }else{
                                                                        echo $qDetaCobroIns."<br>";
                                                                    }
                                                                }
                                                                $rDetaCobro=getArrayBD($qDetaCobro,$conD);
                                                                //foreach($rProductos as $Productos){
                                                                
                                                                foreach($rDetaCobro as $DetaCobro){
                                                                    sleep(1);
                                                                    $qVerifica="select * from tra_bit_cobro_1 where coddetcob = '".$DetaCobro['CODDETCOB']."' and 
                                                                                                                coddocto = '".$CobroBodegas['CODBODEGA']."' and 
                                                                                                                fechacar like '".$lcFecha."%'";
                                                                    
                                                                    $lcPrecio=$ProductosVen['PVENTA'];
                                                                    $str = trim(stripslashes($proyectos['formulaphp']));
                                                                    eval("\$str = \"$str\";");
                                                                    eval("\$sto = $str;");
                                                                    $st+=$sto;
                                                                    //$lcObser.=$lcObser;
                                                                    
                                                                    //$lcDias2=$lcPallets*(($Productos['PVENTA']/30) * $lcDias);
                                                                    if(intval(getCountArrayBD($qVerifica,$conD)<1)){
                                                                        
                                                                        $st=ceil($total1)*($lcPrecio/30);//valor de todos los productos
                                                                        $qVerificaIns="insert into tra_bit_cobro_1(codbitcob,coddetcob,coddocto,fechacar,codcargo,cantidad,precio,valor,obser) 
                                                                                                                values('".sys2015()."',
                                                                                                                    '".$DetaCobro['CODDETCOB']."', 
                                                                                                                    '".$CobroBodegas['CODBODEGA']."', 
                                                                                                                    '".$lcFecha."', 
                                                                                                                    '".$proyectos['CODCARGO']."',
                                                                                                                    '".ceil($total1)."',
                                                                                                                    '".$lcPrecio."',
                                                                                                                    ".$st.",
                                                                                                                    '".$lcObser."');";
                                                                        
                                                                        
                                                                    }
                                                                    $rVerifica=getArrayBD($qVerifica,$conD);
                                                                    foreach($rVerifica as $Verifica){
                                                                        //echo $Productos['PRODNAME']." -/- ".$Proveedores['NOMBRE']." -\ ".$CobroExistencia['existencia']." - ".$CobroExistencia['movimiento']." /- ".$CobroExistencia['ubicacion']." - ".$Productos['MASTERSKU']." -\ ".ceil($lcPallets)." - |".$lcObser."| - $lcPrecio<br>";
                                                                    }   
                                                                }
                                                                $qCobroProductos="select * from cat_prod_ven";
                                                                $rCobroProductos=getArrayBD($qCobroProductos,$conP);
                                                                foreach($rCobroProductos as $CobroProductos){
                                                                    if($CobroExistencia['codprod']==$CobroProductos['CODPROD']){
                                                                        echo $Productos['MASTERSKU']."<br>";
                                                                        foreach($rProductos as $CloudProductos){
                                                                            if($CloudProductos['MASTERSKU']==$CobroProductos['CODIGO']){
                                                                                echo $Productos['MASTERSKU']."<br>";
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                $lcUbi2="";
                                                                $lcUbi2=$lcUbi1;
                                                    }
                                            }
                                        }
                                            //echo "<br>";
                                    }

                                    //aqui va el ingreso
                                    if($st>0){
                                        echo "Ingresado |".ceil($total1)."| $lcFechaF ($st) $lcPrecio || $lcObser<br>$qVerificaIns<br>";
                                        if($conD->query($qVerificaIns)){
                                            $qDetaCobroUP="update tra_det_cobro_1 set valor=valor+($st) where coddetcob='".$DetaCobro['CODDETCOB']."';";
                                            if($conD->query($qDetaCobroUP)){
                                                echo "Ingresado bitCobro<br>";
                                            }
                                        }else{
                                            echo $qVerificaIns."<br>";
                                        }
                                    }
                                }
                            $conP->close();
                        }
                }
            }
         }else{
            $qBalanceIns="insert into cat_bal_cobro(CODBALANCE,INICIA,TERMINA,CODIGO,ESTATUS) 
                            values('".sys2015()."',
                                    '".$lcFechaI."',
                                    '".$lcFechaF."',
                                    '14".str_replace('-','',$lcFechaI).str_replace('-','',$lcFechaF)."',
                                    '1');";
            if($con->query($qBalanceIns)){
                echo $qBalanceIns;
            }
        }
	} 
    }
	$con->close();
/*
	
	$fechaI=date('Y-m-d');
	$nuevafecha = strtotime ( '+14 day' , strtotime ( $fechaI ) ) ;
	$fechaF = date ( 'Y-m-d' , $nuevafecha );
	
	foreach($rTipoProyecto as $empresas){
		var_dump($empresas);
		echo "<br>";echo "<br>";
	} 
/*
	$datos=obtenerDatos("");
	$con = mysqli_connect($datos[0], $datos[1], $datos[2], 'quintoso_'.strtolower($pla).'sigef');
*/
?>