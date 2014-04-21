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
					//TODO validate if result is null
					if( !( $result -> num_rows ) == 0 ){
						$row = $result -> fetch_row();
						$blogDate = $row[ 0 ];
						$blogTitle = $row[ 1 ];
						$blogContent = $row[ 2 ];
						$blogUser = $row[ 3 ];
						$blogProyect = $row[ 4 ];
						
						$blogEntry = "<h3>".$blogTitle."</h3>";
						$blogEntry = $blogEntry."<div class=\"blog-data\"><div class=\"blog-date\"><em>".$blogDate."</em></div><div class=\"blog-author\">By <a href=\"#\">".$blogUser."</a></div></div>";
						$blogEntry = $blogEntry."<div class=\"cleaner\"></div>";
						$blogEntry = $blogEntry."<div class=\"blog-content\">".$blogContent."</div>";
						$blogEntry = $blogEntry."<p>Related to <a href=\"#\">".$blogProyect."</a></p>";					
						$content = str_replace( "{blogEntry}", $blogEntry , $content );
					}
					else{
						$content = str_replace( "{blogEntry}", "<h3>There's no data to show</h3>" , $content );
					}
					
					echo $header;
					echo $content;
					echo $footer;
					break;
					
				case "test1":
					$header = file_get_contents( "./View/Header.html" );
					$content = file_get_contents( "./View/test1.html" );
					$footer = file_get_contents( "./View/Footer.html" );
					
					echo $header;
					echo $content;
					echo $footer;
					break;
				
				case "test2":
					$header = file_get_contents( "./View/Header.html" );
					$content = file_get_contents( "./View/test2.html" );
					$footer = file_get_contents( "./View/Footer.html" );
						
					echo $header;
					echo $content;
					echo $footer;
					break;
					
				case "test3":
					$header = file_get_contents( "./View/Header.html" );
					$content = file_get_contents( "./View/test3.html" );
					$footer = file_get_contents( "./View/Footer.html" );
				
					echo $header;
					echo $content;
					echo $footer;
					break;
				case "errorBD":
					$header = file_get_contents( "./View/Header.html" );
					$content = file_get_contents( "./View/Error403.html" );
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