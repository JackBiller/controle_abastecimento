var ultimoValues = 0;

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
				data: {'pesquisa_empresa_select': true}
			}).done( function(data){
				$("#selectEmpresa").html(data);
			});
			$.ajax({
				url:'app/controllers/funcoesController.php',
				type: 'POST',
				dataType: 'html',
				data: {'pesquisa_bomba_select': true}
			}).done( function(data){
				$("#selectBomba").html(data);

				$.ajax({
					url:'app/controllers/funcoesController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'pesquisa_mim_max_entrada' : true,
						'id_entrada':	$('#editar').val()
					}
				}).done( function(data){
					var vetor = data.split(",,");

					var vlr_min = vetor[0];
					var vlr_max = vetor[1];

					vlr_min = formatarValores(vlr_min);
					vlr_max = formatarValores(vlr_max);

					$("#vlr_min").val("Lt: "+vlr_min);
					$("#vlr_max").val("Lt: "+vlr_max);
				});
				$.ajax({
					url:'app/controllers/editarEntradaController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'id_entrada':	$('#editar').val()
					}
				}).done( function(data){
					//cria vetor de valores
					var vetor = data.split(",,");

					// pega os valores
					var empresa_id 		= vetor[2];
					var bomba_id 		= vetor[3];
					var num_nfe 		= vetor[4];
					var data_entrada 	= vetor[5];
					var mes 			= vetor[6];
					var ano 			= vetor[7];
					var qtd_litros 		= vetor[8];
					var vlr_unit 		= vetor[9];
					var total 			= vetor[10];

					atualizaValoresEditar(qtd_litros);

					qtd_litros = formatarValores(qtd_litros);
					vlr_unit = formatarValores(vlr_unit);
					total = formatarValores(total);
					
					// insere valores
					$("#empresa_id").val(empresa_id);
					$("#bomba_id").val(bomba_id);
					$("#num_nfe").val(num_nfe);
					$("#data_entrada").val(data_entrada);
					$("#qtd_litros").val(qtd_litros);
					$("#vlr_unit").val("R$"+vlr_unit);
					$("#total").val("R$"+total);

					document.getElementById('bomba_id').disabled = true;
				});
			});

			$('#formEntrada').submit(function(e){
				e.preventDefault();

				// Formatar valores
				var qtd_litros = $("#qtd_litros").val();
				qtd_litros = qtd_litros.replace(",", ".");
				qtd_litros = parseFloat(qtd_litros);

				var vlr_unit = $("#vlr_unit").val();
				vlr_unit = vlr_unit.substring(2, vlr_unit.length);
				vlr_unit = vlr_unit.replace(",", ".");
				vlr_unit = parseFloat(vlr_unit);

				var total = $("#total").val();
				total = total.substring(2, total.length);
				total = total.replace(",", ".");
				total = parseFloat(total);

				// Formatar Data
				var data_entrada = $("#data_entrada").val();
				// console.log("data_entrada: "+data_entrada);
				var vetor = data_entrada.split("-");
				var mes = vetor[1];
				var ano = vetor[0];

				$.ajax({
					url:'app/controllers/entradaController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'id_usuario': $('#id_usuario').val(),
						'bomba_id': $('#bomba_id').val(),
						'empresa_id': $('#empresa_id').val(),
						'num_nfe': $('#num_nfe').val(),
						'data_entrada': data_entrada,
						'mes': mes,
						'ano': ano,
						'qtd_litros': qtd_litros,
						'vlr_unit': vlr_unit,
						'total': total
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
			$("#formEntrada").html(msm);
		}
	});
	mask();
});

function atualizaValoresEditar(qtd_litros){
	var bomba = $("#bomba_id").val();
	$.ajax({
		url:'app/controllers/funcoesController.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'atualiza_valores': true,
			'bomba': bomba
		}
	}).done( function(data){
		var vetor = data.split(",,");

		var volume_atual = vetor[0];
		var volume_total = vetor[1];

		volume_atual = parseFloat(volume_atual) - parseFloat(qtd_litros);

		volume_atual = formatarValores(volume_atual);
		volume_total = formatarValores(volume_total);

		$("#volume_atual").val("Lt: "+volume_atual);
		$("#volume_total").val("Lt: "+volume_total);
	});
}

function calcTotal(){
	var qtd_litros = $("#qtd_litros").val();
	var vlr_unit = $("#vlr_unit").val();
	if (qtd_litros != '' && vlr_unit != '') {
		qtd_litros = qtd_litros.replace(",", ".");
		qtd_litros = parseFloat(qtd_litros);

		vlr_unit = vlr_unit.substring(2, vlr_unit.length);
		vlr_unit = vlr_unit.replace(",", ".");
		vlr_unit = parseFloat(vlr_unit);
		
		var total = qtd_litros * vlr_unit;
		total = formatarValores(total);
		$("#total").val("R$"+total);
	}
}

function verificarEntrada(){
	var qtd_litros = $("#qtd_litros").val();
	qtd_litros = qtd_litros.replace(",", ".");
	qtd_litros = parseFloat(qtd_litros);

	var vlr_min = $("#vlr_min").val();
	vlr_min = vlr_min.substring(3, vlr_min.length);
	vlr_min = vlr_min.replace(",", ".");
	vlr_min = parseFloat(vlr_min);
	
	var volume_atual = $("#volume_atual").val();
	volume_atual = volume_atual.substring(3, volume_atual.length);
	volume_atual = volume_atual.replace(",", ".");
	volume_atual = parseFloat(volume_atual);
	
	var volume_total = $("#volume_total").val();
	volume_total = volume_total.substring(3, volume_total.length);
	volume_total = volume_total.replace(",", ".");
	volume_total = parseFloat(volume_total);

	var comoFicaria = qtd_litros + volume_atual;

	if (comoFicaria > volume_total) {
		$.toast({
			text: "Valor inválido para Entrada pois a soma do valor atual com esse é maior que o volume total da bomba!", 
			heading: 'Valor Inválido Para Entrada', 
			icon: 'error', 
			showHideTransition: 'slide', 
			allowToastClose: true, 
			hideAfter: 5000, 
			stack: 5, 
			position: 'bottom-left',
			extAlign: 'left',
			loader: true,
			loaderBg: '#44f'
		});
			$("#qtd_litros").val(ultimoValues);
		calcTotal();
	} else if (comoFicaria < vlr_min) {
		$.toast({
			text: "Valor inválido para Entrada pois a soma do valor atual com esse é maior que o volume total da bomba!", 
			heading: 'Valor Inválido Para Entrada', 
			icon: 'error', 
			showHideTransition: 'slide', 
			allowToastClose: true, 
			hideAfter: 5000, 
			stack: 5, 
			position: 'bottom-left',
			extAlign: 'left',
			loader: true,
			loaderBg: '#44f'
		});
		document.getElementById("enviar").disabled = true;
		calcTotal();
	} else {
		document.getElementById("enviar").disabled = false;
	}
}

function ultimoValor(){
	console.log($("#qtd_litros").val());
	ultimoValues = $("#qtd_litros").val();
}

function formatarValores(valor){
	valor = parseFloat(valor);
	valor = valor.toFixed(2);
	valor = valor.replace(".", ",");
	return valor;
}