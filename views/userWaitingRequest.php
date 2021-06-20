<div class="container">
	
A sua solicitação já foi enviada.
<p>Entre em contatos com um administrador para a sua aprovação ser mais rápida.</p>
<p><h4 class="text-center"><b>Administradores</b></h4></p>
<?php
if(count($group) > 0):
?>	
	<table class="table">
		<tr>
			<th>Nome</th>
			<th>Rank</th>
			<th>Contato</th>
		</tr>
<?php
	foreach ($administrators as $value):
		?>
		<tr>
			<td><?=$value['nickname']?></td>
			<td><?php echo ($value['priority'] == 1)? 'Administrador' :'Líder' ;?></td>
			<td><?php echo ($value['n_phone'] != "0")? 
				'<a class="btn btn-success" href="https://api.whatsapp.com/send?phone='.$value['n_phone'].'">WhatsApp</a>' : 
				'Não há número cadastrado' ;?>	
			</td>
		</tr>
		<?php
	endforeach;
?>
	</table>
<?php
endif;
?>
</div>