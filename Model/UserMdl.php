<?php

	class UserMdl{
		private $connection;
		
		public function __construct( $connection ){
			$this -> connection = $connection;
		}
		
		//TODO funciones query
		public function setUser( $name, $lastname, $nickName, $password, $email, $userType, $code, $regDate){
			$query = "INSERT INTO user ( name, lastname, nickName, password, email, userType, code, regDate ) VALUES ( \"".$name."\", \"".$lastname."\", \"".$nickName."\", \"".$password."\", \"".$email."\", $userType, \"".$code."\",\"".$regDate."\" ) ";
			$result = $this -> connection -> query( $query ) or die( "DB Error: UserMdl.setUser: Error " );
			return $result;
		}
		
		public function setUserContact( $cellphone, $facebook, $github, $google, $twitter, $idUser ){
			$query = "INSERT INTO usercontact ( cellphone, facebook, github, google, twitter, idUser ) VALUES ( \"".$cellphone."\",\"".$facebook."\",\"".$github."\",\"".$google."\",\"".$twitter."\", $idUser ) ";
			$result = $this -> connection -> query( $query ) or die( "DB Error: UserMdl.setUserContact: Error " );
			return $result;
		}
		
		public function getUser( $idUser) {
			$query = "SELECT nickName FROM user WHERE idUser = $idUser";
			$result = $this -> connection -> query( $query ) or die("DB Error: UserMdl.getUser: Error " );
			return $result;
		}
	}

?>

