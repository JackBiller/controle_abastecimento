var id_cia_energia = '';
var id_sec_estado = '';
var id_unid_cons = '';
$(document).ready(function(){
	var msm = '';
	$.ajax({
		url:'app/controllers/conf_operacao.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'id_cliente': $('#id_cliente').val(),
			'senha': 	  $("#pwd").val()
		}
	}).done( function(data){
		console.log(data);
		if (data == "1") {
			listarCliente();
			listarClienteUnidCons();

		var link_gerar  = 	"<a href=\"app/documento/gerar_peticao_contas.php?id="+id_unid_cons+"\" target=\"_blanck\" class=\"btn btn-primary\" id=\"gerar_documentacao\" onclick=\"atualizar_sitiacao('3')\">";
			link_gerar +=	"	<i class=\"fa fa-print\" aria-hidden=\"true\"></i>";
			link_gerar +=	"	&nbsp;Gerar Documentação";
			link_gerar +=	"</a>";

				$('#link_gerar_peticao_contas').html(link_gerar);
		} else {
			msm  = '<h1 class="text-center">';
			msm += '	  Você não esta logado para esse tipo de operação';
			msm += '</h1>';
			$("#formClienteUnidCons").html(msm);
		}
	});
	mask();
});

// function definirLink(){
// 	var anos = $("#select_anos").val();
	
// var link_gerar  = "<a href=\"app/documento/gerar_peticao_contas.php?id="+id_unid_cons+"&anos="+anos+"\" target=\"_blanck\" class=\"btn btn-primary\" id=\"gerar_documentacao\" onclick=\"atualizar_sitiacao('3')\">";
// 	link_gerar +=	"	<i class=\"fa fa-print\" aria-hidden=\"true\"></i>";
// 	link_gerar +=	"	&nbsp;Gerar Documentação";
// 	link_gerar +=	"</a>";

// 	$('#link_gerar_peticao_contas').html(link_gerar);

// }

function alteradoParaAtualizar(){
	document.getElementById("gerar_documentacao").style.display = "none";
}