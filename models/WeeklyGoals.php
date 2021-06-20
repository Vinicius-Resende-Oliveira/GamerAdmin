<?php
class Weeklygoals extends Model{

	public function set($id_member, $id_week, $points, $status){
		$sql = "INSERT INTO weeklygoals (id_member, id_week, points, `status`) VALUES (:id_member, :id_week, :points, :status)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_member", $id_member);
		$sql->bindValue(":id_week", $id_week);
		$sql->bindValue(":points", $points);
		$sql->bindValue(':status', $status);
		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
	}

	public function get($id_member, $id_week){
		$sql = "SELECT * FROM weeklygoals WHERE id_member = :id_member AND id_week = :id_week";
		$sql = $this->db->prepare($sql);
        $sql->bindValue(':id_member', $id_member);
        $sql->bindValue(':id_week', $id_week);
		$sql->execute();
	
		if($sql->rowCount() > 0){
			$member = $sql->fetch(PDO::FETCH_ASSOC);
			return $member;
		}
		return array();	
    }
    public function setWeek($week_start, $week_end){
        $sql = "INSERT INTO week (week_start, week_end) VALUES (:week_start, :week_end)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":week_start", $week_start);
		$sql->bindValue(":week_end", $week_end);
		if($sql->execute()){
			return true;
		}else{
			print_r($sql->errorInfo());
			return false;
		}
    }
}