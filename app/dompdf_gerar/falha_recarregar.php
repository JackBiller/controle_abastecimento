<?php

// pegar valores
// $cia_energia 		= $_REQUEST["cia_energia"];
// $cidade_cia_energia	= $_REQUEST["cidade_cia_energia"];
// $estado_cia_energia	= $_REQUEST["estado_cia_energia"];
// $cidade_cliente 		= $_REQUEST["cidade_cliente"];
// $data_atual 			= $_REQUEST["data_atual"];
// $requerente 			= $_REQUEST["requerente"];
// $estado_civil 		= $_REQUEST["estado_civil"];
// $reg_federal 		= $_REQUEST["reg_federal"];
// $registro_geral 		= $_REQUEST["registro_geral"];
// $endereco 			= $_REQUEST["endereco"];
// $numero 				= $_REQUEST["numero"];
// $bairro 				= $_REQUEST["bairro"];
// $cidade_uni_cons 	= $_REQUEST["cidade_uni_cons"];
// $estado_uni_cons 	= $_REQUEST["estado_uni_cons"];
// $cep_unid_cons 		= $_REQUEST["cep_unid_cons"];
// $anos_requeridos 	= $_REQUEST["anos_requeridos"];
// $cliente 			= $_REQUEST["cliente"];
// $cpf_cliente 		= $_REQUEST["cpf_cliente"];
// $rg_cliente 			= $_REQUEST["rg_cliente"];
// $num_isntalacao 		= $_REQUEST["num_isntalacao"];
// $endereco_unid_cons 	= $_REQUEST["endereco_unid_cons"];
// $data_inicial 		= $_REQUEST["data_inicial"];
// $data_final 			= $_REQUEST["data_final"];

$cia_energia = "cia_energia";
$cidade_cia_energia = "cidade_cia_energia";
$estado_cia_ener = "estado_cia_ener";
$cidade_cliente = "cidade_cliente";
$data_atual = "data_atual";
$requerente = "requerente";
$estado_civil = "estado_civil";
$reg_federal = "reg_federal";
$registro_geral = "registro_geral";
$endereco = "endereco";
$numero = "numero";
$bairro = "bairro";
$cidade_uni_cons = "cidade_uni_cons";
$estado_uni_cons = "estado_uni_cons";
$cep_unid_cons = "cep_unid_cons";
$anos_requeridos = "anos_requeridos";
$cliente = "cliente";
$cpf_cliente = "cpf_cliente";
$rg_cliente = "rg_cliente";
$num_isntalacao = "num_isntalacao";
$endereco_unid_cons = "endereco_unid_cons";
$data_inicial = "data_inicial";
$data_final = "data_final";



// gerar pdf
	use Dompdf\Dompdf;
	require_once "dompdf/autoload.inc.php";

	$dompdf = new DOMPDF();
	$dompdf->load_html('

<!DOCTYPE html>
<html>
<head>
	<title>Requirimento das Contas de Luz</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
	<h3><b>
	ILMO. SR. DIRETOR DA '.$cia_energia.' (DISTRIBUIDORA DE ENERGIA) – AGÊNCIA DE '.$cidade_cia_energia.'/'.$estado_cia_energia.'<br><br><br>
	</b>
	</h3>

	<h4>
	'.$cidade_cliente.'/'.$data_atual.'<br><br>

	Assunto: Solicitação de cópias das contas de energias dos últimos 5 anos <br><br>
	</h4>
	<p class="lead text-justify">
	O/A '.$requerente.', brasileiro, '.$estado_civil.', portador do CPF n. '.$reg_federal.', RG n. '.$registro_geral.', residente e domiciliado na '.$endereco.', n. '.$numero.', bairro '.$bairro.', '.$cidade_uni_cons.'/'.$estado_uni_cons.', CEP'.$cep_unid_cons.', vem, através da presente solicitação, requerer a emissão de cópia das contas de energia do(os) último(os) '.$anos_requeridos.' ano(os) da sua unidade consumidora, onde conste a base de cálculo do ICMS pago.<br><br>
	Seguem os dados para consulta:<br>
	<ul>
	<li>Consumidor: '.$cliente.'</li>
	<li>CPF: '.$cpf_cliente.'</li>
	<li>RG: '.$rg_cliente.'</li>
	<li>Nº da Unidade Consumidora: '.$num_isntalacao.'</li>
	<li>Endereço da unidade consumidora: '.$endereco_unid_cons.'</li>
	<li>Período solicitado: '.$data_inicial.' até '.$data_final.'</li>
	</ul><br><br>
	Segue anexa cópia da última conta de energia.
	Firmo o presente em 2 (duas) vias.</p><br><br>
	Att. <br><br>
	<b>
	__________________________ <br>
	REQUERENTE
	</b>
			</div>
		</div>
	</div>
</body>
</html>
		');
	$dompdf->render();
	$dompdf->stream(
		"nome.pdf",
		array(
			"Attachment" => false
		)
	);

?>