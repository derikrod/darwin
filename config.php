<?php  
	header('Content-Type: text/html; charset=ISO', true);
	require 'environment.php';
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	$config = array();
	if (ENVIRONMENT == 'development') {
		define("BASE_URL", "");
		define("DB_NAME","");
		$config['dbname'] = DB_NAME;
		$config['host']='';
		$config['dbuser']='';
		$config['dbpass'] ='';
	}else{
		define("BASE_URL", "");
		define("DB_NAME","");
		$config['dbname'] = DB_NAME;
		$config['host']='';
		$config['dbuser']='';
		$config['dbpass'] ='';
	}

	global $db;
	try {
		$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'],$config['dbuser'],$config['dbpass']);
	} catch (PDOException $e) {
		echo "ERRO:".$e->getMessage();
		exit;
	}
?>
