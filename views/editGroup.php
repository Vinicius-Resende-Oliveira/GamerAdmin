    <div class="container">
		<h3 class="text-center">Editar dados do Grupo</h3>
    <?php
    if(isset($erroNameExist) && $erroNameExist){
        ?>
        <div class="col-sm-12">
            <div class="alert alert-warning">
                Este nome já esta sendo utilizado. Por favor tente outro.
            </div>
        </div>
        <?php
    }
    ?>
		<form method="POST" action="<?=BASE_URL?>group/update" enctype="multipart/form-data">
			<div class="form-group">
				<label for="name">Nome do grupo:</label>
				<input type="text" class="form-control" placeholder="Digite o nome" id="name" name="name" value="<?=$group['name']?>">
			</div>
			<div class="form-group">
				<label for="tag">TAG:</label>
				<input type="text" class="form-control" placeholder="Digite a TAG do grupo." id="tag" name="tag" required="required" maxlength="3" value="<?=$group['tag']?>">
			</div>
			<div class="form-group">
				<label for="tag">Lider:</label>
				<input type="text" class="form-control" placeholder="Digite o nickname do usuário." id="nickname" name="nickname" required="required" value="<?=$leader['nickname']?>" disabled>
			</div>
			<div class="form-group">
				<label>Privacidade do grupo:</label><br/>
				<div class="custom-control custom-radio custom-control-inline">
				    <input type="radio" class="custom-control-input" id="privacy1" name="privacy" value="0" <?php echo ($group['privacy'] == 0)? 'checked':'';?>>
				    <label class="custom-control-label" for="privacy1">Privado</label>
			  	</div>
			  	<div class="custom-control custom-radio custom-control-inline">
				    <input type="radio"  class="custom-control-input" id="privacy2" name="privacy" value="1" <?php echo ($group['privacy'] == 1)? 'checked':'';?>>
				    <label class="custom-control-label" for="privacy2">Público</label>
				</div>
			</div>
			<div class="form-group">
				<label>Prazo de dias:</label><br/>
        <?php
            if($group['days_due'] <= -2){
                ?>
                <a class="btn btn-danger btn-day" style="display:block;" >Vencido à <?=$group['days_due']*-1?> dias</a>
                <?php
            }else if($group['days_due'] == -1){
                ?>
                <a class="btn btn-danger btn-day" style="display:block;" >Venceu ontem.</a>
                <?php
            }else if($group['days_due'] == 0){
                ?>
                <a class="btn btn-danger btn-day" style="display:block;" >Venceu hoje.</a>
                <?php
            }else if($group['days_due'] < 17 && $group['days_due'] > 0){
                ?>
                <a class="btn btn-warning btn-day" style="display:block;" >Faltam: <?=$group['days_due']?> dias</a>
                <?php
            }else{
                ?>
                <a class="btn btn-success btn-day" style="display:block;" disabled>Faltam: <?=$group['days_due']?> dias</a>
                <?php
            }
        ?>
			</div>
            <div class="form-group">
            <label for="lv1">Sistemas de pontos: <a href="#" data-toggle="tooltip" title="Pontos por nível de monstro abatido"><i class="fas fa-info-circle"></i></a></label>
                <div class="row">
                    <div class="col-sm-2">
                        <label for="lv1">Nível: 1</label>
                        <input type="number" class="form-control" placeholder="" class="lv" id="lv1" name="" value="0" disabled>  
                    </div>
                    <div class="col-sm-2">
                        <label for="lv1">Nível: 2</label>
                        <input type="number" class="form-control" placeholder="" class="lv" id="lv2" name="levels[]" value="<?=$group['pts_goal']['1']?>" min="0" max="100">  
                    </div>
                    <div class="col-sm-2">
                        <label for="lv1">Nível: 3</label>
                        <input type="number" class="form-control" placeholder="" class="lv" id="lv3" name="levels[]" value="<?=$group['pts_goal']['2']?>" min="0" max="100">  
                    </div>
                    <div class="col-sm-2">
                        <label for="lv1">Nível: 4</label>
                        <input type="number" class="form-control" placeholder="" class="lv" id="lv4" name="levels[]" value="<?=$group['pts_goal']['3']?>" min="0" max="100">  
                    </div>
                    <div class="col-sm-2">
                        <label for="lv1">Nível: 5</label>
                        <input type="number" class="form-control" placeholder="" class="lv" id="lv5" name="levels[]" value="<?=$group['pts_goal']['4']?>" min="0" max="100">  
                    </div>
                    <div class="col-sm-2">
                        <label for="lv1">Pontos necessários: <a href="#" data-toggle="tooltip" title="A soma de pontos que o membro terá que cumprir semanalmente"><i class="fas fa-info-circle"></i></a></label>
                        <input type="number" class="form-control" placeholder="" id="goal_total" name="goal_total" value="<?=$group['goal_total']?>" min="0" max="100">  
                        <!-- <input type="checkbox" id="check_simulation"> Simulação <a ></a> -->
                    </div>
                </div>
				
			</div>
			<button type="submit" class="btn btn-primary">Atualizar</button>
		</form>
	</div>
    <script type="text/javascript">
        var simulationCheck = false;
		/* Máscaras ER */
        // function simulation(s){
        //     if( s.is(":checked") == true){
        //         $('#goal_total').value = parseInt($('#lv1').val()) + parseInt($('#lv2').val()) + parseInt($('#lv3').val()) + parseInt($('#lv4').val()) + parseInt($('#lv5').val());
        //     } 
        // }
		// window.onload = function(){
        //     $('.lv').onkeyup = function(){
        //         simulation($('#check_simulation'));
        //     }
        //     $('#check_simulation').onclick = function(){
		// 		simulation(this);
		// 	}
        // }
        $(document).ready(function(){
           $('[data-toggle="popover"]').popover();
        });
	</script>