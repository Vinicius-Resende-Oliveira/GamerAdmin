<?php
class Images extends model {

	public function setImage($id_player, $url){
		$sql = "INSERT INTO images_player (`url`, date_send) VALUES (:url, :date_send)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":url", $url);
		$sql->bindValue(':date_send', date('Y-m-d H:i:s'));
		$sql->execute();
	}



}