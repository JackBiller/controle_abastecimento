// $.ajax({
// 	url:'app/controllers/funcoesController.php',
// 	type: 'POST',
// 	dataType: 'html',
// 	data: {
// 		'listar_questionario': true
// 	}
// }).done( function(data){
// 	console.log(data);
// 	// var vetor = data.split("];[");
// 	// var subVetor = '';
// 	// var msm = '';
// 	// // msm = "<div ng-model='questao'></div>"
// 	// for (var i = 0; i < vetor.length - 1; i++) {
// 	// 	subVetor = vetor[i].split("][");

// 		// msm += "<div ng-model=\"questao"+subVetor[0]+"\" ng-init=\"questao"+subVetor[0]+" = 0\">";
// 		// msm += "{{questao}}";
// 		// msm += "<span class='ativar' ng-show=\"questao"+subVetor[0]+" == "+subVetor[0]+"\" ng-click=\"questao"+subVetor[0]+" = 0\">"+subVetor[1]+"</span><br>";
// 		// msm += "<span class='desativar' ng-show=\"questao"+subVetor[0]+" == 0\" ng-click=\"questao"+subVetor[0]+" = "+subVetor[0]+"\">"+subVetor[1]+"</span>";
// 		// msm += "<br><br><span ng-show=\"questao"+subVetor[0]+" == "+subVetor[0]+"\">"+subVetor[2]+"</span><br><br>";
// 		// msm += "</div>";
// 	// }
// 	$("#conteudo").html(data);
// });
$.ajax({
	url:'../../seuicmsdevolta.com.br/admin/perg_resp.php',
	type: 'POST',
	dataType: 'html',
	data: {
		'listar_questionario': true
	}
}).done( function(data){
	// console.log(data);
	// var vetor = data.split("];[");
	// var subVetor = '';
	// var msm = '';
	// // msm = "<div ng-model='questao'></div>"
	// for (var i = 0; i < vetor.length - 1; i++) {
	// 	subVetor = vetor[i].split("][");

		// msm += "<div ng-model=\"questao"+subVetor[0]+"\" ng-init=\"questao"+subVetor[0]+" = 0\">";
		// msm += "{{questao}}";
		// msm += "<span class='ativar' ng-show=\"questao"+subVetor[0]+" == "+subVetor[0]+"\" ng-click=\"questao"+subVetor[0]+" = 0\">"+subVetor[1]+"</span><br>";
		// msm += "<span class='desativar' ng-show=\"questao"+subVetor[0]+" == 0\" ng-click=\"questao"+subVetor[0]+" = "+subVetor[0]+"\">"+subVetor[1]+"</span>";
		// msm += "<br><br><span ng-show=\"questao"+subVetor[0]+" == "+subVetor[0]+"\">"+subVetor[2]+"</span><br><br>";
		// msm += "</div>";
	// }
	$("#conteudo").html(data);
});