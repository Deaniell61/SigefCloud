<?php
echo "fix tra_ord_enc<br><br>";
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
$getData = "SELECT CODORDEN, ESTATUS, PAYSTA, PAYDAT, PAYREFNUM, SHISTA, PAYMET, SHIPDATE, SHIFEE, SHIFIRNAM, SHILASNAM, SHIADD1, SHIADD2, SHIPCITY, SHIPSTATE, SHIZIPCOD, SHICOU, SHIMETSEL FROM tra_ord_enc;";
$data = mysqli_query(conexion("DEMO"), $getData);
$counter = 0;
$total = 0;
foreach ($data as $item) {
    $update = "
        UPDATE tra_ord_enc SET 
        ESTATUS = '".$item["ESTATUS"]."', 
        PAYSTA = '".$item["PAYSTA"]."', 
        PAYDAT = '".$item["PAYDAT"]."', 
        PAYREFNUM = '".$item["PAYREFNUM"]."', 
        SHISTA = '".$item["SHISTA"]."', 
        PAYMET = '".$item["PAYMET"]."', 
        SHIPDATE = '".$item["SHIPDATE"]."',
        SHIFEE = '".$item["SHIFEE"]."', 
        SHIFIRNAM = '".addslashes($item["SHIFIRNAM"])."', 
        SHILASNAM = '".addslashes($item["SHILASNAM"])."', 
        SHIADD1 = '".addslashes($item["SHIADD1"])."', 
        SHIADD2 = '".addslashes($item["SHIADD2"])."', 
        SHIPCITY = '".$item["SHIPCITY"]."', 
        SHIPSTATE = '".$item["SHIPSTATE"]."', 
        SHIZIPCOD = '".$item["SHIZIPCOD"]."', 
        SHICOU = '".$item["SHICOU"]."', 
        SHIMETSEL = '".$item["SHIMETSEL"]."'
        WHERE CODORDEN = '".$item["CODORDEN"]."';";
//    var_dump($item);
//    echo $update."<br><br>";
    $result = mysqli_query(conexion("Guatemala"), $update);
    if($result){
        $counter += 1;
    }
    else{
        echo $update."<br><br>";
    }
    $total += 1;
}
echo $counter . "/" . $total;