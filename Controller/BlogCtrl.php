<?php

	class BlogCtrl{
		
		public function run( $dbCon ){
			session_start();
			switch ( $_GET[ "action" ]){
				case "newEntry":
					if( isset( $_SESSION[ "user" ]) and isset( $_GET[ "pjtid" ] ) ){
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
						$content = str_replace( "{user}", $_SESSION[ "user" ], $content );
						
						$dateT = getdate() ;
						$content = str_replace( "{date}", $dateT["year"]."-".$dateT["mon"]."-".$dateT["mday"], $content );
						$content = str_replace( "{pjtid}",  $_GET[ "pjtid" ], $content );
						
						echo $header;
						echo $content;
						echo $footer;
						
					}
					else{
						//Send to error
					}
					break;
				
				case "addEntry":
					if( isset( $_SESSION[ "user" ]) and isset(  $_GET[ "pjtid" ] ) ){
						
						$user = $_SESSION[ "idUser" ];
						$title = $_POST[ "Blogtitle" ];
						$contentEntry = $_POST[ "textAreaContent" ];
						
						$dateT = getdate() ;
						
						$current_date = $dateT["year"]."-".$dateT["mon"]."-".$dateT["mday"];
						echo $_GET[ "pjtid" ];
						echo $user;
						echo $title;
						echo $contentEntry;
						echo $current_date;
						
						require_once './Model/BlogMdl.php';
							
						$blog = new BlogMdl($dbCon);
						$result = $blog -> setBlogEntry( $user, $_GET[ "pjtid" ], $current_date, $title, $contentEntry);
						
						echo $user;
						echo $title;
						echo $contentEntry;
						echo $current_date;
						
						header( "Location: ./index.php?control=blog&action=showProjectBlog" );
						
					} else {
						//error
					}
					break;
					
				case "showProjectBlog":
					if ( isset( $_SESSION[ "user" ]) and isset(  $_GET[ "pjtid" ] ) ){
						
						require_once './Model/BlogMdl.php';
						$header = file_get_contents("./View/Header.html");
						$content = file_get_contents("./View/Blog.html");
						$footer = file_get_contents("./View/Footer.html");
						
						echo $header;
						echo $content;
						echo $footer;
										
// 						$blog = new BlogMdl($dbCon);
// 						$result = $blog -> getProjectBlog();
						
					} else {
						
						//error
					}
					
					
				default:
					
			}
		}
	}
?>