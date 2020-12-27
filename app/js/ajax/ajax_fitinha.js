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
				$.ajax({
					url:'app/controllers/funcoesController.php',
					type: 'POST',
					dataType: 'html',
					data: {'pesquisa_bomba_select': true}
				}).done( function(data){
					$("#selectBomba").html(data);
					atualizaValores();
					preencherCampos();
				});
			// }

			// submeter formulaio de cadastro
			$("#formFitinha").submit(function(e){
				console.log("submeteu66");
				e.preventDefault();
				cadastrarAbastecimento();
				return false;
			});
			
		} else {
			msm  = '<h1 class="text-center">';
			msm += '	  Você não esta logado para esse tipo de operação';
			msm += '</h1>';
			$("#formSaida").html(msm);
		}
	});
});

function cadastrarAbastecimento(){
	console.log("submeteu");
	var caminhao_id = 0;
	var terceiros_id = 0;
	var bool_placa_fit = 0;
	var acerto = 0;


	if (document.getElementById("bool_placa_fit").checked) {
		bool_placa_fit = 1;
		$.ajax({
			url:'app/controllers/funcoesController.php',
			type: 'POST',
			dataType: 'html',
			data: {
				'pega_id_caminhao': true,
				'placa': $("#caminhao_id").val()
			}
		}).done( function(data){
			document.getElementById("bool_placa_fit").click();
			console.log(data);
			if (data != 0 || data != "0") {
				var vetor = data.split(",,");
				caminhao_id = vetor[0];
				if (vetor[1] == 1 || vetor[1] == "1") {
					acerto = 3;
				}
				cadastrasAbastecimento(caminhao_id, terceiros_id, acerto, bool_placa_fit);
			} else {
				$.toast({
					text: "Placa inválida!", 
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
				return false;
			}
		});
	} else {
		cadastrasAbastecimento(caminhao_id, terceiros_id, acerto, bool_placa_fit);
	}
}

function cadastrasAbastecimento(caminhao_id, terceiros_id, acerto, bool_placa_fit){
	// Formatar valores
	var litros = $("#litros").val();
	litros = litros.replace(",", ".");
	litros = parseFloat(litros);
	if (litros <= 0) {
		$.toast({
			text: "A quantidade está inválida!", 
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
		return false;
	}

	var vlr_unit = $("#vlr_unit").val();
	vlr_unit = vlr_unit.substring(2, vlr_unit.length);
	vlr_unit = vlr_unit.replace(",", ".");
	vlr_unit = parseFloat(vlr_unit);
	if (litros <= 0) {
		$.toast({
			text: "0 valor unitario está inválido!", 
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
		return false;
	}

	var total = $("#total").val();
	total = total.substring(2, total.length);
	total = total.replace(",", ".");
	total = parseFloat(total);

	// Formatar Data
	if (!document.getElementById("data_abastecimento").checkValidity()) {
		$.toast({
			text: "Data inválida!", 
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
		return false;
	}
	var data_abastecimento = $("#data_abastecimento").val();
	var vetor = data_abastecimento.split("-");
	var mes = vetor[1];
	console.log("mes: "+mes);
	var ano = vetor[0];
	console.log("ano: "+ano);

	$.ajax({
		url:'app/controllers/saidaFitinhaController.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'cadastraFitinha': true,
			'id_usuario': $('#id_usuario').val(),
			'bomba_id': $('#bomba_id').val(),
			'data_abastecimento': data_abastecimento,
			'horas': $("#horas").val(),
			'caminhao_id': caminhao_id,
			'terceiros_id': terceiros_id,
			'mes': mes,
			'ano': ano,
			'litros': litros,
			'vlr_unit': vlr_unit,
			'total': total,
			"bool_cupom": 0,
			"bool_fitinha": 1,
			"bool_acerto": acerto,
			"bool_placa_fit": bool_placa_fit
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
			$("#horas").val('');
			$("#litros").val('');
			$("#total").val('');
			document.getElementById("bool_placa_fit").checked = false;
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

}

function salvarFitinhaT(id){
	var horas = document.getElementById("horas__"+id).value;
	if (horas != "" && horas != "__:__") {

		var bool_placa_fit = 0;
		if (document.getElementById("bool_placa_fit__"+id).checked) {
			console.log("bool_placa_fit: "+bool_placa_fit);
			bool_placa_fit = 1;
		}
		$.ajax({
			url:'app/controllers/saidaFitinhaController.php',
			type: 'POST',
			dataType: 'html',
			data: {
				'pendenteFitinha': true,
				'id_abastecimento': id,
				'horas': horas,
				'bool_fitinha': 1,
				"bool_placa_fit": bool_placa_fit
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
				preencherCampos2();
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
			text: "O campo 'hora' não pode ser vazio!", 
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
		$("#litros").val("");
		$("#total").val("");
	});
	preencherCampos2();
}

function calcTotal(){
	var litros = $("#litros").val();
	var vlr_unit = $("#vlr_unit").val();
	if (litros != '' && vlr_unit != '') {
		litros = litros.replace(",", ".");
		litros = parseFloat(litros);

		vlr_unit = vlr_unit.substring(2, vlr_unit.length);
		vlr_unit = vlr_unit.replace(",", ".");
		vlr_unit = parseFloat(vlr_unit);
		
		var total = litros * vlr_unit;
		total = total.toFixed(2);
		total = total.replace(".", ",");
		$("#total").val("R$"+total);
	}
}

function verificarEntrada(){
	var litros = $("#litros").val();
	litros = litros.replace(",", ".");
	litros = parseFloat(litros);
	
	var volume_atual = $("#volume_atual").val();
	volume_atual = volume_atual.substring(3, volume_atual.length);
	volume_atual = volume_atual.replace(".", ",");
	volume_atual = parseFloat(volume_atual);

	if (litros > volume_atual) {
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
		$("#litros").val(ultimoValues);
		calcTotal();
	}
}

function ultimoValor(){
	console.log($("#litros").val());
	ultimoValues = $("#litros").val();
}
function preencherCampos(){
	$.ajax({
		url:'app/controllers/funcoesFitinhaController.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'bomba_id': $("#bomba_id").val()
		}
	}).done( function(data){
		$("#conteudoSaida").html(data);
		mask();
	});
}

function preencherCampos2(){
	$.ajax({
		url:'app/controllers/funcoesFitinhaController.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'bomba_id': $("#bomba_id").val()
		}
	}).done( function(data){
		$("#conteudoSaida").html(data);

		$.mask.definitions['H'] = "[0-2]";
		$.mask.definitions['h'] = "[0-9]";
		$.mask.definitions['O'] = "[0-5]";
		$.mask.definitions['m'] = "[0-9]";
		$("input[rel=hora], input[data-mask=hora]").mask("Hh:Om");
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