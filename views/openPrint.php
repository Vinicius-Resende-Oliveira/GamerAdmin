<div class="container">
	<div class="row">
		<div class="col-md-8">
			<img src="<?=BASE_URL?>images/prints/<?=$print['url_image']?>" width="100%"/>
		</div>
		<div class="col-md-4">
			<?php
			if(count($monsters) > 0):
				foreach($monsters as $monster):
					$date_monster = DateTime::createFromFormat("Y-m-d H:i:s", $monster['date_monster']);
						if($monster['status'] == 0){
							echo '<div class="alert alert-warning">';
							echo "Nv ".$monster['level']." ".$monster['name']." em ".$date_monster->format("d/m/Y H:i:s")." - R:".$monster['r_position']." X:".$monster['x_position']." Y:".$monster['y_position'];
							echo "</div>";
						}else if($monster['status'] == 1){
							echo '<div class="alert alert-success">';
							echo "Nv ".$monster['level']." ".$monster['name']." em ".$date_monster->format("d/m/Y H:i:s")." - R:".$monster['r_position']." X:".$monster['x_position']." Y:".$monster['y_position'];
							echo "</div>";
						}else{
							$statusPrint = false;
							echo '<div class="alert alert-dark">';
							echo "Nv ".$monster['level']." ".$monster['name']." em ".$date_monster->format("d/m/Y H:i:s")." - R:".$monster['r_position']." X:".$monster['x_position']." Y:".$monster['y_position']." -> ".$monster['note'];
							echo "</div>";
						}
				endforeach;
			endif;
			?>
			<div class="form-control my-2">
				<label for="date_send">Date de envio:</label>
				<input type="text" id="date_send" name="date_send" value="<?=$print['date_send']?>" disabled>
			</div>
			<div class="form-control my-2">
				Usuário: <a href="<?=BASE_URL?>user/open/<?=$user['id_user']?>"><?=$user['nickname']?></a>
			</div>
			<div class="form-control my-2">
				<label for="date_send">Status:</label>
				<?php
				if($print['status'] == 0){
					echo '<font class="text-warning "><strong>Em análise</strong></font>';
				}else if($print['status'] == 1){
					echo '<font class="text-success"><strong>Aprovado</strong></font>';
				}else{
					echo '<font class="text-danger"><strong>Rejeitado</strong></font>';
				}
				?>
			</div>

		</div>
	</div>
</div>
