<?php

require 'vendor/autoload.php';
use \Payutc\Client\AutoJsonClient;

include_once 'config.inc.php';

session_start();

if(!isset($_SESSION['payutc_cookie'])) {
	// Cookie pas défini => login app
	$payutcClient = new AutoJsonClient($_CONFIG['payutc_server'], "STATS");
	// Login app
	$payutcClient->loginApp(array("key" => $_CONFIG['payutc_key']));
	$_SESSION['payutc_cookie'] = $payutcClient->cookie;
} else {
	$payutcClient = new AutoJsonClient($_CONFIG['payutc_server'], "STATS", array(), "Payutc Json PHP Client", $_SESSION['payutc_cookie']);
}

try {
	echo json_encode($payutcClient->getRevenue(array("fun_id" => 2, "start"=> "2014-05-06 18:30")));
} catch(Exception $e) {
	$payutcClient->loginApp(array("key" => $_CONFIG['payutc_key']));
	$_SESSION['payutc_cookie'] = $payutcClient->cookie;
	echo json_encode($payutcClient->getRevenue(array("fun_id" => 2, "start"=> "2014-05-06 18:30")));
}

