<?php
class Users extends model {

	public function setUser($name, $nickname, $n_phone, $email, $password){
		$sql = "INSERT INTO users (name, nickname, n_phone, email, date_register, `password`) VALUES (:name, :nickname, :n_phone, :email, :date_register, :password)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":name", $name);
		$sql->bindValue(":nickname", $nickname);
		$sql->bindValue(":n_phone", $n_phone);
		$sql->bindValue(":email", $email);
		$sql->bindValue(':date_register', date('Y-m-d H:i:s'));
		$sql->bindValue(":password", $password);

		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}

	}
	public function getUser($id_user){
		$sql = "SELECT id, name, nickname, email, n_phone, date_register FROM users WHERE id = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		if($sql->rowCount() > 0){
			$sql = $sql->fetch(PDO::FETCH_ASSOC);
			return $sql;
		}
		return array();
	}
	public function getAll(){
		$sql = "SELECT id, name, nickname, email, n_phone, date_register FROM users ORDER BY nickname";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		if($sql->rowCount() > 0){
			$sql = $sql->fetch(PDO::FETCH_ASSOC);
			return $sql;
		}
		return array();
	}
	public function countAllUsers(){
		$sql = "SELECT COUNT(id) as number FROM users ORDER BY nickname";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0){
			$sql = $sql->fetch(PDO::FETCH_ASSOC);
			return $sql;
		}
		return array();
	}
	public function getUserNickname($nickname){
		$sql = "SELECT id, name, email, n_phone, date_register FROM users WHERE nickname LIKE :nickname";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":nickname", $nickname);
		$sql->execute();

		if($sql->rowCount() > 0){
			$sql = $sql->fetch(PDO::FETCH_ASSOC);
			return $sql;
		}
		return array();
	}
	public function getLastUserCreated(){
		$sql = "SELECT id FROM users WHERE id = (SELECT max(id) FROM users)";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0){
			$user = $sql->fetch(PDO::FETCH_ASSOC);
			return $user['id'];
		}
		return "0";
	}
	public function checkEmailExist($email){
		$sql = "SELECT id FROM users WHERE email = :email";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":email", $email);
		$sql->execute();

		if($sql->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function checkNicknameExist($nickname){
		$sql = "SELECT id FROM users WHERE nickname = :nickname";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":nickname", $nickname);
		$sql->execute();
		
		if($sql->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function checkPassword($id_user, $password){
		$sql = "SELECT id FROM users WHERE id = :id_user AND `password` = :password";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_user", $id_user);
		$sql->bindValue(":password", $password);
		$sql->execute();

		if($sql->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function loginUser($nickname, $password){
		$sql = "SELECT id FROM users WHERE nickname = :nickname AND password = :password";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":nickname", $nickname);
		$sql->bindValue(":password", $password);
		$sql->execute();
		
		if($sql->rowCount() > 0){
			$sql = $sql->fetch(PDO::FETCH_ASSOC);
			return $sql['id'];
		}else{
			return 0;
		}
	}

	public function editUser($id_user, $name, $nickname, $n_phone, $email){
		$sql = "UPDATE users SET name = :name, nickname = :nickname, n_phone = :n_phone, email = :email WHERE id = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':name', $name);
		$sql->bindValue(':nickname', $nickname);
		$sql->bindValue(':n_phone', $n_phone);
		$sql->bindValue(':email', $email);
		$sql->bindValue(':id_user', $id_user);

		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}

	public function changeToken($id_user, $token){
		$sql = "UPDATE users SET token = :token WHERE id = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':token', $token);
		$sql->bindValue(':id_user', $id_user);

		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}
	public function verifyToken($id_user){
		$sql = "SELECT * FROM users WHERE id = :id_user AND token = :token";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':token', $token);
		$sql->execute();

		if($sql->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function changePassword($id_user, $password){
		$sql = "UPDATE users SET `password` = :password WHERE id = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':password', $password);
		$sql->bindValue(':id_user', $id_user);

		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}
	public function addTemporaryUser($nickname, $password){
		$sql = "INSERT INTO users (nickname, `password`, date_register) VALUES (:nickname, :password, :date_register";
		$sql= $this->db->prepare($sql);
		$sql->bindValue(':nickname', $nickname);
		$sql->bindValue(':password', $password);
		$sql->bindValue(':date_register', date('Y-m-d H:i:s'));
		
		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}
}