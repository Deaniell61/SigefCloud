<?php
require_once('../php/coneccion.php');
require_once('../php/fecha.php');

    $periodo=date('Y-m');
    
    $datos=obtenerDatos("");
    /*$datos[0]="localhost";
    $datos[1]="root";
    $datos[2]="1234";
    */
    $pla="";
   //echo var_dump($datos);
    while($pla=="")
    {
        
        $con = mysqli_connect($datos[0], $datos[1], $datos[2], 'quintoso_'.strtolower($pla).'sigef');
            if($pla=="")
            {
                $query1=$con->query("select nombre,iva from cat_peri where nombre='".$periodo."'");

                    if($query1->num_rows==0)
                    {
                        if($con->query("insert into cat_peri(codperi,nombre,cerrado,iva) values('".sys2015()."','".$periodo."',0,0)"))
                        {
                            echo "Actualizado periodo Sigef";
                        }
                    }
            }
            
            if($query=$con->query("select codigo from cat_empresas"))
            {
                while($row=$query->fetch_row())
                {
                    if(strlen($row[0])==1)
					{
						$cod="0".$row[0];
						
					}
					else
					{
						$cod=$row[0];
					}
                    $con2 = mysqli_connect($datos[0], $datos[1], $datos[2], 'quintoso_'.strtolower($pla).'sigef'.$cod);
					
                    $query2=$con2->query("select nombre,iva from cat_peri where nombre='".$periodo."'");

                    if($query2->num_rows==0)
                    {
                        if($con2->query("insert into cat_peri(codperi,nombre,cerrado,iva) values('".sys2015()."','".$periodo."',0,0)"))
                        {
                            echo "Actualizado ".strtoupper($pla).'SIGEF'.$cod;
                        }
                    }
                }
            }
        $pla="r";
    }

?>