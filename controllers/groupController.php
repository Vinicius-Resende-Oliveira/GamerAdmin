<?php
class groupController extends controller{

	public function register(){
		if(isset($_SESSION['id_administrator']) && !$_SESSION['id_administrator']){
			header('Location: '.BASE_URL);
			exit;
		}
		$this->loadView('registerGroup');
	}

	public function save(){
		if(isset($_SESSION['id_administrator']) && !$_SESSION['id_administrator']){
			header('Location: '.BASE_URL);
			exit;
		}
		$dados = array();
		$nickname = addslashes($_POST['nickname']);

		$name = addslashes($_POST['name']);
		$tag = addslashes($_POST['tag']);
		$rules = "";
		$pts_goal = "1[0];2[0];3[0];4[0];5[0]"; 
		$total_goal = 0;
		$privacy = (int) $_POST['privacy'];
		$nameFile = "default_group.png";
		$days = (int) addslashes($_POST['days']);
		if($days > 7){
			$days += 10;
		}
		$dateDue = new DateTime();
		$dateDue->setTimestamp(strtotime("+".$days." days"));

		$user = $this->users->getUserNickname($nickname);
		$dados['erroNameExist'] = $this->groups->checkNameExist($name);
		$dados['erroUserHasGroup'] = $this->members->checkUserHasGroup($user['id']);
		
		if(!$dados['erroNameExist'] && count($dados['erroUserHasGroup']) == 0){
			if($this->groups->setGroup($name, $tag, $rules, $pts_goal, $total_goal, $privacy, $nameFile, $dateDue->format('Y-m-d H:i:s'))){
				$id_group = $this->groups->getLastGroupCreated();
				if($id_group != 0){
					$this->members->setMember($id_group, $user['id'], 2);
					header('Location: '.BASE_URL.'administrator/index');
					return true;
					exit;
				}
			}		
		}
		$this->loadView('registerGroup', $dados);
		return false;
	}

	public function expired($id_group){
		$dados['view'] = "expired";
		$dados['group'] = $this->groups->getGroup($id_group);
		$dados['userPriority'] = $this->userPriority;
		$this->loadTemplete($dados['view'], $dados);
	}

	public function edit(){
		$this->checkUser();
		if(count($this->group) == 0){
			header('Location: '.BASE_URL);
			exit;
		}
		$this->group['pts_goal'] = $this->ptsGoal_Decode($this->group['pts_goal']);
		$dados['group'] = $this->group;
		$dados['member'] = $this->members->getMemberGroup($this->id_user, $this->id_group);
		if($dados['member']['priority'] == 2){
			$dados['leader'] = $this->user;
			$date_create = DateTime::createFromFormat("Y-m-d H:i:s", $dados['group']['date_create']);
			$dados['group']['date_create']= array('time' => $date_create->format("H:i:s"), 'day' => $date_create->format("d/m/Y"));

			$dateDue = DateTime::createFromFormat("Y-m-d H:i:s", $dados['group']['date_due']);
			$dados['group']['days_due'] = (strtotime($dateDue->format("Y-m-d")) - strtotime(date('Y-m-d'))) /86400;
		}else{
			header('Location: '.BASE_URL.'notFound');
			exit;
		}
		$this->loadTemplete('editGroup', $dados);
	}
	public function update(){
		$this->checkUser();
		if(count($this->group) == 0){
			header('Location: '.BASE_URL);
			exit;
		}
		$dados['member'] = $this->members->getMemberGroup($this->id_user, $this->id_group);
		$name = addslashes($_POST['name']);
		$tag = addslashes($_POST['tag']);
		$rules = "";
		$pts_goal = $_POST['levels']; 
		$pts_goal = $this->ptsGoal_Enconde($pts_goal);
		$goal_total = (int) addslashes($_POST['goal_total']);
		
		$privacy = (int) $_POST['privacy'];
		$dados['erroNameExist'] = $this->groups->checkNameExist($name);
		if($dados['member']['priority'] == 2){
			if(!$dados['erroNameExist']){
				if(!$this->groups->updateName($this->id_group, $name, $tag)){
					$this->edit();
					return true;
				}		
			}
			if(!$this->groups->updateGoal($this->id_group, $pts_goal, $goal_total)){
				$this->edit();
				return true;
			}
		}else{
			header('Location: '.BASE_URL.'notFound');
			exit;
		}
		$this->edit();
		return true;
	}
	private function ptsGoal_Enconde($levels){
		$c = 2;
		$pts_goal = "1[0];";
		foreach($levels as $value){
			$pts_goal .= $c.'['.$value.'];';
			$c++;
		}
		return $pts_goal;
	}

	private function ptsGoal_Decode($pts_goal){
		$nv = explode(';', $pts_goal);
		foreach($nv as $key => $value){
			$nv[$key] = substr($value, 2, -1);
		}
		
		return $nv;
	}
}