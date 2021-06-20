<div class="container">
<?php
if(count($groups) > 0):
?>	
	<table class="table">
		<tr>
			<th>Nome</th>
			<th>TAG</th>
			<th>Privacidade</th>
			<th>Participar</th>
		</tr>
<?php
	foreach ($groups as $value):
		?>
		<tr>
			<td><?=$value['name']?></td>
			<td><?=$value['tag']?></td>
			<td><?php echo ($value['privacy'] == 0)? 'Privado' :'Público' ;?></td>
			<td><?php echo ($value['privacy'] == 1)? 
				'<a href="'.BASE_URL.'member/join/'.$value['id'].'">Entrar</a>' : 
				'<a href="'.BASE_URL.'member/request/'.$value['id'].'">Solicitar</a>' ;?>	
			</td>
		</tr>
		<?php
	endforeach;
?>
	</table>
<?php
else:
	?>
	<h2>Não há grupos cadastrados!!</h2>
	<p>Entre em contato com o Adminstrador do site para contratar um pacote</p>
	<?php
endif;
?>
</div>