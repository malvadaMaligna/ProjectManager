<?php
	
	class UserCtrl{
		public function run( $dbCon ){
			switch ( $_GET[ "action" ]){
				case "userRegister":
					
					$name = $_POST[ "name" ];
					$lastName = $_POST[ "lastName" ];
					$nickName = $_POST[ "nickName" ];
					$password = $_POST[ "password" ];
					$email = $_POST[ "email" ];
					$userType = 5;
					$code = $_POST[ "code" ];
					$dateT = getdate() ;
					
					$current_date = $dateT["year"]."-".$dateT["mon"]."-".$dateT["mday"];
					
					$user = new UserMdl($dbCon);
					$result = $user -> setUser( $name, $lastName, $nickName, $password, $email, $userType, $code, $current_date );
					
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