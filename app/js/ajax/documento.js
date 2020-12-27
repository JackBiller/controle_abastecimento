$(document).ready(function(){
	var msm = '';
	var list = "";
	var orientacao = 0;
	var orientacaoL = "";
	var tipoFiltroL = "";
	var idFiltroL = "";

	var filtro = 0;
	var tipoFiltro = "c";
	var idFiltro = 0;

	$.ajax({
		url:'app/controllers/conf_operacao.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'id_usuario': $('#id_usuario').val(),
			'senha': 	  $("#pwd").val()

		}	}).done( function(data){
			console.log(data);
			if (data != "1") {
				msm  = '<h1 class="text-center">';
				msm += '	  Você não esta logado para esse tipo de operação';
				msm += '</h1>';
				$("#formClienteUnidCons").html(msm);
			} else {
				$.ajax({
					url:'app/controllers/funcoesController.php',
					type: 'POST',
					dataType: 'html',
					data: {'pesquisa_terceiros_doc_select': true}
				}).done( function(data){
					$("#selectTerceiros").html(data);
				});
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
					});
				});
			}
		});
		mask();
	});

function gerarLinkEntrada(){
	var dt_inicial = document.getElementById('dt_inicial_entrada');
	var dt_final = document.getElementById('dt_final_entrada');
	var dia = 0;
	var mes = 0;
	var ano = 0;
	var bomba = 0;
	if (dt_inicial.checkValidity() && dt_final.checkValidity()) {
		dt_inicial = dt_inicial.value;
		dt_final = dt_final.value;

		var vetor = dt_inicial.split("-");
		dia = vetor[2];
		mes = vetor[1];
		mes = parseInt(mes) - 1;
		ano = vetor[0];

		dt_inicial = moment(dt_inicial);

		var vetor = dt_final.split("-");
		dia = vetor[2];
		mes = vetor[1];
		mes = parseInt(mes) - 1;
		ano = vetor[0];

		dt_final = moment(dt_final);
		console.log("dt_final"+dt_final);
		var diferenca = dt_final.diff(dt_inicial, 'days');
		console.log("diferenca"+diferenca);

		if (diferenca < 0) {
			var link  = "<button class=\"btn btn-primary btn-block\" onclick=\"gerarLinkEntrada()\">";
			link 	 += "	Verica dados";
			link 	 += "</button>";
			// var link  = "<a href=\"#!relatorio\" class=\"btn btn-danger btn-block\" onclick='dataInvalida();'>";
			// link 	 += "	Gerar em PDF";
			// link 	 += "</a>";
			document.getElementById('gerarEntradaPDF').innerHTML = link;

		} else {
			dt_inicial = document.getElementById('dt_inicial_entrada').value;
			dt_final = document.getElementById('dt_final_entrada').value;
			bomba = document.getElementById('bomba_id').value;

			var url = "app/documento/entradaPDF.php";
			bomba = "?bomba_id="+bomba;
			orientacaoL = "&orientacao="+orientacao;
			dt_inicial = "&dt_inicial="+dt_inicial;
			dt_final = "&dt_final="+dt_final;

			var href = url+bomba+orientacaoL+dt_inicial+dt_final;

			var link  = "<a href=\""+href+"\" class=\"btn btn-danger btn-block\" target=\"_blanck\">";
			link 	 += "	Gerar em PDF";
			link 	 += "</a>";
			document.getElementById('gerarEntradaPDF').innerHTML = link;
		}
	}
}



function gerarLinkSaida(){
	var dt_inicial = document.getElementById('dt_inicial_saida');
	console.log("dt_inicial", dt_inicial);
	var dt_final = document.getElementById('dt_final_saida');
	console.log("dt_final", dt_final);
	var dia = 0;
	var mes = 0;
	var ano = 0;
	var bomba = 0;
	if (dt_inicial.checkValidity() && dt_final.checkValidity()) {
		dt_inicial = dt_inicial.value;
		dt_final = dt_final.value;

		var vetor = dt_inicial.split("-");
		dia = vetor[2];
		mes = vetor[1];
		mes = parseInt(mes) - 1;
		ano = vetor[0];

		dt_inicial = moment(dt_inicial);

		var vetor = dt_final.split("-");
		dia = vetor[2];
		mes = vetor[1];
		mes = parseInt(mes) - 1;
		ano = vetor[0];

		dt_final = moment(dt_final);
		console.log("dt_final"+dt_final);
		var diferenca = dt_final.diff(dt_inicial, 'days');
		console.log("diferenca"+diferenca);

		if (diferenca < 0) {

			var link  = "<button class=\"btn btn-primary btn-block\" onclick=\"gerarLinkSaida()\">";
			link 	 += "	Verica dados";
			link 	 += "</button>";			
			
			document.getElementById('gerarSaidaPDF').innerHTML = link;

		} else {
			dt_inicial = document.getElementById('dt_inicial_saida').value;
			dt_final = document.getElementById('dt_final_saida').value;
			bomba = document.getElementById('bomba_id').value;

			var url = "app/documento/saidaPDF.php";
			bomba = "?bomba_id="+bomba;
			orientacaoL = "&orientacao="+orientacao;
			dt_inicial = "&dt_inicial="+dt_inicial;
			dt_final = "&dt_final="+dt_final;

			if (document.getElementById('vinculaFiltro').checked) {
				filtro = 1;
				if (tipoFiltro == 'c') {
					$.ajax({
						url:'app/controllers/funcoesController.php',
						type: 'POST',
						dataType: 'html',
						data: {
							'pega_id_caminhao': true,
							'placa': $("#caminhao_id").val()
						}
					}).done( function(data){
						console.log(data);
						if (data != 0 || data != "0") {
							var vetor = data.split(",,");
							idFiltro = vetor[0];
							console.log("idFiltro", idFiltro);
						} else {
							idFiltro = 0;
							console.log("idFiltro", idFiltro);
						}
					});	
				} else if (tipoFiltro == 't') {
					idFiltro = document.getElementById('terceiros_id').value;
					console.log("idFiltro", idFiltro);
				} else {
					idFiltro = 0;
				}
			} else {
				filtro = 0;
				tipoFiltro = 0;
			}

			console.log("filtro", filtro);
			if (filtro == 1 || filtro == "1") {
				if (idFiltro != 0) {
					tipoFiltroL = "&tipoFiltro="+tipoFiltro;
					console.log("tipoFiltro", tipoFiltro);
					idFiltroL = "&idFiltro="+idFiltro;
					console.log("idFiltro", idFiltro);
					var href = url+bomba+orientacaoL+dt_inicial+dt_final+tipoFiltroL+idFiltroL;
				} else {
					var href = "#!relatorio";
				}
			} else {
				tipoFiltroL = "&tipoFiltro=";
				idFiltroL = "&idFiltro=";

				var href = url+bomba+orientacaoL+dt_inicial+dt_final+tipoFiltroL+idFiltroL;
				console.log("href", href);
			}

			console.log("href", href);
			if (href == "#!relatorio") {
				var link  = "<button class=\"btn btn-primary btn-block\" onclick=\"gerarLinkSaida()\">";
				link 	 += "	Verica dados";
				link 	 += "</button>";
			} else {
				var link  = "<a href=\""+href+"\" class=\"btn btn-danger btn-block\" target=\"_blanck\">";
				link 	 += "	Gerar em PDF";
				link 	 += "</a>";
			}
			console.log("link", link);
			document.getElementById('gerarSaidaPDF').innerHTML = link;
		}
	}
}

function gerarLinkSaidaTodos(){
	var url = "app/documento/saidaPDF.php";
	var bomba = "?bomba_id="+bomba;
	var orientacaoL = "&orientacao="+orientacao;

	var href = url+bomba+orientacaoL+"&dt_inicial=&dt_final=&tipoFiltro=&idFiltro=";

	var link  = "<a href=\""+href+"\" class=\"btn btn-danger btn-block\" target=\"_blanck\">";
	link 	 += "	Gerar em PDF";
	link 	 += "</a>";

	document.getElementById('gerarSaidaPDFall').innerHTML = link;
}


function gerarLinkMedia(){
	var dt_inicial = document.getElementById('dt_inicial_media');
	console.log("dt_inicial", dt_inicial);
	var dt_final = document.getElementById('dt_final_media');
	console.log("dt_final", dt_final);
	var dia = 0;
	var mes = 0;
	var ano = 0;
	var bomba = 0;
	if (dt_inicial.checkValidity() && dt_final.checkValidity()) {
		dt_inicial = dt_inicial.value;
		dt_final = dt_final.value;

		var vetor = dt_inicial.split("-");
		dia = vetor[2];
		mes = vetor[1];
		mes = parseInt(mes) - 1;
		ano = vetor[0];

		dt_inicial = moment(dt_inicial);

		var vetor = dt_final.split("-");
		dia = vetor[2];
		mes = vetor[1];
		mes = parseInt(mes) - 1;
		ano = vetor[0];

		dt_final = moment(dt_final);
		console.log("dt_final"+dt_final);
		var diferenca = dt_final.diff(dt_inicial, 'days');
		console.log("diferenca"+diferenca);

		if (diferenca < 0) {

			var link  = "<button class=\"btn btn-primary btn-block\" onclick=\"gerarLinkMedia()\">";
			link 	 += "	Verica dados";
			link 	 += "</button>";			
			
			document.getElementById('gerarMediaPDF').innerHTML = link;

		} else {
			dt_inicial = document.getElementById('dt_inicial_media').value;
			dt_final = document.getElementById('dt_final_media').value;
			bomba = document.getElementById('bomba_id').value;

			var url = "app/documento/mediaPDF.php";
			bomba = "?bomba_id="+bomba;
			orientacaoL = "&orientacao="+orientacao;
			dt_inicial = "&dt_inicial="+dt_inicial;
			dt_final = "&dt_final="+dt_final;

			$.ajax({
				url:'app/controllers/funcoesController.php',
				type: 'POST',
				dataType: 'html',
				data: {
					'pega_id_caminhao': true,
					'placa': $("#caminhao_id_vin").val()
				}
			}).done( function(data){
				console.log(data);
				if (data != 0 || data != "0") {
					var vetor = data.split(",,");
					idFiltro = vetor[0];
					console.log("idFiltro", idFiltro);
				} else {
					idFiltro = 0;
					console.log("idFiltro", idFiltro);
				}
			});

			idFiltroL = "&idFiltro="+idFiltro;

			var href = url+bomba+orientacaoL+dt_inicial+dt_final+idFiltroL;
			console.log("href", href);
		}

		console.log("href", href);
		if (href == "#!relatorio") {
			var link  = "<button class=\"btn btn-primary btn-block\" onclick=\"gerarLinkSaida()\">";
			link 	 += "	Verica dados";
			link 	 += "</button>";
		} else {
			var link  = "<a href=\""+href+"\" class=\"btn btn-danger btn-block\" target=\"_blanck\">";
			link 	 += "	Gerar em PDF";
			link 	 += "</a>";
		}
		console.log("link", link);
		document.getElementById('gerarMediaPDF').innerHTML = link;
	}
}








definirOrientacao(0);
vincularFiltro();
definriId();

function definirOrientacao(num){
	orientacao = num;
	gerarLinkSaida();
	gerarLinkEntrada();
}

function vincularFiltro(){
	definriId();
	gerarLinkSaida();
}

function definriId(){
	gerarLinkSaida();
}




// diff data
function dataInvalida(){
	$.toast({
		text: "A data inicial e maior que a data final!", 
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

function dataNula(){
	$.toast({
		text: "Por favor informe a data!", 
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



// padão bomba
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

function definiBomba(){
	var bomba = $("#bomba_id").val();
	$("#bomba_id").val(bomba);
	gerarLinkSaidaTodos();
}