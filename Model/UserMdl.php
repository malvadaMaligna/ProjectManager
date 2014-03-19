<?php

	class UserMdl{
		private $connection;
		
		public function __construct( $connection ){
			$this -> connection = $connection;
		}
		
		//TODO funciones query
		public function setUser(){
			$query = "INSERT INTO user ( name, lastname, nickName, password, email, userType, code, regDate ) VALUES ( \"".$date."\", ) ";
			$result = $this -> connection -> query( $query ) or die( "DB Error: BlogMdl.setEntryBlog: Error " );
			return $result;
		}
		
		public function setUserContact(){
			$query = "INSERT INTO usercontact ( cellphone, facebook, github, google+, twitter, idUser ) VALUES ( ) ";
			$result = $this -> connection -> query( $query ) or die( "DB Error: BlogMdl.setEntryBlog: Error " );
			return $result;
		}
	}

?>