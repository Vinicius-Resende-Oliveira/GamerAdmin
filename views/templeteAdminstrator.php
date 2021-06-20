<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial - Administrador</title>
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <style type="text/css">
        html, body{
            height:100%;
        }
        .h-100{
            height:100%;
        }
        .h-95{
            height:95%;
        }
        .h-90{
            height:90%;
        }
        .container, .container-fluid{
            padding-top: 50px;
            height:100%;
        }
        .item-admin{
            width: 100%;
            text-align: center;
            
        }
        .line-horizontal{
            padding: 1px;
            background-color:#CDCDCD;
        }
        .frame-admin{
            width:100%;
            height:100%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
        <a class="navbar-brand" href="<?=BASE_URL?>">Smart Guild</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
    <!-- Navbar links -->
        <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
            
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?=BASE_URL?>administrator/logout">Sair</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php $this->loadViewInTemplete($viewName, $viewData);?>

    
    <script src="<?=BASE_URL?>assets/js/jquery.min.js"></script>
	<script src="<?=BASE_URL?>assets/js/bootstrap.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/script.js"></script>
</body>
</html>