<div class="container">
<div class="row text-white">
	<div class="col-sm-12">
		<div class="card bg-primary">
			<div class="card-header">
				Adicionar novo membro.
			</div>
			<form method="POST" class="form-inline pl-3" action="<?=BASE_URL?>member/add">
				<div card="card-body">
						<!-- <label for="nickname">Nickname:</label> -->
						<input type="text" class="form-control" placeholder="Digite o nickname" id="nickname" name="nickname">
						<input type="submit" class="btn btn-light" value="Adicionar">
				</div>
			</form>
			<div class="card-footer">
				<small class="float-right">Caso o usuário não esteja cadastrado iremos criar para você.</small>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-8">
		<h3 class="text-center">Membros</h3>
		<?php
		if(count($members) > 0):
		?>
			<table class="table table-striped table-bordered shadow-sm">
			<thead>
				<tr>
					<th>Nickname:</th>
					<th>Cargo:</th>
					<th>Contato:</th>
					<th>Ação:</th>
				</tr>
			</thead>
			<tbody>
		<?php
			foreach ($members as $value):
				if($value['id_user'] != $userOnline){
		?>
					<tr>
						<td><?=$value['nickname']?></a>
						</td>
						<td>
						<?php if($value['priority'] == 0){
							echo "Sem cargo";
						}else if($value['priority'] == 1){
							echo "Administrador";
						}else{
							echo "Líder";
						}
						?>
						</td>
						<td>
						<?php echo ($value['n_phone'] != "0")? 
							'<a class="btn btn-success" href="https://api.whatsapp.com/send?phone='.$value['n_phone'].'">WhatsApp</a>' : 
							'Não há número cadastrado' ;
						?>
						</td>
						<td>
							<a class="btn btn-primary" href="<?=BASE_URL?>user/data/<?=$value['id_user']?>">Visualizar</a>
							<a class="btn btn-danger" href="<?=BASE_URL?>member/kickout/<?=$value['id_user']?>">Retirar do Grupo</a>
						</td>			
					</tr>
		<?php
				} else{
				?>
		<h5 class="text-center">Não há mais membros no seu grupo!</h5>
				<?php
				}
			endforeach;
		echo "</tbody></table>";
		endif;
		?>
	</div>
	<div class="col-sm-4">
		<h3 class="text-center">Solicitações não vistas</h3>
		<?php
		if(count($requests) > 0):
		?>
			<table class="table table-striped table-bordered shadow-sm">
			<thead>
				<tr>
					<th>Nickname:</th>
					<th>Ação:</th>
				</tr>
			</thead>
			<tbody>
		<?php
			foreach ($requests as $value):
		?>
				<tr>
					<td><?=$value['name']?></a></td>
					<td>
						<a class="btn btn-success btn-sm" href="<?=BASE_URL?>member/acceptRequest/<?=$value['id_user']?>">Aceitar</a>
						<a class="btn btn-danger btn-sm" href="<?=BASE_URL?>member/rejectRequest/<?=$value['id_user']?>">Rejeitar</a>
					</td>			
				</tr>
			</tbody>
			</table>
			<?php
			endforeach;
		else:
		?>
		<h5 class="text-center">Não há solicitações no seu grupo!</h5>
		<?php	
		endif;
		?>
	</div>
</div>

</div>