<?php 
	session_start();
	require_once "config.php";
	require_once "routers.php";
	require_once "autoload.php";

	$core = new Core();
	$core -> run();
	
 ?>
