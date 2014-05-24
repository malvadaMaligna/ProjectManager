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
				
			}
		}
	}
?>