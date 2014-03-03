<?php
	class LoginMdl{
		
		private $connection;
		
		public function __construct( $connection ){
			$this -> connection = $connection;
		}
		
		public function authenticate( $user ){
			$query = "SELECT u.password, u.idUser FROM User AS u WHERE u.nickName = \"$user\"";
			$result = $this -> connection -> query( $query ) or die( "DB Error: LoginMdl.authenticate: Error " );
			return $result;
		}
	}

?>