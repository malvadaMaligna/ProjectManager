<?php
	//TODO Start proyect doc
	//TODO Add a licence to the proyect
	//TODO Add controller mapping
	
	require_once './Model/DBManager.php';
	require_once './Controller/config.inc';
	
	//Getting DBManager instance
	$dbCon = DBManager::getInstance( $user, $passwd, $dataBase, $server);
	
	switch ( $_GET[ "control" ] ){
		case "login":
			require_once './Controller/LoginCtrl.php';
			$login = new LoginCtrl();
			$login -> run( $dbCon );
			break;
		case "index":
			require './Controller/IndexCtrl.php';
			$index = new IndexCtrl();
			$index -> run( $dbCon );
			break;
		default:
			//Send to main page
	}
?>