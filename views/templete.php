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
        .container{
            margin-top: 75px;
        }
    </style>
    <script src="<?=BASE_URL?>assets/js/jquery.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
        <a class="navbar-brand" href="<?=BASE_URL?>">Smart Guild</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
    <!-- Navbar links -->
    
        <?php
        if(isset($viewData['view']) && ($viewData['view'] == "expiredGroup" || $viewData['view'] == "userTemporary" || $viewData['view'] == "userWithoutGroup" || $viewData['view'] == "userWaitingRequest")){
        ?>
        <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?=BASE_URL?>user/logout">Sair</a>
                </li>
            </ul>
        </div>
        <?php
        }else{
        ?>
        <div class="collapse navbar-collapse justify-content-between" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?=BASE_URL?>print/send">Enviar Prints</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=BASE_URL?>print/history">Historico de Prints</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        <i class="fas fa-cog"></i>
                    </a>
                    <div class="dropdown-menu" style="right: 10px; left: auto;">
                        <a class="dropdown-item"  href="<?=BASE_URL?>user/edit">Editar Usuário</a>
                        <a class="dropdown-item"  href="<?=BASE_URL?>user/logout">Sair</a>
                    </div>
                </li>
            </ul>
        </div>
        <?php
        }
        ?>
    </nav>
    <?php $this->loadViewInTemplete($viewName, $viewData);?>

    
    
	<script src="<?=BASE_URL?>assets/js/bootstrap.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/script.js"></script>
</body>
</html>