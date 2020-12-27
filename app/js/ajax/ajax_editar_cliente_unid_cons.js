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
			'table': 	  "cliente_unid_cons"
		}
	}).done( function(data){
		if (data == "1") {

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

			$.ajax({
				url:'app/controllers/editarUnidConsController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'preenche_campos_unid_cons': true,
					'id_unid_cons':	$('#editar').val()
				}
			}).done( function(data){
				console.log(data);
				//cria vetor de valores
				var vetor = data.split(",,");

				// pega os valores
				var nro_instalacao 			= vetor[2];
				var unid_cons_nome_terceiro = vetor[3];
				var classificacao 			= vetor[4];
				var endereco 				= vetor[5];
				var numero 					= vetor[6];
				var complemento 			= vetor[7];
				var bairro 					= vetor[8];
				var cep 					= vetor[9];
				var cidade 					= vetor[10];
				var estado 					= vetor[11];
				var cliente_cia_energia_id 	= vetor[12];
				var situacao			 	= vetor[13];
				var cliente_sec_estado_id 	= vetor[14];
				
				// insere valores
				$("#nro_instalacao").val(nro_instalacao);
				$("#classificacao").val(classificacao);
				$("#cep").val(cep);
				$("#endereco").val(endereco);
				$("#numero").val(numero);
				$("#complemento").val(complemento);
				$("#bairro").val(bairro);
				$("#cidade").val(cidade);
				$("#estado").val(estado);
				$("#cliente_cia_energia_id").val(cliente_cia_energia_id);
				$("#cliente_sec_estado_id").val(cliente_sec_estado_id);

				if (unid_cons_nome_terceiro == 1) {
					$("#check_unid_cons_nome_terceiro").click();
				}
				if (situacao == "2" || situacao == "3" || situacao == "4" || situacao == "5") {
					if (unid_cons_nome_terceiro == 1) {
						var terceiro = "<input type=\"hidden\" id=\"unid_cons_nome_terceiro\" value=\"sim\">"
					} else {
						var terceiro = "<input type=\"hidden\" id=\"unid_cons_nome_terceiro\" value=\"nao\">"
					}
					$("#situacaoTerceiro").html(terceiro);
				}
			});

		$('#formClienteUnidCons').submit(function(e){
			var alugada = $('#unid_cons_nome_terceiro').val();

			if (alugada == 'sim') alugada = 1; else alugada = 0;

			e.preventDefault();
				$.ajax({
					url:'app/controllers/atualizaUnidConsController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'id_unid_cons':				$('#editar').val(),
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
					verificaAlteracao(data);
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

function verificaAlteracao(resultado){
	console.log(resultado);
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