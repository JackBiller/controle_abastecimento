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
				url:'app/controllers/editarBombaController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'id_bomba':	$('#editar').val()
				}
			}).done( function(data){
				//cria vetor de valores
				var vetor = data.split(",,");

				// pega os valores
				var descricao    = vetor[1];
				var volume_atual = vetor[2];
				var volume_total = vetor[3];
				
				// insere valores
				$("#descricao").val(descricao);
				$("#volume_atual").val(volume_atual);
				$("#volume_total").val(volume_total);
			});

		$('#formBomba').submit(function(e){
			e.preventDefault();
				var volume_atual = $('#volume_atual').val();
				var volume_total = $('#volume_total').val();
				volume_atual = volume_atual.replace(",", ".");
				volume_total = volume_total.replace(",", ".");
				$.ajax({
					url:'app/controllers/atualizaBombaController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'id_bomba':		$('#editar').val(),
						'descricao':  	$('#descricao').val(),
						'volume_atual': volume_atual,
						'volume_total': volume_total
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
			$("#formBomba").html(msm);
		}
	});
	mask();
});