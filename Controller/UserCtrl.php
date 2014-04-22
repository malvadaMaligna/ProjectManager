<?php
	
	class UserCtrl{
		public function run( $dbCon ){
			session_start();
			switch ( $_GET[ "action" ]){
				case "newUser":
					
					$header = file_get_contents( "./View/Header.html" );
					$content = file_get_contents( "./View/UserRegister.html" );
					$footer = file_get_contents( "./View/Footer.html" );
					
					echo $header;
					echo $content;
					echo $footer;
					
					break;
					
				case "userRegister":
					
					require_once './Model/UserMdl.php';
					
					$name = $_POST[ "name" ];
					$lastName = $_POST[ "lastName" ];
					$nickName = $_POST[ "nickName" ];
					$password = $_POST[ "password" ];
					$email = $_POST[ "email" ];
					$userType = 5;
					$code = $_POST[ "code" ];
					$dateT = getdate() ;
						
					$current_date = $dateT["year"]."-".$dateT["mon"]."-".$dateT["mday"];
					
					if( $name != null and $lastName != null and $nickName != null and $password != null 
						and $email != null and $userType != null and $code != null and $current_date != null ){
						$user = new UserMdl($dbCon);
						$result = $user -> setUser( $name, $lastName, $nickName, $password, $email, $userType, $code, $current_date );
							
						$_SESSION[ "idUser" ] = $dbCon -> getLastId();
						echo $_SESSION[ "idUser" ];
						//echo $dbCon -> getLastId();
						header( "Location: ./index.php?control=user&action=newUserContact" );
					}else{
						header( "Location: ./index.php?control=index&action=errorBD" );
					}
						
					
					break;
				case "newUserContact":
			
					$header = file_get_contents( "./View/Header.html" );
					$content = file_get_contents( "./View/UserContactRegister.html" );
					$footer = file_get_contents( "./View/Footer.html" );
						
					echo $header;
					echo $content;
					echo $footer;
						
					break;
				
				case "userContactRegister":
					if( isset( $_SESSION[ "idUser" ]) ){
						require_once './Model/UserMdl.php';
				
						$fb = $_POST[ "fb" ];
						$tw = $_POST[ "tw" ];
						$git = $_POST[ "git" ];
						$google = $_POST[ "google" ];
						$cel = $_POST[ "cel" ];
						$idUser = $_SESSION[ "idUser" ];
						
						$user = new UserMdl($dbCon);
						$result = $user -> setUserContact( $cel, $fb, $git, $google, $tw, $idUser );

						//TODO
						//header( "Location: ./index.php?control=user&action=newUserContact" );
						
					}else {
						header( "Location: ./index.php?control=index&action=errorBD" );

					}
					break;
				default:
			}
		}
	}
?>