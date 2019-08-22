<?php  
	header('Content-Type: text/html; charset=ISO', true);
	require 'environment.php';
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	$config = array();
	if (ENVIRONMENT == 'development') {
		define("BASE_URL", "http://localhost/darwin");
		define("DB_NAME","u175549069_intr2");
		$config['dbname'] = DB_NAME;
		$config['host']='sql158.main-hosting.eu';
		$config['dbuser']='u175549069_intr2';
		$config['dbpass'] ='Acore20663';
	}else{
		define("BASE_URL", "http://intranet.acoreconsumiveis.com.br");
		define("DB_NAME","u175549069_intr2");
		$config['dbname'] = DB_NAME;
		$config['host']='sql158.main-hosting.eu';
		$config['dbuser']='u175549069_intr2';
		$config['dbpass'] ='Acore20663';
	}

	global $db;
	try {
		$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'],$config['dbuser'],$config['dbpass']);
	} catch (PDOException $e) {
		echo "ERRO:".$e->getMessage();
		exit;
	}
?>