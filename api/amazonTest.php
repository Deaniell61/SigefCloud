<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/lib/amazonMWS/src/MarketplaceWebServiceProducts/amazonMWS.php");
$amazonMWS = new amazonMWS();
//$result = $amazonMWS->getPriceForSKU("300003");
$result = $amazonMWS->syncProduct("502300999");
echo "result: $result";
