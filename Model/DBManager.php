<?php
	/*
	 *@author: Cuauhtemoc Herrera Muñoz
	 *Data Base Manager with Singleton Design Pattern Implemented
	 */

	class DBManager{

		static private $instance = NULL;
		private $user;
		private $passwd;
		private $database;
		private $server;
		private $connection;

		public function __construct( $user, $passwd, $database, $server ){
			$this -> server = $server;
			$this -> user = $user;
			$this -> database = $database;
			$this -> passwd = $passwd;
			$this -> connection = new mysqli( $server, $user, $passwd, $database );
		}

		public static function getInstance( $user, $passwd, $database, $server ){
			if( self::$instance == NULL ){
				self::$instance = new DBManager( $user, $passwd, $database, $server );
			}
			return self::$instance;
		}

		public function connect( ){
			$this -> connection = new mysqli( $this -> server, $this -> user, $this -> passwd, $this -> database );
		}

		public function closeConnection( ){
			$this -> connection -> close( );
		}

		public function query( $query ){
			$result = $this -> connection -> query( $query );
			return $result;
		}
	}
?>
