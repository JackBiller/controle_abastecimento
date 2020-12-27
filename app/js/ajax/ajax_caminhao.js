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
			if (caminhao) {
				$.ajax({
					url:'app/controllers/funcoesCaminhaoController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'pesquisa_caminhao': true
					}
				}).done( function(data){
					$("#conteudoCaminhoes").html(data);
				});
			} else {
				$.ajax({
					url:'app/controllers/funcoesController.php',
					type: 'POST',
					dataType: 'html',
					data: {'pesquisa_cor_select': true}
				}).done( function(data){
					$("#selectCor").html(data);
				});
				$.ajax({
					url:'app/controllers/funcoesController.php',
					type: 'POST',
					dataType: 'html',
					data: {'pesquisa_prprietario_select': true}
				}).done( function(data){
					$("#selectProprietario").html(data);
				});
				$.ajax({
					url:'app/controllers/funcoesController.php',
					type: 'POST',
					dataType: 'html',
					data: {'pesquisa_marca_select': true}
				}).done( function(data){
					$("#selectMarca").html(data);
				});
			}
			$('#formClienteCiaEnergia').submit(function(e){
				e.preventDefault();
				var placa = $("#placa").val();
				placa = placa.toUpperCase();

				$.ajax({
					url:'app/controllers/funcoesController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'validar_placa': 	true,
						'placa':			placa
					}
				}).done( function(data){
					console.log(data);
					if (data == '1') {

						if ($("#vin_media").val() == "sim") {
							var vin_media = 1;
						} else var vin_media = 0;

						$.ajax({
							url:'app/controllers/caminhaoController.php',
							type: 'POST',
							dataType: 'html',
							data: {
								'placa':			placa,
								'cor_id': 			$('#cor_id').val(),
								'proprietario_id':	$('#proprietario_id').val(),
								'marca_id': 		$('#marca_id').val(),
								'vin_media': 		vin_media
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
								$('#placa').val('');
								$('#cor_id').val(1);
								$('#proprietario_id').val(1);
								$('#marca_id').val(1);
								listaPLaca();
								listaPLacaVin();
								listaPLacaNVin();
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
					} else {
						$.toast({
							text: "Placa já cadastrada!", 
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
						$('#placa').val('');
						document.getElementById('placa').focus();
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

function filtraPlaca(valor){
	placa = valor.value;
	placa = placa.toUpperCase();
	$.ajax({
		url:'app/controllers/funcoesCaminhaoController.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'pesquisa_caminhao_placa': true,
			'placa': 					placa
		}
	}).done( function(data){
		$("#conteudoCaminhoes").html(data);
	});
}