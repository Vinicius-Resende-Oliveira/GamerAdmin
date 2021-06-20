<div class="container">
	<div class="col-sm-10 mx-auto">
		<div class="card card-lg">
			<div class="card-header bg-secondary text-white">
				<h5>Dados do usuário</h5>
			</div>
			<div class="card-body">
				<p><strong>Nickname: </strong> <?=$user['nickname']?></p>
				<p><strong>Nome: </strong> <?=$user['nome']?></p>
				<p><strong>Cadastrado desde: </strong><?=$user['date_register']['day']?> às <?=$user['date_register']['time']?></p>
				<p><strong>Grupo vinculado: </strong><?=$group['name']?></p>
				<p><strong>Contato: </strong><?=($user['n_phone'] != "0")? 
							'<a class="btn btn-light text-success" href="https://api.whatsapp.com/send?phone='.$user['n_phone'].'">WhatsApp</a>' : 
							'Não há número cadastrado' ;
						?></p>
			</div>
		<?php 
		if($user_online['priority'] > 0 && $member['priority'] != 2){
		?>
			<div class="card-footer">
				<div class="row">
					<div class="col-sm-6" style="display:flex;">
						<a href="<?=BASE_URL?>member/kickout/<?=$user['id']?>" class="btn btn-danger mx-auto">Expulsar</a>
					</div>
				<?php 
				if($member['priority'] == 0){
				?>
					<div class="col-sm-6" style="display:flex;">
						<a href="<?=BASE_URL?>member/promote/<?=$user['id']?>" class="btn btn-primary mx-auto">Promover</a>
					</div>
				<?php
				}else if($member['priority'] == 1){
				?>
					<div class="col-sm-6" style="display:flex;">
						<a href="<?=BASE_URL?>member/demote/<?=$user['id']?>" class="btn btn-warning mx-auto">Rebaixar</a>
					</div>
				<?php
				}
				?>
					<!-- <div class="col-sm-4" style="display:flex;">
						<a href="" class="btn btn-warning text-white mx-auto">Convidar</a>
					</div> -->
				</div>
			</div>
		<?php
		}
		?>
		</div>
	</div>
	<div class="col-sm-10 mx-auto mt-3">
<?php
if(count($prints) > 0):
?>
		<div class="card-header bg-secondary text-white mb-0">
			<h5>Seu historico de prints</h5>
		</div>

	<?php
	foreach($prints as $print):
		$date_send = DateTime::createFromFormat("Y-m-d H:i:s", $print['date_send']);
	?>
		<div class="row mb-3 mt-0">
			<div class="col-sm-12 mx-auto">
				<div class="card">
					<div class="card-header">
						<h5>Enviado em <?=$date_send->format('d/m/Y')?> às <?=$date_send->format('H:i')?></a></h5>
					</div>
					<div class="card-body">
						<div class="row">
							
							<div class="col-md-8">
								<a href="<?=BASE_URL?>print/open/<?=$print['id_print']?>">
									<img src="<?=BASE_URL?>images/prints/<?=$print['url_image']?>" width="100%" class="rounded img-thumbnail">
								</a>
							</div>
							<div class="col-md-4">
								<h4>Status: 
									<?php 
									if($print['status'] == 0){
										echo '<font class="text-warning">Em análise</font>';
									}else if($print['status'] == 1){
										echo '<font class="text-success">Aprovado</font>';
									}else{
										echo '<font class="text-danger">Rejeitado</font>';
									}
									?>
								</h4>

								<?php 
								if($print['status'] == 0){
									?>
									<a href="<?=BASE_URL?>print/accept/<?=$print['id_print']?>" class="btn btn-success">Aprovar</a>
									<a href="<?=BASE_URL?>print/reject/<?=$print['id_print']?>" class="btn btn-danger">Rejeitar</a>
									<?php
								}
								?>

							</div>
						</div>
					</div>
					<?php
					if(count($print['monsters']) > 0){
					?>
					<div class="card-footer">
						<?php
						foreach ($print['monsters'] as $monster) {
							$date_monster = DateTime::createFromFormat("Y-m-d H:i:s", $monster['date_monster']);
							if($monster['status'] == 0){
								echo '<div class="alert p-1 alert-warning">';
								echo "Nv ".$monster['level']." ".$monster['name']." em ".$date_monster->format("d/m/Y H:i:s")." - R:".$monster['r_position']." X:".$monster['x_position']." Y:".$monster['y_position'];
								echo "</div>";
							}else if($monster['status'] == 1){
								echo '<div class="alert p-1 alert-success">';
								echo "Nv ".$monster['level']." ".$monster['name']." em ".$date_monster->format("d/m/Y H:i:s")." - R:".$monster['r_position']." X:".$monster['x_position']." Y:".$monster['y_position']." - ";
								echo (!empty($monster['note']))? $monster['note']: 'Valido';
								echo "</div>";
							}else{
								$statusPrint = false;
								echo '<div class="alert p-1 alert-dark">';
								echo "<s>Nv ".$monster['level']." ".$monster['name']." em ".$date_monster->format("d/m/Y H:i:s")." - R:".$monster['r_position']." X:".$monster['x_position']." Y:".$monster['y_position']."</s> - Inválido";
								echo "</div>";
							}
						}
						?>
					</div>
					<?php
				}
					?>
				</div>
			</div>
		</div>
	<?php
	endforeach;
	?>

<?php
endif;
?>
	</div>
</div>