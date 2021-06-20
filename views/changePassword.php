<div class="container">
	<form method="POST" id="form">
		<div class="form-group">
			<label for="afterPassword">Digite a senha antiga:</label>
			<input type="password" class="form-control" placeholder="" onkeyup="confirmPassword()" id="afterPassword" name="afterPassword" required>
		</div>
        <div class="form-group">
			<label for="newPassword">Digite a nova senha:</label>
			<input type="password" class="form-control" placeholder=""  id="newPassword" name="newPassword" required onkeyup="passConfirm()">
		</div>
        <div class="form-group">
			<label for="newPassword2">Digite a nova senha novamente:</label>
			<input type="password" class="form-control" placeholder="" id="newPassword2" name="newPassword2"  required onkeyup="passConfirm()">
            <h6 class="bg-danger text-light rounded-bottom invisible" id="text-password2">Os campos não se conhecidem</h6>
		</div>
		<button type="submit" class="btn btn-primary" onclick="checkValues()" disabled>Trocar</button>
	</form>
</div>
<script type="text/javascript">
    var confirm = false;
	var verify = true;
    function confirmPassword(){
        afterPassword = document.getElementById("afterPassword").value;
		data = "password=" + afterPassword;
        if(afterPassword != ""){
                $.ajax({
                method: "POST",
                url: "<?=BASE_URL?>user/confirmPassword/",
                data: data
            })
            .done(function(response){
                if(response == 1){
					$('#afterPassword').removeClass("border-danger");
                    $('#afterPassword').addClass("border-success");
                    confirm = true;
                }else if(response == 0){
					$('#afterPassword').removeClass("border-success");
                    $('#afterPassword').addClass("border-danger");
                    confirm = false;
                }else{
					console.log("Error");
				}
            })
            .fail(function(jqXHR, textStatus, response){
                console.log(response);
            }); 
        }
	}
	function passConfirm(){
		newPassword = document.getElementById("newPassword").value;
		newPassword2 = document.getElementById("newPassword2").value;
		if(newPassword == newPassword2 && newPassword != "" && newPassword2 != ""){
			$('#newPassword2').removeClass('border-danger');
			$('#newPassword').removeClass('border-danger');
			$('#newPassword2').addClass('border-success');
			$('#newPassword').addClass('border-success');
			$('#text-password2').addClass('invisible');
			$('button:contains("Trocar")').prop('disabled',false);
			verify= true;
			
		}else{
			if(verify){
				$('#newPassword2').removeClass('border-success');
				$('#newPassword').removeClass('border-success');
				$('#newPassword2').addClass('border-danger');
				$('#newPassword').addClass('border-danger');
				$('button:contains("Trocar")').prop('disabled',true);
				verify = false;
			}

		}
	}
	function checkValues(){
		afterPassword = document.getElementById("afterPassword").value;
		newPassword = document.getElementById("newPassword").value;
		newPassword2 = document.getElementById("newPassword2").value;
		if(newPassword == afterPassword && newPassword != "" && confirm && verify){
			alert("Essa senha já foi utilizada");
			$('#newPassword').removeClass('border-success');
			$('#newPassword2').removeClass('border-success');
			document.getElementById("newPassword").value = "";
			document.getElementById("newPassword2").value = "";
		}else if(newPassword != newPassword2){
			alert("Digite a mesma senha nos campos de nova senha");
			document.getElementById("newPassword2").value = "";
		}else if(newPassword != afterPassword && newPassword != "" && confirm && verify){
			changePassword(newPassword, afterPassword, "<?=BASE_URL?>user/updatePassword/");
		}
		$('#form').submit(function(e){
			e.preventDefault();
		});
	}

</script>