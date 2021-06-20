<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/style.css">
    <script src="<?=BASE_URL?>assets/js/jquery.min.js"></script>
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="jumbotron">
            <h1>Bem-vindo administrador</h1>
            <h4><strong>Número de usuário: </strong><?=$users['number']?></h4>
            <h4><strong>Número de grupos: </strong><?=$groups['number']?></h4>
        </div>
    </div>

    <script src="<?=BASE_URL?>assets/js/bootstrap.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/script.js"></script>
</body>
</html>