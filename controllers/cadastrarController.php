<?php
class cadastrarController extends controller {

	// public function salvarMember(){
	// 	$dados = array();
	// 	$dados['erro_image'] = true;
	// 	$members = new Members();
	// 	$images = new Images();
	// 	$groups = new Groups();

	// 	$id_group = (int) $_POST['sel_group'];
	// 	$name = addslashes($_POST['name']);
	// 	$nickname = addslashes($_POST['nickname']);
	// 	$email = addslashes($_POST['email']);
	// 	$n_phone = addslashes($_POST['n_phone']);

		
	// 	if(isset($_FILES['file_image'])){
	// 		$file = $_FILES['file_image'];
	// 		$nameFile = $this->uploadImage($file, $nickname);

	// 		if($nameFile != ""){
	// 			$players->setPlayer($name, $nickname, $id_group);
	// 			$images->setImage($players->getLastPlayer(), $nameFile);
	// 			$groups->addNumberMember($id_group);
	// 			$dados['erro_image'] = false;
	// 		}
	// 	}

	// 	$this->loadTemplete('salvar', $dados);
	// }

	private function uploadImage($image, $name){
		$typesFile = array('.jpg', '.jpeg','.pjp', '.pjpeg', '.jfif');

		$nameImage = md5($name . date("dmYHis"));
		$imageFileType = strrchr($image["name"],".");
		
		$nameImage = $nameImage.$imageFileType;

		$target_dir = "images/players/";
		$uploadFile = $target_dir.$nameImage;
		if(in_array($imageFileType, $typesFile)){
			if(move_uploaded_file($image['tmp_name'], $uploadFile)){
				return $nameImage;
			}
		}
		return "";
	}
}