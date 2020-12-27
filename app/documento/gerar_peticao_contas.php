<?php
	require_once "../class/conexao.php";

	$conn = new Conexao();
	$pdo = $conn->Connect();

	include "dados.php";
	$anos_requeridos = $_GET["anos"];

	$data_atual = date("d/m/Y");
	$dia_inicial = date("d");
	$mes_esperado = (int) date("m") + 1;
	$mes_esperado = ((int) $mes_esperado < 10) ? "0".$mes_esperado : $mes_esperado ;
	$ano_esperado = (int) date("Y") - (int) $anos_requeridos;
	$data_inicial = $dia_inicial."/".$mes_esperado."/".$ano_esperado;
	$data_final = date("d/m/Y");

	$anos_requeridos = ($anos_requeridos == "1") ? "": $anos_requeridos;

	use Dompdf\Dompdf;
	require_once "../dompdf_gerar/dompdf/autoload.inc.php";

	$dompdf = new DOMPDF();
	$dompdf->load_html('

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Requirimento das Contas de Luz</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
	<h3><b>
	ILMO. SR. DIRETOR DA '.$ce_cia_energia.' (DISTRIBUIDORA DE ENERGIA) – AGÊNCIA DE '.$ce_cidade.'/'.$ce_estado.'<br><br><br>
	</b>
	</h3>

	<h4>
	'.$cl_cidade.'/'.$data_atual.'<br><br>

	Assunto: Solicitação de cópias das contas de energias do(os) último(os) '.$anos_requeridos.' ano(os) <br><br>
	</h4>
	<p class="lead text-justify">
	O/A '.$cl_cliente.', brasileiro, '.$cl_estado_civil.', portador do CPF n. '.$cl_reg_federal.', RG n. '.$cl_reg_estadual.', residente e domiciliado na '.$cl_endereco.', n. '.$cl_numero.' '.$cl_complemento.', bairro '.$cl_bairro.', '.$cl_cidade.'/'.$cl_estado.', CEP'.$cl_cep.', vem, através da presente solicitação, requerer a emissão de cópia das contas de energia do(os) último(os) '.$anos_requeridos.' ano(os) da sua unidade consumidora, onde conste a base de cálculo do ICMS pago.<br><br>
	Seguem os dados para consulta:<br>
	<ul>
	<li>Consumidor: '.$cl_cliente.'</li>
	<li>CPF: '.$cl_reg_federal.'</li>
	<li>RG: '.$cl_reg_estadual.'</li>
	<li>Nº da Unidade Consumidora: '.$uc_nro_instalacao.'</li>
	<li>Endereço da unidade consumidora: '.$uc_endereco.", numero ".$uc_numero." ".$uc_complemento.", bairro ".$uc_bairro.", cidade ".$uc_cidade.", Estado ".$uc_estado.', CEP '.$uc_cep.'</li>
	<li>Período solicitado: '.$data_inicial.' até '.$data_final.'</li>
	</ul><br><br>
	Segue anexa cópia da última conta de energia.
	Firmo o presente em 2 (duas) vias.</p><br><br>
	Att. <br><br>
	<b>
	__________________________ <br>
	'.$cl_cliente.'
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