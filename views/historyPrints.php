<div class="container">
	<div class="row">
<?php
if(count($history) > 0):
	$counter = 1;
	foreach ($history as $print):
		$date_send = DateTime::createFromFormat("Y-m-d H:i:s", $print['date_send']);
?>
		<div class="col-sm-6">
			<div class="card">
				<div class="card-header">
					Date de envio: <?=$date_send->format('d/m/Y')?> às <?=$date_send->format('H:i')?>
				</div>
				<div class="card-body" style="max-height: 275px;">
					<?php if(count($print['monsters']) > 0 && empty($print['url_image'])){
						foreach ($print['monsters'] as $monster) {
							$date_monster = DateTime::createFromFormat("Y-m-d H:i:s", $monster['date_monster']);
							if($monster['status'] == 0){
								echo '<div class="alert p-1 alert-warning alert-sm">';
								echo "Nv ".$monster['level']." ".$monster['name']." em ".$date_monster->format("d/m/Y H:i:s")." - R:".$monster['r_position']." X:".$monster['x_position']." Y:".$monster['y_position'];
								echo "</div>";
							}else if($monster['status'] == 1){
								echo '<div class="alert p-1 alert-success alert-sm">';
								echo "Nv ".$monster['level']." ".$monster['name']." em ".$date_monster->format("d/m/Y H:i:s")." - R:".$monster['r_position']." X:".$monster['x_position']." Y:".$monster['y_position']." - Valido";
								echo "</div>";
							}else{
								$statusPrint = false;
								echo '<div class="alert p-1 alert-dark alert-sm">';
								echo "<s>Nv ".$monster['level']." ".$monster['name']." em ".$date_monster->format("d/m/Y H:i:s")." - R:".$monster['r_position']." X:".$monster['x_position']." Y:".$monster['y_position']."</s> - Inválido";
								echo "</div>";
							}
						}
					}
					?>
					<a href="<?=BASE_URL?>print/open/<?=$print['id_print']?>" style="display:block;">
						<img src="<?=BASE_URL?>images/prints/<?=$print['url_image']?>" width="100%" style="max-height: 230px;">
					</a>
				</div>
				<div class="card-footer">
					<h6>
					Status: 
						<?php 
						if($print['status'] == 0){
							echo "Em análise";
						}else if ($print['status'] == 1){
							echo "Aceito";
						}else if($print['status'] == 2){
							echo "Rejeitado";
						}
						?>
					</h6>
				</div>
			</div>
		</div>
		<?php
		if($counter == 2){
		?>	
	</div>
	<div class="row mt-3">
		<?php
		$counter = 1;
		}else{
			$counter++;
		}
	endforeach;
else:
?>
	<h2>Você ainda não enviou prints ter um histórico!</h2>
	<a class="btn btn-primary" href="<?=BASE_URL?>print/send">Enviar Prints</a>

<?php
endif;
?>
</div>