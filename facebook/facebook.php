<?php

require_once __DIR__ . "/php-graph-sdk-5.x/src/Facebook/autoload.php";

$fb = new \Facebook\Facebook([
    'app_id' => '2170411849855373',
    'app_secret' => '56a4cc834a857cf0368880cb430ed3ec',
    'default_graph_version' => 'v2.12',
    //'default_access_token' => '{access-token}', // optional
]);

$helper = $fb->getCanvasHelper();

try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (! isset($accessToken)) {
    echo 'No OAuth data could be obtained from the signed request. User has not authorized your app yet.';
    exit;
}

// Logged in
echo '<h3>Signed Request</h3>';
var_dump($helper->getSignedRequest());

echo '<h3>Access Token</h3>';
var_dump($accessToken->getValue());