<?php 
class Configuration
{
	// For a full list of configuration parameters refer in wiki page (https://github.com/paypal/sdk-core-php/wiki/Configuring-the-SDK)
	public static function getConfig()
	{
		$config = array(
				// values: 'sandbox' for testing
				//		   'live' for production
				"mode" => "sandbox",
                'log.LogEnabled' => true,
                'log.FileName' => '../PayPal.log',
                'log.LogLevel' => 'FINE'
	
				// These values are defaulted in SDK. If you want to override default values, uncomment it and add your value.
				// "http.ConnectionTimeOut" => "5000",
				// "http.Retry" => "2"
		);
		return $config;
	}
	
	// Creates a configuration array containing credentials and other required configuration parameters.
	public static function getAcctAndConfig()
	{
		$config = array(
				// Signature Credential
				"acct1.UserName" => "paulo.armas-facilitator_api1.coexport.net",
				"acct1.Password" => "VSNBMWW4MJ37WD5E",
				"acct1.Signature" => "ABUxXLUdsaD1wJ70X8FYh2HsO4M4AMOS3S8aragZjxk4t69Np5mEzQuV",
				"acct1.AppId" => "APP-80W284485P519543T",

//                "acct1.UserName" => "paulo.armas_api1.coexport.net",
//				"acct1.Password" => "6RSR2T3TPUNEH23M",
//				"acct1.Signature" => "AFcWxV21C7fd0v3bYYYRCpSSRl31Au0qzAe6bkUHyxgOuHmT8EVohbky",
//				"acct1.AppId" => "APP-80W284485P519543T",

//              "acct1.UserName" => "jb-us-seller_api1.paypal.com",
//				"acct1.Password" => "WX4WTU3S8MY44S7F",
//				"acct1.Signature" => "AFcWxV21C7fd0v3bYYYRCpSSRl31A7yDhhsPUU2XhtMoZXsWHFxu-RWy",
//				"acct1.AppId" => "APP-80W284485P519543T",
				
				// Sample Certificate Credential
				// "acct1.UserName" => "certuser_biz_api1.paypal.com",
				// "acct1.Password" => "D6JNKKULHN3G5B8A",
				// Certificate path relative to config folder or absolute path in file system
				// "acct1.CertPath" => "cert_key.pem",
				// "acct1.AppId" => "APP-80W284485P519543T"
				);
		
		return array_merge($config, self::getConfig());;
	}

}