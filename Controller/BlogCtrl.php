<?php

	class BlogCtrl{
		
		public function run( $dbCon ){
			session_start();
			switch ( $_GET[ "action" ]){
				case "addEntry":
					if( isset( $_GET[ "pjtid" ] ) ){
						//Validate session and relation project-user
						 
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