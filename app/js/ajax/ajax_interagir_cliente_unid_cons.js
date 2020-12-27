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
			'table': 	  "cliente_unid_cons"
		}
	}).done( function(data){
		console.log(data);
		if (data == "1") {

	} else {
		msm  = '<h1 class="text-center">';
		msm += '	  Você não esta logado para esse tipo de operação';
		msm += '</h1>';
		$("#formClienteUnidCons").html(msm);
	}
});
	mask();
});
var pesquisa_click_unid_cons_cond = true;

function gravar_conta(mesAno , operacao){
	if (mesAno == '1') {
		mesAno = $("#mesAnoT").html();
		var vetor = mesAno.split("/");

			 if (vetor[0] == "Jan") vetor[0] =  1;
		else if (vetor[0] == "Fev") vetor[0] =  2;
		else if (vetor[0] == "Mar") vetor[0] =  3;
		else if (vetor[0] == "Abr") vetor[0] =  4;
		else if (vetor[0] == "Mai") vetor[0] =  5;
		else if (vetor[0] == "Jun") vetor[0] =  6;
		else if (vetor[0] == "Jul") vetor[0] =  7;
		else if (vetor[0] == "Ago") vetor[0] =  8;
		else if (vetor[0] == "Set") vetor[0] =  9;
		else if (vetor[0] == "Out") vetor[0] = 10;
		else if (vetor[0] == "Nov") vetor[0] = 11;
		else if (vetor[0] == "Dez") vetor[0] = 12;

		var vlr_distribuicao = $("#vlr_distribuicao").val();
		var vlr_transmissao = $("#vlr_transmissao").val();
		var vlr_encargos = $("#vlr_encargos").val();
		var perc_aliq_icms = $("#perc_aliq_icms").val();
		var inpc = $("#inpc_modal").val();
		var id_inpc = 0;
		var cliente_unid_cons_id = $("#modal_id").val();
		var vlr_subtotal = $("#vlr_subtotal").html();

		$("#fechar_modal").click();
	} else {
		var vetor = mesAno.split("/");
		var vlr_distribuicao = document.getElementById('vlr_distribuicao'+mesAno).value;
		var vlr_transmissao = document.getElementById('vlr_transmissao'+mesAno).value;
		var vlr_encargos = document.getElementById('vlr_encargos'+mesAno).value;
		var perc_aliq_icms = document.getElementById('perc_aliq_icms'+mesAno).value;
		var inpc = document.getElementById("inpc"+mesAno).value;
		var id_inpc = document.getElementById("id_inpc"+mesAno).value;
		var cliente_unid_cons_id = $("#editar").val();
		var vlr_subtotal = document.getElementById("vlr_subtotal"+mesAno).value;
	}
	var vlr_restituicao = '';
	var vlr_subtotal = '';
	var mes = vetor[0];
	var ano = vetor[1];

	if (vlr_distribuicao != "" && vlr_transmissao != "" && vlr_encargos != "" && perc_aliq_icms != "") {
		vlr_restituicao = calculaRestituicao(vlr_distribuicao , vlr_transmissao , vlr_encargos , perc_aliq_icms);
		vlr_distribuicao = passarDecimal(vlr_distribuicao , 'v');
		vlr_transmissao = passarDecimal(vlr_transmissao , 'v');
		vlr_encargos = passarDecimal(vlr_encargos , 'v');
		perc_aliq_icms = passarDecimal(perc_aliq_icms , 'p');
		vlr_subtotal = parseFloat(vlr_restituicao) * parseFloat(inpc);
		// e.preventDefault();
		$.ajax({
			url:'app/controllers/interagirUnidConsController.php',
			type: 'POST',
			dataType: 'html',
			data: {
				"adicionaConta": 			true,
				"operacao": 				operacao,
				"cliente_unid_cons_id" : 	cliente_unid_cons_id,
				"mes" : 					mes,
				"ano" : 					ano,
				"inpc_id" : 				id_inpc,
				"vlr_distribuicao" : 		vlr_distribuicao,
				"vlr_transmissao" : 		vlr_transmissao,
				"vlr_encargos" : 			vlr_encargos,
				"vlr_restituicao" : 		vlr_restituicao,
				"perc_aliq_icms" : 			perc_aliq_icms,
				"vlr_subtotal" : 			vlr_subtotal
			}
		}).done(function(data){
			// console.log(data);
			if (data == '1') {
				atualizarValorCausa();
				$.toast({
					text: "Adicionado com sucesso!", 
					heading: 'Sucesso', 
					icon: 'success', 
					showHideTransition: 'slide', 
					allowToastClose: true, 
					hideAfter: 2500, 
					stack: 5, 
					position: 'bottom-right',
					extAlign: 'left',
					loader: true,
					loaderBg: '#44f'
				});
				document.getElementById("botao"+mesAno).disabled = true;
				document.getElementById("linha"+mesAno).click();
			}else {
				$.toast({
					text: "Falha ao adicionar!", 
					heading: 'Falha', 
					icon: 'error', 
					showHideTransition: 'slide', 
					allowToastClose: true, 
					hideAfter: 2500, 
					stack: 5, 
					position: 'bottom-right',
					extAlign: 'left',
					loader: true,
					loaderBg: '#44f'
				});
			}
		});
		carregaContas();carregaContas();
	} else {
		$.toast({
			text: "Por favor preencha todos os dados!", 
			heading: 'Falha', 
			icon: 'error', 
			showHideTransition: 'slide', 
			allowToastClose: true, 
			hideAfter: 2500, 
			stack: 5, 
			position: 'bottom-right',
			extAlign: 'left',
			loader: true,
			loaderBg: '#44f'
		});
	}
}

function clickCheck(mesAno){
	document.getElementById("botao"+mesAno).disabled = true;
	document.getElementById("linha"+mesAno).click();
	carregaContas();
}

var jaCarregouUmaVez = true;
function carregaContas(){
	if (jaCarregouUmaVez) {
		$("#carregaConta").click();
		jaCarregouUmaVez = false;
	}
	$.ajax({
		url:'app/controllers/interagirUnidConsController.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'pesquisa_unid_cons': true,
			"cliente_unid_cons_id" : 	$("#editar").val()
		}
	}).done( function(data){
		var vetor = data.split(",,");
		var subVetor = "";
		for (var i = vetor.length - 1; i >= 0; i--) {
			$("#linhasContasEdit").html(data);
		}
		if (pesquisa_click_unid_cons_cond) {
			pesquisa_click_unid_cons_conta();
		}
	});
	atualizarValorCausa();
}

function pesquisa_click_unid_cons_conta(){
	if (pesquisa_click_unid_cons_cond) {
		$.ajax({
			url:'app/controllers/interagirUnidConsController.php',
			type: 'POST',
			dataType: 'html',
			data: {
				'pesquisa_click_unid_cons_conta': 	true,
				"cliente_unid_cons_id" : 			$("#editar").val()
			}
		}).done( function(data){
			console.log(data);
			var vetor = data.split(",,");
			for (var i = vetor.length - 1; i >= 0; i--) {
				console.log(vetor[i]);
				document.getElementById("botao"+vetor[i]).disabled = true;
				document.getElementById("linha"+vetor[i]).click();
			}
			pesquisa_click_unid_cons_cond = false;
		});
	}
}

function calculaSubtotal(mesAno){
	condicao = true;
	var vlr_subtotal = "";
	var vlr_restituicao = "";
	if (mesAno == "1") {
		var vlr_distribuicao = $("#vlr_distribuicao").val();
		var vlr_transmissao = $("#vlr_transmissao").val();
		var vlr_encargos = $("#vlr_encargos").val();
		var perc_aliq_icms = $("#perc_aliq_icms").val();
		var inpc = $("#inpc_modal").val();
		condicao = false;
	} else {
		// console.log("calculaSubtotal");
		var vlr_distribuicao = document.getElementById('vlr_distribuicao'+mesAno).value;
		var vlr_transmissao = document.getElementById('vlr_transmissao'+mesAno).value;
		var vlr_encargos = document.getElementById('vlr_encargos'+mesAno).value;
		var perc_aliq_icms = document.getElementById('perc_aliq_icms'+mesAno).value;
		var inpc = document.getElementById("inpc"+mesAno).value;
	}

	if (vlr_distribuicao != "" && vlr_transmissao != "" && vlr_encargos != "" && perc_aliq_icms != "") {
		
		vlr_subtotal = calculaRestituicao(vlr_distribuicao , vlr_transmissao , vlr_encargos , perc_aliq_icms);
		vlr_restituicao = vlr_subtotal;
		vlr_subtotal = parseFloat(vlr_subtotal) * parseFloat(inpc);
		vlr_restituicao = vlr_restituicao.toFixed(2);
		vlr_restituicao = vlr_restituicao.replace(".", ",");
		if (condicao) {
			if (parseFloat(vlr_subtotal) == 0) {
				document.getElementById("botao"+mesAno).disabled = true;
			} else {
				document.getElementById("botao"+mesAno).disabled = false;
			}
		}
		vlr_subtotal = vlr_subtotal.toFixed(2);
		vlr_subtotal = vlr_subtotal.replace(".", ",");
		if (mesAno == "1") {
			$("#vlr_subtotal").html("R$"+vlr_subtotal);
			$("#vlr_restituicao").html("R$"+vlr_restituicao);
		} else {
			document.getElementById('vlr_subtotal'+mesAno).value = "R$"+vlr_subtotal;
		}
	}
}
function calculaRestituicao(vlr_distribuicao , vlr_transmissao , vlr_encargos , perc_aliq_icms){
	var restituicao = "";
	vlr_distribuicao = passarDecimal(vlr_distribuicao , 'v');
	vlr_transmissao = passarDecimal(vlr_transmissao , 'v');
	vlr_encargos = passarDecimal(vlr_encargos , 'v');
	perc_aliq_icms = passarDecimal(perc_aliq_icms , 'p');

	restituicao = parseFloat(vlr_distribuicao) + parseFloat(vlr_transmissao) + parseFloat(vlr_encargos);
	restituicao = parseFloat(restituicao)/100;
	restituicao = parseFloat(restituicao) * parseFloat(perc_aliq_icms);

	return restituicao;
}

function joga_valor_modal(documento , mesAno){	
	var vlr_distribuicao = document.getElementById("modal_distribuicao"+mesAno).innerHTML;
	var vlr_transmissao = document.getElementById("modal_transmissao"+mesAno).innerHTML;
	var vlr_encargos = document.getElementById("modal_encargos"+mesAno).innerHTML;
	var vlr_restituicao = document.getElementById("modal_restituicao"+mesAno).innerHTML;
	var perc_aliq_icms = document.getElementById("modal_perc"+mesAno).innerHTML;
	var vlr_subtotal = document.getElementById("modal_subtotal"+mesAno).innerHTML;

	vlr_distribuicao = formataValores(vlr_distribuicao , 'v');
	vlr_transmissao = formataValores(vlr_transmissao , 'v');
	vlr_encargos = formataValores(vlr_encargos , 'v');
	perc_aliq_icms = formataValores(perc_aliq_icms , 'p');
	vlr_restituicao = formataValores(vlr_restituicao , 'v');
	vlr_subtotal = formataValores(vlr_subtotal , 'v');

	$("#vlr_distribuicao").val("R$"+vlr_distribuicao);
	$("#vlr_transmissao").val("R$"+vlr_transmissao);
	$("#vlr_encargos").val("R$"+vlr_encargos);
	$("#vlr_restituicao").html("R$"+vlr_restituicao);
	$("#perc_aliq_icms").val("%"+perc_aliq_icms);
	$("#vlr_subtotal").html("R$"+vlr_subtotal);
	$("#mesAnoT").html(document.getElementById("modal"+mesAno).innerHTML);
	$("#inpc_modal").val(document.getElementById("inpc"+mesAno).value);
	$("#modal_id").val($(documento).data("id"));
}

function formataValores(valor , tipo){
	if (tipo == 'v') {
		valor = valor.substr(2, valor.length);
		valor = valor.replace(".", "");
		valor = valor.replace(",", ".");
		valor = parseFloat(valor);
		valor = valor.toFixed(2);
		valor = valor.replace(".", ",");
	} else if (tipo == 'p') {
		valor = valor.substr(1, valor.length);
		valor = valor.replace(",", ".");
		valor = parseFloat(valor);
		valor = valor.toFixed(2);
		valor = valor.replace(".", ",");
	}
	return valor;
}
function passarDecimal(valor , tipo){
	if (tipo == 'v') {
		valor = valor.substr(2, valor.length);
		valor = valor.replace(".", "");
		valor = valor.replace(",", ".");
	} else if (tipo == 'p') {
		valor = valor.substr(1, valor.length);
		valor = valor.replace(",", ".");
	}
	return valor;
}

function atualizarValorCausa(){
	$.ajax({
		url:'app/controllers/interagirUnidConsController.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'atualizarValorCausa': 		true,
			"cliente_unid_cons_id" : 	$("#editar").val()
		}
	}).done( function(data){
		console.log(data);
		var vetor = data.split(",,");
		for (var i = vetor.length - 1; i >= 0; i--) {
			console.log(vetor[i]);
			document.getElementById("botao"+vetor[i]).disabled = true;
			document.getElementById("linha"+vetor[i]).click();
		}
		pesquisa_click_unid_cons_cond = false;
	});
}