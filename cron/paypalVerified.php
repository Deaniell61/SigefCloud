<?php

echo "paypal verified status<br>";


session_start();
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
include_once ($_SERVER["DOCUMENT_ROOT"] . "/php/lib/PayPal-PHP-SDK/autoload.php");

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS',     // ClientID
        'EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL'      // ClientSecret
    )
);

use PayPal\Api\OpenIdSession;
//$baseUrl = getBaseUrl() . '/UserConsentRedirect.php?success=true';
$baseUrl = $_SERVER["DOCUMENT_ROOT"] . '/php/paypal/verifiedResponse.php?success=true';
echo "$baseUrl";
// ### Get User Consent URL
// The clientId is stored in the bootstrap file
//Get Authorization URL returns the redirect URL that could be used to get user's consent

try{
    $redirectUrl = OpenIdSession::getAuthorizationUrl(
        $baseUrl,
        array('openid', 'profile', 'address', 'email', 'phone',
            'https://uri.paypal.com/services/paypalattributes',
            'https://uri.paypal.com/services/expresscheckout',
            'https://uri.paypal.com/services/invoicing'),
        null,
        null,
        null,
        $apiContext
    );
}
catch (Exception $ex){
    ResultPrinter::printError("User Information", "User Info", null, $params, $ex);
}


// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
ResultPrinter::printResult("Generated the User Consent URL", "URL", '<a href="'. $redirectUrl . '" >Click Here to Obtain User Consent</a>', $baseUrl, $redirectUrl);



/*

// ### Obtain Access Token From Refresh Token
//require __DIR__ . '/../bootstrap.php';
use PayPal\Api\OpenIdTokeninfo;
use PayPal\Api\OpenIdUserinfo;
// To obtain User Info, you have to follow three steps in general.
// First, you need to obtain user's consent to retrieve the information you want.
// This is explained in the example "ObtainUserConsent.php".
// Once you get the user's consent, the end result would be long lived refresh token.
// This refresh token should be stored in a permanent storage for later use.
// Lastly, when you need to retrieve the user information, you need to generate the short lived access token
// to retreive the information. The short lived access token can be retrieved using the example shown in
// "GenerateAccessTokenFromRefreshToken.php", or as shown below
// You can retrieve the refresh token by executing ObtainUserConsent.php and store the refresh token
$refreshToken = 'W1JmxG-Cogm-4aSc5Vlen37XaQTj74aQcQiTtXax5UgY7M_AJ--kLX8xNVk8LtCpmueFfcYlRK6UgQLJ-XHsxpw6kZzPpKKccRQeC4z2ldTMfXdIWajZ6CHuebs';
try {
    $tokenInfo = new OpenIdTokeninfo();
    $tokenInfo = $tokenInfo->createFromRefreshToken(array('refresh_token' => $refreshToken), $apiContext);
    $params = array('access_token' => $tokenInfo->getAccessToken());
    $userInfo = OpenIdUserinfo::getUserinfo($params, $apiContext);
} catch (Exception $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
    ResultPrinter::printError("User Information", "User Info", null, $params, $ex);
    exit(1);
}
// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
ResultPrinter::printResult("User Information", "User Info", $userInfo->getUserId(), $params, $userInfo);
*/