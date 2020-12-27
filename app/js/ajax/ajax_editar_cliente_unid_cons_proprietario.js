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
			'table': 	  "cliente_unid_cons_proprietario"
		}
	}).done( function(data){
		if (data == "1") {

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
				url:'app/controllers/editarUnidConsProprietarioController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'preenche_campos_unid_cons': true,
					'id_unid_cons_proprietario': $('#editar').val()
				}
			}).done( function(data){
				console.log(data);
				//cria vetor de valores
				var vetor = data.split(",,");

				// pega os valores
				var cliente_unid_cons_proprietario	= vetor[2];
				var pessoa_tipo						= vetor[3];
				var reg_federal						= vetor[4];
				var reg_estadual					= vetor[5];
				var profissao						= vetor[6];
				var nacionalidade					= vetor[7];
				var representante					= vetor[8];
				var estado_civil					= vetor[9];
				var endereco						= vetor[10];
				var numero							= vetor[11];
				var complemento						= vetor[12];
				var bairro							= vetor[13];
				var cep								= vetor[14];
				var cidade							= vetor[15];
				var estado							= vetor[16];
				var telefone						= vetor[17];
				var celular							= vetor[18];
				var nextel							= vetor[19];
				
				// insere valores
				$('#cliente_unid_cons_proprietario').val(cliente_unid_cons_proprietario);
				// $('#pessoa_tipo').val(pessoa_tipo);
				if (pessoa_tipo == 'f') {
					$('#representante_f').val(representante);
					$('#reg_federal_f').val(reg_federal);
					$('#reg_estadual_f').val(reg_estadual);
				} else {
					$('#representante_j').val(representante);
					$('#reg_federal_j').val(reg_federal);
					$('#reg_estadual_j').val(reg_estadual);
				}				
				$('#estado_civil').val(estado_civil);
				$('#profissao').val(profissao);
				$('#nacionalidade').val(nacionalidade);
				$('#cep').val(cep);
				$('#endereco').val(endereco);
				$('#numero').val(numero);
				$('#complemento').val(complemento);
				$('#bairro').val(bairro);
				$('#cidade').val(cidade);
				$('#estado').val(estado);
				$('#telefone').val(telefone);
				$('#celular').val(celular);
				$('#nextel').val(nextel);
			});

	$('#formClienteUnidCons').submit(function(e){
		if ($("#pessoa_tipo").val() == 'f') {
			$.ajax({
				url:'app/controllers/atualizaUnidConsProprietarioController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'operacao': 						'U',
					'pessoa_fisica': 					true,
					'cliente_unid_cons_proprietario': 	$('#cliente_unid_cons_proprietario').val(),
					'pessoa_tipo': 						$('#pessoa_tipo').val(),
					'nacionalidade': 					$('#nacionalidade').val(),
					'reg_federal': 						$('#reg_federal_f').val(),
					'reg_estadual': 					$('#reg_estadual_f').val(),
					'estado_civil': 					$('#estado_civil').val(),
					'profissao': 						$('#profissao').val(),
					'representante': 					$('#representante_f').val(),
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
					'id_unid_cons_proprietario': 		$('#editar').val()
				}									
			}).done( function(data){
				verificaAlteracao(data);
			});
		} else{
			// reg_estadual = reg_estadual.toUpperCase();					
			// estado = estado.toUpperCase();
			$.ajax({
				url:'app/controllers/atualizaUnidConsProprietarioController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'operacao': 						'U',
					'pessoa_juridica': 					true,
					'cliente_unid_cons_proprietario': 	$('#cliente_unid_cons_proprietario').val(),
					'pessoa_tipo': 						$('#pessoa_tipo').val(),
					'reg_federal': 						$('#reg_federal_j').val(),
					'representante': 					$('#representante_j').val(),
					'reg_estadual': 					$('#reg_estadual_j').val(),
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
					'id_unid_cons_proprietario': 		$('#editar').val()
				}
			}).done( function(data){
				verificaAlteracao(data);
			});
		}
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