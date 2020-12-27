$(document).ready(function(){
	var msm = '';
	$.ajax({
		url:'app/controllers/conf_operacao.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'id_usuario': $('#id_usuario').val(),
			'senha': 	  $("#pwd").val()
		}
	}).done( function(data){
		console.log(data);
		if (data == "1") {
			if (cadastro) {
				$.ajax({
					url:'app/controllers/funcoesUsuarioController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'pesquisa_caminhao': true
					}
				}).done( function(data){
					$("#conteudoUsuario").html(data);
				});
			}
			$('#formUsuario').submit(function(e){
				e.preventDefault();
				if ($('#conf_senha').val() == $('#senha').val()) {
					$.ajax({
						url:'app/controllers/usuarioController.php',
						type: 'POST',
						dataType: 'html',
						data: {
							'nome':  	$('#nome').val(),
							'login': 	$('#login').val(),
							'senha': 	$('#senha').val()
						}
					}).done( function(data){
						if (data == '1') {
							$.toast({
								text: "Cadastrado com sucesso!", 
								heading: 'Sucesso', 
								icon: 'success', 
								showHideTransition: 'slide', 
								allowToastClose: true, 
								hideAfter: 2500, 
								stack: 5, 
								position: 'bottom-left',
								extAlign: 'left',
								loader: true,
								loaderBg: '#44f'
							});
							$('#nome').val('');
							$('#login').val('');
							$('#senha').val('');
							$('#conf_senha').val('');
						} else {
							$.toast({
								text: "Falha ao cadastrar!", 
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
						}
					});
				}else {
					alert("Senha Incorreta");
					$('#senha').val('');
					$('#conf_senha').val('');
				}
				return false;
			});
			mask();
		} else {
			msm  = '<h1 class="text-center">';
			msm += '	  Você não esta logado para esse tipo de operação';
			msm += '</h1>';
			$("#formUsuario").html(msm);
		}
		mask();
	});
});