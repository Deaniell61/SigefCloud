<?php
require_once('../lib/barcode.inc.php');
$code_number = $_GET['UPC'];
new barCodeGenrator($code_number,0,'UPC.gif', 170, 60, true);
?>