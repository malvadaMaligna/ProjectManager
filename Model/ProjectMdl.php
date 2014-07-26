<?php
	class ProjectMdl{
		
		private $connection;
		
		public function __construct( $connection ){
			$this -> connection = $connection;
		}
		
		public function getProject( $idProject ){
			$query = "SELECT name FROM Project WHERE idProject = $idProject ";
			$result = $this -> connection -> query( $query ) or die( "DB Error: ProjectMdl.getProject: Error " );
			return $result;
		}
		
		public function getProjectDataComplete( $idProject ){
			$query = "SELECT p.name, p.description, p.startDate, s.status FROM Project AS p
					INNER JOIN projectstatus AS s ON s.idProjectStatus = p.status WHERE p.idProject = $idProject";
			$result = $this -> connection -> query( $query ) or die( "DB Error: ProjectMdl.getProjectDataComplete: Error " );
			return $result;
		}
		public function getProjectData( $idProject ){
			$query = "SELECT name, description FROM Project WHERE idProject = $idProject ";
			$result = $this -> connection -> query( $query ) or die( "DB Error: ProjectMdl.getProjectData: Error " );
			return $result;
		}
		
		/*public function getProjectsByUser( $idUser ){
			$query = "SELECT p.name, p.description, p.startDate, s.status, p.idProject FROM project AS p 
			INNER JOIN projectstatus AS s ON s.idprojectstatus = p.status 
			INNER JOIN collaborators AS c ON c.idproject = p.idproject 
			INNER JOIN user AS u ON u.iduser = c.iduser WHERE u.iduser = $idUser ";
			$result = $this -> connection -> query( $query ) or die( "DB Error: ProjectMdl.getProjectsByUser: Error " );
			return $result;
		}*/
		public function getProjectsByUser( $idUser ){
		 $query = "SELECT p.name, p.description, p.startDate, s.status, p.idProject 
		 FROM collaborators AS c 
		 INNER JOIN project AS p ON p.idProject = c.idProject 
		 INNER JOIN projectstatus AS s ON s.idprojectstatus = p.status 
		 INNER JOIN user AS u ON u.iduser = c.iduser WHERE u.iduser = $idUser ";
		$result = $this -> connection -> query( $query ) or die( "DB Error: ProjectMdl.getProjectsByUser: Error " );
		return $result;
		}
		
		public function getCollaboratorsByProjectId( $idProject ){
			$query = "SELECT u.nickname, p.name, t.type FROM user AS u 
					INNER JOIN collaborators AS c ON u.iduser = c.iduser 
					INNER JOIN project AS p ON p.idproject = c.idproject 
					INNER JOIN collaboratortype AS t ON t.idcollaboratortype = c.rol 
					WHERE p.idproject = $idProject";
			$result = $this -> connection -> query( $query ) or die( "DB Error: ProjectMdl.getCollaboratorsByProjectId: Error " );
			return $result;
		}
		
		public function getCollaboratorsByProjectIdp( $idProject ){
			$query = "SELECT u.nickname, u.idUser, p.name, t.type FROM user AS u
			INNER JOIN collaborators AS c ON u.iduser = c.iduser
			INNER JOIN project AS p ON p.idproject = c.idproject
			INNER JOIN collaboratortype AS t ON t.idcollaboratortype = c.rol
			WHERE p.idproject = $idProject";
			$result = $this -> connection -> query( $query ) or die( "DB Error: ProjectMdl.getCollaboratorsByProjectId: Error " );
			return $result;
		}
		
 		public function getProjectsInProgress( ){
			$query ="SELECT p.name, p.idProject FROM project AS p WHERE p.status = 1";
			$result = $this -> connection -> query( $query ) or die( "DB Error: ProjectMdl.getProjectsInProgress: Error " );
			return $result;
		}
		
		public function getProjectsFinished( ){
			$query ="SELECT p.name, p.idProject FROM project AS p WHERE p.status = 2";
			$result = $this -> connection -> query( $query ) or die( "DB Error: ProjectMdl.getProjectsFinished: Error " );
			return $result;
		}
		
		public function setProject( $name, $description, $startDate, $status ){
			$query ="INSERT INTO project( name, description, startDate, STATUS ) 
					VALUES (\"".$name."\",\"".$description."\",\"".$startDate."\", $status )";
			$result = $this -> connection -> query( $query ) or die( "DB Error: ProjectMdl.setProject: Error " );
			return $result;
		}
		
		public function setTask( $idProject, $description, $initDate, $endDate, $idOwner, $idUser){
			$query ="INSERT INTO task( idProject, description, initDate, endDate, priority, 
					STATUS , idOwner, deathLine, idUser ) 
					VALUES ( $idProject,  \"".$description."\",  \"".$initDate."\", \"".$endDate."\", 1, 1, $idOwner,\"null\", $idUser )";
			$result = $this -> connection -> query( $query ) or die( "DB Error: ProjectMdl.setTask: Error " );
			return $result;
		}
	}
?>