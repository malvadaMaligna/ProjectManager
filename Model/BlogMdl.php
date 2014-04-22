<?php

	class BlogMdl{
		
		private $connection;
		
		public function __construct( $connection ){
			$this -> connection = $connection;
		}
		
		//TODO funciones query
		public function setBlogEntry( $iduser, $idProject, $date, $title, $content ){
			$query = "INSERT INTO BlogEntry ( iduser, idProject, date, title, content ) VALUES ( $iduser, $idProject, \"".$date."\", \"".$title."\", \"".$content."\" ) ";
			$result = $this -> connection -> query( $query ) or die( "DB Error: BlogMdl.setEntryBlog: Error " );
			return $result;
		}
		
		public function getProject( $idProject ){
			$query = "SELECT name FROM Project WHERE idProject = $idProject ";
			$result = $this -> connection -> query( $query ) or die( "DB Error: BlogMdl.getProject: Error " );
			return $result;
		}
		
		public function getProjectData( $idProject ){
			$query = "SELECT name, description FROM Project WHERE idProject = $idProject ";
			$result = $this -> connection -> query( $query ) or die( "DB Error: BlogMdl.getProject: Error " );
			return $result;
		}
		
		public function getBlogEntries(){
			$query = "SELECT b.date, b.title, b.content, u.nickname, p.name FROM BlogEntry as b INNER JOIN Project as p on p.idProject = b.idProject INNER JOIN User as u on u.idUser = b.idUser WHERE p.idProject = b.idProject ORDER BY b.date";
			$result = $this -> connection -> query( $query ) or die(  "DB Error: BlogMdl.getProject: Error " );
			return $result;
		}
		
		public function getPojectBlogEntries( $idProject ){
			$query = "SELECT b.date, b.title, b.content, u.nickname, p.name FROM BlogEntry as b INNER JOIN Project as p on p.idProject = b.idProject INNER JOIN User as u on u.idUser = b.idUser WHERE p.idProject = b.idProject and b.idProject = $idProject ORDER BY b.date";
			$result = $this -> connection -> query( $query ) or die(  "DB Error: BlogMdl.getProject: Error " );
			return $result;
		}
		
		public function getProjectBlogUsers( $idProject ){
			$query = "SELECT DISTINCT u.nickname FROM blogEntry AS b INNER JOIN user AS u ON u.idUser = b.idUser WHERE b.idProject = $idProject ";
			$result = $this -> connection -> query( $query ) or die(  "DB Error: BlogMdl.getProject: Error " );
			return $result;
		}
	}

	
?>