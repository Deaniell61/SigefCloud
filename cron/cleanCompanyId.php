<?php
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__));
include_once($_SERVER["DOCUMENT_ROOT"] . "/cron/cronHelper.php");

$countries = getCountries();
$countries = json_decode($countries);

foreach ($countries as $country){
    echo "$country<br>";
    clean_TraOrdEnc_CompanyId($country);
}