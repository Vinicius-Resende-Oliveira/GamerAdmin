<?php
class Requests extends Model{

	public function setRequest($id_group, $id_user){
		$sql = "INSERT INTO requests (id_group, id_user, status, date_request) VALUES (:id_group, :id_user, 2, :date_request";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_group", $id_group);
		$sql->bindValue(":id_user", $id_user);
		$sql->bindValue(':date_request', date('Y-m-d H:i:s'));

		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}
	public function getRequest($id_user){
		$member = array();
		$sql = "SELECT * FROM requests WHERE id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if($sql->rowCount() > 0){
			$member = $sql->fetch(PDO::FETCH_ASSOC);
			return $member;
		}
		return array();
	}
	public function getRequestGroup($id_user, $id_group){
		$sql = "SELECT * FROM requests WHERE id_user = :id_user AND id_group = :id_group";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':id_group', $id_group);
		$sql->execute();

		if($sql->rowCount() > 0){
			$member = $sql->fetch(PDO::FETCH_ASSOC);
			return $member;
		}
		return array();
	}
	public function editStatus($id_group, $id_user, $status){
		$sql = "UPDATE requests SET  status = :status WHERE id_group = :id_group AND id_user = :id_user)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_group", $id_group);
		$sql->bindValue(":id_user", $id_user);
		$sql->bindValue(":priority", $priority);

		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}
	public function deleteRequest($id_request){
		$sql = "DELETE FROM requests WHERE id = :id_request";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_request", $id_request);

		if($sql->execute()){
			return true;
		}else{
			echo "Requests";
			print_r($sql->errorInfo());
			return false;
		}
	}
	public function getAllMembersForStatus($id_group, $status){
		$sql = "SELECT * FROM requests WHERE id_group = :id_group AND status = :status";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_group', $id_group);
		$sql->bindValue(':status', $status);
		$sql->execute();

		if($sql->rowCount() > 0){
			$requests = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $requests;
		}
		return array();
	}
	public function getAllMembersResquest($id_group){
		$sql = "SELECT * FROM requests WHERE id_group = :id_group";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_group', $id_group);
		$sql->execute();

		if($sql->rowCount() > 0){
			$requests = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $requests;
		}
		return array();
	}
	public function getAllRequestsInAnalysis($id_group){
		$sql = "SELECT * FROM requests, users WHERE id_group = :id_group AND status = 2 AND requests.id_user = users.id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_group', $id_group);
		$sql->execute();

		if($sql->rowCount() > 0){
			$requests = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $requests;
		}
		return array();
	}
	//========================================Funções para administrador do site
	public function getAllRequestForStatus($status){
		$sql = "SELECT * FROM requests WHERE status = :status";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':status', $status);
		$sql->execute();

		if($sql->rowCount() > 0){
			$requests = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $requests;
		}
		return array();
	}
	public function getAllRequest(){
		$sql = "SELECT * FROM requests";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0){
			$requests = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $requests;
		}
		return array();
	}
	//========================================Final das funções
	public function updateStatusRequest($id_request, $status){
		$sql = "UPDATE requests SET status = :status WHERE id = :id_request";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':status', $status);
		$sql->bindValue(':id_request', $id_request);
		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}
}