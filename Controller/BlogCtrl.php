<?php

	class BlogCtrl{
		
		public function run( $dbCon ){
			session_start();
			switch ( $_GET[ "action" ]){
				case "addEntry":
					if( isset( $_GET[ "pjtid" ] ) ){
						//Validate session and relation project-user
						require_once './Model/BlogMdl.php';
						$header = file_get_contents("./View/Header.html");
						$content = file_get_contents("./View/AddEntry.html");
						$footer = file_get_contents("./View/Footer.html");
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
						echo $header;
						echo $content;
						echo $footer;
						
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