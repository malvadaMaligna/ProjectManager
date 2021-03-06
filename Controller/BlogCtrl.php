<?php

	class BlogCtrl{
		
		public function run( $dbCon ){
			session_start();
			switch ( $_GET[ "action" ]){
				case "newEntryBlog":
					if( isset( $_SESSION[ "user" ]) and isset( $_GET[ "pjtid" ] ) ){
						//Validate session and relation project-user
						require_once './Model/BlogMdl.php';
						$header = file_get_contents("./View/Header.html");
						$content = file_get_contents("./View/AddEntry.html");
						$footer = file_get_contents("./View/Footer.html");
						$navbarContent = $_SESSION[ "user" ];
						$navbarOpt = file_get_contents( "./View/NavBarTemplate.html" );
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
						$navbarContent = "You are not logged in";
						$navbarOpt = "<li><a href=\"./index.php?control=login&action=signIn\">Sign In</a></li>";
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
						header( "Location: ./index.php?control=index&action=errorBD" );
					}
					break;
				
				case "addEntryBlog":
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
						
						header( "Location: ./index.php?control=blog&action=showProjectBlog&pjtid=".$_GET["pjtid"] );
						
					} else {
						header( "Location: ./index.php?control=index&action=errorBD" );
					}
					break;
					
				case "showProjectBlog":
					if ( isset( $_SESSION[ "user" ]) and isset(  $_GET[ "pjtid" ] ) ){
						
						$header = file_get_contents("./View/Header.html");
						$content = file_get_contents("./View/Blog.html");
						$footer = file_get_contents("./View/Footer.html");
						
						$navbarContent = $_SESSION[ "user" ];
						$navbarOpt = file_get_contents( "./View/NavBarTemplate.html" );
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );

						require_once './Model/ProjectMdl.php';
						
						$project = new ProjectMdl( $dbCon );
						//Consulta datos del proyecto
						$result = $project -> getProjectData( $_GET[ "pjtid" ] );
						$row = $result -> fetch_row( );
						$content = str_replace( "{projectName}", $row[ 0 ] , $content );
						$content = str_replace( "{projectDescription}", $row[ 1 ] , $content );
						
						require_once './Model/BlogMdl.php';
						
						$blog = new BlogMdl( $dbCon );
						$result = $blog -> getProjectBlogUsers( $_GET[ "pjtid" ] );
						$users = "";
						$templateUsr = file_get_contents( "./View/BlogTemplateUsers.html" );
						while( $row = $result -> fetch_row( ) ){
							$tmpTemplateUsers = $templateUsr;
							
							$tmpTemplateUsers = str_replace( "{users}", $row[ 0 ] , $tmpTemplateUsers );
							$users .= $tmpTemplateUsers;
						}
						$content = str_replace( "{projectBlogUsers}", $users , $content );
						
						$result = $blog -> getPojectBlogEntries( $_GET[ "pjtid" ] );
						$entries = "";
						$template = file_get_contents( "./View/BlogTemplate.html" );
						while( $row = $result -> fetch_row( ) ){
							$tmpTemplate = $template;

							$tmpTemplate = str_replace( "{title}", $row[ 1 ] , $tmpTemplate );
							$tmpTemplate = str_replace( "{date}", $row[ 0 ] , $tmpTemplate );
							$tmpTemplate = str_replace( "{user}", $row[ 3 ] , $tmpTemplate );
							$tmpTemplate = str_replace( "{contentBlog}", $row[ 2 ] , $tmpTemplate );
							$entries .=  $tmpTemplate;
						}
						$content = str_replace( "{projectBlog}", $entries , $content );
						
						echo $header;
						echo $content;
						echo $footer;
						
					} else {
						$navbarContent = "You are not logged in";
						$navbarOpt = "<li><a href=\"./index.php?control=login&action=signIn\">Sign In</a></li>";
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
						header( "Location: ./index.php?control=index&action=errorBD" );
					}
					break;
					
				default:
					$header = file_get_contents( "./View/Header.html" );
					$content = file_get_contents( "./View/Error404.html" );
					$footer = file_get_contents( "./View/Footer.html" );
						
					echo $header;
					echo $content;
					echo $footer;
			}
		}
	}
?>