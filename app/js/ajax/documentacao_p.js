var id_cia_energia = '';
var id_sec_estado = '';
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
		if (data == "1") {
			listarCliente();
			listarProprietario();
			listarClienteUnidCons();
			
		var link_gerar  =	"<a href=\"../../seuicmsdevolta.com.br/admin/gerar_doc.php?id="+$('#editar').val()+"\" target=\"_blanck\" class=\"btn btn-primary\" id=\"gerar_documentacao\" onclick=\"atualizar_sitiacao()\">";
			link_gerar +=	"	<i class=\"fa fa-print\" aria-hidden=\"true\"></i>";
			link_gerar +=	"	&nbsp;Gerar Documentação";
			link_gerar +=	"</a>";

			$('#link_gerar_retituicao').html(link_gerar);
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
	document.getElementById("editar_prorpietario").style.display = "none";
}