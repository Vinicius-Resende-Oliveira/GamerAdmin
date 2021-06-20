<div class="container">
	<div class="row pb-3">
		<div class="col-sm-4"><a class="btn btn-primary btn-md" style="width: 100%" href="<?=BASE_URL?>print/send">Enviar Prints</a></div>
		<div class="col-sm-4"><a class="btn btn-primary" style="width: 100%" href="<?=BASE_URL?>print/history">Historico de Prints</a></div>
		<div class="col-sm-4"><a class="btn btn-primary btn-md" style="width: 100%" href="<?=BASE_URL?>user/edit">Editar Usuário</a></div>
		
	</div>
	<div class="row pb-3">
		<?php
		if($user['userPriority'] > 0):
			if($group['privacy'] == 0){
				?>
				<div class="col-sm-4"><a class="btn btn-primary btn-md" style="width: 100%" href="<?=BASE_URL?>member/membersAndRequests">Membros e Solicitações</a></div>
				<?php
			}else{
				?>
				<div class="col-sm-4"><a class="btn btn-primary" style="width: 100%" href="<?=BASE_URL?>member/Group">Membros do grupo</a></div>
				<?php
			}
			if($user['userPriority'] == 2){
				?>
				<div class="col-sm-4"><a class="btn btn-primary btn-md" style="width: 100%" href="<?=BASE_URL?>group/edit">Editar Grupo</a></div>
				<?php
			}
		?>
		<div class="col-sm-4"><a class="btn btn-primary btn-md" style="width: 100%" href="<?=BASE_URL?>print/verify">Análisar Prints</a></div>
		<?php
		endif;
		?>
	</div>
</div>