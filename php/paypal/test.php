<?php

include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/paypal/paypalOperations.php");

$paypal = new paypalOperations();

//$paypal->generateOrderInvoice("_5C60HSVME");

//$paypal->remindInvoice("INV2-RBKD-QCJQ-PYA2-36KB");
$paypal->remindInvoice("INV2-6FZ5-96MJ-AGV7-KZ6U"); //  INV2-6FZ5-96MJ-AGV7-KZ6U