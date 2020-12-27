$('#formLogin').submit(function(e){        
    e.preventDefault();
	$.ajax({
		url:'app/controllers/loginController.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'login': $('#usuario').val(),
			'senha': $('#password').val()
		}
	}).done( function(data){
		if (data == "0") {
			$.toast({
				text: "Login ou senha incorretos!", 
				heading: 'Falha', 
				icon: 'error', 
				showHideTransition: 'slide', 
				allowToastClose: true, 
				hideAfter: 2500, 
				stack: 5, 
				position: 'bottom-left',
				extAlign: 'left',
				loader: true,
				loaderBg: '#44f'
			});
		}else{
			$.toast({
				text: "Você está logado!", 
				heading: 'Nota', 
				icon: 'info', 
				showHideTransition: 'slide', 
				allowToastClose: true, 
				hideAfter: 2500, 
				stack: 5, 
				position: 'bottom-left',
				extAlign: 'left',
				loader: true,
				loaderBg: '#44f'
			});
			var vetor = data.split(",/,");
			var conteudo = vetor[0];

			$('#usuario').val('');
			$('#password').val('');
			$("#fecharModalLogin").click();
			$("#usuarioLogado").html(conteudo);
			$("#clique_me").click();

			if (vetor[1] == "1") {
				$("#clique_me_2").click();
			}
		}
	});
    return false;
});


function deslogar(){
	html = "<button type=\"button\" class=\"btn btn-info btn-block\" data-toggle=\"modal\" data-target=\"#modalLogin\">";
    html += "Login</button>"
    html += "<input type=\"hidden\" name=\"id_usuario\" value=\"0\" id=\"id_usuario\">";
	document.getElementById("usuarioLogado").innerHTML = html;
	n_editar();
	$("#clique_me").click();
	if (document.getElementById('clique_me_2').checked) {
		$("#clique_me_2").click();
	}
}