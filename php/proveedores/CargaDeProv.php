<?php
session_start();
	$codprod=$_SESSION['codprov'];
	$pais=$_SESSION['pais'];
	$codpais=$_SESSION['CodPaisCod'];
	echo "<script>abrirProveedor('".strtoupper($codprod)."','".$pais."','".$codpais."');</script>";
?>