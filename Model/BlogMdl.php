<?php

	class BlogMdl{
		
		private $connection;
		
		public function __construct( $connection ){
			$this -> connection = $connection;
		}
		
		//TODO funciones query
		public function setEntryBlog( $user, $idProject){
			$query = "INSET INTO BlogEntry date, title, content WHERE idUser = \"$user\" AND idProject = \"$idProject\"  ";
			$result = $this -> connection -> query( $query ) or die( "DB Error: IndexMdl.getLastBlogEntry: Error " );
			return $result;
		}
	}

	
?>