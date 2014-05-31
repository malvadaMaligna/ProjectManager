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
					
					if( !isset( $_SESSION[ "user" ] ) ){
						$navbarContent = file_get_contents( "./View/NavBarTemplateLog.html");
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", "" , $header );
					}
					else{
						$navbarContent = $_SESSION[ "user" ];
						$navbarOpt = file_get_contents( "./View/NavBarTemplate.html" );
						$header = str_replace( "{user}", $navbarContent , $header );
						$header = str_replace( "{userOpt}", $navbarOpt , $header );
					}
					
					//Get the latest blog entry
					$index = new IndexMdl( $dbCon );
					$result1 = $index -> getLastBlogEntry( );
					//TODO validate if result is null
					if( !( $result1 -> num_rows ) == 0 ){
						$row = $result1 -> fetch_row();
						$blogDate = $row[ 0 ];
						$blogTitle = $row[ 1 ];
						$blogContent = $row[ 2 ];
						$blogUser = $row[ 3 ];
						$blogProyect = $row[ 4 ];
						
						$blogEntry = "<h3 class=\"text-center\">".$blogTitle."</h3>";
						$blogEntry = $blogEntry."<div class=\"blog-data\"><div class=\"blog-date\"><em>".$blogDate."</em></div><div class=\"blog-author\">By <a href=\"#\">".$blogUser."</a></div></div>";
						$blogEntry = $blogEntry."<div class=\"cleaner\"></div>";
						$blogEntry = $blogEntry."<div class=\"blog-content\">".$blogContent."</div>";
						$blogEntry = $blogEntry."<p>Related to <a href=\"#\">".$blogProyect."</a></p>";					
						$content = str_replace( "{blogEntry}", $blogEntry , $content );
					}
					else{
						$content = str_replace( "{blogEntry}", "<h3>There's no data to show</h3>" , $content );
					}
					$result2 = $index -> gestLastArticle( );
					if( !( $result2 -> num_rows ) == 0 ){
						$row = $result2 -> fetch_row();
						$articleType = $row[ 4 ];
						$articleTitle = $row[ 0 ];
						$articleContent = $row[ 1 ];
						$author = $row[ 2 ];
						$articleProyect = $row[ 3 ];
						
						$article = "<h3 class=\"text-center\">".$articleTitle."</h3>";
						$article = $article."<div class=\"\"><div class=\"\"><dl class=\"dl-horizontal\"><dt>Type</dt><dd>".$articleType."<dd></dl></div>";
						$article = $article."<div class=\"blog-content\">".$articleContent."</div>";
						$article = $article."<p>Related to <a href=\"#\">".$articleProyect."</a></p>";
						$article = $article."<div class=\"blog-author\">By <a href=\"#\">".$author."</a></div></div>";
						$article = $article."<div class=\"cleaner\"></div>";
						$content = str_replace( "{wikiArticle}", $article , $content );
					}
					else{
						$content = str_replace( "{wikiArticle}", "<h3>There's no data to show</h3>" , $content );
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