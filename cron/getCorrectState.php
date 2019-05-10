<?php
//echo var_dump(getCorrectState('','36535-9337','AB'));

function getCorrectState($ordId,$zipCode,$state)
{
    require_once('../php/coneccion.php');
    require_once('../php/mails/mensajeOrdenMail.php');

    $con=conexion("");
    $GoogleDirect='https://maps.googleapis.com/maps/api/geocode/json?address=';
	$apyKey='&key=AIzaSyDApgjC6tUNZlYqPFHxSBBtX7TStL-DcAw';
    //AIzaSyDgW7obBgI8oI-rMNwYEevtvn-Wy5pjyJU
    //AIzaSyCdJAwErIy3KmcE_EfHACIvL0Nl1RjhcUo
        $sql="select codigo from cat_estados where codigo='".$state."'";
        $retorna[0]="";
        $retorna[1]="";
            if($ejecuta=$con->query($sql))
            {
                if($ejecuta->num_rows>0)
                {
                    if($row=$ejecuta->fetch_row())
                    {
                        $retorna[0]= $row[0];
                        $retorna[1]= $row[0];
                    }
                }
                else
                {
                    $codCity="99";
                    $googleFile=file_get_contents($GoogleDirect.urlencode($zipCode).$apyKey);
                    $json=json_decode($googleFile,true);
                        
                    for($i=0;$i<count($json['results'][0]['address_components']);$i++)
                    {
                        if($json['results'][0]['address_components'][$i]['types'][0]=="administrative_area_level_1")
                        {
                            $codCity=$json['results'][0]['address_components'][$i]['short_name'];
                        }
                        
                        
                    }
                    $retorna[0]= $codCity;
                    $retorna[1]= "<".$state.">"; 
                    $con->query("update cat_estados set variaciones=variaciones+',".$state."' where codigo='".$retorna[0]."'");

                    if($codCity=="99")
                    {
                        $retorna[0]= $state;
                        $retorna[1]= "<".$state.">"; 
                        $asunto = "Cambio de estado";
                        $pais="Guatemala";
                        $mensaje = utf8_decode(
                        "<html>
                            <head>
                            </head>

                        <body>

                            <span style=\"text-align:center; color:red; width:100%; margin-left:0%;\">
                                <strong>Soporte.</strong>
                            </span>
                            <br>
                            <br>
                        <center>
                            <div style=\"text-align:left; color:blue; width:70%;\">
                                    Se Ingreso el estado: <strong>".$state."</strong>
                                    <br>
                                    Con el ZipCode: <strong>".$zipCode."</strong>
                                    <br>
                                    El cual no pertenece a un estado conocido por google.
                                    <br>
                                    De la orden: <strong>".$ordId."</strong>
                                    <br>
                            </div>
                        </center>	
                        <br>
                        <br>
                            <div style=\"text-align:rigth; color:#D67900; width:100%; margin-left:10%;\" >
                                   Favor verificar el estado.
                                    <br>
                                    <br>
                            </div>

                        <center> 
                            <a href=\"http://www.sigefcloud.com/\">
                                <img style=\"cursor:pointer;\" src=\"http://sigefcloud.com/images/paises/".str_replace(" ","%20",$pais).".png\"  width='200' height='100' alt=\"World Direct\">
                            </a>
                            <br>
                            <br>
                            http://www.sigefcloud.com/ 
                        </center>

                        </body>	

                        </html>");
                        enviaEmailOrden($mensaje,$ordId,$asunto);

                        
                    }
                       
                    }
                }
            
            return $retorna;
}
?>