<?php
	class ArticleMdl{
		
		private $connection;
		
		public function __construct( $connection ){
			$this -> connection = $connection;
		}
		
		public function setArticleEntry(  $title, $content, $idProject, $articleType, $idUser ){
			$query = "INSERT INTO article( title, content, idProject, articleType, author ) VALUES ( \"".$title."\", \"".$content."\", $idProject, $articleType, $idUser )";
			$result = $this -> connection -> query( $query ) or die( "DB Error: ArticleMdl.setArticleEntry: Error " );
			return $result;
		}
		
		public function setArticleTypeEntry( $type ){
			$query = "INSERT INTO articleType( type ) VALUES ( \"".$type."\")";
			$result = $this-> connection -> query( $query ) or die( "DB Error: ArticleMdl.setArticleTypeEntry: Error");
			return $result;
		}
		
		public function getArticleTypes(){
			$query = "SELECT idArticleType, type FROM articleType";
			$result = $this-> connection -> query( $query ) or die( "DB Error: ArticleMdl.getArticleTypes: Error");
			return $result;
		}
		
		public function getArticleTypeById( $articleTypeId ){
			$query = "SELECT type FROM articletype WHERE idArticleType = $articleTypeId ";
			$result = $this -> connection -> query( $query ) or die( "DB Error: ArticleMdl.getArticleTypeById: Error");
			return $result;
		}
		
		public function getProjectArticleAuthors( $idProject ){
			$query = "SELECT DISTINCT u.nickname FROM article AS a INNER JOIN user AS u ON u.idUser = a.author WHERE a.idProject = $idProject";
			$result = $this -> connection -> query( $query ) or die( "DB Error: ArticleMdl.getProjectArticleAuthors: Error");
			return $result;
		}
		
		public function getProjectArticles( $idProject ){
			$query = "SELECT a.title, a.content, t.type, u.nickname, p.name FROM article AS a 
					INNER JOIN articleType AS t ON t.idArticleType = a.articleType 
					INNER JOIN Project AS p ON p.idProject = a.idProject 
					INNER JOIN User AS u ON u.idUser = a.author 
					WHERE p.idProject = a.idProject AND a.idProject = $idProject";
			$result = $this -> connection -> query( $query ) or die( "DB Error: ArticleMdl.getProjectArticles: Error");
			return $result;
		}
	}
?>