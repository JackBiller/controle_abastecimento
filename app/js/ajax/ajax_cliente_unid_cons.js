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

		if (unid_cons) {
			// Ajax Estados do brasil
			$.ajax({
				url:'app/controllers/funcoesUnidConsController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'pesquisa_unid_cons': true,
					'id_cliente':	$('#id_cliente').val()
				}
			}).done( function(data){
				// console.log(data);
				$("#conteudoUnidCons").html(data);
			});
		} else {
			// Ajax Cia de Energia
			$.ajax({
				url:'app/controllers/funcoesUnidConsController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'pesquisa_cia_energia_select': true,
					'id_cliente':	$('#id_cliente').val()
				}
			}).done( function(data){
				$("#selectCiaEnergia").html(data);
			});
			// Ajax Secretaria do estado
			$.ajax({
				url:'app/controllers/funcoesUnidConsController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'pesquisa_sec_estado_select': true,
					'id_cliente':	$('#id_cliente').val()
				}
			}).done( function(data){
				$("#selectSecEstado").html(data);
			});
			$.ajax({
				url:'app/controllers/funcoesController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'pesquisa_estado_select': true
				}
			}).done( function(data){
				$("#selectEstado").html(data);
			});
		}

	$('#formClienteUnidCons').submit(function(e){
		e.preventDefault();

		$.ajax({
			url:'app/controllers/funcoesController.php',
			type: 'POST',
			dataType: 'html',
			data: {
				'verificarVendas': 	true,
				'id_cliente': 		$('#id_cliente').val()
			}
		}).done( function(data){
			console.log(data);
			if (data == '1') {

				var alugada = $('#unid_cons_nome_terceiro').val();
				if (alugada == 'sim') {
					alugada = 1;
				} else {
					alugada = 0;
				}		
					$.ajax({
						url:'app/controllers/clienteUnidConsController.php',
						type: 'POST',
						dataType: 'html',
						data: {
							'id_cliente': 				$('#id_cliente').val(),
							'nro_instalacao':			$('#nro_instalacao').val(),
							'unid_cons_nome_terceiro':	alugada,
							'classificacao':			$('#classificacao').val(),
							'cep': 						$('#cep').val(),
							'endereco': 				$('#endereco').val(),
							'numero': 					$('#numero').val(),
							'complemento': 				$('#complemento').val(),
							'bairro': 					$('#bairro').val(),
							'cidade': 					$('#cidade').val(),
							'estado': 					$('#estado').val(),
							'cliente_cia_energia_id':	$('#cliente_cia_energia_id').val(),
							'cliente_sec_estado_id':	$('#cliente_sec_estado_id').val()
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
							$('#nro_instalacao').val('');
							$('#unid_cons_nome_terceiro').val('');
							$('#classificacao').val('');
							$('#cep').val('');
							$('#endereco').val('');
							$('#numero').val('');
							$('#complemento').val('');
							$('#bairro').val('');
							$('#cidade').val('');
							$('#estado').val('');
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
			} else {
				$.toast({
					text: "Falha ao cadastrar! Você não tem numero de imóveis em compras para cadastrar novas unidades!", 
					heading: 'Falha', 
					icon: 'error', 
					showHideTransition: 'slide', 
					allowToastClose: true, 
					hideAfter: 3500, 
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
		$("#formClienteUnidCons").html(msm);
	}
});
	mask();
});