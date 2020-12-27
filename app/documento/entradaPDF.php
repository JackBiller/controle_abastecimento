<?php
require_once "../class/conexao.php";

$conn = new Conexao();
$pdo = $conn->Connect();

$cont = 0;
$dt_inicial = $_REQUEST['dt_inicial'];
$dt_final = $_REQUEST['dt_final'];
$bomba_id = $_REQUEST['bomba_id'];
$tabela = "";
$totalQuantidade = 0;
$totalTotal = 0;

$sql = "SELECT * FROM entrada WHERE bomba_id = ".$bomba_id." AND data_entrada >= '".$dt_inicial."' AND data_entrada <= '".$dt_final."' ORDER BY data_entrada ASC;";
$verifica = $pdo->query($sql);
foreach ($verifica as $dados) {
	$cont++;
}
if ($cont != 0) {
	$verifica = $pdo->query($sql);
	$tabela .= "
	<table class='table'>
		<tr bgcolor='white'>
			<td><b>Data</b></td>
			<td><b>Empresa</b></td>
			<td><b>CNPJ</b></td>
			<td><b>N° NFe</b></td>
			<td><b>Quantidade em Litros</b></td>
			<td><b>Vlr. Únitario</b></td>
			<td><b>Total</b></td>
		</tr>
		";
		foreach ($verifica as $dados) {
			$totalQuantidade = (float) $totalQuantidade + (float) $dados["qtd_litros"];
			$totalTotal = $totalTotal + $dados["total"];


			$dataDia = substr($dados["data_entrada"] , -2);
			$dataMes = substr($dados["data_entrada"] , -5 , -3);
			$dataAno = substr($dados["data_entrada"] ,  0 ,  4);
			$dataCerta = $dataDia ."/". $dataMes ."/". $dataAno;

			$tabela .= "
			<tr id='linha".$dados[0]."'>
				<td>".$dataCerta."</td>";

				$sql = "SELECT * FROM empresa WHERE id_empresa = ".$dados["empresa_id"].";";
				$verifica2 = $pdo->query($sql);
				foreach ($verifica2 as $dados2) {
					$tabela .= "
					<td>".$dados2["nome"]."</td>
					<td>".$dados2["reg_federal"]."</td>
					";
				}
				$qtd_litros = number_format($dados["qtd_litros"], 2, ',', ' ');
				$vlr_unit = number_format($dados["vlr_unit"], 2, ',', ' ');
				$total = number_format($dados["total"], 2, ',', ' ');
				$tabela .= "
				<td>".$dados["num_nfe"]."</td>
				<td align='left'>Lt ".$qtd_litros."</td>
				<td>R$".$vlr_unit."</td>
				<td>R$".$total."</td>
			</tr>
			";
		}
		if ($totalQuantidade != 0) {
			$mediaGeral = $totalTotal / $totalQuantidade;
		} else {
			$mediaGeral = 0;
		}

		$totalQuantidade = number_format($totalQuantidade, 2, ',', ' ');
		$totalTotal = number_format($totalTotal, 2, ',', ' ');
		$mediaGeral = number_format($mediaGeral, 2, ',', ' ');

		$tabela .= "
		<tr>
			<td colspan='7'><br></td>
		</tr>
		<tr>
			<td colspan='3'></td>
			<td align='right'>
				<b>Quantidade Total: </b>
			</td>
			<td>
				Lt ".$totalQuantidade."
			</td>
			<td align='right'>
				<b>Total: </b>
			</td>
			<td>
				R$".$totalTotal."
			</td>
		</tr>
		<tr>
			<td colspan='4'></td>
			<td colspan='2' align='right'>
				<b>Média valor únitario: </b>
			</td>
			<td>
				R$".$mediaGeral."
			</td>
		</tr>
	</table>
	";
} else {
	$tabela .= "<><h3 class='text-center'>Nenhum registro encontrado</h3>";
}

$dataDia = substr($dt_inicial , -2);
$dataMes = substr($dt_inicial , -5 , -3);
$dataAno = substr($dt_inicial ,  0 ,  4);
$dt_inicial = $dataDia ."/". $dataMes ."/". $dataAno;

$dataDia = substr($dt_final , -2);
$dataMes = substr($dt_final , -5 , -3);
$dataAno = substr($dt_final ,  0 ,  4);
$dt_final = $dataDia ."/". $dataMes ."/". $dataAno;


$sql = "SELECT * FROM bomba WHERE id_bomba = ".$bomba_id.";";
$verifica3 = $pdo->query($sql);
foreach ($verifica3 as $dados3) {
	$bombaAbastecimento = $dados3["descricao"];
}

	// include "dados.php";

	// $gl_local_e_data = "";

use Dompdf\Dompdf;
require_once "../dompdf_gerar/dompdf/autoload.inc.php";

$dompdf = new DOMPDF();
$dompdf->load_html('

	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>Relatório</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div align="center">
						<h1>Relatório de Entrada do Diesel</h1>
						<h4>'.$bombaAbastecimento.'</h4>
						<h4>'.$dt_inicial.' - '.$dt_final.'</h4>


					</div>
				</div>
				<br>
				<div class="col-md-12">
					'.$tabela.'
				</div>
			</div>
		</div>
	</body>
	</html>
	');

if ($_REQUEST['orientacao'] == 1 || $_REQUEST['orientacao'] == "1") {
	$dompdf->setPaper('A4', 'landscape');
}

$dompdf->render();
$dompdf->stream(
	"nome.pdf",
	array(
		"Attachment" => false
		)
	);
	?>