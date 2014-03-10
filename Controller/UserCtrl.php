<?php
	
	class UserCtrl{
		public function run( $dbCon ){
			switch ( $_GET[ "action" ]){
				case "userRegister":
					require_once './Model/UserMdl.php';
					$header = file_get_contents( "./View/Header.html" );
					$content = file_get_contents( "./View/UserRegister.html" );
					$footer = file_get_contents( "./View/Footer.html" );
					
					echo $header;
					echo $content;
					echo $footer;
					
					break;
					default:;
			}
		}
	}
?>