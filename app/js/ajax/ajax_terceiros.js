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
			if (terceiros) {
				$.ajax({
					url:'app/controllers/funcoesTerceiroController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'pesquisa_caminhao': true
					}
				}).done( function(data){
					$("#conteudoTerceiros").html(data);
				});
			}
			$('#formTerceiro').submit(function(e){
				e.preventDefault();
				$.ajax({
					url:'app/controllers/terceiroController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'descricao': $('#descricao').val()
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
			$("#formTerceiro").html(msm);
		}
	});
	mask();
});