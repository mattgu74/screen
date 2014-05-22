<?php

require 'vendor/autoload.php';
use \Payutc\Client\AutoJsonClient;

include_once 'config.inc.php';

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 

session_start();

$debut = "2014-05-22 17:30";

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
	$total = $payutcClient->getRevenue(array("fun_id" => 2, "start"=> $debut));
} catch(Exception $e) {
	$payutcClient->loginApp(array("key" => $_CONFIG['payutc_key']));
	$_SESSION['payutc_cookie'] = $payutcClient->cookie;
	$total = $payutcClient->getRevenue(array("fun_id" => 2, "start"=> $debut));
}

echo json_encode(array(
    "total" => $total
    /*"TC" => $payutcClient->getNbSell(array("fun_id" => 2, "start"=> $debut, "obj_id" => "1702")),
    "GX" => $payutcClient->getNbSell(array("fun_id" => 2, "start"=> $debut, "obj_id" => "1703")),
    "VC" => $payutcClient->getNbSell(array("fun_id" => 2, "start"=> $debut, "obj_id" => "1704")),
    "AN" => $payutcClient->getNbSell(array("fun_id" => 2, "start"=> $debut, "obj_id" => "1705")),*/
   ));
