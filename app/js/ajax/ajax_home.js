$(document).ready(function(){
	$.ajax({
		url:'app/controllers/funcoesHomeController.php',
		type: 'POST',
		dataType: 'html',
		data: {
			'pesquisa_empresa': true
		}
	}).done( function(data){
		$("#conteudoHome").html(data);
	});
});
