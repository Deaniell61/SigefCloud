<?php

require_once __DIR__ . "/php-graph-sdk-5.x/src/Facebook/autoload.php";

$fb = new \Facebook\Facebook([
    'app_id' => '2170411849855373',
    'app_secret' => '56a4cc834a857cf0368880cb430ed3ec',
    'default_graph_version' => 'v2.12',
    //'default_access_token' => '{access-token}', // optional
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://example.com/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';