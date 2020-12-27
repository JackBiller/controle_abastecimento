$(document).ready(function(){
	var msm = '';
	$.ajax({
		url:'app/controllers/conf_operacao.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'id_cliente': $('#id_cliente').val(),
			'senha': 	  $("#pwd").val()
		}
	}).done( function(data){
		console.log(data);
		if (data == "1") {

		$.ajax({
			url:'app/controllers/funcoesController.php',
			type: 'POST',
			dataType: 'html',
			data: {'pesquisa_estado_select': true}
		}).done( function(data){
			$("#selectEstado").html(data);
		});

		$('#formClienteUnidCons').submit(function(e){
			cliente = $('#cliente_unid_cons_proprietario').val();
			console.log(cliente);
			$.ajax({
				url:'app/controllers/cadastroExUnidConsProprietarioController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'cliente_unid_cons_proprietario': 	$('#cliente_unid_cons_proprietario').val(),
					'pessoa_tipo': 						$('#pessoa_tipo').val(),
					'reg_federal': 						$('#reg_federal').val(),
					'reg_estadual': 					$('#reg_estadual').val(),
					'estado_civil': 					$('#estado_civil').val(),
					'profissao': 						$('#profissao').val(),
					'nacionalidade': 					$('#nacionalidade').val(),
					'representante': 					$('#representante').val(),
					'cep': 								$('#cep').val(),
					'endereco': 						$('#endereco').val(),
					'numero': 							$('#numero').val(),
					'complemento': 						$('#complemento').val(),
					'bairro': 							$('#bairro').val(),
					'cidade': 							$('#cidade').val(),
					'estado': 							$('#estado').val(),
					'telefone': 						$('#telefone').val(),
					'celular': 							$('#celular').val(),
					'nextel': 							$('#nextel').val(),
					'id_unid_cons': 					$('#editar').val()
				}									
			}).done( function(data){
				verificaAlteracao(data);
				desabilitarBotao();
				// document.getElementById('submitProprientario').disabled = true;
			});
			return false;
		});
	} else {
		msm  = '<h1 class="text-center">';
		msm += '	  Você não esta logado para esse tipo de operação';
		msm += '</h1>';
		$("#formClienteUnidCons").html(msm);
	}
});
	mask();
});

function desabilitarBotao(){
	document.getElementById("submitProprientario").disabled = true;
}

function verificaAlteracao(resultado){
	console.log(resultado);
	if (resultado == '1' || resultado == 1) {
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
}