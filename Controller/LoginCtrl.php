<?php

	class LoginCtrl {
		
		public function run( $dbCon ){
			session_start();
			switch ( $_GET[ "action" ] ){
				case "signIn":
					if( !isset( $_SESSION[ 'user' ] ) ){
						$header = file_get_contents( "./View/Header.html" );
						$content = file_get_contents( "./View/Login.html" );
						$footer = file_get_contents( "./View/Footer.html" );
						
						$navbarContent = "You are not logged in";
						$navbarOpt = "<li><a href=\"./index.php?control=login&action=signIn\">Sign In</a></li>";
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
						echo $header;
						echo $content;
						echo $footer;
					}
					else{
						header( "Location: ./index.php?control=index&action=index" );
					}
					break;
				case "authenticate":
					if( !isset( $_SESSION[ 'user' ] ) ){
						//TODO validate input values
						require_once './Model/LoginMdl.php';
						$login = new LoginMdl( $dbCon );
						$user = $_POST[ "user" ];
						$passwd = sha1( $_POST[ "passwd" ] );
						$result = $login -> authenticate( $user );
						$row = $result -> fetch_row( );	// conviertes el result en un array
						$key = $row[ 0 ];	//	res del query
						$idUser = $row[ 1 ];
						if( $key == $passwd ){
							$_SESSION[ "user" ] = $user;
							$_SESSION[ "idUser" ] = $idUser;			
							header( "Location: ./index.php?control=index&action=index" );
							//Set data to session
						}
						else{
							//BadLogin
						}
					}
					else{
						//Send to error
					}
					break;
				case "logOut":
					if( isset( $_SESSION[ 'user' ] ) ){
						session_destroy( );
						session_unset( );
						setcookie( session_name( ), ' ', time( ) - 3600 );
						header( "Location: ./index.php?control=index&action=index" );
					}
					else{
						//Send to error
					}
					break;
				default: 
					//Send to 404 Error
				
			}
		}
	}


?>