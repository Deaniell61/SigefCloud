<?php
require_once('../coneccion.php');
include('../fecha.php');
$idioma=idioma();
include('../idiomas/'.$idioma.'.php');
$empresa=$_POST['empresa'];
$usuario=$_POST['usuario'];
$modulo=$_POST['codigo'];
function compEmpresa($usuario,$empresa,$codigo,$colum)
	{
		$squery="select codacceso from sigef_accesos where codusua='$usuario' and codempresa='$empresa' and codmodu='$codigo' and $colum=1";
		
		$ejecutar=mysqli_query(conexion(""),$squery);
				if($ejecutar)
				{
					if($ejecutar->num_rows>0)
					{
					return " checked=\"checked\" ";
					}
					else
					{
						return " ";
					}
				}
					
	}
	
function nombreModul($codigo)
	{
		$squery="select nombre from sigef_modulos where codigo='$codigo'";
		
		$ejecutar=mysqli_query(conexion(""),$squery);
				$row = mysqli_fetch_array($ejecutar, MYSQLI_ASSOC);
		return strtoupper($row['nombre']);
					
	}

echo 	"
<center>".$lang[$idioma]['Modulo']." : ".nombreModul($modulo)."</center>
<div class=\"acidjs-css3-treeview\">
		<ul>
			<li>
		<input type=\"checkbox\" id=\"nodeAgrega\" />
		 		<label>
					<input id=\"chAgrega\"".compEmpresa($usuario,$empresa,$modulo,"agrega")."onChange=\"guardarOpciones('$usuario',document.getElementById('chAgrega').checked,'".$empresa."','".$modulo."','agrega');\"  type=\"checkbox\" value=\"agrega\"/>
						<span></span>
				</label>
				<label for=\"nodeAgrega\">
					Agrega
				</label>
			</li>
			<li>
		<input type=\"checkbox\" id=\"nodeModifica\" />
		 		<label>
					<input id=\"chModifica\"".compEmpresa($usuario,$empresa,$modulo,"modifica")."onChange=\"guardarOpciones('$usuario',document.getElementById('chModifica').checked,'".$empresa."','".$modulo."','modifica');\"  type=\"checkbox\" value=\"modifica\"/>
						<span></span>
				</label>
				<label for=\"nodeModifica\">
					Modifica
				</label>
			</li>
			<li>
		<input type=\"checkbox\" id=\"nodeElimina\" />
		 		<label>
					<input id=\"chElimina\"".compEmpresa($usuario,$empresa,$modulo,"elimina")."onChange=\"guardarOpciones('$usuario',document.getElementById('chElimina').checked,'".$empresa."','".$modulo."','elimina');\"  type=\"checkbox\" value=\"elimina\"/>
						<span></span>
				</label>
				<label for=\"nodeElimina\">
					Elimina
				</label>
			</li>
			<li>
		<input type=\"checkbox\" id=\"nodeNavega\" />
		 		<label>
					<input id=\"chNavega\"".compEmpresa($usuario,$empresa,$modulo,"navega")."onChange=\"guardarOpciones('$usuario',document.getElementById('chNavega').checked,'".$empresa."','".$modulo."','navega');\"  type=\"checkbox\" value=\"navega\"/>
						<span></span>
				</label>
				<label for=\"nodeNavega\">
					Navega
				</label>
			</li>
			<li>
		<input type=\"checkbox\" id=\"nodeReporte\" />
		 		<label>
					<input id=\"chReporte\"".compEmpresa($usuario,$empresa,$modulo,"reporte")."onChange=\"guardarOpciones('$usuario',document.getElementById('chReporte').checked,'".$empresa."','".$modulo."','reporte');\"  type=\"checkbox\" value=\"reporte\"/>
						<span></span>
				</label>
				<label for=\"nodeReporte\">
					Reporte
				</label>
			</li>
			<li>
		<input type=\"checkbox\" id=\"nodeHistorico\" />
		 		<label>
					<input id=\"chHistorico\"".compEmpresa($usuario,$empresa,$modulo,"historico")."onChange=\"guardarOpciones('$usuario',document.getElementById('chHistorico').checked,'".$empresa."','".$modulo."','historico');\" type=\"checkbox\" value=\"historico\"/>
						<span></span>
				</label>
				<label for=\"nodeHistorico\">
					Historico
				</label>
			</li>
		</ul>
	</div>		
		";


 ?>