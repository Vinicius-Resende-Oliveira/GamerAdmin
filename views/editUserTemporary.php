<div class="container">
	<form method="POST" action="<?=BASE_URL?>user/editUserTemporary">
		<div class="form-group">
			<label for="name">Nome do Jogador:</label>
			<input type="text" class="form-control" placeholder="Digite seu nome" id="name" name="name" value="<?=$user['name']?>">
		</div>
		<div class="form-group">
			<label for="nickname">Nickname no jogo:</label>
			<input type="text" class="form-control" placeholder="Digite seu nickname usado no jogo." id="nickname" name="nickname" value="<?=$user['nickname']?>" required disabled>
		</div>
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" placeholder="Digite seu Email" id="email" name="email" value="<?=$user['email']?>" required >
		</div>
		<div class="form-group">
			<label for="n_phone">Número de contato:</label>
			<input type="text" class="form-control" placeholder="Digite seu número de WhatsApp" id="n_phone" name="n_phone" required >
		</div>
		<div class="form-group">
			<label for="sel_group">Seu grupo:</label>
			<select class="form-control" id="sel_group" name="sel_group" disabled>
				<option value="0">Não tenho.</option>
				<?php
				if(count($groups) > 0):
					foreach($groups as $group){
						if($group['id'] == $user['id_group']):
					?>
				<option value="<?= $group['id']; ?>" selected><?= $group['name']; ?></option>
					<?php
						else:
							if($group['privacy'] == 1){
					?>
				<option value="<?= $group['id']; ?>"><?= $group['name']; ?></option>
					<?php
							}
						endif;
					}
				endif;
				?>
			</select>
		</div>
		<button type="submit" class="btn btn-primary">Atualizar</button>
	</form>
</div>