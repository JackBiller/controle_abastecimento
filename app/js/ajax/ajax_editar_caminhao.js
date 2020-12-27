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
				$.ajax({
					url:'app/controllers/editarCaminhaoController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'id_caminhao':	$('#editar').val()
					}
				}).done( function(data){
					//cria vetor de valores
					var vetor = data.split(",,");

					// pega os valores
					var placa 				= vetor[1];
					var cor_id 				= vetor[2];
					var proprietario_id 	= vetor[3];
					var marca_id			= vetor[4];
					var vin_media			= vetor[5];
					
					// insere valores
					$("#placa").val(placa);
					$("#cor_id").val(cor_id);
					$("#proprietario_id").val(proprietario_id);
					$("#marca_id").val(marca_id);

					if (vin_media == 1 || vin_media == "1") {
						document.getElementById("vinculo").click();
					}
				});
			});

			$('#formClienteCiaEnergia').submit(function(e){
				e.preventDefault();
				var placa = $("#placa").val();
				placa = placa.toUpperCase();

				if ($("#vin_media").val() == "sim") {
					var vin_media = 1;
				} else var vin_media = 0;

				$.ajax({
					url:'app/controllers/atualizaCaminhaoController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'id_caminhao':		$('#editar').val(),
						'placa':  			$('#placa').val(),
						'cor_id':			$('#cor_id').val(),
						'proprietario_id': 	$("#proprietario_id").val(),
						'marca_id':     	$('#marca_id').val(),
						'vin_media': 		vin_media
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
						listaPLaca();
						listaPLacaVin();
						listaPLacaNVin();
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