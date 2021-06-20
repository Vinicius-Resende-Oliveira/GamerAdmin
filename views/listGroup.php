<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<style>
	</style>
</head>
<body class="bg-light">
	<div class="container">
		<?php
		if($groups['number'] > 0):
		?>
		<div class="table-responsive-sm">
		
			<table class="table text-center table-hover">
			<thead>
				<tr class="border border-1">
					<th>Name</th>
					<!-- <th>TAG:</th> -->
					<th>Lider</th>
					<th>Prazo</th>
				</tr>
			</thead>
			<tbody>
		<?php
			foreach ($groups as $key => $value):
				if($key != "number"){
		?>
					<tr class="border border-1 shadow-sm">
						<td><a href="<?=BASE_URL?>administrator/group/<?=$value['id']?>/<?=$value['id_user']?>">[<?=$value['tag']?>]<?=$value['name']?></a></td>
						<!-- <td><?=$value['tag']?></td> -->
						<td><?=$value['nickname']?></td>
						<td>
						<?php
							if($value['days_due'] <= -2){
								?>
								<a class="btn btn-danger" style="display:block;">Vencido à <?=$value['days_due']*-1?> dias</a>
								<?php
							}else if($value['days_due'] == -1){
								?>
								<a class="btn btn-danger" style="display:block;">Venceu ontem</a>
								<?php
							}else if($value['days_due'] == 0){
								?>
								<a class="btn btn-danger" style="display:block;">Venceu hoje</a>
								<?php
							}else if($value['days_due'] < 17 && $value['days_due'] > 0){
								?>
								<a class="btn btn-warning" style="display:block;">Faltam: <?=$value['days_due']?> dias</a>
								<?php
							}else{
								?>
								<a class="btn btn-success" style="display:block;">Faltam: <?=$value['days_due']?> dias</a>
								<?php
							}
						?>
						</td>			
					</tr>
		<?php
			}
			endforeach;
			echo "</tbody></table></div>";
		endif;
	?>
	</div>
	<script src="<?=BASE_URL?>assets/js/jquery.min.js"></script>
	<script src="<?=BASE_URL?>assets/js/bootstrap.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/script.js"></script>
</body>
</html>