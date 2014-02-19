<?php
	class IndexCtrl {
		
		public function run( $dbCon ){
			session_start();
			switch ( $_GET[ "action" ]){
				case "index":
					require_once './Model/IndexMdl.php';
					$header = file_get_contents( "./View/Header.html" );
					$content = file_get_contents( "./View/MainPage.html" );
					$footer = file_get_contents( "./View/Footer.html" );
					
					if( !isset( $_SESSION[ 'user' ] ) ){
						$navbarContent = "You are not logged in";
						$navbarOpt = "<li><a href=\"./index.php?control=login&action=signIn\">Sign In</a></li>";
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
					}
					else{
						$navbarContent = $_SESSION[ "user" ];
						$navbarOpt = "<li class=\"dropdown\">
											<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"glyphicon glyphicon-home\"></i> Home<b class=\"caret\"></b></a>
											<ul class=\"dropdown-menu\">
												<li><a href=\"#\"><i class=\"glyphicon glyphicon-user\"></i> Profile</a></li>
												<li><a href=\"#\"><i class=\"glyphicon glyphicon-book\"></i> Projects</a></li>
												<li><a href=\"#\"><i class=\"glyphicon glyphicon-wrench\"></i> Settings</a></li>
												<li class=\"divider\"></li>
												<li><a href=\"./index.php?control=login&action=logOut\"><i class=\"glyphicon glyphicon-log-out\" ></i> Log out</a></li>
											</ul>
										</li>";
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
					}
					
					//Get the latest blog entry
					$index = new IndexMdl( $dbCon );
					$result = $index -> getLastBlogEntry( );
					$row = $result -> fetch_row();
					$blogDate = $row[ 0 ];
					$blogTitle = $row[ 1 ];
					$blogContent = $row[ 2 ];
					$blogUser = $row[ 3 ];
					$blogProyect = $row[ 4 ];
					
					echo $blogContent;
					
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