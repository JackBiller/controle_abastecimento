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
		console.log(data);
		if (data == "1") {
			if (saida) {
				$.ajax({
					url:'app/controllers/funcoesController.php',
					type: 'POST',
					dataType: 'html',
					data: {'pesquisa_ano_saida_select': true}
				}).done( function(data){
					$("#selectAnoDinamico").html(data);
					$.ajax({
						url:'app/controllers/funcoesController.php',
						type: 'POST',
						dataType: 'html',
						data: {'pesquisa_bomba_select_ex': true}
					}).done( function(data){
						$("#selectBomba").html(data);
						atualizaValores();
						definirData();
					});
				});
			} else {
				$.ajax({
					url:'app/controllers/funcoesController.php',
					type: 'POST',
					dataType: 'html',
					data: {'pesquisa_terceiros_select': true}
				}).done( function(data){
					$("#selectTerceiros").html(data);
				});
				$.ajax({
					url:'app/controllers/funcoesController.php',
					type: 'POST',
					dataType: 'html',
					data: {'pesquisa_bomba_select': true}
				}).done( function(data){
					$("#selectBomba").html(data);
					atualizaValores();
				});
			}
			$('#formSaida').submit(function(e){
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
				console.log("mes: "+mes);
				var ano = vetor[0];
				console.log("ano: "+ano);


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
						$("#num_nfe").val('');
						$("#data_entrada").val('');
						$("#qtd_litros").val('');
						$("#total").val('');
						atualizaValores();
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
			$("#formMedia").html(msm);
		}
	});
	mask();
});

function atualizaValores(){
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

		volume_atual = parseFloat(volume_atual);
		volume_atual = volume_atual.toFixed(2);
		volume_atual = volume_atual.replace(".", ",");
		volume_total = parseFloat(volume_total);
		volume_total = volume_total.toFixed(2);
		volume_total = volume_total.replace(".", ",");

		$("#volume_atual").val("Lt: "+volume_atual);
		$("#volume_total").val("Lt: "+volume_total);
		$("#qtd_litros").val("");
		$("#vlr_unit").val("");
		$("#total").val("");
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
		total = total.toFixed(2);
		total = total.replace(".", ",");
		$("#total").val("R$"+total);
	}
}

function verificarEntrada(){
	var qtd_litros = $("#qtd_litros").val();
	qtd_litros = qtd_litros.replace(",", ".");
	qtd_litros = parseFloat(qtd_litros);
	
	var volume_atual = $("#volume_atual").val();
	volume_atual = volume_atual.substring(3, volume_atual.length);
	volume_atual = volume_atual.replace(".", ",");
	volume_atual = parseFloat(volume_atual);
	
	var volume_total = $("#volume_total").val();
	volume_total = volume_total.substring(3, volume_total.length);
	volume_total = volume_total.replace(".", ",");
	volume_total = parseFloat(volume_total);

	var comoFicaria = qtd_litros + volume_atual;

	if (comoFicaria > volume_total ) {
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
	}
}

function ultimoValor(){
	console.log($("#qtd_litros").val());
	ultimoValues = $("#qtd_litros").val();
}

function definirData(){
	var d = new Date();
	mes = d.getMonth();
	if (mes == 11) {
		mes = 1;
	} else{
		mes = parseInt(mes) + 1;
	}
	ano = d.getFullYear();
	$("#mes").val(mes);
	$("#selectMes").val(mes);
	$("#ano").val(ano);
	$("#selectAno").val(ano);

	preencherCampos();
}

function definiMes(){
	var mes = $("#selectMes").val();
	$("#mes").val(mes);

	preencherCampos();
}

function definiAno(){
	var ano = $("#selectAno").val();
	$("#ano").val(ano);

	preencherCampos();
}

function definiBomba(){
	var bomba = $("#bomba_id").val();
	$("#bomba_id").val(bomba);

	preencherCampos();
}




// function preencherCampos(){
// 	$.ajax({
// 		url:'app/controllers/funcoesAcertoController.php',
// 		type: 'POST',
// 		dataType: 'html',
// 		data: {
// 			'bomba_id': $("#bomba_id").val(),
// 			'placa': $("#caminhao_id").val()
// 		}
// 	}).done( function(data){
// 		$("#conteudoSaida").html(data);
// 	});
// }

function preencherCampos(){
	$.ajax({
		url:'app/controllers/funcoesMediaController.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'mes':   $("#mes").val(),
			'ano':   $("#ano").val(),
			'bomba': $("#bomba_id").val(),
			'placa': $("#caminhao_id").val()
		}
	}).done( function(data){
		$("#conteudoSaida").html(data);
	});
}

function valorUnitario(documento){
	if (documento.checkValidity()) {
		var data = documento.value;
		$.ajax({
			url:'app/controllers/funcoesController.php',
			type: 'POST',
			dataType: 'html',
			data: {
				'pesquisa_vlr_unit_data_select': true,
				'data': data
			}
		}).done( function(data){
			if (data != '') {
				data = parseFloat(data);
				data = data.toFixed(2);
				data = data.replace(".", ",");
				$("#vlr_unit").val("R$"+data);
				calcTotal();
			}
		});
	}
}