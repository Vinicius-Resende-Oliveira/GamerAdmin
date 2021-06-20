<?php
class Administrators extends model {

	public function login($nickname, $password){
		$sql = "SELECT id FROM administrators WHERE nickname = :nickname AND password = :password";
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

	public function editAdministrator($id_administrator, $name, $nickname, $n_phone, $email){
		$sql = "UPDATE adminstrators SET name = :name, nickname = :nickname, n_phone = :n_phone, email = :email WHERE id = :id_administrator";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':name', $name);
		$sql->bindValue(':nickname', $nickname);
		$sql->bindValue(':n_phone', $n_phone);
		$sql->bindValue(':email', $email);
		$sql->bindValue(':id_administrator', $id_administrator);

		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}
	public function get($id_administrator){
		$sql = "SELECT id, `name`, nickname, email, n_phone FROM administrators WHERE id = :id_administrator";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_administrator", $id_administrator);
		$sql->execute();

		if($sql->rowCount() > 0){
			$sql = $sql->fetch(PDO::FETCH_ASSOC);
			return $sql;
		}
		return array();
	}
}