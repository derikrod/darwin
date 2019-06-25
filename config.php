<?php  
	require 'environment.php';

	$config = array();
	if (ENVIRONMENT == 'development') {
		define("BASE_URL", "http://localhost/darwin");
		define("DB_NAME","darwin");
		$config['dbname'] = DB_NAME;
		$config['host']='localhost';
		$config['dbuser']='root';
		$config['dbpass'] ='';
	}else{
		define("BASE_URL", "http://intranet.acoreconsumiveis.com.br");
		define("DB_NAME","u175549069_intra");
		$config['dbname'] = DB_NAME;
		$config['host']='acoreconsumiveis.com.br';
		$config['dbuser']='u175549069_intra';
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