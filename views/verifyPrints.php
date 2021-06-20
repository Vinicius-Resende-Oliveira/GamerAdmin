<div class="container">
<?php
if(count($prints) > 0):
	$counter = 1;
	foreach ($prints as $print):
?>
	<div class="row my-3">
		<div class="col-sm-10 mx-auto">
			<div class="card">
				<div class="card-header">
					<h5>Enviado em <?=$print['date_send']?> por <a href="<?=BASE_URL?>user/open/<?=$print['user']['id_user']?>"><?=$print['user']['nickname']?></a></h5>
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
							echo "Nv ".$monster['level']." ".$monster['name']." em ".$date_monster->format("d/m/Y H:i:s")." - R:".$monster['r_position']." X:".$monster['x_position']." Y:".$monster['y_position']." - Valido";
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
else:
?>
	<h2>Não foi enviados prints para serem conferidos!</h2>

<?php
endif;
?>
</div>