<?php
class Groups extends model {


	public function getAllGroups(){
		$sql = "SELECT * FROM groups ORDER BY name";
		$sql = $this->db->query($sql);

        if($sql->rowCount() > 0){
            $sql = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $sql;
		}else{
			return array();
		}
	}

	public function setGroup($name, $tag, $rules, $pts_goal, $goal_total, $privacy, $url_image, $date_due){
		$sql = "INSERT INTO groups (name, tag, rules, pts_goal, goal_total, date_create, privacy, url_image, date_due) VALUES (:name, :tag, :rules, :pts_goal, :goal_total, :date_create, :privacy, :url_image, :date_due)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':name', $name);
		$sql->bindValue(':tag', $tag);
		$sql->bindValue(':rules', $rules);
		$sql->bindValue(':pts_goal', $pts_goal);
		$sql->bindValue(':goal_total', $goal_total);
		$sql->bindValue(':date_create', date('Y-m-d H:i:s'));
		$sql->bindValue(':privacy', $privacy);
		$sql->bindValue(':url_image', $url_image);
		$sql->bindValue(':date_due', $date_due);
		
		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}

	public function getGroup($id_group){
		$sql = "SELECT * FROM groups WHERE id = :id_group";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_group', $id_group);
		$sql->execute();

		if($sql->rowCount() > 0){
			$group = $sql->fetch(PDO::FETCH_ASSOC);
			return $group;
		}
		return array();
	}

	public function getLastGroupCreated(){
		$sql = "SELECT id FROM groups WHERE id = (SELECT max(id) FROM groups)";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0){
			$group = $sql->fetch(PDO::FETCH_ASSOC);
			return $group['id'];
		}
		return "0";
	}
	public function checkNameExist($name){
		$sql = "SELECT id FROM groups WHERE `name` = :name";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":name", $name);
		$sql->execute();

		if($sql->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function updateName($id_group, $name, $tag){
		$sql = "UPDATE groups SET `name` = :name, tag = :tag WHERE id = :id_group";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':name', $name);
		$sql->bindValue(':tag', $tag);
		$sql->bindValue(':id_group', $id_group);
		
		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}

	public function updateGoal($id_group, $pts_goal, $goal_total){
		$sql = "UPDATE groups SET pts_goal = :pts_goal, goal_total = :goal_total WHERE id = :id_group";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':pts_goal', $pts_goal);
		$sql->bindValue(':goal_total', $goal_total);
		$sql->bindValue(':id_group', $id_group);
		
		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}
	public function updateRules($id_group, $rules){
		$sql = "UPDATE groups SET rules = :rules WHERE id = :id_group";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':rules', $rules);
		$sql->bindValue(':id_group', $id_group);
		
		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}

	public function getAllForDue(){
		$sql = "SELECT groups.*, users.nickname, users.id as id_user FROM groups, members, users WHERE members.priority = 2 AND members.id_group = groups.id AND members.id_user = users.id ORDER BY date_due ASC";
		$sql = $this->db->query($sql);

        if($sql->rowCount() > 0){
            $sql = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $sql;
		}else{
			return array();
		}
	}

	public function renew($id_group, $date_due){
		$sql = "UPDATE groups SET date_due = :date_due WHERE id = :id_group";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':date_due', $date_due);
		$sql->bindValue(':id_group', $id_group);
		
		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}
}