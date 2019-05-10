<?php
$code_number = $_GET['UPC'];
//require_once('../lib/php-barcode-master/barcode.php');
//$generatorJPG = new Picqer\Barcode\BarcodeGeneratorJPG();
echo "<img src='../lib/php-barcode-master/barcode.php?text=$code_number&print=true' />";
