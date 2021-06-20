<?php
class printController extends controller{


	public function send(){
		$this->checkUser();
		if($this->id_group == 0){
			header('Location: '.BASE_URL);
		}	
		$this->loadTemplete("uploadPrints");
	}

	public function upload(){
		$this->checkUser();
		if($this->id_group == 0){
			header('Location: '.BASE_URL);
		}
		if(count($_FILES['print']) > 0){
			$name = $this->uploadImage($_FILES['print'], $this->id_user.$this->id_group, 'images/prints/');
		}else{
			header('Location: '.BASE_URL);
			exit;
		}
		echo $name;
		if(!$this->uploadPrintBase($name, $this->id_user)){
			echo "Ops! Algo deu errado.";
			exit;
		}
		header('Location: '.BASE_URL.'print/history');
		exit;
	}
	private function uploadPrintsBase($names, $numberImages){
		if(count($names) > 0){
			if($this->prints->setPrint($this->id_user)){
				$id_print = $this->prints->getLastCreatePrint();
				if($id_print != 0){
					for($counter = 0; $counter < $numberImages; $counter++){
						if(!$this->prints->setFile($id_print, $names[$counter])){
							return false;
						}
					}
					return true;
				}
			}
		}
		return false;
	}
	private function uploadPrintBase($name, $id_user){
		if(!empty($name)){
			if($this->prints->setPrint($id_user)){
				$id_print = $this->prints->getLastCreatePrint();
				if($id_print != 0){
					if(!$this->prints->setFile($id_print, $name)){
						return false;
						echo "Não setou o arquuivo";
					}
					return true;
				}
				echo "Não encontrou o id do print";
			}
			echo "Não setou o print";
		}
		return false;
	}
	public function history(){
		$this->checkUser();
		if($this->id_group == 0){
			header('Location: '.BASE_URL);
		}	
		$dados['history'] = $this->prints->getHistoryPrints($this->id_user);
		for ($i=0; $i < count($dados['history']) ; $i++) { 
			$dados['history'][$i]['monsters'] = $this->prints->getMonsters($dados['history'][$i]['id_print']);
		}
		$this->loadTemplete('historyPrints', $dados);
	}

	public function verify(){
		$this->checkUser();
		if($this->userPriority == 0){
			header('Location: '.BASE_URL);
		}	
		$dados['prints'] = $this->prints->getPrintsToAnalyze($this->id_group, $this->id_user);
		for ($i=0; $i < count($dados['prints']) ; $i++) { 
			$dados['prints'][$i]['monsters'] = $this->prints->getMonsters($dados['prints'][$i]['id_print']);
			$dados['prints'][$i]['user'] = $this->users->getUser($dados['prints'][$i]['id_user']);
		}
		$this->loadTemplete('verifyPrints', $dados);
	}

	public function open($id_print){
		$this->checkUser();
		$dados['print'] = $this->prints->getPrintToAnalyze($id_print);
		$dados['user'] = $this->users->getUser($dados['print']['id_user']);
		$dados['monsters'] = $this->prints->getMonsters($id_print);
		
		if($this->userPriority == 0 || $dados['print']['id_user'] == $this->id_user){
			$this->loadTemplete('openPrint', $dados);
		}else{
			$this->loadTemplete('verifyPrint', $dados);
		}
	}

	public function addMonster($id_print){
		$this->checkUser();
		if($this->userPriority == 0){
			header('Location: '.BASE_URL);
			exit;
		}
		if(!isset($_POST['name']) && empty($_POST['name'])){
			header('Location: '.BASE_URL.'print/open/'.$id_print);
			exit;
		}
		if(count($this->prints->getPrintToAnalyze($id_print)) == 0){
			header('Location: '.BASE_URL);
			exit;
		}
		$name = addslashes($_POST['name']);
		$level = addslashes($_POST['level']);
		$date_monster = addslashes($_POST['date_monster']);
		$x_position = addslashes($_POST['x_position']);
		$y_position = addslashes($_POST['y_position']);
		$r_position = addslashes($_POST['r_position']);

		$date = DateTime::createFromFormat('d-m-y H:i:s', $date_monster);
		$date_monster = $date->format('Y-m-d H:i:s');
		
		$this->prints->setMonster($id_print, $name, $level, $date_monster, $x_position, $y_position, $r_position, 1, "Adicionado");
		header('Location: '.BASE_URL.'print/open/'.$id_print);
		exit;
	}
	public function accept($id_print){
		$this->checkUser();
		if($this->userPriority == 0){
			header('Location: '.BASE_URL);
			exit;
		}
		if(count($this->prints->getPrintToAnalyze($id_print)) == 0){
			header('Location: '.BASE_URL);
			exit;
		}
		$this->prints->updateStatus($id_print, 1);
		header('Location: '.BASE_URL.'print/verify');
		exit;
	}
	public function reject($id_print){
		$this->checkUser();
		if($this->userPriority == 0){
			header('Location: '.BASE_URL);
			exit;
		}
		if(count($this->prints->getPrintToAnalyze($id_print)) == 0){
			header('Location: '.BASE_URL);
			exit;
		}
		$this->prints->updateStatus($id_print, 2);
		header('Location: '.BASE_URL.'print/verify');
		exit;
	}
}