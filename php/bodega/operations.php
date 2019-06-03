<?php
use ___PHPSTORM_HELPERS\object;

require_once('../coneccion.php');
    require_once('../fecha.php');
    $idioma=idioma();
    include('../idiomas/'.$idioma.'.php');
    session_start();
    $fecha = date('Y-m-d');
    $controller = $_REQUEST['controller'];
    $pais = $_SESSION['pais'];
    $codpais = $_SESSION['codpais'];
    switch ($controller) {
        case 'buscar/orden':{
            $term = $_POST['term'];
            buscarOrden($term);
            break;
        }
        case 'cargar/upc':{
            $term = $_POST['term'];
            cargarUPC($term);
            break;
        }
        case 'insert/shipping':{
            $term = $_POST['term'];
            $detalle = $_POST['detalle'];
            $data = (object) array("term"=>$term,"detalle"=>$detalle);
            insertShipping($data);
            break;
        }
        default:{
            break;
        }
    }

    function orderDetalle($data){
        $orderIdsQ = "
            SELECT 
                *
            FROM
                tra_ord_det
            WHERE
                codorden = '".$data->codorden."';
            ";

        //echo "$orderIdsQ<br>";
        $orderIdsResult = mysqli_query(conexion($_SESSION["pais"]), $orderIdsQ);
        return mysqli_fetch_assoc($orderIdsResult);
    }
    function cargarUPC($term){
        require_once('../coneccion.php');
        require_once('../fecha.php');
        $idioma=idioma();
        include('../idiomas/'.$idioma.'.php');
        $orden = null;
        $squery = "select * from cat_prod where UPC='$term';";
        if($ejecutar=mysqli_query(conexion($_SESSION["pais"]), $squery)){
            if($ejecutar->num_rows>0){
                $orden= mysqli_fetch_assoc($ejecutar);
            }
        }
        echo json_encode($orden);

    }

    function insertShipping($data){
        require_once('../coneccion.php');
        require_once('../fecha.php');
        // $idioma=idioma();
        include('../idiomas/'.$idioma.'.php');
        $orden = null;
        $codordshi = sys2015();
        $squery = "INSERT INTO tra_ord_shi(codordshi,codorddet,prodname,sku,chamount,status) 
                    VALUES('$codordshi','" . $data->detalle['CODDETORD'] . "','" .$data->detalle['Productos']['Producto']['PRODNAME'] . "','" . $data->detalle['Productos']['Producto']['MASTERSKU'] . "','" . $data->detalle['LINETOTAL'] . "','Created')";
        // $squery = "insert into  cat_prod where UPC='$data->term';";
        if($ejecutar=mysqli_query(conexion($_SESSION["pais"]), $squery)){
            if($ejecutar->num_rows>0){
                $orden= mysqli_fetch_assoc($ejecutar);
            }
        }
        // $orden->append['sinsert'];
        // $orden['sinsert']=$squery1;
        echo json_encode($orden);

    }
    function buscarOrden($term){
        require_once('../coneccion.php');
        require_once('../fecha.php');
        $idioma=idioma();
        include('../idiomas/'.$idioma.'.php');
        $squery = "select * from tra_ord_enc where orderid='$term';";
        $Orden = null;
        if($ejecutar=mysqli_query(conexion($_SESSION["pais"]), $squery)){
            $Orden = mysqli_fetch_assoc($ejecutar);
        }
        if($Orden){
            if(strlen($Orden)>1){
                $oren = array();
                foreach ($Orden as $key => $value) {
                    $squery = "select * from tra_ord_det where codorden='".$value['CODORDEN']."';";
                    if($ejecutar=mysqli_query(conexion($_SESSION["pais"]), $squery)){
                        ($value->append['Detalle']);
                        $value['Detalle'] =mysqli_fetch_assoc($ejecutar);
                        array_push($oren,$value);
                    }
                }
                $Orden = $oren;
            }else{
                $squery = "select * from tra_ord_det where codorden='".$Orden['CODORDEN']."';";
                if($ejecutar=mysqli_query(conexion($_SESSION["pais"]), $squery)){
                    ($Orden->append['Detalle']);
                    $Orden['Detalle'] =mysqli_fetch_assoc($ejecutar);
                }
            }
        }

        if($Orden['Detalle']){
            if(strlen($Orden['Detalle'])>1){
                $ores = array();
                foreach ($Orden['Detalle'] as $key => $value) {
                    $squery = "select * from tra_bun_det where amazonsku='".$value['PRODUCTID']."';";
                    if($ejecutar=mysqli_query(conexion($_SESSION["pais"]), $squery)){
                        if($ejecutar->num_rows>0){
                            ($value->append['Productos']);
                            $value['Productos']=mysqli_fetch_assoc($ejecutar);
                            $squery = "select * from cat_prod where mastersku='".$value['Productos']['MASTERSKU']."';";
                            if($ejecutar=mysqli_query(conexion($_SESSION["pais"]), $squery)){
                                ($value['Productos']->append['Producto']);
                                $value['Productos']['Producto'] = mysqli_fetch_assoc($ejecutar);
                            }
                            $ores = $value;
                        }else{
                            $squery = "select * from cat_prod where mastersku='".$value['PRODUCTID']."';";
                            if($ejecutar=mysqli_query(conexion($_SESSION["pais"]), $squery)){
                                if($ejecutar->num_rows>0){
                                    ($value->append['Productos']);
                                    $value['Productos']=mysqli_fetch_assoc($ejecutar);
                                }
                            }
                            $ores = $value;
                        }
                        
                    }
                }
                $Orden = $ores;
            }else{
                $squery = "select * from tra_bun_det where amazonsku='".$Orden['Detalle']['PRODUCTID']."';";
                
                if($ejecutar=mysqli_query(conexion($_SESSION["pais"]), $squery)){
                    if($ejecutar->num_rows>0){
                        ($Orden['Detalle']->append['Productos']);
                        $Orden['Detalle']['Productos']=mysqli_fetch_assoc($ejecutar);
                        $squery = "select * from cat_prod where mastersku='".$Orden['Detalle']['Productos']['MASTERSKU']."';";
                        if($ejecutar2=mysqli_query(conexion($_SESSION["pais"]), $squery)){
                            ($Orden['Detalle']['Productos']->append['Producto']);
                            $Orden['Detalle']['Productos']['Producto'] = mysqli_fetch_assoc($ejecutar2);
                            $squery = "select * from tra_ord_shi where CODORDDET='".$Orden['Detalle']['CODDETORD']."';";
                            if($ejecutar3=mysqli_query(conexion($_SESSION["pais"]), $squery)){
                                ($Orden['Detalle']->append['pendientes']);
                                ($Orden['Detalle']->append['agregadas']);
                                ($Orden['Detalle']->append['squery']);
                                $Orden['Detalle']['pendientes']= $Orden['Detalle']['QTY']-$ejecutar3->num_rows;
                                $Orden['Detalle']['agregadas']=$ejecutar3->num_rows;
                                $Orden['Detalle']['squery']=$squery;
                            }
                        }
                    }else{
                        $squery = "select * from cat_prod where mastersku='".$Orden['Detalle']['PRODUCTID']."';";
                        if($ejecutar=mysqli_query(conexion($_SESSION["pais"]), $squery)){
                            if($ejecutar->num_rows>0){
                                ($Orden['Detalle']->append['Productos']);
                                $Orden['Detalle']['Productos']=mysqli_fetch_assoc($ejecutar);
                            }
                        }
                    }
                    
                }
            }
            
        }
            echo json_encode($Orden['Detalle']);
            // echo encabezado().makeTable($Orden['Detalle']) ;

            // if order existe
            // traer su detalle
            // en detalle traer cantidad de la orden, codigo de bundle y agregar cantidad de codprod como tenga el bundle
            // si product id buscar en tra_bun_det amazonsku o cat_prod mastersku
            // si esta en carprod es producto padre
                // descargar unidades x1
            // si esta en tra_bun_det descargar cantidad del unit bundle por el mastersku de esa orden
            // upc esta en cat_pro
            
            // llevar registro de movimientos de bodegas en
            // generar registro para tra_mov_enc
            // tra_mov_det agregar una linea por detalle de orden 
            // tra_ord_shi agregar una linea por escaneo

            // cada que escanea un producto en el detalle agrega linea a traordshi, cada que escanea por primeravez el detalle de la orden agrega tra_mov_det
            // en la orden agregarle codmoven tanto de detalle como de encabezado en sus respectivas tablas
            // tra_ord_shi 
            // tra_ord_en tiene shifee ese dato divido (tra_ord_enc.ordeunit o unidad de bundle) es igual a shamount 
            // codbod es para filtrar por bodega

            // echo encabezado().tabla($squery,$pais,$codpais);
    }

    function encabezado()
    {
        require_once('../fecha.php');
        $idioma=idioma();
        include('../idiomas/'.$idioma.'.php');
        return "<center>
                <div>
                <table id=\"tablas\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"hover tablas table\">
                
                    
                    <thead>
                    <tr  class=\"titulo\">
                        <th >".$lang[$idioma]['codProd']."</th>
                        <th>".$lang[$idioma]['descProd']."</th>
                        <th>".$lang[$idioma]['ubicacion']."</th>
                        <th>".$lang[$idioma]['cantidadDespacho']."</th>
                        <th>".$lang[$idioma]['cantidadAgregada']."</th>
                        <th>".$lang[$idioma]['cantidadPendiente']."</th>
                        
                    </tr> </thead>
                    
                
                ";
    }
    function tabla($squer,$pais,$codpais)
    {
        require_once('../fecha.php');
        $idioma=idioma();
        include('../idiomas/'.$idioma.'.php');
        $retornar="";
        $total=0;
        $contador=0;
        $contador2=0;
        $retornar=$retornar."<tbody>";
        $ejecutar=mysqli_query(conexion($pais),$squer);
            if($ejecutar)
            {
                if($ejecutar->num_rows>0)
                {
                    while($row=mysqli_fetch_array($ejecutar,MYSQLI_ASSOC))
                    {
                        if($contador==100)
						{
							$contador=0;
							$pag++;
						}
                        $retornar=$retornar."<tr  id=\"OrdenDetNum".$contador."\">
                                <td><input type=\"checkbox\" id=\"CheckOrdenDetNum".$contador."\" value=\"".strtoupper($row['codorden'])."\" /></td>
                                <td hidden=\"hidden\">".($row['codorden'])."</td>
                                <td><center>".($row['orderid'])."</center></td>
                                <td id=\"ActualState".$contador."\">Bodega</td>
                                <td>".($row['orderid'])."</td>
                                <td><center>".($row['orderid'])."</center></td>
                                <td>".($row['orderid'])."</td>
                                <td>".($row['orderid'])."</td>
                                
                            </tr>";
                        $total=$total+round($row['2'],5,2);
                        $contador++;
                    }
                }
                    mysqli_close(conexion($pais));
                
            }
            else
            {	
                $retornar="Error de llenado de tabla";
            }
                $retornar=$retornar."</tbody></table></div>
                </center><br>
                
                <script   type=\"text/javascript\">

            $(document).ready(function(){
        
                $('#tablas').DataTable( {
                        \"scrollY\": \"300px\",
                        \"scrollX\": true,
                        \"paging\":  true,
                        \"pageLength\": 100,
                        \"info\":     false,
                        \"oLanguage\": {
                    \"sLengthMenu\": \" _MENU_ \",
                    }
                } );
                
                ejecutarpie();
                
            });
            document.getElementById('totalGrid').innerHTML=': ".($contador2)."';
        
            document.getElementById('tablas_length').style.display='none';
            setTimeout(function () {
                $(\"#cargaLoadVP\").dialog(\"close\");
            }, 300);
            </script>";
                    
            $retornar=$retornar."<div id='NotificacionVentana'></div>";	
            return $retornar;
    }

    function makeTable($data){
        $retornar = "";
        if(strlen($data)>1){
            foreach ($data as $key => $value) {
                $retornar=$retornar."<tr  id=\"OrdenDetNum".($key+1)."\">
                                    <td><center>".($value['PRODUCTID'])."</center></td>
                                    <td id=\"ActualState".($key+1)."\">".($value['Productos']['Producto']['DESCSIS'])."</td>
                                    <td>".($value['Productos']['Producto']['CODPROD'])."</td>
                                    <td><center>".$value['QTY']."</center></td>
                                    <td>".$value['QTY']."</td>
                                    <td>".$value['QTY']."</td>
                                    
                                </tr>";
            }
        }else{
            $retornar=$retornar."<tr  id=\"OrdenDetNum".(1)."\">
                <td><center>".($data['PRODUCTID'])."</center></td>
                <td id=\"ActualState".(1)."\">".($data['Productos']['Producto']['DESCSIS'])."</td>
                <td>".($data['Productos']['Producto']['CODPROD'])."</td>
                <td><center>".$data['QTY']."</center></td>
                <td>".$data['QTY']."</td>
                <td>".$data['QTY']."</td>
            
            </tr>";
        }
        
            
        $retornar=$retornar."</tbody></table></div>
                </center>
                
        <script   type=\"text/javascript\">

            $(document).ready(function(){
        
                $('#tablas').DataTable( {
                        \"scrollY\": \"300px\",
                        \"scrollX\": true,
                        \"paging\":  true,
                        \"pageLength\": 100,
                        \"info\":     false,
                        \"oLanguage\": {
                    \"sLengthMenu\": \" _MENU_ \",
                    }
                } );
                
                ejecutarpie();
                
            });
            document.getElementById('tablas_length').style.display='none';
            setTimeout(function () {
                $(\"#cargaLoadVP\").dialog(\"close\");
            }, 300);
            </script>";
                    
            $retornar=$retornar."<div id='NotificacionVentana'></div>";	
            return $retornar;
    }

    

				
?>
