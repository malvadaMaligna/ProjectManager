<?php

	class UserMdl{
		private $connection;
		
		public function __construct( $connection ){
			$this -> connection = $connection;
		}
		
		//TODO funciones query
		public function setUser( $name, $lastname, $nickName, $password, $email, $userType, $code, $regDate){
			$query = "INSERT INTO user ( name, lastname, nickName, password, email, userType, code, regDate ) VALUES ( \"".$name."\", \"".$lastname."\", \"".$nickName."\", \"".$password."\", \"".$email."\", $userType, \"".$code."\",\"".$regDate."\" ) ";
			$result = $this -> connection -> query( $query ) or die( "DB Error: UserMdl.setUser: Error " );
			return $result;
		}
		
		public function setUserContact( $cellphone, $facebook, $github, $google, $twitter, $idUser ){
			$query = "INSERT INTO usercontact ( cellphone, facebook, github, google, twitter, idUser ) VALUES ( \"".$cellphone."\",\"".$facebook."\",\"".$github."\",\"".$google."\",\"".$twitter."\", $idUser ) ";
			$result = $this -> connection -> query( $query ) or die( "DB Error: UserMdl.setUserContact: Error " );
			return $result;
		}
		
		public function getUser( $idUser) {
			$query = "SELECT nickName FROM user WHERE idUser = $idUser";
			$result = $this -> connection -> query( $query ) or die("DB Error: UserMdl.getUser: Error " );
			return $result;
		}
		
		public function updateUserData( $nickName, $mail, $pswd, $cell, $fb, $tw, $idUser ){
			$query = "UPDATE user AS u INNER JOIN usercontact AS s SET u.nickName =  \"".$nickName."\",
					u.email = \"".$mail."\", u.password = \"".$pswd."\", s.cellphone = \"".$cell."\", 
					s.facebook = \"".$fb."\", s.twitter = \"".$tw."\" WHERE u.idUser = $idUser AND s.idUser = $idUser ";
			$result = $this -> connection -> query( $query ) or die( "DB Error: UserMdl.updateUserData: Error " );
			return $result;
		}
		
		public function getTasksByUser( $idOwner ){
			$query = "SELECT t.description, t.initDate, t.deathline, t.endDate, p.name FROM task AS t 
					INNER JOIN project AS p ON t.idproject = p.idproject WHERE idOwner = $idOwner AND t.status =1";
			$result = $this -> connection -> query( $query ) or die( "DB Error: UserMdl.getTasksByIdUser: Error " );
			return $result;
		}
		
		public function getCountTasksByUser( $idOwner ){
			$query = "SELECT COUNT( * ) FROM task WHERE idOwner = $idOwner AND STATUS =1";
			$result = $this -> connection -> query( $query ) or die( "DB Error: UserMdl.getCountTasksByUser: Error " );
			return $result;
		}
		
		public function getLastBlogEntryByUser( $idUser ){
			$query = "SELECT b.date, b.title, b.content, u.nickname, p.name FROM BlogEntry AS b 
					INNER JOIN Project AS p ON p.idProject = b.idProject 
					INNER JOIN User AS u ON u.idUser = b.idUser WHERE u.idUser = $idUser 
					ORDER BY b.date DESC , b.idBlogEntry DESC LIMIT 1";
			$result = $this -> connection -> query( $query ) or die( "DB Error: UserMdl.getLastBlogEntryByUser: Error " );
			return $result;
		}
		
		public function getLastArticleByUser( $idUser ){
			$query = "SELECT a.title, a.content, u.nickname, p.name, t.type FROM article AS a 
					INNER JOIN articleType AS t ON a.articleType = t.idArticleType 
					INNER JOIN Project AS p ON p.idProject = a.idProject 
					INNER JOIN User AS u ON u.idUser = a.author WHERE u.idUser = $idUser ORDER BY a.idArticle DESC";
			$result = $this -> connection -> query( $query ) or die( "DB Error: UserMdl.getLastArticleByUser: Error " );
			return $result;
		}
		
		public function getUsers( ){
			$query ="SELECT idUser, nickName FROM user";
			$result = $this -> connection -> query( $query ) or die( "DB Error: UserMdl.getUsers: Error " );
			return $result;
		}
	}

?>

