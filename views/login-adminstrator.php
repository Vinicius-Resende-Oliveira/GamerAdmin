
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
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
		    padding: 10%;
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
		    background-color: #FFDC41;
		}
		.login-form-1 .ForgetPwd{
		    color: #FFCD43;
		    font-weight: 600;
		    text-decoration: none;
		}

    </style>
</head>
<body>
<?php
if(isset($memberNotFound) && $memberNotFound){
	?>
	<div class="alert alert-warning">
		Você errou o nickname ou a senha. Digite novamente!
	</div>
	<?php
}
?>
<div class="container login-container">
    <div class="row">
        <div class="col-md-6 mx-auto login-form-1">
            <h2>Smart Guild - Admin</h2>
        	<h4>LOGIN</h4>
            
			<form method="POST" action="<?=BASE_URL?>administrator/connecting">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Nickname" value="" name="nickname" />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Senha" value="" name="password"/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btnSubmit" value="Login" />
                </div>
            </form>
        </div>
	</div>	
</div>
