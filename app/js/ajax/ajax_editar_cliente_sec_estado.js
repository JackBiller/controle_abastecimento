$(document).ready(function(){
	var msm = '';
	$.ajax({
		url:'app/controllers/conf_operacao_e.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'id_cliente': $('#id_cliente').val(),
			'senha': 	  $("#pwd").val(),
			'editar': 	  $("#editar").val(),
			'table': 	  "cliente_sec_estado"
		}
	}).done( function(data){
		if (data == "1") {

		$.ajax({
			url:'app/controllers/funcoesController.php',
			type: 'POST',
			dataType: 'html',
			data: {'pesquisa_estado_select': true}
		}).done( function(data){
			$("#selectEstado").html(data);
			$.ajax({
				url:'app/controllers/editarSecEstadoController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'preenche_campos_cia_energia': true,
					'id_cliente_sec_estado':	$('#editar').val()
				}
			}).done( function(data){
				//cria vetor de valores
				var vetor = data.split(",,");

				// pega os valores
				var sec_estado	 		= vetor[2];
				var endereco 			= vetor[3];
				var numero 				= vetor[4];
				var complemento 		= vetor[5];
				var bairro 				= vetor[6];
				var cep 				= vetor[7];
				var cidade 				= vetor[8];
				var estado 				= vetor[9];
				
				// insere valores
				$("#sec_estado").val(sec_estado);
				$("#cep").val(cep);
				$("#endereco").val(endereco);
				$("#numero").val(numero);
				$("#complemento").val(complemento);
				$("#bairro").val(bairro);
				$("#cidade").val(cidade);
				$("#estado").val(estado);
			});
		});

	$('#formClienteCiaEnergia').submit(function(e){
		e.preventDefault();
			$.ajax({
				url:'app/controllers/atualizaSecEstadoController.php',
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
					'estado':      		$('#estado').val(),
					'id_sec_estado': 	$("#editar").val()
				}
			}).done( function(data){
				console.log(data);
				if (data == '1') {
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
				}else {
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