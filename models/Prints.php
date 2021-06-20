<?php
class Prints extends model{

	public function getHistoryPrints($id_user){
		$sql = "SELECT * FROM prints, files WHERE prints.id_user = :id_user AND prints.id = files.id_print ORDER BY date_send DESC";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if($sql->rowCount() > 0){
			$prints = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $prints;
		}
		return array();
	}

	public function getAllEvaluatorPrints($id_evaluator){
		$sql = "SELECT * FROM prints, files WHERE id_evaluator = :evaluator AND prints.id = files.id_print ORDER BY date_send DESC";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_evaluator', $id_evaluator);
		$sql->execute();

		if($sql->rowCount() > 0){
			$prints = $sql->fetch(PDO::FETCH_ASSOC);
			return $prints;
		}
		return array();
	}
	public function setPrint($id_user){
		$sql = "INSERT INTO prints (id_user, date_send) VALUES (:id_user, :date_send)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':date_send', date('Y-m-d H:i:s'));
		if($sql->execute()){
			return true;
		}
		return false;
	}

	public function getLastCreatePrint(){
		$sql = "SELECT id FROM prints WHERE id = (SELECT max(id) FROM prints)";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0){
			$group = $sql->fetch(PDO::FETCH_ASSOC);
			return $group['id'];
		}
		return "0";
	}

	public function setFile($id_print, $url_image){
		$sql = "INSERT INTO files (id_print, url_image) VALUES (:id_print, :url_image)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_print', $id_print);
		$sql->bindValue(':url_image', $url_image);
		if($sql->execute()){
			return true;
		}
		return false;
	}

	public function getPrintsToAnalyze($id_group, $id_evaluator){
		$sql = "SELECT *, prints.id AS id_print1, files.id AS id_file, prints.id_user AS id_user1 FROM prints, files, members WHERE  prints.id_user != :id_evaluator AND prints.id = files.id_print AND members.id_user = prints.id_user AND members.id_group = :id_group AND prints.status = 0 ORDER BY date_send ASC";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_evaluator', $id_evaluator);
		$sql->bindValue(':id_group', $id_group);
		$sql->execute();

		if($sql->rowCount() > 0){
			$prints = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $prints;
		}
		return array();
	}
	public function getPrintToAnalyze($id_print){
		$sql = "SELECT *, prints.id AS id_print1, files.id AS id_file FROM prints, files WHERE  prints.id = :id_print AND prints.id = files.id_print";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_print', $id_print);
		$sql->execute();

		if($sql->rowCount() > 0){
			$prints = $sql->fetch(PDO::FETCH_ASSOC);
			return $prints;
		}
		return array();
	}
	public function setMonster($id_print, $name, $level, $date_monster, $x_position, $y_position, $r_position, $status = 0, $note = NULL){
		$sql = "INSERT INTO monsters (id_print, name, level, date_monster, x_position, y_position, r_position, status, note) VALUES (:id_print, :name, :level, :date_monster, :x_position, :y_position, :r_position, :status, :note)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_print', $id_print);
		$sql->bindValue(':name', $name);
		$sql->bindValue(':level', $level);
		$sql->bindValue(':date_monster', $date_monster);
		$sql->bindValue(':x_position', $x_position);
		$sql->bindValue(':y_position', $y_position);
		$sql->bindValue(':r_position', $r_position);
		$sql->bindValue(':status', $status);
		$sql->bindValue(':note', $note);
		if($sql->execute()){
			return true;
		}
		print_r($sql->errorInfo());
		return false;
	}
	public function getMonsters($id_print){
		$sql = "SELECT * FROM monsters WHERE  monsters.id_print = :id_print";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_print', $id_print);
		$sql->execute();

		if($sql->rowCount() > 0){
			$prints = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $prints;
		}
		return array();
	}
	public function checkMonster($name, $level, $date_monster, $x_position, $y_position, $r_position){
		$sql = "SELECT id FROM monsters WHERE `name` = :name AND `level` = :level AND date_monster = :date_monster AND x_position = :x_position AND y_position = :y_position AND r_position = :r_position";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':name', $name);
		$sql->bindValue(':level', $level);
		$sql->bindValue(':date_monster', $date_monster);
		$sql->bindValue(':x_position', $x_position);
		$sql->bindValue(':y_position', $y_position);
		$sql->bindValue(':r_position', $r_position);
		$sql->execute();

		if($sql->rowCount() > 0){
			$monsters = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $monsters;
		}
		return array();
	}
	public function updateStatus($id_print, $status){
		$sql = "UPDATE prints SET `status` = :status WHERE id = :id_print";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":status", $status);
		$sql->bindValue(":id_print", $id_print);

		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}
	public function updateAnalyzeFile($id_file, $analyze){
		$sql = "UPDATE files SET `analyze` = :analyze WHERE id = :id_file";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":analyze", $analyze);
		$sql->bindValue(":id_file", $id_file);

		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}
	public function updateAnalyzePrint($id_print, $n_monsters, $pts_total = 0){
		$sql = "UPDATE prints SET `n_monsters` = :n_monsters, pts_total = :pts_total WHERE id = :id_print";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":n_monsters", $n_monsters);
		$sql->bindValue(":pts_total", $pts_total);
		$sql->bindValue(":id_print", $id_print);

		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}

	public function getAllPrintsForVision(){
		$sql = "SELECT *, prints.id as id_print1, files.id as id_file FROM prints, files WHERE files.id_print = prints.id AND files.analyze = 0";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0){
			$prints = $sql->fetchAll(PDO::FETCH_ASSOC);
			return $prints;
		}
		return array();
	}
}