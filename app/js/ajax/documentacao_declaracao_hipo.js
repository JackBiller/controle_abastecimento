$(document).ready(function(){
	var msm = '';
	var id_unid_cons = '';
	$.ajax({
		url:'app/controllers/conf_operacao.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'id_cliente': $('#id_cliente').val(),
			'senha': 	  $("#pwd").val()
		}
	}).done( function(data){
		// console.log(data);
		if (data == "1") {
			listarCliente();

		var link_gerar = "<a href=\"../../seuicmsdevolta.com.br/admin/gerar_doc.php?id="+$('#editar').val()+"\" target=\"_blanck\" class=\"btn btn-primary\" id=\"gerar_documentacao\" onclick=\"atualizar_sitiacao('4')\">";
			link_gerar +=	"	<i class=\"fa fa-print\" aria-hidden=\"true\"></i>";
			link_gerar +=	"	&nbsp;Gerar Documentação";
			link_gerar +=	"</a>";

			$('#link_gerar_declaracao_hipo').html(link_gerar);
		} else {
			msm  = '<h1 class="text-center">';
			msm += '	  Você não esta logado para esse tipo de operação';
			msm += '</h1>';
			$("#formClienteUnidCons").html(msm);
		}
	});
	mask();
});

function alteradoParaAtualizar(){
	document.getElementById("gerar_documentacao").style.display = "none";
}