<?php
class controller {
    
    public $id_user;
    public $id_group;
    public $userPriority;
    public $user;
    public $group;
    public $member;
    public $request;
    protected $users;
    protected $groups;
    protected $members;
    protected $requests;
    protected $prints;
    protected $administrators;
    protected $weeklygoals;

    public function __construct(){
        $this->users = new Users();
        $this->prints = new Prints();
        $this->groups = new Groups();
        $this->members = new Members();
        $this->requests = new Requests();
        $this->weeklygoals = new WeeklyGoals();
    }
    
    public function loadView($viewName, $viewData = array()) {
        extract($viewData);
        require 'views/'.$viewName.'.php';
    }

    public function loadTemplete($viewName, $viewData = array()){
        require 'views/templete.php';
    }
    
    public function loadViewInTemplete($viewName, $viewData = array()) {
        extract($viewData);
        require 'views/'.$viewName.'.php';
    }
    
    protected function defineCookie($name, $value, $expired = 24){
        setcookie($name, $value, time() + (3600 * $expired));
    }
    
    protected function unsetcookie($key, $path = '', $domain = '', $secure = false) {
        if (array_key_exists($key, $_COOKIE)) {
            if (false === setcookie($key, null, -(3600 * 25), $path, $domain, $secure)) {
                return false;
            }
            unset($_COOKIE[$key]);
        }

        return true;
    }

    protected function uploadImage($image, $name, $url){
        $typesFile = array('.jpg', '.jpeg','.pjp', '.pjpeg', '.jfif');

        $nameImage = md5($name . strtotime(date("Y-m-d H:i:s")));
        $imageFileType = strrchr($image["name"],".");
        
        $nameImage = $nameImage.$imageFileType;

        $target_dir = $url;
        $uploadFile = $target_dir.$nameImage;
        if(in_array($imageFileType, $typesFile)){
            if(move_uploaded_file($image['tmp_name'], $uploadFile)){
                return $nameImage;
            }
        }
        return "";
    }
    protected function uploadImages($images, $name, $url){
        $names = array();
        $typesFile = array('.jpg', '.jpeg','.pjp', '.pjpeg', '.jfif');
        $target_dir = $url;

        for($counter=0; $counter < count($images['name']); $counter++) {

            $nameImage = md5($name. $counter . date("dmYHis"));
            $imageFileType = strrchr($images["name"][$counter],".");
            $nameImage = $nameImage.$imageFileType;
            $uploadFile = $target_dir.$nameImage;

            if(in_array($imageFileType, $typesFile)){
                if(move_uploaded_file($images['tmp_name'][$counter], $uploadFile)){
                    $names[$counter] = $nameImage; 
                }
            }

        }
        return $names;
    }

    protected function checkUser(){
        if(!isset($_SESSION['id_user']) || $_SESSION['id_user'] == 0){
            header('Location: '.BASE_URL.'user/logout');
            exit;
        }
        $this->id_user = $_SESSION['id_user'];
        $this->user = $this->users->getUser($this->id_user);
        $this->member = $this->members->getMember($this->id_user);
        $this->request = $this->requests->getRequest($this->id_user);

        if(count($this->member) > 0){
            $this->id_group = $this->member['id_group'];
            $this->userPriority = $this->member['priority'];
            $this->group = $this->groups->getGroup($this->id_group);
            if($this->checkGroupDateDue()){
                header("Location: ".BASE_URL."group/expired/".$this->id_group);
                exit;
            }
        }else if(count($this->request) > 0){
            $this->id_group = $this->request['id_group'];
            $this->group = $this->groups->getGroup($this->id_group);
            $this->member['id'] = 0;
        }else{
            $this->member['id'] = 0;
            $this->id_group = 0;
            $this->group = $this->groups->getGroup($this->id_group);
        }
        return true;
    }
    
    protected function checkUserAdapter(){
        if(!isset($_SESSION['id_user']) || $_SESSION['id_user'] == 0){
            return false;
        }
        $this->id_user = $_SESSION['id_user'];
        $this->user = $this->users->getUser($this->id_user);
        $this->member = $this->members->getMember($this->id_user);
        $this->request = $this->requests->getRequest($this->id_user);

        if(count($this->member) > 0){
            $this->id_group = $this->member['id_group'];
            $this->userPriority = $this->member['priority'];
            $this->group = $this->groups->getGroup($this->id_group);
            if($this->checkGroupDateDue()){
                return false;
            }
        }else if(count($this->request) > 0){
            $this->id_group = $this->request['id_group'];
            $this->group = $this->groups->getGroup($this->id_group);
            $this->member['id'] = 0;
        }else{
            $this->member['id'] = 0;
            $this->id_group = 0;
            $this->group = $this->groups->getGroup($this->id_group);
        }
        return true;
    }

    protected function dateUser(){
        $dateUser = $this->users->getUser($this->id_user);
        $dateUser['userPriority'] = $this->userPriority;
        $dateUser['id_member'] = ($this->member['id'] =! 0)? $this->member['id'] : 0;
        return $dateUser;
    }

    protected function checkGroupDateDue(){
        $timestamp_dateToday = strtotime(date("Y-m-d"));
        $dateDue = DateTime::createFromFormat("Y-m-d H:i:s", $this->group['date_due']);
        $timestamp_dateDue = strtotime($dateDue->format("Y-m-d"));
        if($timestamp_dateDue > $timestamp_dateToday){
            return false;
        }else{
            return true;
            
        }
    }

    protected function verifyAdministrator(){
		if(!isset($_SESSION['id_administrator']) || $_SESSION['id_administrator'] == 0){
			header('Location: '.BASE_URL.'administrator/login');
			return array();
			exit;
		}
		$dados['administrator'] = $this->administrators->get($_SESSION['id_administrator']);
		if(count($dados['administrator']) == 0){
			header('Location: '.BASE_URL.'administrator/login');
			return array();
			exit;
		}
		return $dados;
	}
}