<?php
class memberController extends controller{

	public function join($id_group){
		$this->checkUser();
		if(!isset($id_group) || empty($id_group)){
			header('Location: '.BASE_URL);
			exit;
		}
		if($this->id_group == 0){
			$this->id_group = $id_group;
			$this->members->setMember($this->id_group, $this->id_user, 0);
		}
		header('Location: '.BASE_URL);
		exit;
	}

	public function request($id_group){
		$this->checkUser();
		if(!isset($id_group) || empty($id_group)){
			header('Location: '.BASE_URL);
			exit;
		}
		if($this->id_group == 0){
			$this->requests->setRequest($id_group, $this->id_user);
		}
		header('Location: '.BASE_URL);
		exit;
	}

	public function Group(){
		$this->checkUser();
		$dados['members'] = $this->members->getAllMembersGroup($this->id_group);
		$dados['userOnline'] = $this->id_user;
		$this->loadTemplete('membersGroup', $dados);
	}
	public function membersAndRequests(){
		$this->checkUser();
		if($this->userPriority > 0){
			$dados['userOnline'] = $this->id_user;
			$dados['members'] = $this->members->getAllMembersGroup($this->id_group);
			$dados['requests'] = $this->requests->getAllRequestsInAnalysis($this->id_group);
			$this->loadTemplete('membersAndRequests', $dados);	
		}else{
			header('Location: '.BASE_URL);
		}
	}

	public function acceptRequest($id_user){
		$this->checkUser();
		if($this->userPriority > 0){
			$request = $this->requests->getRequestGroup($id_user, $this->id_group);
			if(count($request) > 0 && $request['status'] == 2){
				if($this->requests->updateStatusRequest($request['id'], 1)){
					if($this->members->setMember($this->id_group, $id_user, 0)){
						header('Location: '.BASE_URL.'member/membersAndRequests');
						exit;
					}
				}
			}
		}
		header('Location: '.BASE_URL);
		exit;
	}

	public function rejectRequest($id_user){
		$this->checkUser();
		if($this->userPriority > 0){
			$request = $this->requests->getRequestGroup($id_user, $this->id_group);
			if(count($request) > 0 && $request['status'] == 2){
				if($this->members->updateStatusRequest($request['id'], 0)){
					header('Location: '.BASE_URL.'member/membersAndRequests');
					exit;
				}
			}
		}
		header('Location: '.BASE_URL);
		exit;
	}

	public function kickout($id_user){
		$this->checkUser();
		if($this->userPriority > 0){
			$member = $this->members->getMemberGroup($id_user, $this->id_group);
			$request = $this->requests->getRequestGroup($id_user, $this->id_group);
			if(count($member) > 0){
				if($this->members->deleteMember($member['id'])){
					$this->members->updateDownNumberMembers($this->id_group);
					if(count($request) > 0 && $request['status'] == 1){
						if($this->requests->deleteRequest($request['id'])){
							header('Location: '.BASE_URL.'member/membersAndRequests');
							exit;
						}
					}
					header('Location: '.BASE_URL.'member/membersAndRequests');
					exit;
				}
			}
		}
		// header('Location: '.BASE_URL);
		// exit;
	}
	public function promote($id_user){
		$this->checkUser();
		if($this->userPriority > 0){
			$member = $this->members->getMemberGroup($id_user, $this->id_group);
			if(count($member) > 0 && $member['priority'] == 0){
				if($this->members->editPriority($this->id_group, $id_user, 1)){
					header('Location: '.BASE_URL.'user/data/'.$id_user);
					exit;
				}
			}
		}
		// header('Location: '.BASE_URL);
		// exit;
	}

	public function demote($id_user){
		$this->checkUser();
		if($this->userPriority > 0){
			$member = $this->members->getMemberGroup($id_user, $this->id_group);
			if(count($member) > 0 && $member['priority'] == 1){
				if($this->members->editPriority($this->id_group, $id_user, 0)){
					header('Location: '.BASE_URL.'user/data/'.$id_user);
					exit;
				}
			}
		}
		// header('Location: '.BASE_URL);
		// exit;
	}

	public function formAdd(){
		$this->checkUser();
		if(!isset($this->userPriority) || empty($this->userPriority)){
			header('Location: '.BASE_URL);
			exit;
		}

		$this->loadTemplete('addMember');
	}
	public function add(){
		$this->checkUser();
		if(!isset($this->id_group) || empty($this->id_group)){
			header('Location: '.BASE_URL);
			exit;
		}
		if(count($_POST) == 0){
			header('Location: '.BASE_URL);
			exit;
		}
		$nickname = addslashes($_POST['nickname']);
		if($this->userPriority > 0){
			$dados['erroNicknameExist'] = $this->users->checkNicknameExist($nickname);
			if(!$dados['erroNicknameExist']){
				if($this->users->addTemporaryUser($nickname, md5($nickname))){
					$id_user = $this->users->getLastUserCreated();
					if($this->members->setMember($this->id_group, $id_user, 0)){
						header('Location: '.BASE_URL.'member/membersAndRequests');
						exit;
					}
				}
			}else{
				$user = $this->users->getUserNickname($nickname);
				$id_user = $user['id'];
				$member = $this->members->getMember($id_user);
				if(count($member) == 0){
					if($this->members->setMember($this->id_group, $id_user, 0)){
						header('Location: '.BASE_URL.'member/membersAndRequests');
						exit;
					}
				}else{
					echo "Este usuario já tem grupo";
				}
			}
		}
		// header('Location: '.BASE_URL);
		// exit;
	}
}