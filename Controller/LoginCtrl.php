<?php

	class LoginCtrl {
		
		public function run( $dbCon ){
			switch ( $_GET[ "action" ] ){
				case "signIn":
					$header = file_get_contents( "./View/Header.html" );
					$content = file_get_contents( "./View/Login.html" );
					$footer = file_get_contents( "./View/Footer.html" );
					
					echo $header;
					echo $content;
					echo $footer;
					break;
				case "authenticate":
					//TODO validate input values
					require_once './Model/LoginMdl.php';
					$login = new LoginMdl( $dbCon );
					$user = $_POST[ "user" ];
					$passwd = sha1( $_POST[ "passwd" ] );
					$result = $login -> authenticate( $user );
					$row = $result -> fetch_row( );
					var_dump( $result );
					break;
				default: 
					//Send to 404 Error
				
			}
		}
	}


?>