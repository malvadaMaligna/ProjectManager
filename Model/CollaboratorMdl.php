<?php
	class CollaboratorMdl{
		
		private $connection;
		
		public function __construct( $connection ){
			$this -> connection = $connection;
		}
		
		public function setLeader( $idProject, $idUser, $rol ){
			$query = "INSERT INTO collaborators( idProject, idUser, rol ) VALUES ( $idProject, $idUser, $rol )";
			$result = $this -> connection -> query( $query ) or die( "DB Error: CollaboratorMdl.setLeader: Error " );
			return $result;
		}
		
		public function setCollaborator( $idProject, $idUser, $rol ){
			$query = "INSERT INTO collaborators( idProject, idUser, rol ) VALUES ( $idProject, $idUser, $rol )";
			$result = $this -> connection -> query( $query ) or die( "DB Error: CollaboratorMdl.setLeader: Error " );
			return $result;
		}
	}
?>