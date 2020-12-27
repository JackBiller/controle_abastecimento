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

		$.ajax({
			url:'app/controllers/funcoesController.php',
			type: 'POST',
			dataType: 'html',
			data: {'pesquisa_estado_select': true}
		}).done( function(data){
			$("#selectEstado").html(data);
		});
		if (empresa) {
			$.ajax({
				url:'app/controllers/funcoesEmpresaController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'pesquisa_empresa': true
				}
			}).done( function(data){
				$("#conteudoEmpresa").html(data);
			});
		}

	$('#formEmpresa').submit(function(e){
		e.preventDefault();
			$.ajax({
				url:'app/controllers/clienteEmpresaController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'nome':			$('#nome').val(),
					'reg_federal': 	$('#reg_federal').val(),
					'reg_estadual':	$('#reg_estadual').val(),
					'cep':     		$('#cep').val(),
					'endereco':    	$('#endereco').val(),
					'numero':      	$('#numero').val(),
					'complemento': 	$('#complemento').val(),
					'bairro':      	$('#bairro').val(),
					'cidade':      	$('#cidade').val(),
					'estado':      	$('#estado_id').val()
				}
			}).done( function(data){
				console.log(data);
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
					$('#reg_federal').val('');
					$('#reg_estadual').val('');
					$('#cep').val('');
					$('#endereco').val('');
					$('#numero').val('');
					$('#complemento').val('');
					$('#bairro').val('');
					$('#cidade').val('');
					$('#estado_id').val(1);
				}else {
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
		return false;
	});
	} else {
		msm  = '<h1 class="text-center">';
		msm += '	  Você não esta logado para esse tipo de operação';
		msm += '</h1>';
		$("#formEmpresa").html(msm);
	}
});
	mask();
});