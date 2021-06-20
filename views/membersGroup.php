<div class="container">
<?php
if(count($members) > 0):
?>
	<table class="table">
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
					<a class="btn btn-primary mx-auto" href="<?=BASE_URL?>user/data/<?=$value['id_user']?>">Visualizar</a>
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