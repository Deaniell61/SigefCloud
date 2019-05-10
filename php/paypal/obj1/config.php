<?php

  //start session in all pages
  if (session_status() == PHP_SESSION_NONE) { session_start(); } //PHP >= 5.4.0
  //if(session_id() == '') { session_start(); } //uncomment this line if PHP < 5.4.0 and comment out line above

	// sandbox or live
	define('PPL_MODE', 'sandbox');

	if(PPL_MODE=='sandbox'){

		define('PPL_API_USER', 'paulo.armas-facilitator_api1.coexport.net');
		define('PPL_API_PASSWORD', 'VSNBMWW4MJ37WD5E');
		define('PPL_API_SIGNATURE', 'ABUxXLUdsaD1wJ70X8FYh2HsO4M4AMOS3S8aragZjxk4t69Np5mEzQuV');
	}
	else{

//        define('PPL_API_USER', 'paulo.armas_api1.coexport.net');
//        define('PPL_API_PASSWORD', '6RSR2T3TPUNEH23M');
//        define('PPL_API_SIGNATURE', 'AFcWxV21C7fd0v3bYYYRCpSSRl31AX420GdGBPW-FtjNOn2kG6cdSedu');
	}

	define('PPL_LANG', 'EN');

	define('PPL_LOGO_IMG', 'http://www.sanwebe.com/wp-content/themes/sanwebe/img/logo.png');

	define('PPL_RETURN_URL', 'http://desarrollo.sigefcloud.com/php/paypal/response.php');
	define('PPL_CANCEL_URL', 'http://desarrollo.sigefcloud.com/php/paypal/response.php');

	define('PPL_CURRENCY_CODE', 'USD');


	/*
	 Classic Sandbox API CredentialsUsername:paulo.armas-facilitator_api1.coexport.netPassword:VSNBMWW4MJ37WD5ESignature:ABUxXLUdsaD1wJ70X8FYh2HsO4M4AMOS3S8aragZjxk4t69Np5mEzQuVREST AppsApp nameSigefCloud
	 * */