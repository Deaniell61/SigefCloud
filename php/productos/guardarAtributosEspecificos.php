<?php
require_once('../coneccion.php');
require_once('../fecha.php');

$values=limpiar_caracteres_sql($_POST['consulta']);
$codigo=sys2015();
sleep(1);
$codigo1=sys2015();

				$str = $values;
				eval("\$str = \"$str\";");
				$return=$str;
				
				
				echo "insert into cat_esp_atr_pro(codesppro,codespatr,codprod,valor) values".substr($return,0,strlen($return)-1);


?>