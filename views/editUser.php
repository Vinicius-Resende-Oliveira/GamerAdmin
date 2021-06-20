<div class="container">
	<form method="POST" action="<?=BASE_URL?>user/updateUser">
		<div class="form-group">
			<label for="name">Nome do Jogador:</label>
			<input type="text" class="form-control" placeholder="Digite seu nome" id="name" name="name" value="<?=$user['name']?>">
		</div>
		<div class="form-group">
			<label for="nickname">Nickname no jogo:</label>
			<input type="text" class="form-control" placeholder="Digite seu nickname usado no jogo." id="nickname" name="nickname" value="<?=$user['nickname']?>" required>
		</div>
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" placeholder="Digite seu Email" id="email" name="email" value="<?=$user['email']?>" required disabled>
		</div>
		<div class="form-group">
			<label for="n_phone">Número de contato:</label>
			<input type="text" class="form-control" placeholder="Digite seu número de WhatsApp" id="n_phone" name="n_phone" maxlength="15" required value="<?=$user['n_phone']?>">
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
		<button type="submit" class="btn btn-primary">Atualizar</button> <a href="<?=BASE_URL?>user/changePassword" class="btn btn-warning">Trocar Senha</a>
	</form>
</div>
<script type="text/javascript">
		/* Máscaras ER */
		function mascara(o,f){
		    v_obj=o
		    v_fun=f
		    setTimeout("execmascara()",1)
		}
		function execmascara(){
		    v_obj.value=v_fun(v_obj.value)
		}
		function mtel(v){
		    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
		    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
		    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
		    return v;
		}
		function id( el ){
			return document.getElementById( el );
		}
		window.onload = function(){
			id('n_phone').onkeyup = function(){
				mascara( this, mtel );
			}
		}
	</script>