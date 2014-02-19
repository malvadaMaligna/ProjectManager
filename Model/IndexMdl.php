<?php
	class IndexMdl{
		
		private $connection;
		
		public function __construct( $connection ){
			$this -> connection = $connection;
		}
		
		public function getLastBlogEntry(  ){
			$query = "SELECT b.date, b.title, b.content, u.nickname, p.name FROM BlogEntry as b INNER JOIN Project as p on p.idProject = b.idProject INNER JOIN User as u on u.idUser = b.idUser ORDER BY b.date DESC LIMIT 1";
			$result = $this -> connection -> query( $query ) or die( "DB Error: IndexMdl.getLastBlogEntry: Error " );
			return $result;
		}
	}

?>