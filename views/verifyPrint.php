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
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMonster">Adicionar monstros</button>
		<?php
		if($print['status'] == 0 && !isset($statusPrint)):
		?>
			<a class="btn btn-success" href="<?=BASE_URL?>print/accept/<?=$print['id_print']?>">Aprovar</a>
			<a class="btn btn-danger" href="<?=BASE_URL?>print/reject/<?=$print['id_print']?>">Rejeitar</a>

		<?php
		endif;
		if(isset($statusPrint) && !$statusPrint && $print['status'] == 0):
		?>
			<a class="btn btn-danger" href="<?=BASE_URL?>print/rejectPrint/<?=$print['id_print']?>">Rejeitar</a>		
		<?php
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



<!-- The Modal -->
<div class="modal" id="addMonster">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
	<div class="modal-header">
		<h4 class="modal-title">Adicinar Monstros</h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
	</div>

      	<!-- Modal body -->
		<form method="POST" action="<?=BASE_URL?>print/addMonster/<?=$print['id_print']?>">
      		<div class="modal-body">
    			<div class="row">
    				<div class="col-sm-3">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Localização:</span>
							</div>
							<input type="text" class="form-control" placeholder="R" name="r_position">
							<input type="text" class="form-control" placeholder="X" name="x_position">
							<input type="text" class="form-control" placeholder="Y" name="y_position">
						</div>
    				</div>
    				<div class="col-sm-3">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Nome:</span>
							</div>
							<input type="text" class="form-control" placeholder="Nome do Monstro" name="name">
						</div>
    				</div>
    				<div class="col-sm-3">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Nível:</span>
							</div>
							<input type="text" class="form-control" placeholder="Nível do monstro" name="level">
						</div>
    				</div>
    				<div class="col-sm-3">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Data:</span>
							</div>
							<input type="text" class="form-control" placeholder="DD-MM-AA HH:MM:SS" name="date_monster">
						</div>
    				</div>
    			</div>
    	  	</div>

      		<!-- Modal footer -->
		    <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
		        <input type="submit" class="btn btn-success" value="Enviar"/>
		    </div>
		</form>

    </div>
  </div>
</div>