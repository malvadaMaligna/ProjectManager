<?php

	class BlogCtrl{
		
		public function run( $dbCon ){
			session_start();
			switch ( $_GET[ "action" ]){
				case "addEntry":
					if( isset( $_GET[ "pjtid" ] ) ){
						//Validate session and relation project-user
						require_once './Model/BlogMdl.php';
						$header = file_get_contents("./View/Header.html");
						$content = file_get_contents("./View/AddEntry.html");
						$footer = file_get_contents("./View/Footer.html");
						
						echo $header;
						echo $content;
						echo $footer;
					}
					else{
						//Send to error
					}
					break;
				default:
					
			}
		}
	}
?>