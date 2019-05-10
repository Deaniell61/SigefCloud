<?php
    function getArrayBD($sql,$con){
        $cont=0;
        $return=array();
        if($ejecuta=$con->query($sql)){
                while($row=$ejecuta->fetch_assoc()){
                    $return[$cont]=$row;
                    $cont++;
                }
                return $return;
        }else{
            echo "error de query";
        }
    }

    function getCountArrayBD($sql,$con){
        $cont=99;
        $return=array();
        if($ejecuta=$con->query($sql)){
                $cont=$ejecuta->num_rows;
                /*while($row=$ejecuta->fetch_assoc()){
                    $return[$cont]=$row;
                    $cont++;
                }*/
               
        } else{
            echo "error de query";
        }
         return $cont;
    }

    function getArrayBDNum($sql,$con){
        $cont=0;
        $return=array();
        if($ejecuta=$con->query($sql)){
                while($row=$ejecuta->fetch_row()){
                    $return[$cont]=$row;
                    $cont++;
                }
                return $return;
        }else{
            echo "error de query";
        }
    }
?>