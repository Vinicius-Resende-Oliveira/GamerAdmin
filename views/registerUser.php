<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/style.css">
    <style type="text/css">
    	html, body{
    		height:100%;
    		background-color: #447AB7;
    	}
    	.login-container{
		    display: flex;
		    justify-content: center;
		    align-items: center;
		    height: 100%;
		}
		.login-container .row{
			width: 100%;
		}
		.login-form-1{
		    padding: 5%;
		    box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2), 0 9px 26px 0 rgba(0, 0, 0, 0.19);
		}
		.login-form-1 h2 {
		    text-align: center;
		    color: #eeffee;
		}
		.login-form-1 h4 {
		    text-align: center;
		    color: #FFCD43;
		}
		.login-container form{
		    padding: 5%;
		}
		.btnSubmit
		{
		    width: 50%;
		    border-radius: 1rem;
		    padding: 1.5%;
		    border: none;
		    cursor: pointer;
		}
		.login-form-1 .btnSubmit{
		    font-weight: 600;
		    color: #fff;
		    background-color: #F89812;
		}
		.login-form-1 .ForgetPwd{
		    color: #FFCD43;
		    font-weight: 600;
		    text-decoration: none;
		}
		.toast{
			position:fixed;
			top:10px;
			right:10px;
			z-index: 10;
		}
    </style>
    <script type="text/javascript">
		/* Máscaras ER */
		var verify = false;
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
		function passConfirm(){
		    if($('#password').val() != $('#password2').val()){
				
				if(!verify){
					console.log($('#password').val() + " -> " + $('#password2').val());	
					$('#password2').addClass('border-danger');
					verify = true;
				}
			}else{
				$('#password2').removeClass('border-danger');
				$('#password2').addClass('border-success');
				$('#password').addClass('border-success');
				$('#text-password2').addClass('invisible');
				verify= false;
			}
		}
		function checkValues(){
			if($('#password').val() != $('#password2').val() ){
				
				// $('#text-password2').addClass('visible');
				$('#text-password2').removeClass('invisible');
				$('#form').submit(function(e){
					e.preventDefault();
				});
			}
			// else{
			// 	$('#form').submit();
			// }
			
		}
		window.onload = function(){
			id('n_phone').onkeyup = function(){
				mascara( this, mtel );
			}
			// id('password2').onkeyup = function(){
			// 	passConfirm( this, mtel );
			// }
			$("#form-input-creat").append('');
			$(document).ready(function(){
				$('.toast').toast('show');
			});
		}
	</script>
</head>
<body>

<div class="container login-container">
	
    <div class="row">
        <div class="col-md-9 mx-auto login-form-1">
        	<h2>Smart Guild</h2>
        	<h4>CADASTRO</h4>
            <form method="POST" action="<?=BASE_URL?>user/save" id="form">
				<div class="row">
				<?php
				if(isset($erroEmailExist) && $erroEmailExist){
					?>
					<div class="col-sm-12">
						<div class="alert alert-warning">
							Este email já esta sendo utilizado. Por favor tente outro.
						</div>
					</div>
					<?php
				}
				if(isset($erroNicknameExist) && $erroNicknameExist){
					?>
					<div class="col-sm-12"></div>
						<div class="alert alert-warning">
							Este nickname já esta sendo utilizado. Por favor tente outro.
						</div>
					</div>
					<?php
				}
				?>
            		<div class="col-sm-6">
		                <div class="form-group">
							<input type="text" class="form-control" placeholder="Digite seu nome" id="name" name="name">
						</div>
            		</div>
            		<div class="col-sm-6">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Digite seu nickname usado no jogo." id="nickname" name="nickname" required="required">
						</div>
            		</div>
            	</div>
            	<div class="row">
            		<div class="col-sm-6">
		                <div class="form-group">
							<input type="email" class="form-control" placeholder="Digite seu Email" id="email" name="email" required="required">
						</div>
            		</div>
            		<div class="col-sm-6">
						<div class="form-group" >
							<input type="text" class="form-control" placeholder="Digite seu número de WhatsApp" id="n_phone" name="n_phone" maxlength="15" required="required">
						</div>
            		</div>
            	</div>
            	<div class="row">
            		<div class="col-sm-12">
	            		<div class="form-group">
							<label for="sel_group" style="color: #eeffee;">Selecione seu grupo:</label>
							<select class="form-control" id="sel_group" name="sel_group">
								<option value="0">Não tenho.</option>
								<?php
								if(count($groups) > 0):
									foreach($groups as $group){
									?>
								<option value="<?= $group['id']; ?>"><?= $group['name']; ?></option>
									<?php
									}
								endif;
								?>
							</select>
						</div>
            		</div>
            	</div>
				<div class="row">
            		<div class="col-sm-6">
		                <div class="form-group">
							<input type="password" class="form-control" placeholder="Digite sua senha" id="password" name="password" required="required">
						</div>
            		</div>
            		<div class="col-sm-6">
						<div class="form-group">
							<input type="password" class="form-control" placeholder="Digite novamete a senha" id="password2" name="password2" required="required" onkeyup="passConfirm()">
							<h6 class="bg-danger text-light rounded-bottom invisible" id="text-password2">Os campos não se conhecidem</h6>
						</div>
            		</div>
            	</div>
				<div class="form-group">
					<input type="submit" class="btnSubmit" onclick="checkValues()" value="Cadastrar"/>
                </div>
				<div class="form-group">
                	<p style="color: #eeffee;">Já esta cadastrado? <a href="<?=BASE_URL?>user/login" class="ForgetPwd">Clique aqui</a></p>
                </div>
            </form>
        </div>
	</div>	
</div>

<script src="<?=BASE_URL?>assets/js/jquery.min.js"></script>
	<script src="<?=BASE_URL?>assets/js/bootstrap.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/script.js"></script>
</body>
</html>