<?php

require_once('../lib/barcode.inc.php');

$code_number = $_POST['UPC'];

//echo "<img src='clsGenerarCodigoBarras.php?UPC=".$code_number."'>";
echo "<img src='../lib/php-barcode-master/barcode.php?text=$code_number&print=true'>";

?>