<?php
class administratorController extends controller {

	public function __construct(){
		$this->administrators = new Administrators();
		parent::__construct();
	}
	public function index(){
		$dados['administrator'] = $this->verifyAdministrator();
		$this->loadTemplete("homeAdminstrator", $dados);
 	}

	public function login(){
		$this->loadView("login-adminstrator");
		exit;
	}

	public function connecting(){

		$dados = array();
		$nickname = addslashes($_POST['nickname']);
		$password = md5(addslashes($_POST['password']));

		$id_administrator = $this->administrators->login($nickname, $password);
		if($id_administrator > 0){
			$_SESSION['id_administrator'] = $id_administrator;
			header('Location: '.BASE_URL.'administrator/index');
		}else{
			$dados['userNotFound'] = true;
			$this->loadView('login-adminstrator', $dados);
		}
	}
	public function logout(){
		session_destroy();
		header("Location: ".BASE_URL."administrator/login");
		exit;
	}

	public function listGroup(){
		$dados['administrator'] = $this->verifyAdministrator();
		$timestamp_dateToday = strtotime(date('Y-m-d'));
		$dados['groups'] = $this->groups->getAllForDue();
		$dados['groups']['number'] = count($dados['groups']);

		foreach ($dados['groups'] as $key => $value) {
			if($key != "number"){
				$dateDue = DateTime::createFromFormat("Y-m-d H:i:s", $value['date_due']);
				$timestamp_dateDue = strtotime($dateDue->format("Y-m-d"));
				$dados['groups'][$key]['days_due'] = ($timestamp_dateDue - $timestamp_dateToday) /86400;
			}
			
		}

		$this->loadView("listGroup", $dados);
	}

	public function data(){
		$dados['administrator'] = $this->verifyAdministrator();

		$dados['groups'] = $this->groups->getAllGroups();
		$dados['groups']['number'] = count($dados['groups']);
		$dados['users'] = $this->users->countAllUsers();

		$this->loadView('data-administrator', $dados);
	}
	
	public function loadTemplete($viewName, $viewData = array()){
        require 'views/templeteAdminstrator.php';
    }

	public function group($id_group, $id_user){
		$dados['administrator'] = $this->verifyAdministrator();
		$dados['link'] = "administrator-group-".$id_group."-".$id_user;
		$dados['group'] = $this->groups->getGroup($id_group);
		$dados['member'] = $this->members->getMemberGroup($id_user, $id_group);
		$dados['members'] = $this->members->getAllMembersGroup($id_group);
		if($dados['member']['priority'] == 2){
			$dados['leader'] = $this->users->getUser($id_user);
			$date_create = DateTime::createFromFormat("Y-m-d H:i:s", $dados['group']['date_create']);
			$dados['group']['date_create']= array('time' => $date_create->format("H:i:s"), 'day' => $date_create->format("d/m/Y"));

			$dateDue = DateTime::createFromFormat("Y-m-d H:i:s", $dados['group']['date_due']);
			$dados['group']['days_due'] = (strtotime($dateDue->format("Y-m-d")) - strtotime(date('Y-m-d'))) /86400;
		}else{
			header('Location: '.BASE_URL.'notFound');
			exit;
		}

		$this->loadview('dataGroup-administrator', $dados);
	}

	public function dataUser($id_user){
		$dados['administrator'] = $this->verifyAdministrator();
		
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

	public function renew($id_group, $link){
		$dados['administrator'] = $this->verifyAdministrator();
		$link = explode('-', $link);
		$link = implode('/', $link);
		$group = $this->groups->getGroup($id_group);
		if(count($group) > 0){
			$dateDue = DateTime::createFromFormat("Y-m-d H:i:s", $group['date_due']);
			$timestamp_dateToday = strtotime(date('Y-m-d'));

			$days_due = (strtotime($dateDue->format("Y-m-d")) - $timestamp_dateToday) /86400;
			if($days_due >= 0){
				$dateDue->modify("+40 days");
			}else{
				$dateDue->setTimestamp(strtotime(date('Y-m-d')));
				$dateDue->modify("+40 days");
			}
			if($this->groups->renew($id_group, $dateDue->format('Y-m-d H:i:s'))){
				$group = $this->groups->getGroup($id_group);
				$dateDue = DateTime::createFromFormat("Y-m-d H:i:s", $group['date_due']);
				$days_due = (strtotime($dateDue->format("Y-m-d")) - $timestamp_dateToday) /86400;
				
				header('Location: '.BASE_URL.$link);
			}else{
				echo "Error";
			}

		}
	}

	public function renewAdapter($id_group){
		$dados['administrator'] = $this->verifyAdministrator();

		$group = $this->groups->getGroup($id_group);
		if(count($group) > 0){
			$dateDue = DateTime::createFromFormat("Y-m-d H:i:s", $group['date_due']);
			$timestamp_dateToday = strtotime(date('Y-m-d'));

			$days_due = (strtotime($dateDue->format("Y-m-d")) - $timestamp_dateToday) /86400;
			if($days_due >= 0){
				$dateDue->modify("+40 days");
			}else{
				$dateDue->setTimestamp(strtotime(date('Y-m-d')));
				$dateDue->modify("+40 days");
			}
			if($this->groups->renew($id_group, $dateDue->format('Y-m-d H:i:s'))){
				$group = $this->groups->getGroup($id_group);
				$dateDue = DateTime::createFromFormat("Y-m-d H:i:s", $group['date_due']);
				$days_due = (strtotime($dateDue->format("Y-m-d")) - $timestamp_dateToday) /86400;
				echo $days_due;
			}else{
				echo "Error";
			}

		}
	}
}