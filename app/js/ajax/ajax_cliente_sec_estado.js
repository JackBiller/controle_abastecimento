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
		if (sec_estado) {
			$.ajax({
				url:'app/controllers/funcoesSecEstadoController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'pesquisa_sec_estado': true,
					'id_cliente':	$('#id_cliente').val()
				}
			}).done( function(data){
				$("#conteudoSecEstado").html(data);
			});
		}

	$('#formClienteCiaEnergia').submit(function(e){
		e.preventDefault();
			$.ajax({
				url:'app/controllers/clienteSecEstadoController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'id_cliente':  		$('#id_cliente').val(),
					'sec_estado':		$('#sec_estado').val(),
					'cep':     			$('#cep').val(),
					'endereco':    		$('#endereco').val(),
					'numero':      		$('#numero').val(),
					'complemento': 		$('#complemento').val(),
					'bairro':      		$('#bairro').val(),
					'cidade':      		$('#cidade').val(),
					'estado':      		$('#estado').val()
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
					$('#sec_estado').val('');
					$('#reg_federal').val('');
					$('#reg_estadual').val('');
					$('#cep').val('');
					$('#endereco').val('');
					$('#numero').val('');
					$('#complemento').val('');
					$('#bairro').val('');
					$('#cidade').val('');
					$('#estado').val('');
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
		$("#formClienteCiaEnergia").html(msm);
	}
});
	mask();
});