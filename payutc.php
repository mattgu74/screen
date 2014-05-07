<?php

require 'vendor/autoload.php';
use \Payutc\Client\AutoJsonClient;

include_once 'config.inc.php';

session_start();

$debut = "2014-05-06 18:30";

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
    "total" => $total,
    "GI" => $payutcClient->getNbSell(array("fun_id" => 2, "start"=> $debut, "obj_id" => "1702")),
    "TC" => $payutcClient->getNbSell(array("fun_id" => 2, "start"=> $debut, "obj_id" => "1703")),
    "GSU" => $payutcClient->getNbSell(array("fun_id" => 2, "start"=> $debut, "obj_id" => "1704")),
    "GM" => $payutcClient->getNbSell(array("fun_id" => 2, "start"=> $debut, "obj_id" => "1705")),
    "GSM" => $payutcClient->getNbSell(array("fun_id" => 2, "start"=> $debut, "obj_id" => "1706")),
    "GB" => $payutcClient->getNbSell(array("fun_id" => 2, "start"=> $debut, "obj_id" => "1707")),
    "GP" => $payutcClient->getNbSell(array("fun_id" => 2, "start"=> $debut, "obj_id" => "1708"))
   ));
