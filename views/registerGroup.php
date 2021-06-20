<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/style.css">
	<style>
	</style>
</head>
<body class="bg-light">
	<div class="container">
		<h3 class="text-center">Crie o grupo!!</h3>
	<?php
	if(isset($erroNameExist) && $erroNameExist){
		?>
		<div class="col-sm-12">
			<div class="alert alert-warning">
				Este nome já esta sendo utilizado. Por favor tente outro.
			</div>
		</div>
		<?php
	}
	if(isset($erroUserHasGroup) && $erroUserHasGroup){
		?>
		<div class="col-sm-12">
			<div class="alert alert-warning">
				Este nickname já esta cadastrado em um grupo. Peça para ele sair do seu grupo primeiro antes de criar um novo.
			</div>
		</div>
		<?php
	}
	?>
		<form method="POST" action="<?=BASE_URL?>group/save" enctype="multipart/form-data">
			<div class="form-group">
				<label for="name">Nome do grupo:</label>
				<input type="text" class="form-control" placeholder="Digite o nome" id="name" name="name">
			</div>
			<div class="form-group">
				<label for="tag">TAG:</label>
				<input type="text" class="form-control" placeholder="Digite a TAG do grupo." id="tag" name="tag" required="required" maxlength="3">
			</div>
			<div class="form-group">
				<label for="tag">Nickname:</label>
				<input type="text" class="form-control" placeholder="Digite o nickname do usuário." id="nickname" name="nickname" required="required">
			</div>
			<div class="form-group">
				<label>Privacidade do grupo:</label><br/>
				<div class="custom-control custom-radio custom-control-inline">
				    <input type="radio" class="custom-control-input" id="privacy1" name="privacy" value="0" checked>
				    <label class="custom-control-label" for="privacy1">Privado</label>
			  	</div>
			  	<div class="custom-control custom-radio custom-control-inline">
				    <input type="radio"  class="custom-control-input" id="privacy2" name="privacy" value="1">
				    <label class="custom-control-label" for="privacy2">Público</label>
				</div>
			</div>
			<div class="form-group">
				<label>Prazo de dias:</label><br/>
				<div class="custom-control custom-radio custom-control-inline">
				    <input type="radio" class="custom-control-input" id="days1" name="days" value="7" checked>
				    <label class="custom-control-label" for="days1">7</label>
			  	</div>
			  	<div class="custom-control custom-radio custom-control-inline">
				    <input type="radio"  class="custom-control-input" id="days2" name="days" value="30">
				    <label class="custom-control-label" for="days2">30</label>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Cadastrar</button>
		</form>
	</div>
	<script src="<?=BASE_URL?>assets/js/jquery.min.js"></script>
	<script src="<?=BASE_URL?>assets/js/bootstrap.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/script.js"></script>
</body>
</html>