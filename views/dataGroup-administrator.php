<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="<?=BASE_URL?>assets/js/jquery.min.js"></script>
</head>
<body class="bg-light">
    <div class="container">
        <div class="col-sm-12 mx-auto">
            <div class="card card-lg">
                <div class="card-header bg-secondary text-white">
                    <h5>Dados do grupo</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nome: </strong> <?=$group['name']?></p>
                    <p><strong>Criado em: </strong><?=$group['date_create']['day']?> às <?=$group['date_create']['time']?></p>
                    <p><strong>Lider: </strong><a href="<?=BASE_URL?>user/data/<?=$leader['id']?>"><?=$leader['nickname']?></a></p>
                    <p><strong>Número de membros: </strong><?=$group['number_members']?>/100</p>
                </div>
                <div class="card-footer">
                <?php
                    if($group['days_due'] <= -2){
                        ?>
                        <!-- <a class="btn btn-danger" style="display:block;" onclick="renewGroup(<?=$group['id']?>)">Vencido à <?=$group['days_due']*-1?> dias <br/> Clique para adicionar mais 40 dias</a> -->
                        <a class="btn btn-danger" style="display:block;" href="<?=BASE_URL?>administrator/renew/<?=$group['id']?>/<?=$link?>" >Vencido à <?=$group['days_due']*-1?> dias <br/> Clique para adicionar mais 40 dias</a>
                        <?php
                    }else if($group['days_due'] == -1){
                        ?>
                        <a class="btn btn-danger" style="display:block;" href="<?=BASE_URL?>administrator/renew/<?=$group['id']?>/<?=$link?>">Venceu ontem <br/> Clique para adicionar mais 40 dias</a>
                        <?php
                    }else if($group['days_due'] == 0){
                        ?>
                        <a class="btn btn-danger" style="display:block;" href="<?=BASE_URL?>administrator/renew/<?=$group['id']?>/<?=$link?>" >Venceu hoje <br/> Clique para adicionar mais 40 dias</a>
                        <?php
                    }else if($group['days_due'] < 17 && $group['days_due'] > 0){
                        ?>
                        <a class="btn btn-warning" style="display:block;" href="<?=BASE_URL?>administrator/renew/<?=$group['id']?>/<?=$link?>" >Faltam: <?=$group['days_due']?> dias  <br/> Clique para adicionar mais 30 dias</a>
                        <?php
                    }else{
                        ?>
                        <a class="btn btn-success" style="display:block;" disabled>Faltam: <?=$group['days_due']?> dias</a>
                        <?php
                    }
                ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
            <?php
            if(count($members) > 0):
            ?>
                <table class="table text-center border-1 shadow-sm">
                    <thead>
                        <tr>
                            <th>Nickname:</th>
                            <th>Cargo:</th>
                            <th>Contato:</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                    foreach ($members as $value):
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
                        </tr>
                <?php
                    endforeach;
                ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
	
	<script src="<?=BASE_URL?>assets/js/bootstrap.min.js"></script>
    <script src="<?=BASE_URL?>assets/js/script.js"></script>
    <script>
    // function renewGroup(id_group){
    //     $.ajax({
    //     method: "POST",
    //     url: "<?=BASE_URL?>administrator/renewAdapter/"+id_group,
    //     data: {}
    //     })
    //     .done(function(msg){
    //         console.log(msg);
    //     });
    // }
    </script>
</body>
</html>