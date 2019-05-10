<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// 1. Autoload the SDK Package. This will include all the files and classes to your autoloader
require __DIR__  . '/autoload.php';

// 2. Provide your Secret Key. Replace the given one with your app clientId, and Secret
// https://developer.paypal.com/webapps/developer/applications/myapps
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AV4FssRDb7LyIRlW5GX1Ids7cRTVQP7kKe9BmIjMSsoD2sVrPfn7dwF69Pyj9i87Gmew1szT5Y2V1LRE',     // ClientID
        'EBk_8yFaZELVG0FhT-G75oQ3hC5NFOvcFp2RXGeDlRJXCDq0PmUvscOW0Oe_5SgOPY3zQzNjQkKnwJtU'      // ClientSecret
    )
);

// 3. Lets try to create a Payment
// https://developer.paypal.com/docs/api/payments/#payment_create
$payer = new \PayPal\Api\Payer();
$payer->setPaymentMethod('paypal');

$amount = new \PayPal\Api\Amount();
$amount->setTotal('1.00');
$amount->setCurrency('USD');

$transaction = new \PayPal\Api\Transaction();
$transaction->setAmount($amount);

$redirectUrls = new \PayPal\Api\RedirectUrls();
$redirectUrls->setReturnUrl("https://desarrollo.sigefcloud.com/php/paypal/redirect.php")
    ->setCancelUrl("https://desarrollo.sigefcloud.com/php/paypal/cancel.php");

$payment = new \PayPal\Api\Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setTransactions(array($transaction))
    ->setRedirectUrls($redirectUrls);

// 4. Make a Create Call and print the values
try {
    $payment->create($apiContext);
    echo "S " . $payment;

    echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
}
catch (\PayPal\Exception\PayPalConnectionException $ex) {
    // This will print the detailed information on the exception.
    //REALLY HELPFUL FOR DEBUGGING
    echo "E " . $ex->getData();
}