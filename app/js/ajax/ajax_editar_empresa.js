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
			$.ajax({
				url:'app/controllers/funcoesController.php',
				type: 'POST',
				dataType: 'html',
				data: {'pesquisa_estado_select': true}
			}).done( function(data){
				$("#selectEstado").html(data);
				$.ajax({
					url:'app/controllers/editarEmpresaController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'id_empresa':	$('#editar').val()
					}
				}).done( function(data){
					//cria vetor de valores
					var vetor = data.split(",,");

					// pega os valores
					var nome 			= vetor[1];
					var reg_federal 	= vetor[2];
					var reg_estadual 	= vetor[3];
					var endereco 		= vetor[4];
					var numero 			= vetor[5];
					var complemento 	= vetor[6];
					var bairro 			= vetor[7];
					var cidade 			= vetor[8];
					var estado 			= vetor[9];
					var cep				= vetor[10];
					
					// insere valores
					$("#nome").val(nome);
					$("#reg_federal").val(reg_federal);
					$("#reg_estadual").val(reg_estadual);
					$("#cep").val(cep);
					$("#endereco").val(endereco);
					$("#numero").val(numero);
					$("#complemento").val(complemento);
					$("#bairro").val(bairro);
					$("#cidade").val(cidade);
					$("#estado_id").val(estado);
				});
			});

		$('#formEmpresa').submit(function(e){
			e.preventDefault();
				$.ajax({
					url:'app/controllers/atualizaEmpresaController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'id_empresa':	$('#editar').val(),
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
			$("#formEmpresa").html(msm);
		}
	});
	mask();
});