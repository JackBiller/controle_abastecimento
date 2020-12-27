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
			if (bomba) {
				$.ajax({
					url:'app/controllers/funcoesBombaController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'pesquisa_caminhao': true
					}
				}).done( function(data){
					$("#conteudoBomba").html(data);
				});
			}
			$('#formBomba').submit(function(e){
				e.preventDefault();
				var volume_atual = $('#volume_atual').val();
				var volume_total = $('#volume_total').val();
				volume_atual = volume_atual.replace(",", ".");
				volume_total = volume_total.replace(",", ".");
				$.ajax({
					url:'app/controllers/bombaController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'descricao': $('#descricao').val(),
						'volume_atual': volume_atual,
						'volume_total': volume_total
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
						$('#descricao').val('');
						$('#volume_atual').val('');
						$('#volume_total').val('');
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
			$("#formBomba").html(msm);
		}
	});
	mask();
});