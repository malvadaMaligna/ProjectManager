<?php
	class IndexCtrl {
		
		public function run( $dbCon ){
			switch ( $_GET[ "action" ]){
				case "index":
					$header = file_get_contents( "./View/Header.html" );
					$content = file_get_contents( "./View/MainPage.html" );
					$footer = file_get_contents( "./View/Footer.html" );
						
					echo $header;
					echo $content;
					echo $footer;
					break;
					default:
						//Send to 404 Error
			} 
		}
	}

?>