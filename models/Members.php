<?php
class Members extends Model{

	public function setMember($id_group, $id_user, $priority){
		$sql = "INSERT INTO members (id_group, id_user, priority, date_entry) VALUES (:id_group, :id_user, :priority, :date_entry)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_group", $id_group);
		$sql->bindValue(":id_user", $id_user);
		$sql->bindValue(":priority", $priority);
		$sql->bindValue(':date_entry', date('Y-m-d H:i:s'));
		if($sql->execute()){
			$this->updateUpNumberMembers($id_group);
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}

	public function updateUpNumberMembers($id_group){
		$sql = "UPDATE groups SET number_members = number_members + 1 WHERE id = :id_group";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_group", $id_group);

		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}
	public function updateDownNumberMembers($id_group){
		$sql = "UPDATE groups SET number_members = number_members - 1 WHERE id = :id_group";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_group", $id_group);

		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}
	public function getMember($id_user){
		$member = array();
		$sql = "SELECT * FROM members WHERE id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();
	
		if($sql->rowCount() > 0){
			$member = $sql->fetch(PDO::FETCH_ASSOC);
			return $member;
		}
		return array();	
	}
	public function getMemberGroup($id_user, $id_group){
		$sql = "SELECT * FROM members WHERE id_group = :id_group AND id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_group', $id_group);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();
	
		if($sql->rowCount() > 0){
			$member = $sql->fetch(PDO::FETCH_ASSOC);
			return $member;
		}
		return array();	
	}
	public function getLeaderGroup($id_group){
		$sql = "SELECT * FROM members WHERE id_group = :id_group AND priority = 2";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_group', $id_group);
		$sql->execute();

		if($sql->rowCount() > 0){
			$member = $sql->fetch(PDO::FETCH_ASSOC);
			return $member;
		}
		return array();
	}

	public function checkUserHasGroup($id_user){
		$sql = "SELECT * FROM members WHERE id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		if($sql->rowCount() > 0){
			$member = $sql->fetch(PDO::FETCH_ASSOC);
			return $member;
		}else{
			return array();
		}
	}

	public function editPriority($id_group, $id_user, $priority){
		$sql = "UPDATE members SET members.priority = :priority WHERE members.id_group = :id_group AND members.id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":priority", $priority);
		$sql->bindValue(":id_group", $id_group);
		$sql->bindValue(":id_user", $id_user);

		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}
	public function deleteMember($id_member){
		$sql = "DELETE FROM members WHERE id = :id_member";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_member", $id_member);

		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}
	public function getAllMemberByPriority($priority){
		$sql = "SELECT * FROM members WHERE priority = :priority";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':priority', $priority);
		$sql->execute();

		if($sql->rowCount() > 0){
			$group = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $group;
		}
		return array();
	}
	public function getAllGroupMembersByPriority($id_group, $priority){
		$sql = "SELECT * FROM members WHERE id_group = :id_group AND priority = :priority";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_group', $id_group);
		$sql->bindValue(':priority', $priority);
		$sql->execute();

		if($sql->rowCount() > 0){
			$membersAdmin = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $membersAdmin;
		}
		return array();
	}
	// public function getAllGroupMember($id_group){
	// 	$sql = "SELECT * FROM members WHERE id_group = :id_group";
	// 	$sql = $this->db->prepare($sql);
	// 	$sql->bindValue(':id_group', $id_group);
	// 	$sql->execute();

	// 	if($sql->rowCount() > 0){
	// 		$allMembers = $sql->fetchAll(PDO::FETCH_ASSOC);
	// 		return $allMembers;
	// 	}
	// 	return array();
	// }
	public function getAllSuperiorAdministrator($id_group){
		$sql = "SELECT * FROM members, users WHERE members.priority > 1 AND users.id = members.id_user AND members.id_group = :id_group ORDER BY members.priority DESC, users.name";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_group', $id_group);
		$sql->execute();
	
		if($sql->rowCount() > 0){
			$members = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $members;
		}
		return array();
	}
	public function getAllMembersGroup($id_group){
		$sql = "SELECT users.name, users.nickname, users.n_phone, users.date_register, members.date_entry, members.priority, users.id as is_user, members.id as id_member FROM members, users WHERE users.id = members.id_user AND members.id_group = :id_group ORDER BY members.priority DESC, users.name";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_group', $id_group);
		$sql->execute();
	
		if($sql->rowCount() > 0){
			$members = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $members;
		}
		return array();
	}
}