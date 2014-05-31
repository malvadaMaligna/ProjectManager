<?php
	class ProjectCtrl{
		public function run( $dbCon ){
			session_start();
			switch ( $_GET[ "action" ]){
				case "showProjectsByUser":
					if( isset( $_SESSION[ "user" ] ) ){
						
						$header = file_get_contents("./View/Header.html");
						$content = file_get_contents("./View/ProjectsByUser.html");
						$footer = file_get_contents("./View/Footer.html");
						
						$navbarContent = $_SESSION[ "user" ];
						$navbarOpt = file_get_contents( "./View/NavBarTemplate.html" );
						
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
						
						$content = str_replace( "{user}", $_SESSION[ "user" ], $content );
						
						require_once './Model/ProjectMdl.php';
						
						$project = new ProjectMdl( $dbCon );
						$result1 = $project -> getProjectsByUser( $_SESSION[ "idUser" ] );
						
						$projects = "";
						$projectTemplate = file_get_contents( "./View/ProjectTemplate.html" );
						while( $row = $result1 -> fetch_row( ) ){
						$tmpProjectTemplate = $projectTemplate;
						
						$tmpProjectTemplate = str_replace( "{name}", $row[ 0 ] , $tmpProjectTemplate );
						$tmpProjectTemplate = str_replace( "{dateStart}", $row[ 2 ] , $tmpProjectTemplate );
						$tmpProjectTemplate = str_replace( "{status}", $row[ 3 ] , $tmpProjectTemplate );
						$tmpProjectTemplate = str_replace( "{description}", $row[ 1 ] , $tmpProjectTemplate );
						$projects .=  $tmpProjectTemplate;
						$pjtid = $row[4];
						}
						$content = str_replace( "{projectsByUser}", $projects , $content );
						
						$result2 = $project -> getCollaboratorsByProjectId( $pjtid );
						$collaborators = "";
						$colaboratorsTemplate = file_get_contents( "./View/collaboratorsTemplate.html" );
						while( $row1 = $result2 -> fetch_row( ) ){
							$tmpcolTemplate = $colaboratorsTemplate;
						
							$tmpcolTemplate = str_replace( "{x}", $row1[ 0 ] , $tmpcolTemplate );
							$tmpcolTemplate = str_replace( "{y}", $row1[ 2 ] , $tmpcolTemplate );
							$collaborators .=  $tmpcolTemplate;	
						}
						$content = str_replace( "{collaborators}", $collaborators , $content );
						/*$result = $project -> getProjectsByUser( $_SESSION[ "idUser" ] );
						$projects = "";
						$projectTemplate = file_get_contents( "./View/ProjectTemplate.html" );
						while( $row = $result -> fetch_row( ) ){
							$tmpProjectTemplate = $projectTemplate;
						
							$tmpProjectTemplate = str_replace( "{name}", $row[ 0 ] , $tmpProjectTemplate );
							$tmpProjectTemplate = str_replace( "{dateStart}", $row[ 2 ] , $tmpProjectTemplate );
							$tmpProjectTemplate = str_replace( "{status}", $row[ 3 ] , $tmpProjectTemplate );
							$tmpProjectTemplate = str_replace( "{description}", $row[ 1 ] , $tmpProjectTemplate );
							$projects .=  $tmpProjectTemplate;
						}
						$content = str_replace( "{projectsByUser}", $projects , $content );*/
						
						echo $header;
						echo $content;
						echo $footer;
						
					} else {
						$navbarContent = "You are not logged in";
						$navbarOpt = "<li><a href=\"./index.php?control=login&action=signIn\">Sign In</a></li>";
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
						header( "Location: ./index.php?control=index&action=errorBD" );
						//TODO Errorr
					}
				break;
				case "showProject":
					if( isset( $_SESSION[ "idUser" ] ) and isset( $_SESSION[ "user" ] ) and isset( $_GET[ "pjtid" ] ) ){
						$header = file_get_contents( "./View/Header.html" );
						$content = file_get_contents( "./View/ProjectByUser.html" );
						$footer = file_get_contents( "./View/Footer.html" );
						$navbarContent = $_SESSION[ "user" ];
						$navbarOpt = file_get_contents( "./View/NavBarTemplate.html" );
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
						
						require_once './Model/ProjectMdl.php';
						$project = new ProjectMdl( $dbCon );
						$result1 = $project -> getProjectDataComplete(  $_GET[ "pjtid" ] );
						
						$row1 = $result1 -> fetch_row( );
						$content = str_replace( "{name}", $row1[ 0 ] , $content );
						$content = str_replace( "{dateStart}", $row1[ 2 ] , $content );
						$content = str_replace( "{status}", $row1[ 3 ] , $content );
						$content = str_replace( "{description}", $row1[ 1 ] , $content );
						/*while( $row1 = $result1 -> fetch_row( ) ){
							$tmpPro = $proTemplate;
							$tmpPro = str_replace( "{name}", $row1[ 0 ] , $tmpPro );
							$tmpPro = str_replace( "{dateStart}", $row1[ 2 ] , $tmpPro );
							$tmpPro = str_replace( "{status}", $row1[ 3 ] , $tmpPro );
							$tmpPro = str_replace( "{description}", $row1[ 1 ] , $tmpPro );
							$pro .= $tmpPro;
						}*/
						//$content = str_replace( "{project}", $proTemplate , $content );
						$content = str_replace( "{pjtid}", $_GET[ "pjtid" ] , $content );
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
				case "showAllProjects":
					if( isset( $_SESSION[ "idUser" ] ) and isset( $_SESSION[ "user" ] ) ){	
						$header = file_get_contents( "./View/Header.html" );
						$content = file_get_contents( "./View/AllProjects.html" );
						$footer = file_get_contents( "./View/Footer.html" );
						$navbarContent = $_SESSION[ "user" ];
						$navbarOpt = file_get_contents( "./View/NavBarTemplate.html" );
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
						
						require_once './Model/ProjectMdl.php';
						$project = new ProjectMdl( $dbCon );
						$result1 = $project -> getProjectsInProgress( );
						$temProjectsI = "";
						$tempPro = "<li><a href=\"./index.php?control=project&action=showProject&pjtid={pjtid}\">{pro}</a></li>";
						if ( !( $result1 -> num_rows ) == 0 ){
							while( $row1 = $result1 -> fetch_row( ) ){
								$projects = $tempPro;
								$projects = str_replace( "{pro}", $row1[ 0 ] , $projects );
								$projects = str_replace( "{pjtid}", $row1[ 1 ], $projects );
								$temProjectsI .= $projects;
							}
							$content = str_replace( "{projectsInProgress}", $temProjectsI , $content );
						} else {
							$content = str_replace( "{projectsFinished}", "<label>No projects in progress</label>" , $content );
						}
						$result2 = $project -> getProjectsFinished( );
						$temProjectsF = "";
						$tempProF = "<li ><a href=\"./index.php?control=project&action=showProject&pjtid={pjtid}\">{pro}</a></li>";
						if ( !( $result2 -> num_rows ) == 0 ){
							while( $row2 = $result2 -> fetch_row( ) ){
								$projectsF = $tempProF;
								$projectsF = str_replace( "{pro}", $row2[ 0 ] , $projectsF );
								$projectsF = str_replace( "{pjtid}", $row2[ 1 ], $projectsF );
								$temProjectsF .= $projectsF;
							}
							$content = str_replace( "{projectsFinished}", $temProjectsF , $content );
						} else {
							$content = str_replace( "{projectsFinished}", "<label>No projects in progress</label>" , $content );
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
				case "newProject":
					if( isset( $_SESSION[ "idUser" ] ) and isset( $_SESSION[ "user" ] ) ){
						$header = file_get_contents( "./View/Header.html" );
						$content = file_get_contents( "./View/NewProject.html" );
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
				case "setProject":
					if( isset( $_SESSION[ "idUser" ] ) and isset( $_SESSION[ "user" ] ) ){
						$name = $_POST[ "name" ];
						$descrip = $_POST[ "descrip" ];
						$status = 1;
						$rol = 1;
						$dateT = getdate() ;
						
						$current_date = $dateT["year"]."-".$dateT["mon"]."-".$dateT["mday"];
						if( $name != null and $descrip != null ){
							require_once './Model/ProjectMdl.php';
							$project = new ProjectMdl( $dbCon );
							$result1 = $project -> setProject( $name, $descrip, $current_date, $status );
							$_SESSION[ "idProject" ] = $dbCon -> getLastId();
							require_once './Model/CollaboratorMdl.php';
							$collaborator = new CollaboratorMdl( $dbCon );
							$result2 = $collaborator -> setLeader( $_SESSION[ "idProject" ], $_SESSION[ "idUser" ], $rol );
							header( "Location: ./index.php?control=user&action=getCollaborators" );
						}
					} else {
						header( "Location: ./index.php?control=index&action=errorBD" );
					}
				break;
				case "newTask":
					if( isset( $_SESSION[ "idUser" ] ) and isset( $_SESSION[ "user" ] ) ){
						$header = file_get_contents( "./View/Header.html" );
						$content = file_get_contents( "./View/AddTask.html" );
						$footer = file_get_contents( "./View/Footer.html" );
						$navbarContent = $_SESSION[ "user" ];
						$navbarOpt = file_get_contents( "./View/NavBarTemplate.html" );
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
						
						require_once './Model/ProjectMdl.php';
						$project = new ProjectMdl( $dbCon );
						$result1 = $project -> getCollaboratorsByProjectIdp( $_GET[ "pjtid" ]);
						$tempText = "";
						$userTmp = "<option name=\"usr\" id=\"usr\" value=\"{idUser}\">{nickName}</option>";
						while ( $row = $result1 -> fetch_row() ){
							$us = $userTmp;
							$us = str_replace( "{idUser}", $row[ 1 ] , $us );
							$us = str_replace( "{nickName}", $row[ 0 ] , $us );
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
				case "addTask":
					if( isset( $_SESSION[ "idUser" ] ) and isset( $_SESSION[ "user" ] ) ){
						$descrip = $_POST[ "descrip" ];
						$init = $_POST[ "init" ];
						$end = $_POST[ "end" ];
						$usr = $_POST[ "usr" ];
						$pjt = $_GET[ "pjtid" ];
						require_once './Model/ProjectMdl.php';
						$project = new ProjectMdl( $dbCon );
						$result1 = $project -> setTask( $pjt, $descrip, $init, $end, $usr, $_SESSION[ "idUser" ]);
						header( "Location: ./index.php?control=user&action=profile" );
					} else {
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