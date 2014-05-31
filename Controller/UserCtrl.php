<?php
	
	class UserCtrl{
		public function run( $dbCon ){
			session_start();
			switch ( $_GET[ "action" ]){
				case "newUser":
					
					$header = file_get_contents( "./View/Header.html" );
					$content = file_get_contents( "./View/UserRegister.html" );
					$footer = file_get_contents( "./View/Footer.html" );
					
					$header = str_replace( "{user}", "" , $header );
					
					echo $header;
					echo $content;
					echo $footer;
					
					break;
					
				case "userRegister":
					
					require_once './Model/UserMdl.php';
					
					$name = $_POST[ "name" ];
					$lastName = $_POST[ "lastName" ];
					$nickName = $_POST[ "nickName" ];
					$password =  sha1( $_POST[ "password" ] );
					$email = $_POST[ "email" ];
					$userType = 5;
					$code = $_POST[ "code" ];
					$dateT = getdate() ;
						
					$current_date = $dateT["year"]."-".$dateT["mon"]."-".$dateT["mday"];
					
					if( $name != null and $lastName != null and $nickName != null and $password != null 
						and $email != null and $userType != null and $code != null and $current_date != null ){
						$user = new UserMdl($dbCon);
						$result = $user -> setUser( $name, $lastName, $nickName, $password, $email, $userType, $code, $current_date );
							
						$_SESSION[ "idUser" ] = $dbCon -> getLastId();
						echo $_SESSION[ "idUser" ];
						//echo $dbCon -> getLastId();
						header( "Location: ./index.php?control=user&action=newUserContact" );
					} else{
						header( "Location: ./index.php?control=index&action=errorBD" );
					}
						
					
					break;
				case "newUserContact":
			
					$header = file_get_contents( "./View/Header.html" );
					$content = file_get_contents( "./View/UserContactRegister.html" );
					$footer = file_get_contents( "./View/Footer.html" );
					
					$header = str_replace( "{user}", "" , $header );
						
					echo $header;
					echo $content;
					echo $footer;
						
					break;
				
				case "userContactRegister":
					if( isset( $_SESSION[ "idUser" ] ) ){
						require_once './Model/UserMdl.php';
				
						$fb = $_POST[ "fb" ];
						$tw = $_POST[ "tw" ];
						$git = $_POST[ "git" ];
						$google = $_POST[ "google" ];
						$cel = $_POST[ "cel" ];
						$idUser = $_SESSION[ "idUser" ];
						
						$user = new UserMdl($dbCon);
						$result = $user -> setUserContact( $cel, $fb, $git, $google, $tw, $idUser );
						$_SESSION[ "user" ] = $user -> getUser( $_SESSION[ "idUser" ]) -> fetch_row( )[0];
						header( "Location: ./index.php?control=index&action=index" );
						
					} else {
						header( "Location: ./index.php?control=index&action=errorBD" );

					}
					break;
				case "settings":
					if( isset( $_SESSION[ "idUser" ] ) and isset( $_SESSION[ "user" ] ) ){
						
						$header = file_get_contents( "./View/Header.html" );
						$content = file_get_contents( "./View/UpdateUserProfile.html" );
						$footer = file_get_contents( "./View/Footer.html" );
						$navbarContent = $_SESSION[ "user" ];
						$navbarOpt = file_get_contents( "./View/NavBarTemplate.html" );
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
						
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
				case "updateProfile":
					if( isset( $_SESSION[ "idUser" ] ) and isset( $_SESSION[ "user" ] ) ){
						
						require_once './Model/UserMdl.php';
						
						$nickName = $_POST[ "name" ];
						$password =  sha1( $_POST[ "pswd" ] );
						$email = $_POST[ "mail" ];
						$fb = $_POST[ "fb" ];
						$tw = $_POST[ "tw" ];
						$cel = $_POST[ "cell" ];
						echo $nickName;
						echo $password;
						echo $email;
						echo $fb;
						echo $tw;
						echo $cel;
						echo $_SESSION[ "idUser" ];
						$user = new UserMdl($dbCon);
						$result = $user -> updateUserData( $nickName, $email, $password, $cel, $fb, $tw,  $_SESSION[ "idUser" ] );
						
						header( "Location: ./index.php?control=index&action=index" );
						
					} else {
						header( "Location: ./index.php?control=index&action=errorBD" );
					}
					break;
				case "profile":
					if( isset( $_SESSION[ "idUser" ] ) and isset( $_SESSION[ "user" ] ) ){
						
						$header = file_get_contents( "./View/Header.html" );
						$content = file_get_contents( "./View/Profile.html" );
						$footer = file_get_contents( "./View/Footer.html" );
						$navbarContent = $_SESSION[ "user" ];
						$navbarOpt = file_get_contents( "./View/NavBarTemplate.html" );
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
						
						require_once './Model/UserMdl.php';
						$user = new UserMdl($dbCon);
						$result1 = $user -> getCountTasksByUser( $_SESSION[ "idUser" ] );
						$row1 = $result1 -> fetch_row( );
						if ( !( $result1 -> num_rows ) == 0 ){
							$content = str_replace( "{task}", $row1[ 0 ] , $content );
						} else {
							$content = str_replace( "{task}", "0" , $content );
						}
						
						require_once './Model/ProjectMdl.php';
						$project = new ProjectMdl( $dbCon );
						$result2 = $project -> getProjectsByUser( $_SESSION[ "idUser" ] );
						$pro = "";
						$tempPro = "<li><a href=\"./index.php?control=project&action=showProject&pjtid={pjtid}\">{pro}</a></li>";
						if ( !( $result2 -> num_rows ) == 0 ){
							while( $row2 = $result2 -> fetch_row( ) ){
								$projects = $tempPro;	
								$projects = str_replace( "{pro}", $row2[ 0 ] , $projects );
								$projects = str_replace( "{pjtid}", $row2[ 4 ], $projects );
								$pro .= $projects;
							}
							$content = str_replace( "{projects}", $pro , $content );
						} else {
							$content = str_replace( "{projects}", "<label>You don't collaborate on any project yet</label>" , $content );
						}
						
						$result3 = $user -> getLastBlogEntryByUser( $_SESSION[ "idUser" ] );
						$tmpTemplate = file_get_contents( "./View/BlogTemplate.html" );
						if ( !( $result3 -> num_rows ) == 0 ){
							while( $row3 = $result3 -> fetch_row( ) ){
								$tmpTemplate = str_replace( "{title}", $row3[ 1 ] , $tmpTemplate );
								$tmpTemplate = str_replace( "{date}", $row3[ 0 ] , $tmpTemplate );
								$tmpTemplate = str_replace( "{user}", $row3[ 3 ] , $tmpTemplate );
								$tmpTemplate = str_replace( "{contentBlog}", $row3[ 2 ] , $tmpTemplate );
							}
							$content = str_replace( "{lastEntryBlog}", $tmpTemplate , $content );
						} else {
							$content = str_replace( "{lastEntryBlog}", "<p>You don't have blog entries</p>" , $content );
						}
						
						$result4 = $user -> getLastArticleByUser( $_SESSION[ "idUser" ] );
						$tmpArticleTemplate = file_get_contents( "./View/ArticleTemplate.html" );
						if ( !( $result4 -> num_rows ) == 0 ){
							while( $row4 = $result4 -> fetch_row( ) ){
								$tmpArticleTemplate = str_replace( "{title}", $row4[ 0 ] , $tmpArticleTemplate );
								$tmpArticleTemplate = str_replace( "{type}", $row4[ 2 ] , $tmpArticleTemplate );
								$tmpArticleTemplate = str_replace( "{user}", $row4[ 3 ] , $tmpArticleTemplate );
								$tmpArticleTemplate = str_replace( "{content}", $row4[ 1 ] , $tmpArticleTemplate );
							}
							$content = str_replace( "{lastArticle}", $tmpArticleTemplate , $content );
						} else {
							$content = str_replace( "{lastArticle}", "<p>You don't have articles</p>" , $content );
						}
						
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
				case "showTasks":
					if( isset( $_SESSION[ "idUser" ] ) and isset( $_SESSION[ "user" ] ) ){
						
						$header = file_get_contents( "./View/Header.html" );
						$content = file_get_contents( "./View/Tasks.html" );
						$footer = file_get_contents( "./View/Footer.html" );
						$navbarContent = $_SESSION[ "user" ];
						$navbarOpt = file_get_contents( "./View/NavBarTemplate.html" );
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
						
						require_once './Model/UserMdl.php';
						$user = new UserMdl($dbCon);
						$result1 = $user -> getTasksByUser( $_SESSION[ "idUser" ] );
						$task = "";
						$taskTemplate = file_get_contents( "./View/TaskTemplate.html" );
						if ( !( $result1 -> num_rows ) == 0 ){
							while( $row1 = $result1 -> fetch_row( ) ){
								$tasks = $taskTemplate;
								$tasks = str_replace( "{description}", $row1[ 0 ] , $tasks );
								$tasks = str_replace( "{project}", $row1[ 4 ] , $tasks );
								$tasks = str_replace( "{endDate}", $row1[ 3 ] , $tasks );
								$tasks = str_replace( "{initDate}", $row1[ 1 ] , $tasks );
								$task .= $tasks;
							}
							$content = str_replace( "{tasks}", $task , $content );
						} else {
							$content = str_replace( "{tasks}", "<p>You don't have tasks</p>" , $content );
						}
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
				case "getCollaborators":
					if( isset( $_SESSION[ "idUser" ] ) and isset( $_SESSION[ "user" ] ) ){
						
						$header = file_get_contents( "./View/Header.html" );
						$content = file_get_contents( "./View/AddCollaborators.html" );
						$footer = file_get_contents( "./View/Footer.html" );
						$navbarContent = $_SESSION[ "user" ];
						$navbarOpt = file_get_contents( "./View/NavBarTemplate.html" );
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
						
						require_once './Model/UserMdl.php';
						$user = new UserMdl($dbCon);
						$result1 = $user -> getUsers( );
						$tempText = "";
						$userTmp = "<option value=\"{idUser}\">{nickName}</option>";
						while ( $row = $result1 -> fetch_row() ){
							$us = $userTmp;
							$us = str_replace( "{idUser}", $row[ 0 ] , $us );
							$us = str_replace( "{nickName}", $row[ 1 ] , $us );
							$tempText .= $us;
						}
						
						$content = str_replace( "{users}", $tempText , $content );
						
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
				case "addedCollaborator":
					if( isset( $_SESSION[ "idUser" ] ) and isset( $_SESSION[ "user" ] ) ){
						require_once './Model/CollaboratorMdl.php';
						$rol = 2;
						$collaborator = new CollaboratorMdl( $dbCon );
						$result2 = $collaborator -> setCollaborator( $_SESSION[ "idProject" ], $_SESSION[ "idUser" ], $rol );
						header( "Location: ./index.php?control=user&action=profile" );
					} else {
						header( "Location: ./index.php?control=index&action=errorBD" );
					}
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