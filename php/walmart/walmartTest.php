<?php

//include_once ("auth.php");
include_once("walmart.php");

//$auth = new auth();
$walmart = new walmart(true);

//$testURL = "https://api-gateway.walmart.com/v3/feeds?feedType=SUPPLIER_FULL_ITEM";
//$testURL = "https://api-gateway.walmart.com/v3/orders/released?shipNode=855653&createdStartDate=2015-01-01";

//$tAuth = $auth->getSignature($testURL);
//$tTimestamp = $tAuth["timestamp"];
//$tSignature = $tAuth["signature"];

//


?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<html>
<body>
<!--<div>-->
<!--    <textarea id="customRequest" rows="2" cols="150">-->
<!---->
<!--    </textarea>-->
<!--    <textarea id="customResponse" rows="8" cols="150">-->
<!---->
<!--    </textarea>-->
<!--    <br>-->
<!--    <input type="button" id="getCustomRequest" value="custom request">-->
<!--</div>-->
<!--<h2>shipping</h2>-->
<!--<div>-->
<!--    --><?php
//    $tTest = $walmart->shipping("1784426662439", "Guatemala");
//    echo "<br>R:<br>" . htmlentities($tTest);
//    ?>
<!--</div>-->
<!---->
<!--<h2>item 502300489</h2>-->
<!--<div>-->
<!--    --><?php
//    echo $tTest = $walmart->item();
//    ?>
<!--</div>-->
<!--<h2>order 3783746698308</h2>-->
<!--<div>-->
<!--    --><?php
//    echo "<br>4780930713173<br>";
//    echo $tTest = $walmart->order("2581449557123");
//    ?>
<!--</div>-->
<!--<h2>update inventory</h2>-->
<!--<div>-->
<!--    --><?php
//    echo $tTest = $walmart->updateInventory("300004 ", "Guatemala");
//    ?>
<!--</div>-->
<!--<h2>feeds</h2>-->
<!--<div>-->
<!--    --><?php
//    //echo $tTest = $walmart->feeds();
//    ?>
<!--</div>-->
<!--<h2>orders released!!!</h2>-->
<!--<div>-->
<!--    --><?php
//    $tTest = $walmart->ordersReleased();
//    $tTest = json_decode($tTest);
//    echo $tTest->meta->limit;
//    var_dump($tTest);
//    echo $tTest[0];
//    echo $tTest;
//    $tTest = json_decode($tTest);
//    echo "@@@@<br><br>:";
//    echo $tTest->meta;
//    echo ":<br><br>@@@";
//    echo $tTest;
//    ?>
<!--</div>-->
<!--<h2>orders</h2>-->
<!--<div>-->
<!--    --><?php
//    echo $tTest = $walmart->orders();
//    ?>
<!--</div>-->
<?php
//    echo $tTest = $walmart->shipping("4782171029987", "Guatemala");
//?>

<h2>cancel order</h2>
<div>
    <?php
    $tTest = $walmart->cancelOrder("1794485494631", "Guatemala");
    var_dump($tTest);
    ?>
</div>


</body>
</html>