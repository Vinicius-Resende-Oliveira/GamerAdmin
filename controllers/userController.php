<?php
class userController extends controller{

	public function home(){
		$this->checkUser();
		
		if($this->user['name'] == NULL || $this->user['email'] == NULL){
			header('Location: '.BASE_URL.'user/userTemporary');
			exit;
		}else if($this->id_group > 0 && $this->userPriority == 1){
			$dados = $this->administratorPriority();
		}else if($this->id_group > 0 && $this->userPriority == 2){
			$dados = $this->leaderPriority();
		}else if($this->id_group > 0 && count($this->request) > 0 && $this->request['status'] == 2){
			$dados = $this->userWaitingRequest();
		// }else if($this->id_group > 0 && (count($this->request) == 0 || $this->request['status'] == 0) && $this->userPriority != 0){
		}else if($this->id_group == 0 && (count($this->request) == 0 || $this->request['status'] == 0)){
			$dados = $this->userWithoutGroup();
		}else if($this->id_group > 0 && $this->userPriority == 0){
			$dados = $this->commomPriority();
		}
		$dados['user'] = $this->dateUser();

		
		if(isset($dados['view'])){
			$this->loadTemplete($dados['view'], $dados);
		}else{
			$this->loadTemplete('homeMember', $dados);
		}
	}

	private function commomPriority(){
		$dados = array('member' => 'commomPriority');
		$dados['group'] = $this->group;
		return $dados;
	}

	private function administratorPriority(){
		$dados = array('member' => 'administratorPriority');
		$dados['group'] = $this->group;
		return $dados;
	}

	private function leaderPriority(){
		$dados = array('member' => 'leaderPriority');
		// $dados['avaliator'] = $this->members->getAllMembersGroup($this->group);
		$dados['group'] = $this->group;
		if($dados['group']['pts_goal'] == "1[0];2[0];3[0];4[0];5[0];"){
			$dados = array('view' => 'editGroup');
		}
		return $dados;
	}

	private function userWaitingRequest(){
		$dados = array('view' => 'userWaitingRequest');
		$dados['request'] = $this->request;
		$dados['group'] = $this->group;
		$dados['administrators'] = $this->members->getAllSuperiorAdministrator($this->id_group);
		return $dados;
	}
	private function userWithoutGroup(){
		$dados = array('view' => 'userWithoutGroup');

		$dados['groups'] = $this->groups->getAllGroups();

		return $dados;
	}
	public function register(){
		$dados = array();

		$dados['groups'] = $this->groups->getAllGroups();

		$this->loadView('registerUser', $dados);
	}

	public function save(){
		$dados = array();
		
		$id_group = (int) $_POST['sel_group'];
		$name = addslashes($_POST['name']);
		$nickname = addslashes($_POST['nickname']);
		$email = addslashes($_POST['email']);
		$n_phone = addslashes($_POST['n_phone']);
		$password = md5(addslashes($_POST['password']));
		$n_phone =  "55".str_replace(array('(', ')', '-', ' '), "", $n_phone);

		$dados['erroEmailExist'] = $this->users->checkEmailExist($email);
		$dados['erroNicknameExist'] = $this->users->checkNicknameExist($nickname);

		if(!$dados['erroEmailExist'] && !$dados['erroNicknameExist']){
			if($this->users->setUser($name, $nickname, $n_phone, $email, $password)){
				$id_user = $this->users->getLastUserCreated();	
				if($id_user != 0){
					$_SESSION['id_user'] = $id_user;
					header('Location: '.BASE_URL.'user/home');
					exit;
				}
			}		
		}
		$this->loadView('registerUser', $dados);
	}

	public function login(){
		$dados = array();
		$this->loadView('login', $dados);
	}

	public function connecting(){
		$dados = array();
		$nickname = addslashes($_POST['nickname']);
		$password = md5(addslashes($_POST['password']));

		$id_user = $this->users->loginUser($nickname, $password);
		if($id_user > 0){
			$_SESSION['id_user'] = $id_user;
			header('Location: '.BASE_URL.'user/home');
		}else{
			$dados['userNotFound'] = true;
			$this->loadView('login', $dados);
		}

	}
	public function logout(){
		$this->id_user = 0;
		$this->id_group = 0;

		session_destroy();
		header("Location: ".BASE_URL."user/login");
		exit;
	}

	public function userTemporary(){
		$this->checkUser();
		if($this->user['email'] != NULL){
			header('Location: '.BASE_URL);
			exit;
		}
		$dados['view'] = 'userTemporary';
		$dados['user'] = $this->user;
		$dados['user']['id_group'] = $this->id_group;
		$dados['groups'] = $this->groups->getAllGroups();
		$this->loadTemplete('editUserTemporary', $dados);
	}
	public function editUserTemporary(){
		$this->checkUser();
		if($this->user['name'] != NULL || $this->user['email'] != NULL){
			header('Location: '.BASE_URL);
			exit;
		}
		if(!isset($_POST['name']) && empty($_POST['name'])){
			header('Location: '.BASE_URL.'user/userTemporary');
			exit;
		}
		$name = addslashes($_POST['name']);
		$nickname = $this->user['nickname'];
		$email = addslashes($_POST['email']);
		$n_phone = addslashes($_POST['n_phone']);
		$n_phone =  "55".str_replace(array('(', ')', '-', ' '), "", $n_phone);

		$dados['erroEmailExist'] = $this->users->checkEmailExist($email);

		if(!$dados['erroEmailExist']){
			if($this->users->editUser($this->id_user, $name, $nickname, $n_phone, $email)){
				header('Location: '.BASE_URL);
				exit;
			}	
		}
		
		header('Location: '.BASE_URL.'user/userTemporary');
		exit;
	}

	public function edit(){
		$this->checkUser();
		$dados['user'] = $this->user;
		$dados['user']['id_group'] = $this->id_group;
		$dados['groups'] = $this->groups->getAllGroups();
		$numberComplete = substr($dados['user']['n_phone'], 2);
		$numberDDD =  substr($numberComplete, 0, 2);
		if(strlen(substr($numberComplete, 2)) == 8){
			$dados['user']['n_phone'] = "(".$numberDDD.") 9".substr($numberComplete, 2, 4)."-".substr($numberComplete, 6, 4);
		}else{
			$dados['user']['n_phone'] = "(".$numberDDD.") ".substr($numberComplete, 2, 5)."-".substr($numberComplete, 7);
		}
		$this->loadTemplete('editUser', $dados);
	}

	public function updateUser(){
		$this->checkUser();
		$name = addslashes($_POST['name']);
		$nickname = addslashes($_POST['nickname']);
		$email = $this->user['email'];
		$n_phone = addslashes($_POST['n_phone']);
		$n_phone =  "55".str_replace(array('(', ')', '-', ' '), "", $n_phone);
		
		$dados['erroNicknameExist'] = $this->users->checkNicknameExist($nickname);

		if(!$dados['erroNicknameExist']){
			if($this->users->editUser($this->id_user, $name, $nickname, $n_phone, $email)){
				header('Location: '.BASE_URL);
				exit;
			}	
		}
		
		header('Location: '.BASE_URL.'user/edit');
		exit;
	}
	public function updatePassword(){
		if(!$this->checkUserAdapter()){
			echo "false";
			exit;
		}
		if(!isset($_POST['newPassword']) || !isset($_POST['afterPassword']) || $this->id_user == 0){
			echo "false";
			exit;
		}
		
		$id_user = $this->id_user;
		$afterPassword = addslashes($_POST['afterPassword']);
		$newPassword = addslashes($_POST['newPassword']);
		if($this->users->checkPassword($id_user, md5($afterPassword))){
			if($this->users->changePassword($id_user, md5($newPassword))){
				echo "true";
			}else{
				echo "false";
			}
		}else{
			echo "false";
		}
	}
	public function data($id_user){
		$this->checkUser();
		if($id_user == $this->id_user){
			$this->profile();
		}
		$dados['user_online'] = $this->user;
		$dados['user_online']['priority'] = $this->userPriority;
		$dados['user'] = $this->users->getUser($id_user);
		$dados['member'] = $this->members->getMember($id_user);
		if(count($dados['member']) > 0){
			$dados['group'] = $this->groups->getGroup($dados['member']['id_group']);
			$dados['prints'] = $this->prints->getHistoryPrints($id_user);
			if(count($dados['prints']) > 0){
				for ($i=0; $i < count($dados['prints']); $i++) { 
					$dados['prints'][$i]['monsters'] = $this->prints->getMonsters($dados['prints'][$i]['id_print']);
				}
			}
		}else{
			$data['group'] = array();
			$data['prints'] = array();
		}
		$date_register = DateTime::createFromFormat("Y-m-d H:i:s", $dados['user']['date_register']);
		$dados['user']['date_register'] = array('time' => $date_register->format("H:i:s"), 'day' => $date_register->format("d/m/Y"));
		$this->loadTemplete('dataUser', $dados);
	}
	public function profile(){
		echo "Este é o seu perfil";
	}

	public function changePassword(){
		$this->checkUser();
		$dados['id_user'] = $this->id_user;
		$this->loadTemplete('changePassword', $dados);
	}

	public function confirmPassword(){
		if(!$this->checkUserAdapter()){
			echo 0;
			exit;
		}
		if(!isset($_POST['password']) || $this->id_user == 0){
			echo 0;
			exit;
		}
		
		$id_user = $this->id_user;
		$password = addslashes($_POST['password']);
		if($this->users->checkPassword($id_user, md5($password))){
			echo 1;
		}else{
			echo 0;
		}
	}
}