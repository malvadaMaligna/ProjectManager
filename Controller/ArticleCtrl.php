<?php
	class ArticleCtrl{
		public function run( $dbCon ){
			session_start();
			switch ( $_GET[ "action" ]){
				case "newArticleEntry":
					if( isset( $_SESSION[ "user" ] ) and isset( $_GET[ "pjtid" ] ) ){
						
						$header = file_get_contents("./View/Header.html");
						$content = file_get_contents("./View/AddArticle.html");
						$footer = file_get_contents("./View/Footer.html");
						
						$navbarContent = $_SESSION[ "user" ];
						$navbarOpt = file_get_contents( "./View/NavBarTemplate.html" );
				
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
						
						$content = str_replace( "{user}", $_SESSION[ "user" ], $content );
						$content = str_replace( "{pjtid}",  $_GET[ "pjtid" ], $content );
						
						require_once './Model/ArticleMdl.php';
						
						$article = new ArticleMdl( $dbCon );
						$result = $article -> getArticleTypes();
						$tempText = "";
						$acticleTmp = "<option value=\"{id}\">{type}</option>";
						while ( $row = $result -> fetch_row() ){
							$article = $acticleTmp;
							$article = str_replace( "{id}", $row[ 0 ] , $article );
							$article = str_replace( "{type}", $row[ 1 ] , $article );
							$tempText .= $article;
						}
						
						$content = str_replace( "{ArticleType}", $tempText , $content );
						
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
				case "showProjectArticles":
					if( isset( $_SESSION[ "user" ] ) and isset( $_GET[ "pjtid" ] ) ){
					
						$header = file_get_contents("./View/Header.html");
						$content = file_get_contents("./View/ArticlesByProject.html");
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
						
						require_once './Model/ArticleMdl.php';
						$article = new ArticleMdl( $dbCon);
						$result = $article -> getProjectArticleAuthors( $_GET[ "pjtid" ] );
						$authors = "";
						$authorTemp = "<h5><a href=\"#\">{users}</a></h5>";
						while( $row = $result -> fetch_row( ) ){
							$tmpTemplateAuthors = $authorTemp;
								
							$tmpTemplateAuthors = str_replace( "{users}", $row[ 0 ] , $tmpTemplateAuthors );
							$authors .= $tmpTemplateAuthors;
						}
						$content = str_replace( "{projectArticleAuthors}", $authors , $content );
						
						$result = $article -> getProjectArticles( $_GET[ "pjtid" ] );
						$articles = "";
						$articleTemplate = file_get_contents( "./View/ArticleTemplate.html" );
						while( $row = $result -> fetch_row( ) ){
							$tmpArticleTemplate = $articleTemplate;
						
							$tmpArticleTemplate = str_replace( "{title}", $row[ 0 ] , $tmpArticleTemplate );
							$tmpArticleTemplate = str_replace( "{type}", $row[ 2 ] , $tmpArticleTemplate );
							$tmpArticleTemplate = str_replace( "{user}", $row[ 3 ] , $tmpArticleTemplate );
							$tmpArticleTemplate = str_replace( "{content}", $row[ 1 ] , $tmpArticleTemplate );
							$articles .=  $tmpArticleTemplate;
						}
						$content = str_replace( "{projectArticles}", $articles , $content );
						
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
					
				case "previewArticle":
					if( isset( $_SESSION[ "user" ] ) and isset( $_GET[ "pjtid" ] ) ){

						$header = file_get_contents("./View/Header.html");
						$content = file_get_contents("./View/ArticleTypeTemplate.html");
						$footer = file_get_contents("./View/Footer.html");
						
						$navbarContent = $_SESSION[ "user" ];
						$navbarOpt = file_get_contents( "./View/NavBarTemplate.html" );
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
						
						$content = str_replace( "{user}", $_SESSION[ "user" ], $content );
						$content = str_replace( "{pjtid}",  $_GET[ "pjtid" ], $content );
						
						$userid = $_SESSION[ "idUser" ];
						$title = $_POST[ "title" ];
						$type = $_POST[ "typeArticle" ];
						$contentEntry = $_POST[ "textAreaContent" ];
						
						$content = str_replace( "{user}", $_SESSION[ "user" ], $content );
						$content = str_replace( "{title}", $title, $content );
						$content = str_replace( "{content}", $contentEntry, $content );
						
						require_once './Model/ArticleMdl.php';
						
						$article = new ArticleMdl( $dbCon );
						$result1 = $article -> getArticleTypeById( $type );
						$row = $result1 -> fetch_row( );
						$content = str_replace( "{type}", $row[ 0 ] , $content );
						
						
						echo $header;
						echo $content;
						echo $footer;
						
						$result2 = $article -> setArticleEntry( $title, $contentEntry, $_GET[ "pjtid" ], $type, $userid);
					} else {
						$navbarContent = "You are not logged in";
						$navbarOpt = "<li><a href=\"./index.php?control=login&action=signIn\">Sign In</a></li>";
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
						header( "Location: ./index.php?control=index&action=errorBD" );
					}
					break;
				default:
					
			}
		}
	}
?>