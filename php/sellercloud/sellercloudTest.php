<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/php/sellercloud/sellercloud.php");
session_start();
$sellercloud = new sellercloud();
//echo $_SESSION["codEmpresa"] . "<br>";
var_dump($sellercloud->getZipCode("33175"));
if (isset($_GET['ws'])) {
/*
    $ws = $_GET['ws'];
    $_SESSION["CODORDEN"] = "_4u0109f9h"; //_4IF1DJ08A
    $_SESSION["CODBODEGA"] = "_4A216W6BO"; //_4IF1DJ08A
    echo $_SESSION["CODORDEN"]." - ".$_SESSION["CODBODEGA"]."<br>";
    $tTest = $sellercloud->testArray($ws);
    var_dump($tTest);
//    $tt = $sellercloud->createNewOrder();
//    var_dump($tt);
    //test order ids: 5180489, object(stdClass)#7 (1) { ["CreateNewOrderResult"]=> int(5181042) }
*/
} else {
//$tClientId = $sellercloud->getClientId();
//$tClientName = $sellercloud->getClientName();
//echo $tClientName;
//$tTest = $sellercloud->createNewOrderTest();
//var_dump($tTesaaaaaaaa
//$tCompaniesList = $sellercloud->getComapniesList();
//var_dump($tCompaniesList);
//$tZipCodeInfo = $sellercloud->getZipCodeInfo();
//var_dump($tZipCodeInfo);\
//    $tTest = $sellercloud->testArray("CreateNewOrder");
//    var_dump($tTest);
//    $tt = $sellercloud->getUser("romalch@gmail.com");
//    var_dump($tt);
//    $tt = $sellercloud->createNewOrder();
//    var_dump($tt);
}
