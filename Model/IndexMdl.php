<?php
	class IndexMdl{
		
		private $connection;
		
		public function __construct( $connection ){
			$this -> connection = $connection;
		}
		
		public function getLastBlogEntry( ){
			$query = "SELECT b.date, b.title, b.content, u.nickname, p.name FROM BlogEntry as b 
					INNER JOIN Project as p on p.idProject = b.idProject 
					INNER JOIN User as u on u.idUser = b.idUser 
					ORDER BY b.date DESC, b.idBlogEntry DESC LIMIT 1";
			$result = $this -> connection -> query( $query ) or die( "DB Error: IndexMdl.getLastBlogEntry: Error " );
			return $result;
		}
		
		public function gestLastArticle( ){
			$query = "SELECT a.title, a.content, u.nickname, p.name, t.type FROM article AS a 
					INNER JOIN articleType AS t ON a.articleType = t.idArticleType 
					INNER JOIN Project AS p ON p.idProject = a.idProject 
					INNER JOIN User AS u ON u.idUser = a.author 
					ORDER BY a.idArticle DESC LIMIT 1";
			$result = $this -> connection -> query( $query ) or die( "DB Error: IndexMdl.gestLastArticle: Error " );
			return $result;
		}
	}

?>