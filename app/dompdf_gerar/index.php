<?php

$cia_energia = "cia_energia";
$estado_cia_energia = "estado_cia_energia";
$anos_requeridos = "anos_requeridos";
$cidade_cia_energia = "cidade_cia_energia";
$cidade_cliente = "cidade_cliente";
$data_atual = "data_atual";
$requerente = "requerente";
$estado_civil = "estado_civil";
$reg_federal = "reg_federal";
$endereco = "endereco";
$numero = "numero";
$cidade_uni_cons = "cidade_uni_cons";
$estado_uni_cons = "estado_uni_cons";
$registro_geral = "registro_geral";
$bairro = "bairro";
$cep_unid_cons = "cep_unid_cons";
$cliente = "cliente";
$cpf_cliente = "cpf_cliente";
$rg_cliente = "rg_cliente";
$num_isntalacao = "num_isntalacao";
$endereco_unid_cons = "endereco_unid_cons";
$data_inicial = "data_inicial";
$data_final = "data_final";


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

	Assunto: Solicitação de cópias das contas de energias do(os) último(os) '.$anos_requeridos.' ano(os) <br><br>
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
	REQUERENTE '.$requerente.'
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