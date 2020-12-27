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
		if (data == "1") {
			// ajax para trazer as informações
			$.ajax({
				url:'app/controllers/editarUsuario.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'id_usuario': $('#id_usuario').val()
				}
			}).done( function(data){
				//cria vetor de valores
				var vetor = data.split(",,");
				// pega os valores
				var nome = vetor[1];
				// insere valores
				$('#nome').val(nome);
			});

	$('#formUsuario').submit(function(e){
		$.ajax({
			url:'app/controllers/atualizaPerfilController.php',
			type: 'POST',
			dataType: 'html',
			data: {
				'nome': $('#nome').val(),
				'id_usuario': $('#id_usuario').val()
			}
		}).done( function(data){
			verificaAlteracao(data);
		});
		return false;
	});
	} else {
		msm  = '<h1 class="text-center">';
		msm += '	  Você não esta logado para esse tipo de operação';
		msm += '</h1>';
		$("#formUsuario").html(msm);
	}
});
	mask();
});

function verificaAlteracao(resultado){
	if (resultado == '1' || resultado == 1) {
		$.toast({
			text: "Alterado com sucesso!", 
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
	} else {
		$.toast({
			text: "Falha ao alterar!", 
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
}