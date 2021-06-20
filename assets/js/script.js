$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

function CheckFiles(e){
	var fup = $("#prints");
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') +1 );

	if(ext == 'jpeg' || ext == 'jpg'){
		return true;
	}else{
		return false;
	}
}
function processar_formulario(){
    if(document.getElementById("prints").value==""){
        alert("Por favor, selecione um arquivo!");
        document.getElementById("prints").focus();
    }else{
        document.getElementById("button_prints").innerHTML = "Carregando..."
        document.getElementById("formulario").submit();            
    }
}
function changePassword(newPassword, afterPassword, locage){
    data = "afterPassword=" + afterPassword + "&newPassword=" + newPassword;
    if(afterPassword != "" && newPassword != "" && afterPassword != newPassword){
            $.ajax({
            method: "POST",
            url: locage,
            data: data
        })
        .done(function(response){
            if(response === "true"){
                alert("Senha trocada com sucesso!!");
                document.getElementById("newPassword").value = "";
			    document.getElementById("newPassword2").value = "";
            }else if(response === "false"){
                alert("Não foi possível troca a sua senha.");
            }else{
                alert("Não foi possível troca a sua senha.");
            }
        })
        .fail(function(jqXHR, textStatus, response){
            console.log(response);
            alert("Não foi possível troca a sua senha.");
        }); 
    }
}