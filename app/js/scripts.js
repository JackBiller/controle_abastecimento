function editar(el){
	var id_cliente_unid_cons = $(el).data("id");
	$("#editar").val(id_cliente_unid_cons);
}

function n_editar(){
	$("#editar").val(0);
}

function maius(obj){
    obj.value = obj.value.toUpperCase();
}

function excluir(el , table){
	bootbox.confirm({
		title: "Tem certeza que deseja excluir este cadastro?",
		message: "Ao aperta o botão \"Sim\" você irá excluir este cadastro por completo do sistema",
		buttons: {
			confirm: {
				label: 'Sim',
				className: 'btn-success'
			},
			cancel: {
				label: 'Não',
				className: 'btn-danger'
			}
		},
		callback: function (result) {
			if (result) {
				$.ajax({
					url:'app/controllers/funcoesController.php',
					type: 'POST',
					dataType: 'html',
					data: {
						'excluir_unid_cons'	: true,
						'id'				: $(el).data("id"),
						'table' 			: table,
					}
				}).done( function(data){
					if (data == "1") {
						$.toast({
							text: "Excuido com sucesso!", 
							heading: 'Excluido', 
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
						$("#linha"+$(el).data("id")).remove();
					} else {
						$.toast({
							text: data, 
							heading: "Falha ao Excuir!", 
							icon: 'info', 
							showHideTransition: 'slide', 
							allowToastClose: true, 
							hideAfter: 3500, 
							stack: 5, 
							position: 'bottom-left',
							extAlign: 'left',
							loader: true,
							loaderBg: '#44f'
						});
					}
				});
			}
		}
	});
}

var condicaoInpc = true;
function valorInpc(){
	if (condicaoInpc) {
		$.ajax({
			url:'app/controllers/interagirUnidConsController.php',
			type: 'POST',
			dataType: 'html',
			data: {
				'inpc': true
			}
		}).done( function(data){
			if (data != null) {
				var cont = 0;
				var vetor = data.split(",,");
				var subVetor = "";
				for (var i = 0; i < vetor.length; i++) {
					cont++;
					subVetor = vetor[i].split(",");
					document.getElementById("inpc"+subVetor[1]).value = subVetor[2];
					document.getElementById("id_inpc"+subVetor[1]).value = subVetor[0];
				}
				if (cont >= 59) {
					condicaoInpc = false;
				}
			}
		});
	}
}

function liberarParaGerar(){
	document.getElementById("gerar_documentacao").disabled = false;
}

function atualizar_sitiacao(situacao){
	$.ajax({
		url:'app/controllers/funcoesController.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'atualiza_situacao': true,
			'id_unid_cons': 	 $('#editar').val()
		}
	}).done( function(data){
		alteradoParaAtualizar();
	});
}

function listaPLaca(){
	$.ajax({
		url:'app/controllers/funcoesController.php',
		type: 'POST',
		dataType: 'html',
		data: {'pesquisa_caminhao_select': true}
	}).done( function(data){
		console.log(data);
		$("#listaCaminhao").html(data);
	});
}

function listaPLacaVin(){
	$.ajax({
		url:'app/controllers/funcoesController.php',
		type: 'POST',
		dataType: 'html',
		data: {'pesquisa_caminhao_vin_select': true}
	}).done( function(data){
		console.log(data);
		$("#listaCaminhaoVin").html(data);
	});
}

function listaPLacaNVin(){
	$.ajax({
		url:'app/controllers/funcoesController.php',
		type: 'POST',
		dataType: 'html',
		data: {'pesquisa_caminhao_n_vin_select': true}
	}).done( function(data){
		console.log(data);
		$("#listaCaminhaoNVin").html(data);
	});
}

function mask(){
	jQuery(function($){
		$('.cpf').mask("999.999.999-99");
		$('.rg').mask("aa-99.999.999");
		$('.cnpj').mask("99.999.999/9999-9");

		$('.telefone').mask("(99) 9999-9999");
		$('.celular').mask("(99) 9 9999-9999");

		$('.cep').mask("99.999-999");
	});

	$.mask.definitions['H'] = "[0-2]";
	$.mask.definitions['h'] = "[0-9]";
	$.mask.definitions['O'] = "[0-5]";
	$.mask.definitions['m'] = "[0-9]";

	$("input[rel=data], input[data-mask=data]").mask("99/99/9999");
	$("input[data-mask=ano]").mask("9999");
	$("input[rel=hora], input[data-mask=hora]").mask("Hh:Om");
	$("input[rel=minutos], input[data-mask=minutos]").mask("99?9M");
	$("input[rel=placa], input[data-mask=placa]").mask("aaa-9999");
	$("input[rel=cpf], input[data-mask=cpf]").mask("999.999.999-99");
	$("input[rel=cnpj], input[data-mask=cnpj]").mask("99.999.999/9999-99");
	$("input[rel=cei], input[data-mask=cei]").mask("99.9999999.99-99");
	$("input[rel=ncm], input[data-mask=ncm]").mask("9999.99.99");
	$("input[rel=cest], input[data-mask=cest]").mask("99.9999.99");
	$("input[rel=cnae], input[data-mask=cnae]").mask("9999-9.99");
	$("input[rel=planoDeContas], input[data-mask=planoDeContas]").mask("9.9.99.99.99");
	$("input[rel=cep], input[data-mask=cep]").mask("99999-999");
	$("input[rel=ean], input[data-mask=ean]").mask("9999999999999");

	$("input[rel=quantidade], input[data-mask=quantidade]").maskMoney({showSymbol: false, precision: 4, decimal: ",", thousands: ""});
	$("input[rel=porcento], input[data-mask=porcento]").maskMoney({showSymbol: true, symbol:"%" , decimal: ",", thousands: ""});
	$("input[rel=decimalGeral], input[data-mask=decimalGeral]").maskMoney({showSymbol: true, symbol:"" , decimal: ",", thousands: ""});
	$("input[rel=dinheiro], input[data-mask=dinheiro]").maskMoney({showSymbol: true, symbol: "R$", decimal: ",", thousands: ""});
	$("input[rel=peso4dec], input[data-mask=peso4dec]").maskMoney({showSymbol: false, precision: 4, decimal: ",", thousands: "."});

	$("input[data-mask=num1dec]").maskMoney({showSymbol: false, precision: 1, decimal: ",", thousands: "."});
	$("input[data-mask=num2dec]").maskMoney({showSymbol: false, precision: 2, decimal: ",", thousands: "."});
	$("input[data-mask=num3dec]").maskMoney({showSymbol: false, precision: 3, decimal: ",", thousands: "."});
	$("input[data-mask=num4dec]").maskMoney({showSymbol: false, precision: 4, decimal: ",", thousands: "."});

	$("input[rel=telefone], input[rel=celular], input[data-mask=telefone], input[data-mask=celular]").focusout(function () {
		var phone, element;
		element = $(this);
		element.unmask();
		phone = element.val().replace(/\D/g, '');
		if (phone.length > 10) {
		    element.mask("(99) 99999-999?9");
		} else {
			element.mask("(99) 9999-9999?9");
		}
	}).trigger('focusout');

	$("input[rel=telefone_sem_ddd], input[rel=celular], input[data-mask=telefone_sem_ddd], input[data-mask=celular]").focusout(function () {
		var phone, element;
		element = $(this);
		element.unmask();
		phone = element.val().replace(/\D/g, '');
		if (phone.length > 10) {
			element.mask("99999-999?9");
		} else {
			element.mask("9999-9999?9");
		}
	}).trigger('focusout');
}

function maiuscula(z){
	return z.toUpperCase();
}