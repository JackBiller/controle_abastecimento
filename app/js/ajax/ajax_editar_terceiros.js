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
				url:'app/controllers/editarTerceiroController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'id_terceiros':	$('#editar').val()
				}
			}).done( function(data){
				//cria vetor de valores
				var vetor = data.split(",,");

				// pega os valores
				var descricao = vetor[1];
				
				// insere valores
				$("#descricao").val(descricao);
			});

			$('#formTerceiro').submit(function(e){
				e.preventDefault();
				$.ajax({
					url:'app/controllers/atualizaTerceirosController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'id_terceiros':	$('#editar').val(),
						'descricao': $('#descricao').val()
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